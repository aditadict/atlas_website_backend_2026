<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of active clients.
     */
    public function index(): JsonResponse
    {
        $clients = Client::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($clients);
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client): JsonResponse
    {
        return response()->json($client);
    }
}
