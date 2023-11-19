<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RatingController extends Controller
{
    //Display a listing of the ratings for recipe.
    public function index(Recipe $recipe)
    {
        return $recipe->ratings()->get();
    }

    //Store a newly created raiting for recipe.
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => 'required|integer|between:0,5',
            'comment' => 'string',
        ], [
            'rating' => 'The field rating must be within 0 and 5.'
        ]);

        $rating = $request->all();
        $rating['recipe_id'] = $recipe->id;
        $rating['user_id'] = auth('sanctum')->user()->id;

        return Rating::create($rating);
    }

    //Fetch ratings created by a user
    public function fetchRatingsCreatedByUser(User $user) {
        return $user->ratings()->paginate(12);
    }
}
