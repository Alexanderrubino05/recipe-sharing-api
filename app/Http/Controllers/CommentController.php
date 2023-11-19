<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Store a new comment
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'body' => 'required'
        ]);
        
        $input = $request->all();
        $input['recipe_id'] = $recipe->id;
        $input['author_id'] = auth('sanctum')->user()->id;

        return Comment::create($input);
    }
    
    //Fetch all parent comments for a recipe
    public function index(Recipe $recipe) {
        return $recipe->comments()->paginate(12);
    }

    //Fetch all replies to a comment
    public function fetchReplies(Comment $comment) {
        return $comment->replies()->paginate(12);
    }
}
