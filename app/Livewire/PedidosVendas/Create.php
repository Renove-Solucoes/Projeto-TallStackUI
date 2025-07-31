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
        $this->pedidosVenda->tipo_pessoa = 'F';

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
            'pedidosVenda.tipo_pessoa' => ['required', 'string', 'max:1'],
            'pedidosVenda.cpf_cnpj' => ['required', 'string', 'max:14'],
            'pedidosVenda.nome' => ['required', 'string', 'max:255'],
            'pedidosVenda.email' => ['required', 'email', 'max:100'],
            'pedidosVenda.telefone' => ['required', 'string', 'max:15'],
            'pedidosVenda.cep' => ['required', 'string', 'max:9'],
            'pedidosVenda.endereco' => ['required', 'string', 'max:50'],
            'pedidosVenda.bairro' => ['required', 'string', 'max:30'],
            'pedidosVenda.numero' => ['required', 'string', 'max:10'],
            'pedidosVenda.cidade' => ['required', 'string', 'max:255'],
            'pedidosVenda.uf' => ['required', 'string', 'max:2'],
            'pedidosVenda.complemento' => ['nullable', 'string', 'max:255'],
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
            $this->pedidosVenda->tipo_pessoa = 'F';

            $this->modal = false;

            $this->toast()->success('Atenção!', 'Pedido de venda criado com sucesso.')->send();
        } catch (\Throwable $e) {
            logger()->error('Erro ao salvar pedido', ['exception' => $e]);
            $this->toast()->error('Erro', 'Erro ao salvar: ' . $e->getMessage())->send();
        }
    }
}
