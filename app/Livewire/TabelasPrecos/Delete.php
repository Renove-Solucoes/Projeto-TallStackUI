<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\TabelaPreco;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Delete extends Component
{

    use Alert;

    public TabelaPreco $tabelaPreco;

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

        $this->question('Atenção!', 'Você tem certeza de deletar o produto ' . $this->tabelaPreco->descricao . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        $this->tabelaPreco->delete();
        $this->dispatch('deleted');
        $this->toast()->info('Atenção!', 'Tabela de preço deletada com sucesso.')->send();
    }
}
