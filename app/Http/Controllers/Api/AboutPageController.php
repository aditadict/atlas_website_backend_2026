<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    /**
     * Get active about page data
     */
    public function index()
    {
        $aboutPage = AboutPage::where('is_active', true)->first();

        if (!$aboutPage) {
            return response()->json([
                'message' => 'About page not found',
                'data' => null
            ], 404);
        }

        return response()->json($aboutPage);
    }
}
