<?php

namespace App\Livewire\Tags;

use App\Livewire\Traits\Alert;
use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Renderless;

class Delete extends Component
{

    use Alert;

    public Tag $tag;

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

        $this->question('Atenção!', 'Você tem certeza de deletar a tag ' . $this->tag->nome . '?')
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        try {
            $this->tag->delete();
            $this->dispatch('deleted');

            $this->success('Atenção!', 'Tag deletado com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar tag - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel deletar a tag. <br> Verifique se a tag está em uso.');
        }
    }
}
