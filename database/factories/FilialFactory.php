<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filial>
 */
class FilialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $empresa = Empresa::factory()->create();

        return [
            'empresa_id' => $empresa->id,
            'razao_social' => fake('pt_BR')->company(),
            'nome_fantasia' => fake('pt_BR')->company(),
            'tipo_pessoa' => $this->faker->randomElement(['J', 'F']), // Juridica ou Fisica
            'status' => 'A',
        ];
    }
}
