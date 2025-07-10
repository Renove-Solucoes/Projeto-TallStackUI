<?php

namespace App\Livewire\Categorias;

use App\Livewire\Traits\Alert;
use App\Models\Categoria;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use Alert;

    public ?Categoria $categoria;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.categorias.update');
    }

    #[On('load::categoria')]
    public function load(Categoria $categoria): void
    {
        $this->categoria = $categoria;
        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'categoria.nome' => ['required', 'string', 'max:25', Rule::unique('categorias', 'nome')->ignore($this->categoria->id)],
            'categoria.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function save()
    {
        $this->validate();

        try {

            $this->categoria->save();
            $this->dispatch('updated');
            $this->reset();
            $this->success();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar categoria - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar a categoria.');
        }
    }
}
