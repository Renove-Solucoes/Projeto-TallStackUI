<?php

namespace App\Livewire\PedidosVendas;

use App\Models\PedidosVenda;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{


    use WithPagination;


    public ?int $quantity = 10;

    public ?string $search = null;

    public PedidosVenda $pedidosVenda;

    public bool $slide = false;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];


    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'cliente_id', 'label' => 'cliente'],
        ['index' => 'data_emissao', 'label' => 'data'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];

    public function render()
    {
        return view('livewire.pedidos-vendas.index');
    }


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return PedidosVenda::query()
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search !== null, fn(Builder $query) => $query->whereAny(['cliente_id'], 'like', '%' . trim($this->search) . '%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
