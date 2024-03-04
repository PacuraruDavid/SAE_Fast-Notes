<?php

namespace Database\Factories;

use App\Models\Competence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UE>
 */
class UEFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "code" => fake()->unique()->regexify('BFT[A-C]{1}[1-9]{1}[0-9]{1}AU'),
            "code_competence" => Competence::factory(),
            "libelle" => fake()->unique()->name()
        ];
    }
}
