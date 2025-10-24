<?php

namespace App\Livewire\FormasPagamentos;

use App\Livewire\Traits\Alert;
use App\Models\FormasPagamentos;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public FormasPagamentos $formas_pagamentos;




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

        $this->question('Atenção!', 'Você tem certeza de deletar essa forma de pagamento ' . $this->formas_pagamentos->descricao . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        //TODO: Verificar quando deletar dar error no edit
        try {
            $this->formas_pagamentos->delete();

            $this->dispatch('deleted');

            $this->toast()->info('Atenção!', 'Forma de pagamento deletado com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar forma de pagamento - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar a forma de pagamento. <br> Verifique se o forma de pagamento está em uso.');
        }
    }
}
