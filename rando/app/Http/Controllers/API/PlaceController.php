<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $places = Place::with('favorites')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($place) {
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
            'image_place' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'map_place' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
        ]);

        $validatedData['estimated_time_place'] = Carbon::createFromFormat('H:i', $validatedData['estimated_time_place'])->format('H:i');

        $imageFilename = null;
        if ($request->hasFile('image_place')) {
            $imageFilename = pathinfo($request->file('image_place')->getClientOriginalName(), PATHINFO_FILENAME)
                            . '_' . time() . '.' . $request->file('image_place')->getClientOriginalExtension();
            $request->file('image_place')->storeAs('public/uploads', $imageFilename);
        }

        $mapFilename = null;
        if ($request->hasFile('map_place')) {
            $mapFilename = pathinfo($request->file('map_place')->getClientOriginalName(), PATHINFO_FILENAME)
                          . '_' . time() . '.' . $request->file('map_place')->getClientOriginalExtension();
            $request->file('map_place')->storeAs('public/uploads', $mapFilename);
        }

        $place = Place::create([
            ...$validatedData,
            'image_place' => $imageFilename,
            'map_place' => $mapFilename,
        ]);

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
        $place->load(['favorites.user']);

        $averageRating = $place->favorites()->whereNotNull('rating')->avg('rating');
        $place->average_rating = $averageRating ? round($averageRating, 1) : null;

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
            'image_place' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'map_place' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
        ]);

        $validatedData['estimated_time_place'] = Carbon::createFromFormat('H:i', $validatedData['estimated_time_place'])->format('H:i');

        $imageFilename = $place->image_place;
        if ($request->hasFile('image_place')) {
            $imageFilename = pathinfo($request->file('image_place')->getClientOriginalName(), PATHINFO_FILENAME)
                            . '_' . time() . '.' . $request->file('image_place')->getClientOriginalExtension();
            $request->file('image_place')->storeAs('public/uploads', $imageFilename);
        }

        $mapFilename = $place->map_place;
        if ($request->hasFile('map_place')) {
            $mapFilename = pathinfo($request->file('map_place')->getClientOriginalName(), PATHINFO_FILENAME)
                          . '_' . time() . '.' . $request->file('map_place')->getClientOriginalExtension();
            $request->file('map_place')->storeAs('public/uploads', $mapFilename);
        }

        $place->update([
            ...$validatedData,
            'image_place' => $imageFilename,
            'map_place' => $mapFilename,
        ]);

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
