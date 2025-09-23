<?php

namespace App\Livewire\Clientes;

use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public Cliente $cliente;

    public function render(): string
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

        $this->question('Atenção!', 'Você tem certeza de deletar o cliente ' . $this->cliente->nome . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {

        try {
            $this->cliente->delete();
            $this->dispatch('deleted');
            $this->toast()->info('Atenção!', 'Cliente deletado com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cliente - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar o cliente. <br> Verifique se o cliente está em uso.');
        }
    }
}
