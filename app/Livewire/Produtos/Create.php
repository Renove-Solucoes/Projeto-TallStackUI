<?php

namespace App\Livewire\Produtos;

use App\Livewire\Traits\Alert;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use Alert;

    public Produto $produto;
    public Categoria $categoria;

    public $imagemTemp = '';
    public $categorias;
    public $categorias_selecionadas = [];

    public bool $modal = false;

    public function mount()
    {
        $this->produto = new Produto();
        $this->produto->status = 'A';
        $this->produto->unidade = 'UN';
        $this->categorias = Categoria::where('tipo', 'P')
            ->where('status', 'A')
            ->get(['id', 'nome'])
            ->map(fn($categoria) => [
                'id' => $categoria->id,
                'nome' => $categoria->nome,
            ])
            ->toArray();
        $this->produto->tipo = 'F';
        $this->imagemTemp = '';
    }


    public function render()
    {
        return view('livewire.produtos.create');
    }

    public function Rules()
    {
        return [
            'produto.nome' => 'required|string|max:255',
            'produto.sku' => 'required|string|max:100',
            'produto.tipo' => 'required|string|in:F,D',
            'produto.unidade' => 'required|string|max:10',
            'produto.data_validade' => 'required|date',
            'produto.preco_padrao' => 'required|numeric|min:0',
            'produto.status' => 'required|string|in:A,I',
            'imagemTemp' => 'nullable|image|max:2048'
        ];
    }

    public function updatedProdutoPrecoPadrao($value)
    {
        $this->produto['preco_padrao'] = (float) str_replace(['R$', '.', ','], ['', '', '.'], $value);
    }


    public function save()
    {
        // if ($this->imagemTemp) {
        //     $path = $this->imagemTemp->store('produtos', 'public');
        //     $this->produto->imagem = $path;
        // }
        try {
            $this->validate();


            DB::transaction(function () {
                $this->produto->save();
                $this->produto->categorias()->sync($this->categorias_selecionadas);
            });


            $this->dispatch('created');

            $this->reset();
            $this->produto = new Produto();
            $this->produto->status = 'A';
            $this->produto->unidade = 'UN';
            $this->produto->tipo = 'F';

            $this->categorias = Categoria::all(['id', 'nome'])->map(fn($categoria) => [
                'nome' => $categoria->nome,
                'id' => $categoria->id,
            ])->toArray();


            $this->toast()->success('Atenção!', 'Produto cadastrado com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao criar produto - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel criar o produto.');
        }
    }
}
