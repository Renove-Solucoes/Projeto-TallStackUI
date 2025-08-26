<?php

namespace App\Livewire\Filiais;

use App\Livewire\Traits\Alert;
use App\Models\Empresa;
use App\Models\Filial;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use Alert;

    public Filial $filial;

    public bool $modal = false;

    public $empresas;

    public function mount()
    {
        $this->filial = new Filial();
        $this->filial->status = 'A';
        $this->filial->tipo_pessoa = 'F';
        $this->filial->empresa_id = 1;
        $this->empresas = Empresa::all(['id', 'nome'])
            ->map(fn($empresa) => [
                'id' => $empresa->id,
                'nome' => $empresa->nome,
            ])
            ->toArray();
    }

    public function rules()
    {
        return [
            'filial.empresa_id' => ['required', 'exists:empresas,id'],
            'filial.razao_social' => ['required', 'string', 'max:60', Rule::unique('filials', 'razao_social')],
            'filial.nome_fantasia' => ['required', 'string', 'max:60', Rule::unique('filials', 'nome_fantasia')],
            'filial.status' => ['required', 'string', 'max:1'],
            'filial.tipo_pessoa' => ['required', 'string', 'max:1'],
        ];
    }

    public function render()
    {
        return view('livewire.filiais.create');
    }

    public function save()
    {
        $this->validate();

        try {

            $this->filial->save();
            $this->dispatch('created');
            $this->reset();
            $this->filial = new Filial();
            $this->filial->status = 'A';
            $this->filial->tipo_pessoa = 'F';
            $this->empresas = Empresa::all(['id', 'nome'])
                ->map(fn($empresa) => [
                    'id' => $empresa->id,
                    'nome' => $empresa->nome,
                ])
                ->toArray();

            $this->toast()->success('Atenção!', 'Filial criada com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error($e);
            $this->alert('error', 'Ocorreu um erro ao salvar a filial');
        }
    }
}
