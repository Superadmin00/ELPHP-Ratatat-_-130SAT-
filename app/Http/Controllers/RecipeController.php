<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Models\Like;
use App\Models\Favorite;

class RecipeController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        $recipes = Recipe::all();

        foreach ($recipes as $recipe) {
            $recipe->recipe_ingredients = json_decode($recipe->recipe_ingredients);
            $recipe->recipe_instructions = json_decode($recipe->recipe_instructions);
        }

        return response()->json($recipes, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'recipe_category' => 'required|string',
            'recipe_title' => 'required|string',
            'recipe_description' => 'required|string',
            'recipe_ingredients' => 'required|json',
            'recipe_instructions' => 'required|json',
            'images.*' => 'required|image|mimes:jpeg,png,webp|max:512',
            'recipe_prep_time' => 'required|integer',
            'recipe_cook_time' => 'required|integer',
            'recipe_servings' => 'required|integer',
            'recipe_status' => 'required|string'
        ]);

        $recipe = $request->user()->recipes()->create([
            'recipe_category' => $fields['recipe_category'],
            'recipe_title' => $fields['recipe_title'],
            'recipe_description' => $fields['recipe_description'],
            'recipe_ingredients' => $fields['recipe_ingredients'],
            'recipe_instructions' => $fields['recipe_instructions'],
            'recipe_prep_time' => $fields['recipe_prep_time'],
            'recipe_cook_time' => $fields['recipe_cook_time'],
            'recipe_servings' => $fields['recipe_servings'],
            'recipe_status' => $fields['recipe_status']
        ]);

        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store("recipe-images/$recipe->id", 'public');
                $imageUrls[] = '/storage/' . $path;
            }
        }

        $recipe->update([
            'recipe_img_refs' => $imageUrls
        ]);

        $recipe->recipe_ingredients = json_decode($recipe->recipe_ingredients);
        $recipe->recipe_instructions = json_decode($recipe->recipe_instructions);

        return response()->json($recipe, 200);
    }

    public function show(Recipe $recipe)
    {
        $recipe->recipe_ingredients = json_decode($recipe->recipe_ingredients);
        $recipe->recipe_instructions = json_decode($recipe->recipe_instructions);

        return response()->json($recipe, 200);
    }

    public function update(Request $request, Recipe $recipe)
    {
        Gate::authorize('modify', $recipe);

        $fields = $request->validate([
            'recipe_category' => 'required|string',
            'recipe_title' => 'required|string',
            'recipe_description' => 'required|string',
            'recipe_ingredients' => 'required|string',
            'recipe_instructions' => 'required|string',
            'images.*' => 'sometimes|image|mimes:jpeg,png,webp|max:512',
            'recipe_prep_time' => 'required|integer',
            'recipe_cook_time' => 'required|integer',
            'recipe_servings' => 'required|integer',
            'recipe_status' => 'required|string'
        ]);

        $imageUrls = $recipe->recipe_img_refs ?? [];
        foreach ($imageUrls as $imageUrl) {
            $path = str_replace('/storage/', '', $imageUrl);
            Storage::disk('public')->delete($path);
        }

        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store("recipe-images/{$recipe->id}", 'public');
                $imageUrls[] = '/storage/' . $path;
            }
        }

        $recipe->update([
            'recipe_category' => $fields['recipe_category'],
            'recipe_title' => $fields['recipe_title'],
            'recipe_description' => $fields['recipe_description'],
            'recipe_ingredients' => $fields['recipe_ingredients'],
            'recipe_instructions' => $fields['recipe_instructions'],
            'recipe_img_refs' => $imageUrls,
            'recipe_prep_time' => $fields['recipe_prep_time'],
            'recipe_cook_time' => $fields['recipe_cook_time'],
            'recipe_servings' => $fields['recipe_servings'],
            'recipe_status' => $fields['recipe_status']
        ]);

        $recipe->recipe_ingredients = json_decode($recipe->recipe_ingredients);
        $recipe->recipe_instructions = json_decode($recipe->recipe_instructions);

        return response()->json($recipe, 200);
    }

    public function destroy(Recipe $recipe)
    {
        Gate::authorize('modify', $recipe);

        $imageUrls = $recipe->recipe_img_refs ?? [];
        foreach ($imageUrls as $imageUrl) {
            $path = str_replace('/storage/', '', $imageUrl);
            Storage::disk('public')->delete($path);
        }

        $recipe->delete();

        return response()->json([
            'message' => 'Recipe deleted successfully',
        ], 200);
    }
    public function likeRecipe(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        $like = Like::where('user_id', $user->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'UNLIKED'], 200);
        } else {
            Like::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
            return response()->json(['message' => 'LIKED'], 200);
        }
    }

    public function getRecipeLikesCount(Request $request, Recipe $recipe)
    {
        $likesCount = $recipe->likes()->count();

        $userLiked = $recipe->likes()->where('user_id', $request->user()->id)->exists();

        return response()->json([
            'likes_count' => $likesCount,
            'user_liked' => $userLiked,
        ]);
    }

    public function favoriteRecipe(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'UNFAVORITED'], 200);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
            return response()->json(['message' => 'FAVORITED'], 200);
        }
    }

    public function getFavorites(Request $request)
    {
        $user = $request->user();
        $favoriteRecipeIds = $user->favorites()->pluck('recipe_id');

        return response()->json($favoriteRecipeIds);
    }
}
