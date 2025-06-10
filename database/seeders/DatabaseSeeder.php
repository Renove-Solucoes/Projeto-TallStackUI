<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Endereco;
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
        $tags = Tag::factory(10)->create();
        // $Enderecos = Endereco::factory(24)->create();

        // Associar tags aleatórias aos clientes
        $clientes->each(function ($cliente) use ($tags) {
            $cliente->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // Criar endereços aleatórios para todos os clientes
        $clientes->each(function ($cliente) {
            Endereco::factory(rand(1, 3))->create([
                'cliente_id' => $cliente->id
            ]);
        });

        // Cria 60 endereços, cada um com cliente_id aleatório
        // Endereco::factory(60)->create([
        //     'cliente_id' => function () use ($clientes) {
        //         return $clientes->random()->id;
        //     },
        // ]);
    }
}
