<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'cpf_cnpj' =>  fake()->bothify('###########'),
            'nome' => fake('pt_BR')->name(),
            'tipo_pessoa' => $this->faker->randomElement(['F','J']),
            'email' => fake('pt_BR')->email(),
            'telefone' =>  fake()->bothify('#########'),
            'status' => 'A',
        ];
    }
}
