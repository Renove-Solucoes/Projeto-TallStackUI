<?php

namespace App\Livewire\Produtos;

use App\Models\Produto;
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
            ->whereNotIn('id', [Auth::id()])
            ->when(
                $this->search !== null,
                fn($query) =>
                $query->where(function ($q) {
                    $term = '%' . trim($this->search) . '%';
                    $q->where('nome', 'like', $term)
                        ->orWhere('sku', 'like', $term);
                })
            )->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
