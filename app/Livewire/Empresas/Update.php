<?php

namespace App\Livewire\Empresas;

use App\Livewire\Traits\Alert;
use App\Models\Categoria;
use App\Models\Empresa;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use TallStackUi\Traits\Interactions;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use Interactions;

    public Empresa $empresa;

    public bool $modal = false;

    #[On('load::empresa')]
    public function load(Empresa $empresa): void
    {
        $this->empresa = $empresa;
        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'empresa.nome' => ['required', 'string', 'max:255', Rule::unique('empresas', 'nome')->ignore($this->empresa)],
            'empresa.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function render()
    {
        return view('livewire.empresas.update');
    }

    public function save()
    {
        $this->validate();

        try {

            $this->empresa->save();


            $this->reset(['modal', 'empresa']);

            $this->dispatch('updated');
            $this->reset();
            $this->empresa = new Empresa();
            $this->empresa->status = 'A';

            $this->toast()->success('Atetenção!', 'Empresa atualizada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error($e);
            $this->alert('error', 'Ocorreu um erro ao atualizar a empresa');
        }
    }
}
