<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\View;
use App\Models\Article;
use App\Models\Visitor;

class ViewController extends Controller
{
    /**
     * @author Rik Verbeek
     * 
     * Create a view
     */
    public function create(Request $request)
    {
        // Check for parameters
        if($request->has('article_id') && Article::find($request->article_id, ['id'])) {
            $view = new View();

            $view->article_id = $request->article_id;
            $view->visitor_id = Visitor::getVisitorByIP($request->ip())->id;

            $view->save();

            return response()->json([
                'message' => 'View was created'
            ], 201);
        }

        return response()->json([
            'message' => 'Something went wrong'
        ], 200);
    }
}
