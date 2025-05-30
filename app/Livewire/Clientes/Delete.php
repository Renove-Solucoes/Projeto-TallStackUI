<?php

namespace App\Livewire\Clientes;

use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public Cliente $cliente;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="red" wire:click="confirm" />
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

        $this->cliente->delete();

        $this->dispatch('deleted');

        $this->success('Atenção!', 'Cliente deletado com sucesso.');
    }
}
