<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Project::query();

        // Filter by industry
        if ($request->has('industry')) {
            $industry = strtolower($request->industry);
            $query->where(function ($q) use ($industry) {
                $q->whereRaw("LOWER(industry->>'en') LIKE ?", ["%{$industry}%"])
                    ->orWhereRaw("LOWER(industry->>'id') LIKE ?", ["%{$industry}%"]);
            });
        }

        // Filter by system_type
        if ($request->has('system_type')) {
            $systemType = strtolower($request->system_type);
            $query->where(function ($q) use ($systemType) {
                $q->whereRaw("LOWER(system_type->>'en') LIKE ?", ["%{$systemType}%"])
                    ->orWhereRaw("LOWER(system_type->>'id') LIKE ?", ["%{$systemType}%"]);
            });
        }

        // Filter by featured status
        if ($request->has('featured')) {
            $query->where('featured', filter_var($request->featured, FILTER_VALIDATE_BOOLEAN));
        }

        // Pagination
        $limit = min($request->input('limit', 20), 100);
        $skip = $request->input('skip', 0);

        $projects = $query
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = Project::create($request->validated());

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project->update($request->validated());

        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(null, 204);
    }

    /**
     * Get distinct industries and system types for filtering
     */
    public function filters(): JsonResponse
    {
        $projects = Project::all();

        $industries = $projects->pluck('industry')->unique()->filter()->values();
        $systemTypes = $projects->pluck('system_type')->unique()->filter()->values();

        return response()->json([
            'industries' => $industries,
            'system_types' => $systemTypes
        ]);
    }
}
