<?php

namespace App\Livewire\Clientes;

use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use GuzzleHttp\Client;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use Alert;

    public Cliente $cliente;

    public bool $modal = false;

    public $fotoTemp = '';

    public function mount(): void
    {
        $this->cliente = new Cliente();
        $this->cliente->tipo_pessoa = 'F';
        $this->cliente->status = 'A';
        $this->cliente->credito = '';
        $this->imagemTemp = '';
    }


    public function render()
    {
        return view('livewire.clientes.create');
    }

    public function rules(): array
    {
        return [
            'fotoTemp' => [
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


    public function updatedClienteCredito()
    {

        $this->cliente->credito = str_replace(['.', ','], ['', '.'], $this->cliente->credito);
    }

    public function save(): void
    {
        $this->validate();

        $this->cliente->save();

        $this->dispatch('created');

        //TODO: Limpar o campo moeda do formulario create depois que salvar o registro.
        $this->reset();
        $this->cliente = new Cliente();
        $this->cliente->tipo_pessoa = 'J';
        $this->cliente->status = 'I';





        $this->success();
    }
}
