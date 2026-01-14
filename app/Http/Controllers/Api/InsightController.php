<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInsightRequest;
use App\Http\Requests\UpdateInsightRequest;
use App\Models\Insight;
use App\Models\InsightFeedback;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InsightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Insight::query();

        // Filter by category
        if ($request->has('category')) {
            $category = strtolower($request->category);
            $query->where(function ($q) use ($category) {
                $q->whereRaw("LOWER(category->>'en') LIKE ?", ["%{$category}%"])
                    ->orWhereRaw("LOWER(category->>'id') LIKE ?", ["%{$category}%"]);
            });
        }

        // Filter by published status
        if ($request->has('published')) {
            $query->where('published', filter_var($request->published, FILTER_VALIDATE_BOOLEAN));
        }

        // Pagination
        $limit = min($request->input('limit', 20), 100);
        $skip = $request->input('skip', 0);

        $insights = $query
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();

        return response()->json($insights);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsightRequest $request): JsonResponse
    {
        $insight = Insight::create($request->validated());

        return response()->json($insight, 201);
    }

    /**
     * Display the specified resource by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $insight = Insight::with('seo')->where('slug', $slug)->firstOrFail();
        
        // Get SEO data (custom or dynamic fallback)
        $seoData = $insight->seo;
        $dynamicSeo = $insight->getDynamicSEOData();
        
        // Build SEO response with custom data or fallback to dynamic
        $seoResponse = [
            'title' => $seoData?->title ?? $dynamicSeo->title,
            'description' => $seoData?->description ?? $dynamicSeo->description,
            'author' => $seoData?->author ?? null,
            'robots' => $seoData?->robots ?? 'index, follow',
            'image' => $dynamicSeo->image,
            'type' => 'article',
            'published_time' => $insight->created_at?->toIso8601String(),
            'modified_time' => $insight->updated_at?->toIso8601String(),
            'section' => $insight->category['en'] ?? null,
        ];
        
        // Merge SEO data with insight
        $response = $insight->toArray();
        $response['seo'] = $seoResponse;
        
        return response()->json($response);
    }

    /**
     * Get related insights based on the same category.
     */
    public function related(string $slug): JsonResponse
    {
        $insight = Insight::where('slug', $slug)->firstOrFail();

        // Get insights with the same category, excluding the current one
        $relatedInsights = Insight::where('published', true)
            ->where('slug', '!=', $slug)
            ->where(function ($query) use ($insight) {
                $query->whereRaw("category->>'en' = ?", [$insight->category['en'] ?? ''])
                    ->orWhereRaw("category->>'id' = ?", [$insight->category['id'] ?? '']);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json($relatedInsights);
    }

    /**
     * Get distinct categories for filtering
     */
    public function filters(): JsonResponse
    {
        $categories = Insight::where('published', true)
            ->get()
            ->pluck('category')
            ->unique()
            ->filter()
            ->values();

        return response()->json($categories);
    }

    /**
     * Update the specified resource in storage by slug.
     */
    public function update(UpdateInsightRequest $request, string $slug): JsonResponse
    {
        $insight = Insight::where('slug', $slug)->firstOrFail();
        $insight->update($request->validated());

        return response()->json($insight);
    }

    /**
     * Remove the specified resource from storage by slug.
     */
    public function destroy(string $slug): JsonResponse
    {
        $insight = Insight::where('slug', $slug)->firstOrFail();
        $insight->delete();

        return response()->json(null, 204);
    }

    /**
     * Submit feedback for an insight (helpful or not helpful)
     */
    public function feedback(Request $request, string $slug): JsonResponse
    {
        $insight = Insight::where('slug', $slug)->firstOrFail();

        $request->validate([
            'is_helpful' => 'required|boolean'
        ]);

        $ipAddress = $request->ip();

        // Check if user already gave feedback for this insight
        $existingFeedback = InsightFeedback::where('insight_id', $insight->id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existingFeedback) {
            // Update existing feedback
            $existingFeedback->update(['is_helpful' => $request->is_helpful]);
        } else {
            // Create new feedback
            InsightFeedback::create([
                'insight_id' => $insight->id,
                'ip_address' => $ipAddress,
                'is_helpful' => $request->is_helpful,
            ]);
        }

        // Get updated feedback counts
        $helpfulCount = InsightFeedback::where('insight_id', $insight->id)
            ->where('is_helpful', true)
            ->count();

        $notHelpfulCount = InsightFeedback::where('insight_id', $insight->id)
            ->where('is_helpful', false)
            ->count();

        return response()->json([
            'message' => 'Feedback submitted successfully',
            'helpful_count' => $helpfulCount,
            'not_helpful_count' => $notHelpfulCount,
        ]);
    }

    /**
     * Get feedback stats for an insight
     */
    public function feedbackStats(string $slug): JsonResponse
    {
        $insight = Insight::where('slug', $slug)->firstOrFail();

        $helpfulCount = InsightFeedback::where('insight_id', $insight->id)
            ->where('is_helpful', true)
            ->count();

        $notHelpfulCount = InsightFeedback::where('insight_id', $insight->id)
            ->where('is_helpful', false)
            ->count();

        return response()->json([
            'helpful_count' => $helpfulCount,
            'not_helpful_count' => $notHelpfulCount,
            'total_count' => $helpfulCount + $notHelpfulCount,
        ]);
    }
}
