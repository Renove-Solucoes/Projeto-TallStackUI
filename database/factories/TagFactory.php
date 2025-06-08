<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'Novo Cliente',
            'Cliente VIP',
            'Inadimplente',
            'Cliente Ativo',
            'Cliente Potencial',
            'Cliente Antigo',
            'Cliente em Negociação',
            'Cliente Corporativo',
            'Cliente Individual',
            'Cliente Internacional'
        ];
        return [
            'nome' => $this->faker->unique()->randomElement($tags),
            'status' => 'A',
        ];
    }
}
