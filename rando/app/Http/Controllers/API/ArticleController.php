<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Liste paginée des articles
     */
    public function index()
    {
        $articles = Article::with(['category', 'user'])->paginate(50);
        return response()->json($articles, 200);
    }

    /**
     * Derniers articles pour la page d'accueil
     */
    public function indexHome()
    {
        $articles = Article::with(['category', 'user'])
            ->latest()
            ->limit(3)
            ->get();

        return response()->json($articles, 200);
    }

    /**
     * Création d'un nouvel article avec image
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title_article' => ['required', 'string', 'max:255'],
            'date_article' => ['required', 'date'],
            'content_article' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'image_article' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10000'],
        ]);

        $filename = null;

        if ($request->hasFile('image_article')) {
            $file = $request->file('image_article');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                        . '_' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/uploads', $filename);
        }

        $article = Article::create([
            ...$validatedData,
            'image_article' => $filename,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $article,
        ]);
    }

    /**
     * Affichage d'un article par ID
     */
    public function show($id)
    {
        $article = Article::with(['category', 'user'])->find($id);

        if (!$article) {
            return response()->json([
                'error' => 'Article introuvable',
                'message' => 'Aucun article avec cet ID ne figure dans la base de données.',
                'id_recherché' => $id
            ], 404);
        }

        return response()->json($article, 200);
    }

    /**
     * Mise à jour d'un article avec image
     */
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title_article' => ['required', 'string', 'max:255'],
            'date_article' => ['required', 'date'],
            'content_article' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'image_article' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10000'],
        ]);

        $filename = $article->image_article;

        if ($request->hasFile('image_article')) {
            $file = $request->file('image_article');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                        . '_' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/uploads', $filename);
        }

        $article->update([
            ...$validatedData,
            'image_article' => $filename,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $article,
        ]);
    }

    /**
     * Suppression d'un article
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}
