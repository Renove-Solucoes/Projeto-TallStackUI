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
        $tagCliente = [
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

        $tagProdutos = [
            'Lançamentos',
            'Promoções',
            'Novidades',
            'Fora de Linha',
        ];

        // Junta as tags com seus tipos
        $tags = collect($tagCliente)
            ->map(fn($nome) => ['nome' => $nome, 'tipo' => 'C'])
            ->merge(
                collect($tagProdutos)
                    ->map(fn($nome) => ['nome' => $nome, 'tipo' => 'P'])
            )
            ->shuffle() // Embaralha aleatoriamente
            ->values();

        // Seleciona um aleatório
        $usados = session('tags_usadas', []);

        $tagSelecionada = $tags->first(fn($tag) => !in_array($tag['nome'], $usados));

        if ($tagSelecionada) {
            // Marca como usada
            session(['tags_usadas' => [...$usados, $tagSelecionada['nome']]]);

            return [
                'tipo' => $tagSelecionada['tipo'],
                'nome' => $tagSelecionada['nome'],
                'status' => 'A',
            ];
        }

        return [
            'tipo' => $tagSelecionada['tipo'],
            'nome' => $tagSelecionada['nome'],
            'status' => 'A',
        ];
    }
}
