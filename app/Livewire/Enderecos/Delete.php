<?php

namespace App\Livewire\Enderecos;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\Endereco;
use Livewire\Attributes\Renderless;

class Delete extends Component
{

    use Alert;

    public bool $modal = false;


    public Endereco $endereco;

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="amber" wire:click="confirm" outline />
        </div>
        HTML;
    }

    #[On('load::endereco')]
    public function mount(int $enderecoId)
    {
        $this->enderecoId = $enderecoId;
        $this->endereco = Endereco::findOrFail($this->enderecoId);
    }

    #[Renderless]
    public function confirm(): void
    {


        $this->question('Atenção!', 'Você tem certeza de deletar o endereço ' . $this->endereco->endereco . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {



        $this->endereco->delete();

        $this->dispatch('deleted');
        $this->dispatch('refresh::endereco');
        $this->success('Atenção!', 'Endereço deletado com sucesso.');
    }
}
