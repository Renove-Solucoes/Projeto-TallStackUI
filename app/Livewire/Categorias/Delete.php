<?php

namespace App\Livewire\Categorias;

use App\Livewire\Traits\Alert;
use App\Models\Categoria;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Illuminate\Support\Facades\Log;


class Delete extends Component
{
    use Alert;

    public Categoria $categoria;

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
        $this->question('Atenção!', 'Você tem certeza de deletar a categoria ' . $this->categoria->nome . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        try {
            $this->categoria->delete();
            $this->dispatch('deleted');

            $this->success('Atenção!', 'Categoria deletada com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar categoria - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar a categoria. <br> Verifique se a categoria está em uso.');
        }
    }
}
