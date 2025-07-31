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
        $tipoPessoa = fake()->randomElement(['F', 'J']);

        return [
            'cpf_cnpj' => $tipoPessoa === 'F'
                ? fake()->numerify('###.###.###-##')
                : fake()->numerify('##.###.###/####-##'),
            'nome' => fake('pt_BR')->name(),
            'tipo_pessoa' => $tipoPessoa,
            'email' => fake('pt_BR')->email(),
            'telefone' => fake()->numerify('(##) #####-####'),
            'nascimento' => fake()->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
            'credito' => fake()->randomFloat(2, 600, 19000),
            'credito_ativo' => fake()->boolean(),
            'status' => 'A',
        ];
    }
}
