<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    /**
     * Get all active solutions
     */
    public function index(Request $request)
    {
        $query = Solution::where('is_active', true)
            ->orderBy('order', 'asc');

        $solutions = $query->get();

        return response()->json($solutions);
    }

    /**
     * Get solution by slug
     */
    public function show($slug)
    {
        $solution = Solution::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($solution);
    }
}
