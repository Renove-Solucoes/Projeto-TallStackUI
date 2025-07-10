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
        // Categorias por tipo
        $categorias_Produtos = [
            'Roupas',
            'Sapatos',
            'Eletrodomésticos',
            'Móveis',
            'Celulares',
            'Eletrônicos',
            'Informática',
            'Video-game',
        ];

        $categorias_Cliente = [
            'Cliente Nacional',
            'Cliente VIP',
            'Cliente Ativo',
            'Cliente Potencial',
            'Cliente Antigo',
            'Cliente em Negociação',
            'Cliente Corporativo',
            'Cliente Individual',
            'Cliente Internacional',
        ];

        // Junta ambas com seus tipos
        $categorias_nomes = collect($categorias_Produtos)->map(fn($nome) => [
            'nome' => $nome,
            'tipo' => 'P',
        ])->merge(
            collect($categorias_Cliente)->map(fn($nome) => [
                'nome' => $nome,
                'tipo' => 'C',
            ])
        )->shuffle()->values();

        // Recupere nomes já usados da sessão (para evitar repetições)
        $usados = session('categorias_usadas', []);

        // Pega um nome ainda não usado
        $categoriaSelecionada = $categorias_nomes->first(fn($cat) => !in_array($cat['nome'], $usados));

        // Caso esgotem os nomes, lança exceção
        if (!$categoriaSelecionada) {
            throw new \Exception('Todos os nomes de categoria já foram utilizados.');
        }

        // Atualiza sessão para manter rastreio
        session(['categorias_usadas' => [...$usados, $categoriaSelecionada['nome']]]);

        return [
            'tipo' => $categoriaSelecionada['tipo'],
            'nome' => $categoriaSelecionada['nome'],
            'status' => 'A',
        ];
    }
}
