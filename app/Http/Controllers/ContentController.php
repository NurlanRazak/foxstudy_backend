<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ContentController extends Controller
{

    public function articles(Request $request)
    {
        $data = [];

        $articles = Article::active()->orderBy('lft')->get();

        if(!$articles)
        {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        foreach($articles as $article) {
            $data[] = new ArticleResource($article);
        }

        return response()->json([
            'data' => $data,
            'message' => 'OK, keep going, u doing well.',
        ]);
    }

    public function article(Request $request, string $article_id)
    {
        return new ArticleResource(Article::active()->where('id', $article_id)->firstOrFail());
    }
}
