<?php

namespace App\Livewire\Categorias;

use App\Livewire\Traits\Alert;
use App\Models\Categoria;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use Alert;

    public Categoria $categoria;

    public bool $modal = false;

    public function mount()
    {
        $this->categoria = new Categoria();
        $this->categoria->status = 'A';
    }

    public function rules(): array
    {
        return [
            'categoria.nome' => ['required', 'string', 'max:25', Rule::unique('categorias', 'nome')],
            'categoria.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function render()
    {
        return view('livewire.categorias.create');
    }

    public function save()
    {
        $this->validate();

        try {

            $this->categoria->save();
            $this->dispatch('created');
            $this->reset();
            $this->toast()->success('Atenção!', 'Categoria criada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao criar categoria - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel criar a categoria.');
        }
    }
}
