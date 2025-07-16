<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\TabelasPreco;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{

    use Alert;

    public TabelasPreco $tabelasPreco;

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="amber" wire:click="confirm" outline />
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {

        $this->question('Atenção!', 'Você tem certeza de deletar o produto ' . $this->tabelasPreco->descricao . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        $this->tabelasPreco->delete();
        $this->dispatch('deleted');
        $this->toast()->info('Atenção!', 'Tabela de preço deletada com sucesso.')->send();
    }
}
