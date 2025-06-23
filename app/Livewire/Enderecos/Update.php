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
            'endereco.cliente_id' => ['required'],
            'endereco.descricao' => ['required'],
            'endereco.cep' => ['required'],
            'endereco.endereco' => ['required'],
            'endereco.bairro' => ['required'],
            'endereco.numero' => ['required'],
            'endereco.cidade' => ['required'],
            'endereco.uf' => ['required'],
            'endereco.complemento' => ['nullable'],
            'endereco.status' => ['required'],
            
            
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
        $this->dispatch('updated_enderecos');
        // $this->resetExcept('endereco');
        // $this->success();
    }
}
