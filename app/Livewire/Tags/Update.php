<?php

namespace App\Livewire\Tags;

use App\Livewire\Traits\Alert;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use Alert;

    public ?Tag $tag;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.tags.update');
    }

    #[On('load::tag')]
    public function load(Tag $tag): void
    {
        $this->tag = $tag;
        $this->modal = true;
    }


    public function rules(): array
    {
        return [
            'tag.nome' => ['required', 'string', 'max:255', Rule::unique('tags', 'nome')->ignore($this->tag->id)],
            'tag.tipo' => ['required', 'string', 'max:1'],
            'tag.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        try {

            $this->tag->update();
            $this->dispatch('updated');
            $this->reset();
            $this->toast()->success('Atenção!', 'Tag atualizada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar tag - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar a tag.');
        }
    }
}
