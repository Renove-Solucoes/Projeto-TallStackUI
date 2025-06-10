<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => null,
            'endereco' =>  fake('pt_BR')->streetAddress(),
            // 'principal' => '0',
            'cep' =>  fake('pt_BR')->postcode(),
            'numero' => fake('pt_BR')->buildingNumber(),
            'bairro' => fake('pt_BR')->streetName(),
            'cidade' => fake('pt_BR')->city(),
            'uf' => fake('pt_BR')->stateAbbr(),
            'complemento' => fake('pt_BR')->secondaryAddress(),
            'status' => 'A',
            'descricao' => $this->faker->randomElement(['Casa', 'Trabalho', 'Apartamento', 'Casa da Mãe']),
        ];
    }
}
