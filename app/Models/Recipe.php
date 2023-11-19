<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "ingredients", "instructions", "cooking_time", "cuisine", "meal_type"];
    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array'
    ]; //This will automatically deserialize the values to a PHP array when you access it on Eloquent model.

    //Fetch parent comments to this recipe
    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    //Fetch raitings to this recipe
    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
