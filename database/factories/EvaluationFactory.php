<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Evaluation;
use App\Models\Utilisateur;
use App\Models\Ressource;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "libelle" => fake()->name(),
            "coefficient" => fake()->randomFloat(2,0.1,4.0),
            "type" => fake()->name(),
            "code_ressource" => Ressource::factory()->create()
        ];

    }
}
