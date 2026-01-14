<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Contact::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $limit = min($request->input('limit', 50), 100);
        $skip = $request->input('skip', 0);

        $contacts = $query
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();

        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());

        return response()->json($contact, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $contact->update($request->validated());

        return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json(null, 204);
    }
}
