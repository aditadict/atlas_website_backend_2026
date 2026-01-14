<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * API root endpoint
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Atlas Digitalize API',
            'version' => '1.0.0',
        ]);
    }

    /**
     * Health check endpoint
     */
    public function health(): JsonResponse
    {
        $databaseStatus = 'connected';

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $databaseStatus = 'disconnected';
        }

        return response()->json([
            'status' => 'healthy',
            'database' => $databaseStatus,
        ]);
    }
}
