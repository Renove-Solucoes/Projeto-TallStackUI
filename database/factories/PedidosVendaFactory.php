<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidosVendaFactory extends Factory
{
    public function definition()
    {
        return [
            'cliente_id'     => Cliente::inRandomOrder()->first()->id ?? Cliente::factory()->create()->id,
            'data_emissao'   => $this->faker->dateTimeBetween('-6 months', '+1 years'),
            'tipo_pessoa'    => $this->faker->randomElement(['F', 'J']), // F: Física, J: Jurídica
            'cpf_cnpj'       => $this->faker->numerify('###########'), // CPF/CNPJ fictício
            'nome'           => $this->faker->name(),
            'email'          => $this->faker->safeEmail(),
            'telefone'       => $this->faker->phoneNumber(),
            'cep' => $this->faker->numerify('########'),
            'endereco'       => $this->faker->streetAddress(),
            'bairro'         => $this->faker->word(),
            'numero'         => $this->faker->buildingNumber(),
            'cidade'         => $this->faker->city(),
            'uf'             => $this->faker->stateAbbr(),
            'complemento'    => $this->faker->optional()->secondaryAddress(),
            'status'         => $this->faker->randomElement(['A', 'I']),
        ];
    }
}
