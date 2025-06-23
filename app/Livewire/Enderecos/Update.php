<?php

namespace App\Livewire\Enderecos;

use App\Livewire\Traits\Alert;
use App\Models\Endereco;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;

    public Endereco $endereco;


    public bool $modal = false;

    public function rules(): array
    {
        return [

            'endereco.descricao' => [
                'required',
                'string',
                'max:255'
            ],

            'endereco.cep' => [
                'required',
                'string',
                'max:255'
            ],
            'endereco.endereco' => [
                'required',
                'string',
                'max:255'

            ],
            'endereco.bairro' => [
                'required',
                'string',
                'max:255'
            ],
            'endereco.numero' => [
                'required',
                'string',
                'max:255'
            ],
            'endereco.uf' => [
                'required',
                'string',
                'uppercase',
                'max:2'
            ],
            'endereco.cidade' => [
                'required',
                'string',
                'max:255'
            ],
            'endereco.complemento' => [
                'nullable',
                'string',
                'max:255'
            ],
            'endereco.status' => [
                'required',
                'string',
                'max:1'
            ],

        ];
    }


    #[On('load::endereco')]
    public function load(Endereco $endereco): void
    {
        $this->endereco = $endereco;
        $this->resetErrorBag();
        $this->modal = true;
    }



    public function render(): View
    {
        return view('livewire.enderecos.update');
    }

    public function save(): void
    {
        $this->validate();
        $this->endereco->update();
        $this->modal = false;
        $this->dispatch('refresh::endereco');
        // $this->resetExcept('endereco');
        // $this->success();
    }
}
