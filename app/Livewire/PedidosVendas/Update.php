<?php

namespace App\Livewire\PedidosVendas;

use App\Livewire\Traits\Alert;
use App\Models\PedidosVenda;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Update extends Component
{
    use Alert;
    use WithPagination;

    public ?PedidosVenda $pedidosVenda;
    public array $clientes = [];

    public bool $modal = false;


    public function mount()
    {
        $this->clientes = \App\Models\Cliente::orderBy('nome')->get(['id', 'nome'])->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.pedidos-vendas.update');
    }

    #[On('load::pedidosVenda')]
    public function load(PedidosVenda $pedidosVenda)
    {
        $this->pedidosVenda = $pedidosVenda;
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function rules()
    {
        return [
            'pedidosVenda.cliente_id' => ['required', Rule::exists('clientes', 'id')],
            'pedidosVenda.data_emissao' => ['required', 'date'],
            'pedidosVenda.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            $this->pedidosVenda->save();
            $this->dispatch('updated');
            $this->modal = false;
            $this->toast()->success('Atenção!', 'Pedido de venda atualizado com sucesso.')->send();
        } catch (\Throwable $e) {
            logger()->error('Erro ao salvar pedido', ['exception' => $e]);
            $this->toast()->error('Erro', 'Erro ao salvar: ' . $e->getMessage())->send();
        }
    }
}
