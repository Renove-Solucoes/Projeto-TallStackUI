<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\TabelasPreco;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use Alert;

    public ?TabelasPreco $tabelasPreco;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.tabelas-precos.update');
    }

    #[On('load::tabelasPreco')]
    public function load(TabelasPreco $tabelasPreco)
    {
        $this->tabelasPreco = $tabelasPreco;
        $this->modal = true;
    }

    public function Rules()
    {
        return [
            'tabelasPreco.descricao' => [
                'required',
                'string',
                'max:40',
                Rule::unique('tabelas_precos', 'descricao')->ignore($this->tabelasPreco->id),
            ],
            'tabelasPreco.data_de' => ['required', 'date'],
            'tabelasPreco.data_ate' => ['required', 'date'],
            'tabelasPreco.status' => ['required', 'string', 'max:1'],

        ];
    }

    public function save()
    {
        $this->validate();

        try {

            $this->tabelasPreco->save();
            $this->dispatch('updated');
            $this->toast()->success('Atenção!', 'Tabela de preços atualizada com sucesso.')->send();

            $this->modal = false;
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar tabela de preços - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar a tabela de preços.');
        }
    }
}
