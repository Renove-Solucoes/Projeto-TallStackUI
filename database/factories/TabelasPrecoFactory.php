<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TabelasPreco>
 */
class TabelasPrecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataDe = $this->faker->dateTimeBetween('-1 years', 'now');

        return [
            //
            // 'empresa_id' => null,
            'descricao' => $this->faker->unique()->randomElement(['Lançamento', 'Promoção', 'BlackFriday', 'Fora de Linha']),
            'data_de' => $dataDe,
            'data_ate' => $this->faker->dateTimeBetween($dataDe, '+1 years'),
            'status' => $this->faker->randomElement(['A', 'I'])
        ];
    }
}
