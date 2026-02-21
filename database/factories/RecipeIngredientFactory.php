<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeIngredient>
 */
class RecipeIngredientFactory extends Factory
{
    protected $model = RecipeIngredient::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'ingredient_id' => Ingredient::factory(),
            'amount' => $this->faker->randomFloat(2, 0.1, 500),
            'unit' => $this->faker->randomElement([
                'g',
                'ml',
                'pcs',
                'tbsp',
                'tsp',
            ]),
            'note' => $this->faker->optional()->word(),
            'sort_order' => 0,
        ];
    }
}