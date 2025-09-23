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
        try {
            $this->tabelaPreco->delete();
            $this->dispatch('deleted');
            $this->toast()->info('Atenção!', 'Tabela de preços deletada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar tabela de preços - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar a tabela de preços. <br> Verifique se a tabela de preços está em uso.');
        }
    }
}
