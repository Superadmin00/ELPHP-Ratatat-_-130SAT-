<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_category',
        'recipe_title',
        'recipe_description',
        'recipe_ingredients',
        'recipe_instructions',
        'recipe_img_refs',
        'recipe_prep_time',
        'recipe_cook_time',
        'recipe_servings',
        'recipe_status',
    ];

    protected $casts = [
        'recipe_img_refs' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
