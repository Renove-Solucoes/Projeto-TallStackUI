<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\TabelaPreco;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{


    use Alert;

    public TabelaPreco $tabelaPreco;

    public bool $modal = false;

    public function mount()
    {
        $this->tabelaPreco = new tabelaPreco();
        $this->tabelaPreco->status = 'I';
    }

    public function Rules()
    {
        return [
            'tabelaPreco.descricao' => [
                'required',
                'string',
                'max:40',
                Rule::unique('tabelas_precos', 'descricao'),
            ],
            'tabelaPreco.data_de' => ['required', 'date'],
            'tabelaPreco.data_ate' => ['required', 'date', 'after_or_equal:tabelaPreco.data_de'],
            'tabelaPreco.status' => ['required', 'string', 'max:1'],

        ];
    }

    public function render()
    {
        return view('livewire.tabelas-precos.create');
    }

    public function save()
    {
        $this->validate();
        $this->tabelaPreco->save();
        $this->dispatch('created');

        $this->reset('tabelaPreco');
        $this->tabelaPreco = new TabelaPreco();
        $this->tabelaPreco->status = 'A';

        $this->modal = false;

        $this->toast()->success('Atenção!', 'Tabela de preços criada com sucesso.')->send();
    }
}
