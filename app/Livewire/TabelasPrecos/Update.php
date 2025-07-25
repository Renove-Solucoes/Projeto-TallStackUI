<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\TabelaPreco;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class Update extends Component
{
    use Alert;

    public ?TabelaPreco $tabelaPreco;
    public $itens = [];

    public bool $modal = false;

    public function render()
    {
        return view('livewire.tabelas-precos.update');
    }

    #[On('load::tabelaPreco')]
    public function load(tabelaPreco $tabelaPreco)
    {
        $this->tabelaPreco = $tabelaPreco;
        $this->modal = true;

        $this->itens = [];
        
        if ($this->tabelaPreco->items()->count() > 0) {
            $itemsTabela = $this->tabelaPreco->items()->get();

            foreach ($itemsTabela as $item) {

                $this->itens[] = [
                    'id' => $item->id,
                    'produto_id' => $item->produto_id,
                    'descricao' => $item->produto->nome ?? '',
                    'sku' => $item->produto->sku ?? '',
                    'unidade' => $item->produto->unidade ?? '',
                    'preco' => $item->preco,
                    'status' => $item->status,
                ];
                
            }
        }

    }

    public function Rules()
    {
        return [
            'tabelaPreco.descricao' => [
                'required',
                'string',
                'max:40',
                Rule::unique('tabelas_precos', 'descricao')->ignore($this->tabelaPreco->id),
            ],
            'tabelaPreco.data_de' => ['required', 'date'],
            'tabelaPreco.data_ate' => ['required', 'date', 'after_or_equal:tabelaPreco.data_de'],
            'tabelaPreco.status' => ['required', 'string', 'max:1'],

        ];
    }

    public function save()
    {
        $this->validate();

        try {

            $this->tabelaPreco->save();
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
