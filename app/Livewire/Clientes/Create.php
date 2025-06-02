<?php

namespace App\Livewire\Clientes;

use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use GuzzleHttp\Client;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use Alert;

    public Cliente $cliente;

    public bool $modal = false;

    public function mount(): void
    {
        $this->cliente = new Cliente();
        $this->cliente->tipo_pessoa = 'F';
        $this->cliente->status = 'I';
    }


    public function render()
    {
        return view('livewire.clientes.create');
    }

    public function rules(): array
    {
        return [
            'cliente.tipo_pessoa' => [
                'required',
                'string',
                'min:1',
                'max:1'
            ],
            'cliente.cpf_cnpj' => [
                'required',
                'string',
                'min:14',
                'max:18',
                Rule::unique('clientes', 'cpf_cnpj'),
            ],

            'cliente.nome' => [
                'required',
                'string',
                'max:255'
            ],
            'cliente.email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clientes', 'email'),
            ],
            'cliente.telefone' => [
                'required',
                'string',
            ],
            'cliente.nascimento' => [
                'required',
                'date',
            ],
            'cliente.status' => [
                'required',
                'string',
                'min:1',
                'max:1'
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->cliente->save();

        $this->dispatch('created');

        $this->reset();
        $this->cliente = new Cliente();

        $this->success();
    }
}
