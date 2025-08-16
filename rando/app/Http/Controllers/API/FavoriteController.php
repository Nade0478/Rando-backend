<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Affiche tous les favoris avec leurs relations.
     */
    public function index()
    {
        $favorites = Favorite::with(['place', 'user'])->paginate(50);
        return response()->json($favorites, 200);
    }

    /**
     * Ajoute un nouveau favori.
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

        $favorite = Favorite::create($validatedData);

        return response()->json([
            'status' => 'Success',
            'data' => $favorite,
        ], 201);
    }

    /**
     * Affiche un favori spécifique avec ses relations.
     */
    public function show(Favorite $favorite)
    {
        return response()->json($favorite->load(['place', 'user']), 200);
    }

    /**
     * Met à jour un favori existant.
     */
    public function update(Request $request, Favorite $favorite)
    {
        $validatedData = $request->validate([
            'is_favorite' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $favorite->update($validatedData);

        return response()->json([
            'status' => 'Updated',
            'data' => $favorite,
        ], 200);
    }

    /**
     * Supprime un favori.
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return response()->json(null, 204);
    }

    /**
     * Ajoute ou retire un favori selon son existence.
     */
    public function toggleFavorite(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'place_id' => ['required', 'integer', 'exists:places,id'],
        ]);

        $favorite = Favorite::where('user_id', $validated['user_id'])
            ->where('place_id', $validated['place_id'])
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Lieu retiré des favoris'], 200);
        }

        $newFavorite = Favorite::create([
            'user_id' => $validated['user_id'],
            'place_id' => $validated['place_id'],
            'is_favorite' => true,
        ]);

        return response()->json([
            'message' => 'Lieu ajouté aux favoris',
            'data' => $newFavorite,
        ], 201);
    }

    /**
     * Liste des favoris d’un utilisateur.
     */
    public function userFavorites($userId)
    {
        $favorites = Favorite::with('place')
            ->where('user_id', $userId)
            ->where('is_favorite', true)
            ->get();

        return response()->json($favorites, 200);
    }

    /**
     * Liste des commentaires associés à un lieu.
     */
    public function placeComments($placeId)
    {
        $comments = Favorite::with('user')
            ->where('place_id', $placeId)
            ->whereNotNull('comment')
            ->get(['user_id', 'comment', 'rating', 'created_at']);

        return response()->json($comments, 200);
    }
}
