<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['author_id', 'recipe_id', 'parent_id', 'body'];

    //Fetch replies to this comment
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
