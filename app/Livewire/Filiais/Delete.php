<?php

namespace App\Livewire\Filiais;

use App\Livewire\Traits\Alert;
use App\Models\Filial;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Delete extends Component
{
    use Alert;

    public Filial $filial;

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
        $this->question('Atenção!', 'Você tem certeza de deletar essa filial ' . $this->filial->nome_fantasia . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        try {
            $this->filial->delete();
            $this->dispatch('deleted');

            $this->toast()->info('Atenção!', 'Filial deletada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar deletar - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar a filial');
        }
    }
}
