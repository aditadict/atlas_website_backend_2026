<?php

use App\Http\Controllers\Api\AboutPageController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InsightController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SolutionController;
use Illuminate\Support\Facades\Route;

// Root API endpoint
Route::get('/', [ApiController::class, 'index']);

// Health check endpoint
Route::get('/health', [ApiController::class, 'health']);

// Authentication endpoints
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Public endpoints - no authentication required
Route::get('/about', [AboutPageController::class, 'index']);
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{client}', [ClientController::class, 'show']);
Route::get('/solutions', [SolutionController::class, 'index']);
Route::get('/solutions/{solution}', [SolutionController::class, 'show']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/insights', [InsightController::class, 'index']);
Route::get('/insights/filters', [InsightController::class, 'filters']);
Route::get('/insights/{insight:slug}', [InsightController::class, 'show']);
Route::get('/insights/{insight:slug}/related', [InsightController::class, 'related']);
Route::post('/insights/{insight:slug}/feedback', [InsightController::class, 'feedback']);
Route::get('/insights/{insight:slug}/feedback-stats', [InsightController::class, 'feedbackStats']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/filters', [ProjectController::class, 'filters']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);

// Protected endpoints - Sanctum authentication required
Route::middleware('auth:sanctum')->group(function () {
    // Auth user endpoints
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // About page management (admin only)
    Route::post('/about', [AboutPageController::class, 'store']);
    Route::put('/about/{aboutPage}', [AboutPageController::class, 'update']);
    Route::delete('/about/{aboutPage}', [AboutPageController::class, 'destroy']);

    // Solution management (admin only)
    Route::post('/solutions', [SolutionController::class, 'store']);
    Route::put('/solutions/{solution}', [SolutionController::class, 'update']);
    Route::delete('/solutions/{solution}', [SolutionController::class, 'destroy']);

    // Contact management (admin only)
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/contacts/{contact}', [ContactController::class, 'show']);
    Route::put('/contacts/{contact}', [ContactController::class, 'update']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);

    // Insight management (admin only)
    Route::post('/insights', [InsightController::class, 'store']);
    Route::put('/insights/{insight}', [InsightController::class, 'update']);
    Route::delete('/insights/{insight}', [InsightController::class, 'destroy']);

    // Project management (admin only)
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);
});
