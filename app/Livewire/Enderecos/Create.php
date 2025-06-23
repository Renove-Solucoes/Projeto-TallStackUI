<?php

namespace App\Livewire\Enderecos;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\Endereco;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;


class Create extends Component
{
    use Alert;

    public Endereco $endereco;

    public bool $modal = false;

    public function mount(): void
    {
        $this->endereco = new Endereco();
        $this->endereco->status = 'A';
    }

    public function rules(): array
    {
        return [
            'imagemTemp' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,png,jpg,svg,bmp',
                'max:2048'
            ],
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
            'cliente.credito' => [
                'required',
                'numeric',
            ],
            'cliente.credito_ativo' => [
                'required',
                'boolean',
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



    public function render()
    {
        return view('livewire.enderecos.create');
    }



    public function save(): void
    {
        $this->validate();
        $this->endereco->save();
        $this->dispatch('created');


        $this->reset();
        $this->endereco = new Cliente();
        // $this->resetExcept('endereco');
        // $this->success();
    }
}
