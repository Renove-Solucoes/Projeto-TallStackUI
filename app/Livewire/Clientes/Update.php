<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;


class Update extends Component
{

    use Alert;

    public ?Cliente $cliente;

    public bool $modal = false;



    public function render(): View
    {
        return view('livewire.clientes.update');
    }

    #[On('load::cliente')]
    public function load(Cliente $cliente): void
    {
        $this->cliente = $cliente;


        $this->modal = true;
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
                'min:11',
                'max:14',
                Rule::unique('clientes', 'cpf_cnpj')->ignore($this->cliente->id),
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
                Rule::unique('clientes', 'email')->ignore($this->cliente->id),
            ],
            'cliente.telefone' => [
                'required',
                'numeric',
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

        $this->cliente->update();

        $this->dispatch('updated');

        $this->resetExcept('cliente');

        $this->success();
    }
}
