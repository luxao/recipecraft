<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //cretate default user
        $user = User::factory()->create([
            'name' => 'Jozef Mrkva',
            'email' => 'j.mrkva@gmail.com',
        ]);

        // 1) Ingredient pool (idempotentné, nespôsobí duplicate)
        $ingredientNames = [
            'Flour', 'Eggs', 'Milk', 'Butter', 'Salt', 'Pepper', 'Garlic', 'Onion',
            'Chicken breast', 'Rice', 'Pasta', 'Tomatoes', 'Olive oil', 'Sugar', 'Lemon',
            'Potatoes', 'Carrots', 'Cheese', 'Yogurt', 'Paprika', 'Cumin', 'Basil',
        ];

        $ingredients = collect($ingredientNames)->map(function ($name) {
            return Ingredient::firstOrCreate(
                ['name' => $name],
                ['category' => 'other']
            );
        });

        // 2) Tags
        $tagNames = ['vegan', 'quick', 'cheap', 'healthy', 'protein', 'breakfast', 'lunch', 'dinner'];

        $tags = collect($tagNames)->map(fn ($name) => Tag::firstOrCreate(['name' => $name]));

        // 3) Recipes + attach všetko
        Recipe::factory()
            ->count(10)
            ->create(['user_id' => $user->id])
            ->each(function (Recipe $recipe) use ($ingredients, $tags) {

                // ingredients for recipe
                $selected = $ingredients->random(rand(3, 8))->values();

                foreach ($selected as $i => $ingredient) {
                    RecipeIngredient::factory()->create([
                        'recipe_id' => $recipe->id,
                        'ingredient_id' => $ingredient->id,
                        'sort_order' => $i,
                    ]);
                }

                // steps
                for ($n = 1; $n <= rand(3, 7); $n++) {
                    RecipeStep::factory()->create([
                        'recipe_id' => $recipe->id,
                        'step_number' => $n,
                    ]);
                }

                // tags
                $recipe->tags()->syncWithoutDetaching(
                    $tags->random(rand(1, 4))->pluck('id')->all()
                );
            });

    }
}