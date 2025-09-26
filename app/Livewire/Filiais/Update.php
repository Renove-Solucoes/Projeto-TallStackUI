<?php

namespace App\Livewire\Filiais;

use App\Livewire\Traits\Alert;
use App\Models\Empresa;
use App\Models\Filial;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use TallStackUi\Traits\Interactions;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use Alert;
    use Interactions;

    public Filial $filial;

    public $empresas;

    public $modal = false;


    #[On('load::filial')]
    public function load(Filial $filial): void
    {
        $this->filial = $filial;
        $this->modal = true;
    }

    public function mount()
    {
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
            'filial.razao_social' => ['required', 'string', 'max:60', Rule::unique('filials', 'razao_social')->ignore($this->filial->id)],
            'filial.nome_fantasia' => ['required', 'string', 'max:60', Rule::unique('filials', 'nome_fantasia')->ignore($this->filial->id)],
            'filial.status' => ['required', 'string', 'max:1'],
            'filial.tipo_pessoa' => ['required', 'string', 'max:1'],
        ];
    }


    public function render()
    {
        return view('livewire.filiais.update');
    }


    public function save()
    {
        $this->validate();

        try {
            $this->filial->save();

            $this->reset('modal', 'filial');

            $this->dispatch('updated');

            $this->toast()->success('Atenção!', 'Filial atualizada com sucesso.')->send();

            $this->empresas = Empresa::all(['id', 'nome'])
                ->map(fn($empresa) => [
                    'id' => $empresa->id,
                    'nome' => $empresa->nome,
                ])
                ->toArray();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar filial - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name, [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possível atualizar a filial.');
        }
    }
}
