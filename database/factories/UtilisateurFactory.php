<?php

namespace Database\Factories;
use App\Models\Groupe;
use App\Models\Semestre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilisateur>
 */
class UtilisateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'nom' => fake()->name(),
            'prenom' => fake()->name(),
            ];
    }
}
