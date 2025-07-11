<?php

namespace App\Livewire\Produtos;

use App\Livewire\Traits\Alert;
use App\Models\Produto;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public Produto $produto;



    public function render(): string
    {

        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="amber" wire:click="confirm" outline/>
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {

        $this->question('Atenção!', 'Você tem certeza de deletar o produto ' . $this->produto->nome . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {

        try {
            $this->produto->delete();

            $this->dispatch('deleted');

            $this->toast()->info('Atenção!', 'Produto deletado com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar produto - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar o produto. <br> Verifique se o produto está em uso.');
        }
    }
}
