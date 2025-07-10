<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define algumas categorias de produtos
        $categorias_nomes = ['Roupas', 'Sapatos', 'Eletrodomésticos', 'Móveis', 'Celulares', 'Eletrônicos', 'Informática', 'Video-game'];

        return [
            // 'empresa_id' => null,
            'nome' => $this->faker->unique()->randomElement($categorias_nomes),
            // 'empresa_id' => function () {
            //     return Empresa::inRandomOrder()->first()->id;
            // },
            'status' => 'A',
        ];
    }
}
