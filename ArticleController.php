<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Category;
use App\Models\Visitor;

class ArticleController extends Controller
{
    /**
     * @author Rik Verbeek
     * 
     * Store an article in the database
     */
    public function create(Request $request) 
    {
        // Check if paramaters are submitted
        if($request->has('title') && $request->has('body')) {
            $article = new Article();

            $article->title = $request->title;
            $article->body = $request->body;

            $article->save();

            // The categories are send in the {1,2} format so explode
            if($request->has('categories')) {
                $articles_categories = [];

                foreach(explode(',', $request->categories) as $category_id) {
                    // Check if the category actually exists
                    $category = Category::find((int)$category_id);

                    if($category) {
                        $articles_categories[] = ['article_id' => $article->id, 'category_id' => (int)$category_id];
                    }
                }

                DB::table('articles_categories')->insert($articles_categories);
            }
            
            return response()->json([
                'message' => 'Article was created'
            ], 201);
        }

        return response()->json([
            'message' => 'Not enough parameters'
        ], 200);
    }

    /**
     * @author Rik Verbeek
     * 
     * General search, this method is used for both retrieving of all records as filtered and sorted queries
     */
    public function search(Request $request)
    {
        $articles = Article::select(DB::raw('articles.*, (SELECT COUNT(*) FROM views WHERE article_id = articles.id) AS views, (SELECT COUNT(*) FROM votes WHERE article_id = articles.id) AS votes'));

        // If the categories filter is passed, add the querybuilder
        if($request->has('categories')) {
            $articles->leftJoin('articles_categories', 'articles.id', '=', 'articles_categories.article_id');

            // The categories are passed in the {1, 2} format so explode 
            foreach(explode(',', $request->categories) as $category_id) {
                if(Category::find($category_id, ['id'])) {
                    $articles->where('articles_categories.category_id', (int)$category_id);
                }
            }
        }

        // If date_from parameter is passed add to the querybuilder
        if($request->has('date_from')) {
            $articles->where('created_at', '>=', $request->date_from);
        }

        // If date_till parameter is passed add to the querybuilder
        if($request->has('date_till')) {
            $articles->where('created_at', '<=', $request->date_till);
        }

        // If phrase (search query) parameter is passed add to the querybuilder
        if($request->has('phrase')) {

            // Perform fuzzy search
            foreach(explode(' ', $request->phrase) as $word) {
                $articles->where(function($query) use ($word) {
                    $query->where('articles.title', 'like', '%' . $word . '%');
                    $query->orWhere('articles.body', 'like', '%' . $word . '%');
                });
            }
        }

        // If sort_on_views parameter is passed add to the querybuilder
        if($request->has('sort_on_views')) {
            $articles->orderBy('views', 'desc');
        }

        // If sort_on_votes parameter is passed add to the querybuilder
        if($request->has('sort_on_votes')) {
            $articles->orderBy('votes', 'desc');
        }

        // If offset and limit parameter is passed add to the querybuilder, note they both have to be passed
        if($request->has('offset') && $request->has('limit')) {
            $articles->offset((int)$request->offset)->limit($request->limit);
        }

        return response()->json([
            'data' => $articles->get()
        ], 200);
    }
}
