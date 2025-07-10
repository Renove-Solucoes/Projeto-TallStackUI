<?php

namespace App\Livewire\Tags;

use App\Livewire\Traits\Alert;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{

    use Alert;

    public Tag $tag;

    public bool $modal = false;

    public function mount()
    {
        $this->tag = new Tag();
        $this->tag->status = 'A';
        $this->tag->tipo = 'C';
    }

    public function rules(): array
    {
        return [
            'tag.nome' => ['required', 'string', 'max:255', Rule::unique('tags', 'nome')],
            'tag.tipo' => ['required', 'string', 'max:1'],
            'tag.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function render()
    {
        return view('livewire.tags.create');
    }

    public function save()
    {
        $this->validate();

        try {

            $this->tag->save();
            $this->dispatch('created');

            $this->reset();
            $this->tag = new Tag();
            $this->tag->status = 'A';
            $this->tag->tipo = 'C';

            $this->toast()->success('Atenção!', 'Tag criada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao criar tag - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel criar a tag.');
        }
    }
}
