<?php

namespace App\Livewire\PedidosVendas;

use App\Livewire\Traits\Alert;
use App\Models\PedidosVenda;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Delete extends Component
{
    use Alert;

    public PedidosVenda $pedidosVenda;


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

        $this->question('Atenção!', 'Você tem certeza de deletar esse pedido ' . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        //TODO: Verificar quando deletar dar error no edit
        try {
            $this->pedidosVenda->delete();

            $this->dispatch('deleted');

            $this->toast()->info('Atenção!', 'Pedido deletado com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao deletar produto - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar o Pedido. <br> Verifique se o Pedido está em uso.');
        }
    }
}
