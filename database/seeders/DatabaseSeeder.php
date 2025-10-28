<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Filial;
use App\Models\FormasPagamentos;
use App\Models\PedidosVenda;
use App\Models\Produto;
use App\Models\TabelaPreco;
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

        //Criando Formas de Pagamentos
        $formasPagamentos = [
            ['descricao' => 'Pix', 'tipo_pagamento' => 0, 'condicao_pagamento' => '0', 'aplicavel_em' => 'A', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Dinheiro', 'tipo_pagamento' => 1, 'condicao_pagamento' => '0', 'aplicavel_em' => 'A', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Boleto', 'tipo_pagamento' => 2, 'condicao_pagamento' => '0', 'aplicavel_em' => 'R', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Cartão Debito', 'tipo_pagamento' => 4, 'condicao_pagamento' => '0', 'aplicavel_em' => 'A', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Cartão 1x', 'tipo_pagamento' => 5, 'condicao_pagamento' => '0', 'aplicavel_em' => 'A', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Cartão 2x', 'tipo_pagamento' => 5, 'condicao_pagamento' => '30, 60', 'aplicavel_em' => 'A', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Cartão 3x', 'tipo_pagamento' => 5, 'condicao_pagamento' => '30, 60, 90', 'aplicavel_em' => 'A', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
            ['descricao' => 'Cartão 10x', 'tipo_pagamento' => 5, 'condicao_pagamento' => '30, 60, 90', 'aplicavel_em' => 'P', 'juros' => 0.00, 'multa' => 0.00, 'lancar_dia_util' => true, 'status' => 'A'],
        ];

        foreach ($formasPagamentos as $formaPagamento) {
            FormasPagamentos::create($formaPagamento);
        }



        $clientes = Cliente::factory(24)->create();
        $tags = Tag::factory(14)->create();
        $categorias = Categoria::factory(17)->create();
        $produtos = Produto::factory(20)->create();
        $tabelasPreco = TabelaPreco::factory(4)->create();
        // $Enderecos = Endereco::factory(24)->create();
        $PedidosVenda = PedidosVenda::factory(24)->create();

        $empresas = Empresa::factory(5)->create();
        $filiais = Filial::factory(8)->create();

        $filiais->each(function ($filial) use ($empresas) {
            $filial->empresa_id = $empresas->random()->id;
            $filial->save();
        });



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


        //Assoscia de 4 a 8 Produtos na tabela de preco
        $tabelasPreco->each(function ($tabelaPreco) use ($produtos) {
            $quantidade = min($produtos->count(), rand(4, 8));

            $produtosSelecionados = $produtos->random($quantidade);

            foreach ($produtosSelecionados as $produto) {
                $tabelaPreco->items()->create([
                    'produto_id' => $produto->id,
                    'preco' => rand(1000, 5000) / 100, // Exemplo de preço aleatório
                ]);
            }
        });

        //Assoscia de 4 a 8 Produtos no pedido de venda
        $PedidosVenda->each(function ($pedido) use ($produtos) {
            $quantidade = min($produtos->count(), rand(2, 4));

            $produtosSelecionados = $produtos->random($quantidade);

            $totalItem = 0;

            foreach ($produtosSelecionados as $produto) {
                $quantidade = rand(1, 10);
                $preco = rand(1000, 5000) / 100;
                $totalItem = $totalItem + ($quantidade * $preco);
                $pedido->itens()->create([
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidade,
                    'preco' => $preco,
                ]);
            }

            $pedido->total = $totalItem;
            $pedido->save();
        });

        // Busca tabelas de preço ativas
        $tabelasPreco = TabelaPreco::where('status', 'A')->get();

        // Associa cada pedido a uma tabela ativa aleatória
        $PedidosVenda->each(function ($pedido) use ($tabelasPreco) {
            $tabelaPreco = $tabelasPreco->random();
            $pedido->tabelaPreco()->associate($tabelaPreco);
            $pedido->save();
        });

        // --- Define vendedores aleatórios ---
        $quantidadeVendedores = max(2, rand(5, 10));
        $vendedores = User::inRandomOrder()->take($quantidadeVendedores)->get();

        // Marca como vendedores
        $vendedores->each(fn($user) => $user->update(['vendedor' => true]));

        // --- Associa vendedores aos pedidos ---
        $PedidosVenda->each(function ($pedido) use ($vendedores) {

            // --- Vendedor 1 (sempre obrigatório) ---
            $vendedor1 = $vendedores->random();

            // --- Vendedor 2 (opcional) ---
            $vendedor2 = rand(0, 1) // 50% de chance de ter um segundo vendedor
                ? $vendedores->where('id', '!=', $vendedor1->id)->random()
                : null;

            $pedido->update([
                'vendedor_id' => $vendedor1->id,
                'vendedor2_id' => $vendedor2?->id,
            ]);
        });

        $formasPagamentos = FormasPagamentos::where('status', ['A', 'R'])->get();

        $PedidosVenda->each(function ($pedido) use ($formasPagamentos) {
            $pedido->formaPagamento()->associate($formasPagamentos->random());
            $pedido->save();
        });

        // Cria 60 endereços, cada um com cliente_id aleatório
        // Endereco::factory(60)->create([
        //     'cliente_id' => function () use ($clientes) {
        //         return $clientes->random()->id;
        //     },
        // ]);
    }
}
