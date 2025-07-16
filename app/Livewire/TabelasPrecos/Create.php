<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\TabelasPreco;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{


    use Alert;

    public TabelasPreco $tabelasPreco;

    public bool $modal = false;

    public function mount()
    {
        $this->tabelasPreco = new TabelasPreco();
        $this->tabelasPreco->status = 'A';
    }

    public function Rules()
    {
        return [
            'tabelasPreco.descricao' => [
                'required',
                'string',
                'max:40',
                Rule::unique('tabelas_precos', 'descricao'),
            ],
            'tabelasPreco.data_de' => ['required', 'date'],
            'tabelasPreco.data_ate' => ['required', 'date', 'after_or_equal:data_de'],
            'tabelasPreco.status' => ['required', 'string', 'max:1'],

        ];
    }

    public function render()
    {
        return view('livewire.tabelas-precos.create');
    }

    public function save()
    {
        $this->validate();
        $this->tabelasPreco->save();
        $this->dispatch('created');

        $this->reset('tabelasPreco');
        $this->tabelasPreco = new TabelasPreco();
        $this->tabelasPreco->status = 'A';

        $this->modal = false;

        $this->toast()->success('Atenção!', 'Tabela de preços criada com sucesso.')->send();
    }
}
