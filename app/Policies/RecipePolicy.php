<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecipePolicy
{
    public function modify(User $user, Recipe $recipe): Response
    {
        return $user->id === $recipe->user_id
            ? Response::allow()
            : Response::deny('You do not own this recipe.');
    }
}
