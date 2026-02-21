<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prep = $this->faker->numberBetween(5, 60);
        $cook = $this->faker->numberBetween(10, 120);

        return [
            'user_id' => User::factory(),
            'title' => ucfirst($this->faker->words(rand(2, 4), true)),
            'description' => $this->faker->optional()->paragraph(),
            'servings_default' => $this->faker->numberBetween(1, 6),
            'prep_minutes' => $prep,
            'cook_minutes' => $cook,
            'difficulty' => $this->faker->randomElement([
                'easy',
                'medium',
                'hard',
            ]),

            'visibility' => 'private',
        ];
    }
}
