<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlaceController extends Controller
{
    /**
     * Affiche tous les lieux.
     */
    public function index()
    {
        $places = Place::with('favorites')->get()->map(function ($place) {
            $place->estimated_time_place = Carbon::parse($place->estimated_time_place)->format('H:i');
            return $place;
        });

        return response()->json($places, 200);
    }

    /**
     * Affiche les 3 derniers lieux pour la page d’accueil.
     */
    public function indexHome()
    {
        $places = Place::with('favorites')->limit(3)->orderBy('created_at', 'desc')->get()->map(function ($place) {
            $place->estimated_time_place = Carbon::parse($place->estimated_time_place)->format('H:i');
            return $place;
        });

        return response()->json($places, 200);
    }

    /**
     * Enregistre un nouveau lieu.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_place' => ['required', 'string', 'max:255'],
            'latitude_place' => ['required', 'numeric'],
            'longitude_place' => ['required', 'numeric'],
            'description_place' => ['required', 'string', 'max:1000'],
            'distance_place' => ['required', 'numeric'],
            'difficulty_place' => ['required', 'in:Facile,Moyen,Difficile'],
            'estimated_time_place' => ['required', 'date_format:H:i'],
            'image_place' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'map_place' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
        ]);

        $validatedData['estimated_time_place'] = Carbon::createFromFormat('H:i', $validatedData['estimated_time_place'])->format('H:i');

        $filename = null;
        if ($request->hasFile('image_place')) {
            $filename = time() . '_' . $request->file('image_place')->getClientOriginalName();
            $request->file('image_place')->storeAs('public/uploads', $filename);
        }

        $map_place = null;
        if ($request->hasFile('map_place')) {
            $map_place = time() . '_' . $request->file('map_place')->getClientOriginalName();
            $request->file('map_place')->storeAs('public/uploads', $map_place);
        }

        $place = Place::create(array_merge(
            $validatedData,
            ['image_place' => $filename, 'map_place' => $map_place]
        ));

        return response()->json([
            'status' => 'Success',
            'data' => $place,
        ]);
    }

    /**
     * Affiche un lieu avec ses commentaires et sa note moyenne.
     */
    public function show(Place $place)
    {
        $place->estimated_time_place = Carbon::parse($place->estimated_time_place)->format('H:i');

        // Charger les commentaires et utilisateurs
        $place->load(['favorites.user']);

        // Calculer la moyenne des notes
        $averageRating = $place->favorites()->whereNotNull('rating')->avg('rating');
        $place->average_rating = $averageRating ? round($averageRating, 1) : null;

        // Préparer les commentaires
        $comments = $place->favorites->whereNotNull('comment')->map(function ($fav) {
            return [
                'user' => $fav->user->name ?? 'Utilisateur',
                'comment' => $fav->comment,
                'rating' => $fav->rating,
                'date' => $fav->created_at->format('d/m/Y'),
            ];
        });

        return response()->json([
            'place' => $place,
            'average_rating' => $place->average_rating,
            'comments' => $comments,
        ], 200);
    }

    /**
     * Met à jour un lieu existant.
     */
    public function update(Request $request, Place $place)
    {
        $validatedData = $request->validate([
            'name_place' => ['required', 'string', 'max:255'],
            'latitude_place' => ['required', 'numeric'],
            'longitude_place' => ['required', 'numeric'],
            'description_place' => ['required', 'string', 'max:1000'],
            'distance_place' => ['required', 'numeric'],
            'difficulty_place' => ['required', 'in:Facile,Moyen,Difficile'],
            'estimated_time_place' => ['required', 'date_format:H:i'],
            'image_place' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'map_place' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
        ]);

        $validatedData['estimated_time_place'] = Carbon::createFromFormat('H:i', $validatedData['estimated_time_place'])->format('H:i');

        $filename = $place->image_place;
        if ($request->hasFile('image_place')) {
            $filename = time() . '_' . $request->file('image_place')->getClientOriginalName();
            $request->file('image_place')->storeAs('public/uploads', $filename);
        }

        $map_place = $place->map_place;
        if ($request->hasFile('map_place')) {
            $map_place = time() . '_' . $request->file('map_place')->getClientOriginalName();
            $request->file('map_place')->storeAs('public/uploads', $map_place);
        }

        $place->update(array_merge(
            $validatedData,
            ['image_place' => $filename, 'map_place' => $map_place]
        ));

        return response()->json([
            'status' => 'Success',
            'data' => $place,
        ]);
    }

    /**
     * Supprime un lieu.
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json(null, 204);
    }
}
