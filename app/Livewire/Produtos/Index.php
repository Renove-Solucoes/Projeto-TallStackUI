<?php

namespace App\Livewire\Produtos;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Pagination\LengthAwarePaginator;

use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public ?int $quantity = 10;

    public ?string $search = null;

    public Produto $produto;

    public bool $slide = false;

    public $filtro = [
        'categoria' => '',
        'tag' => '',
        'status' => '',
        'tipo' => '',
    ];

    public $categorias = [];
    public $tags = [];


    public function mount(): void
    {
        $this->categorias = Categoria::where('tipo', 'P')
            ->where('status', 'A')
            ->get(['id', 'nome'])
            ->map(fn($c) => ['id' => $c->id, 'nome' => $c->nome])
            ->toArray();

        $this->tags = Tag::where('tipo', 'P')
            ->where('status', 'A')
            ->get(['id', 'nome'])
            ->map(fn($t) => ['id' => $t->id, 'nome' => $t->nome])
            ->toArray();
    }

    public function filtrar()
    {
        $this->rows();
    }

    public function limparFiltros()
    {
        $this->search = null;
        $this->reset('filtro');
    }

    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];

    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'nome', 'label' => 'Nome'],
        ['index' => 'sku', 'label' => 'SKU'],
        ['index' => 'unidade', 'label' => 'UN'],
        ['index' => 'data_validade', 'label' => 'Validade'],
        ['index' => 'tipo_nome', 'label' => 'Tipo'],
        ['index' => 'preco_padrao', 'label' => 'Preço'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];

    public function render()
    {
        return view('livewire.produtos.index');
    }


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Produto::query()
            ->when(
                filled($this->search),
                fn($query) =>
                $query->where(function ($q) {
                    $term = '%' . trim($this->search) . '%';
                    $q->where('nome', 'like', $term)
                        ->orWhere('sku', 'like', $term);
                })
            )
            ->when(
                filled($this->filtro['categoria']),
                fn($query) =>
                $query->whereHas(
                    'categorias',
                    fn($q) =>
                    $q->where('categoria_id', $this->filtro['categoria'])
                )
            )
            ->when(
                filled($this->filtro['tag']),
                fn($query) =>
                $query->whereHas(
                    'tags',
                    fn($q) =>
                    $q->where('tag_id', $this->filtro['tag'])
                )
            )
            ->when(
                filled($this->filtro['status']),
                fn($query) =>
                $query->where('status', $this->filtro['status'])
            )
            ->when(
                filled($this->filtro['tipo']),
                fn($query) =>
                $query->where('tipo', $this->filtro['tipo'])
            )
            ->when(
                blank($this->search)
                    && blank($this->filtro['categoria'])
                    && blank($this->filtro['tag'])
                    && blank($this->filtro['status'])
                    && blank($this->filtro['tipo']),
                fn($query) => $query // Nenhum filtro — retorna tudo
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
