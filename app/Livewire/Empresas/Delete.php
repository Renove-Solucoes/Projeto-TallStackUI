<?php

namespace App\Livewire\Empresas;

use App\Livewire\Traits\Alert;
use App\Models\Empresa;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Delete extends Component
{
    use Alert;

    public Empresa $empresa;

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
        $this->question('Atenção!', 'Você tem certeza de deletar a empresa ' . $this->empresa->nome . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        try {
            $this->empresa->delete();
            $this->dispatch('deleted');

            $this->toast()->info('Atenção!', 'Empresa deletada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar deletar - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar a categoria. <br> Verifique se a categoria está em uso.');
        }
    }
}
