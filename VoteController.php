<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vote;
use App\Models\Article;
use App\Models\Visitor;

class VoteController extends Controller
{
    /**
     * @author Rik Verbeek
     * 
     * Create a vote
     */
    public function create(Request $request)
    {
        // Check for parameters and if the article voted fot actually exists
        if($request->has('score') && $request->has('article_id') && Article::find($request->article_id, ['id'])) {
            // Get an existing visitor or create one
            $visitor = Visitor::getVisitorByIP($request->ip());
            
            // Visitor can't vote on an article already voted for
            if(Vote::where('article_id', $request->article_id)->where('visitor_id', $visitor->id)->first()) {
                return response()->json([
                    'message' => 'Already voted'
                ], 200);
            }

            // Visitor can only vote 10 times a day
            if(count(Vote::where('visitor_id', $visitor->id)->where(DB::raw('DATE(votes.created_at) = CURDATE()'))->all()) > 9) {
                return response()->json([
                    'message' => 'Already voted'
                ], 200);
            }

            $votes = (int)$request->score;
            
            /**
             * Register each vote seperatly, this server 2 purposes
             * 1. It's on the client to decide what the maximum of votes should be 
             * 2. Counting votes will always be fair because the actual amount of votes is counted
             */
            while($votes > 0) {
                $vote = new Vote();

                $vote->article_id = $request->article_id;
                $vote->visitor_id = $visitor->id;

                $vote->save();
                
                $votes--;
            }

            return response()->json([
                'message' => 'Vote was created'
            ], 201);
        }

        return response()->json([
            'message' => 'Something went wrong'
        ], 200);
    }
}
