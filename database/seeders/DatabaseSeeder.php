<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Produto;
use App\Models\TabelasPreco;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(24)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $clientes = Cliente::factory(24)->create();
        $tags = Tag::factory(14)->create();
        $categorias = Categoria::factory(17)->create();
        $produtos = Produto::factory(20)->create();
        $tabelasPreco = TabelasPreco::factory(4)->create();
        // $Enderecos = Endereco::factory(24)->create();


        // Carrega apenas as tags do tipo CLIENTE
        $tagsCliente = Tag::where('tipo', 'C')->get();

        // Associa de 1 a 3 tags CLIENTE a cada cliente
        $clientes->each(function ($cliente) use ($tagsCliente) {
            $quantidade = min($tagsCliente->count(), rand(1, 3));

            $cliente->tags()->attach(
                $tagsCliente->random($quantidade)->pluck('id')->toArray()
            );
        });

        // Carrega apenas as tags do tipo PRODUTO
        $tagsProduto = Tag::where('tipo', 'P')->get();

        //Assoscia de 1 a 3 tags PRODUTO a cada produto
        $produtos->each(function ($produto) use ($tagsProduto) {
            $quantidade = min($tagsProduto->count(), rand(1, 3));

            $produto->tags()->attach(
                $tagsProduto->random($quantidade)->pluck('id')->toArray()
            );
        });

        // Criar endereços aleatórios para todos os clientes
        $clientes->each(function ($cliente) {
            Endereco::factory(rand(1, 3))->create([
                'cliente_id' => $cliente->id
            ]);
        });




        // Associa de 1 a 3 categorias a cada produto
        $produtos->each(function ($produto) use ($categorias) {
            $quantidade = min($categorias->count(), rand(1, 3));

            $produto->categorias()->attach(
                $categorias->random($quantidade)->pluck('id')->toArray()
            );
        });

        // Cria 60 endereços, cada um com cliente_id aleatório
        // Endereco::factory(60)->create([
        //     'cliente_id' => function () use ($clientes) {
        //         return $clientes->random()->id;
        //     },
        // ]);
    }
}
