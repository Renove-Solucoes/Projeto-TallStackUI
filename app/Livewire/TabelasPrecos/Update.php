<?php

namespace App\Livewire\TabelasPrecos;

use App\Livewire\Traits\Alert;
use App\Models\Produto;
use App\Models\TabelaPreco;
use App\Models\TabelaPrecoItem;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Update extends Component
{
    use Alert;
    use WithPagination;

    public ?TabelaPreco $tabelaPreco;
    public $itens = [];
    public $sugestoes = [];



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
                    'sku' => $item->produto->sku ?? '',
                    'descricao' => $item->produto->nome ?? '',
                    'preco' => $item->preco,
                    'status' => $item->status,
                    'updated' => 0,
                    'deleted' => 0
                ];
            }
        } else {
            $this->addItem();
        }



        // dd ($this->sugestoes);
    }

    public function addItem()
    {
        $this->itens[] =
            [
                'id' => '',
                'produto_id' => '',
                'sku' => '',
                'descricao' => '',
                'preco' => 0.00,
                'status' => 'A',
                'updated' => 0,
                'deleted' => 0
            ];
    }


    public function removeItem($index)
    {
        // unset($this->itens[$index]);
        // $this->itens = array_values($this->itens); // reindexa
        $this->itens[$index]['deleted'] = 1;
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

    public function updatedItens($value, $key)
    {

        $index = explode('.', $key);
        $this->itens[$index[0]]['updated'] = 1;

        //se alterado descrição buscar produtos
        if ($index[1] == 'descricao') {
            $busca = $value ?? '';
            $this->sugestoes = [];
            if (strlen($busca) > 2) {
                $this->sugestoes[$index[0]] = Produto::where('nome', 'like', '%' . $busca . '%')
                    ->orWhere('sku', 'like', '%' . $busca . '%')
                    ->limit(10)
                    ->get()
                    ->toArray();
            } else {
                $this->sugestoes[$index[0]][] = [
                    'id' => 0,
                    'nome' => 'Nenhum dado encontrado',
                    'sku' => '',
                ];
            }
        }
        // dd($this->sugestoes);
    }

    public function selecionarItem($index, $produtoId)
    {
        dd($index, $produtoId);
        $produto = \App\Models\Produto::find($produtoId);

        if ($produto) {
            $this->itens[$index]['produto_id'] = $produto->id;
            $this->itens[$index]['descricao'] = $produto->nome;
            $this->itens[$index]['sku'] = $produto->sku;
            $this->itens[$index]['unidade'] = $produto->unidade;
            $this->sugestoes[$index] = [];
        }
    }

    public function save()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $this->tabelaPreco->save();

                foreach ($this->itens as $item) {
                    // Atualiza ou cria?

                    if (!empty($item['id']) && $item['deleted'] == 1) {
                        // Deleta
                        $itemModel = TabelaPrecoItem::find($item['id']);
                        if ($itemModel) {
                            $itemModel->delete();
                        }
                    } else if (!empty($item['id']) && $item['updated'] == 1) {
                        // Atualiza
                        $itemModel = TabelaPrecoItem::find($item['id']);
                        $item['preco'] = str_replace(['.', ','], ['', '.'], $item['preco']);
                        if ($itemModel) {

                            $itemModel->update([
                                'produto_id' => $item['produto_id'],
                                'preco' => $item['preco'],
                                'status' => $item['status'] == 1 ? 'A' : 'I',
                            ]);
                        }
                    } else if (empty($item['id'])) {
                        // Cria
                        $item['preco'] = str_replace(['.', ','], ['', '.'], $item['preco']);
                        TabelaPrecoItem::create([
                            'tabela_preco_id' => $this->tabelaPreco->id,
                            'produto_id' => $item['produto_id'],
                            'preco' => $item['preco'],
                            'status' => $item['status'] ?? 'A',
                        ]);
                    }
                }
            });


            $this->dispatch('updated');
            $this->toast()->success('Atenção!', 'Tabela de preços atualizada com sucesso.')->send();

            $this->modal = false;
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar tabela de preços - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar a tabela de preços.' . $e->getMessage());
        }
    }
}
