<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    //Fetch recipes with search params
    public function index(Request $request) {
        $request->validate([
            'search' => 'string',
            'sortBy' => Rule::in(['cuisine']),
            'sortOrder' => Rule::in(['asc', 'desc']),
            'mealType' => Rule::in(['breakfast', 'brunch', 'lunch', 'dinner', 'dessert']),
        ], [
            'mealType' => "The 'mealType' parameter accepts only ['breakfast', 'brunch', 'lunch', 'dinner', 'dessert'] values",
        ]);

        return Recipe::
        when($request->search, function($query) use ($request) {
            $query
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        })
        ->when($request->mealType, function($query) use ($request) {
            $query
                ->where('meal_type', $request->mealType);
        })
        ->when($request->sortBy, function ($query) use ($request) {
            $query->orderBy($request->sortBy, $request->sortOrder ?? 'asc');
        })
        ->paginate(12);
    }

    //Store a new recipe from request
    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'array'],
            'instructions' => ['required', 'array'],
            'cooking_time' => ['required', 'string'],
            'cuisine' => ['required', 'string'],
            'meal_type' => ['required', 'string'],
        ], [
            'title' => 'A title field is required and must be a String.'
        ]);

        return Recipe::create($request->all());
    }

    //Display the specified recipe.
    public function show(Recipe $recipe)
    {
        return $recipe;
    }

    //Update the specified recipe in storage.
    public function update(Request $request, Recipe $recipe)
    {      
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'array'],
            'instructions' => ['required', 'array'],
            'cooking_time' => ['required', 'string'],
            'cuisine' => ['required', 'string'],
            'meal_type' => ['required', 'string'],
        ], [
            'title' => 'A title field is required and must be a String.'
        ]);
        
        $recipe->update($request->all());
        return $recipe;
    }

    //Remove the specified recipe from storage.
    public function destroy(string $id)
    {
        return Recipe::destroy($id);
    }
}
