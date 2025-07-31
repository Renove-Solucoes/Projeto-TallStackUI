<?php

namespace App\Livewire\PedidosVendas;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Livewire\Traits\Alert;
use App\Models\PedidosVenda;

class Create extends Component
{
    use Alert;

    public PedidosVenda $pedidosVenda;

    public bool $modal = false;

    public array $clientes = [];

    public function mount()
    {
        $this->pedidosVenda = new PedidosVenda();
        $this->pedidosVenda->status = 'A';

        $this->clientes = \App\Models\Cliente::orderBy('nome')->get(['id', 'nome'])->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
            ];
        })->toArray();
    }

    public function rules()
    {
        return [
            'pedidosVenda.cliente_id' => ['required', Rule::exists('clientes', 'id')],
            'pedidosVenda.data_emissao' => ['required', 'date'],
            'pedidosVenda.status' => ['required', 'string', 'max:1'],

        ];
    }

    public function render()
    {
        return view('livewire.pedidos-vendas.create');
    }

    public function save()
    {

        $this->validate();

        try {

            $this->pedidosVenda->save();

            $this->dispatch('created');

            $this->reset();
            $this->pedidosVenda = new PedidosVenda();
            $this->pedidosVenda->status = 'A';

            $this->modal = false;

            $this->toast()->success('Atenção!', 'Pedido de venda criado com sucesso.')->send();
        } catch (\Throwable $e) {
            logger()->error('Erro ao salvar pedido', ['exception' => $e]);
            $this->toast()->error('Erro', 'Erro ao salvar: ' . $e->getMessage())->send();
        }
    }
}
