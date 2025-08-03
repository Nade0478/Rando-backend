<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\At_Favorite;
use Illuminate\Http\Request;

class At_FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $at_Favorites = At_Favorite::with(['place', 'user'])->paginate(50);
        return response()->json($at_Favorites, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'place_id' => ['required', 'integer', 'exists:places,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'is_favorite' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $at_Favorite = At_Favorite::create($validatedData);

        return response()->json([
            'status' => 'Success',
            'data' => $at_Favorite,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(At_Favorite $at_Favorite)
    {
        return response()->json($at_Favorite->load(['place', 'user']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, At_Favorite $at_Favorite)
    {
        $validatedData = $request->validate([
            'is_favorite' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $at_Favorite->update($validatedData);

        return response()->json([
            'status' => 'Updated',
            'data' => $at_Favorite,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(At_Favorite $at_Favorite)
    {
        $at_Favorite->delete();

        return response()->json(null, 204);
    }
}
