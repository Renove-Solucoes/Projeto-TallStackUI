<?php

namespace App\Livewire\Empresas;

use App\Livewire\Traits\Alert;
use App\Models\Empresa;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use Alert;

    public Empresa $empresa;

    public bool $modal = false;


    public function mount()
    {
        $this->empresa = new Empresa();

        $this->empresa->status = 'A';
    }

    public function rules(): array
    {
        return [
            'empresa.nome' => ['required', 'string', 'max:255', Rule::unique('empresas', 'nome')],
            'empresa.status' => ['required', 'string', 'max:1'],
        ];
    }

    public function render()
    {
        return view('livewire.empresas.create');
    }


    public function save()
    {
        $this->validate();

        try {

            $this->empresa->save();
            $this->dispatch('created');
            $this->reset();
            $this->empresa = new Empresa();
            $this->empresa->status = 'A';

            $this->toast()->success('Atenção!', 'Empresa criada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error($e);
            $this->alert('error', 'Ocorreu um erro ao salvar a empresa');
        }
    }
}
