<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('recipe_category');
            $table->text('recipe_title');
            $table->text('recipe_description');
            $table->text('recipe_ingredients');
            $table->text('recipe_instructions');
            $table->text('recipe_img_refs')->nullable();
            $table->integer('recipe_prep_time');
            $table->integer('recipe_cook_time');
            $table->integer('recipe_servings');
            $table->text('recipe_status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
