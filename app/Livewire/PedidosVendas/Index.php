<?php

namespace App\Livewire\PedidosVendas;

use App\Models\Cliente;
use App\Models\PedidosVenda;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{


    use WithPagination;


    public ?int $quantity = 10;

    public ?string $search = null;

    public Cliente $cliente;
    public PedidosVenda $pedidosVenda;

    public bool $slide = false;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];


    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'cliente_id', 'label' => 'cliente'],
        ['index' => 'vendedores_nomes', 'label' => 'vendedor'],
        ['index' => 'data_emissao', 'label' => 'data'],
        ['index' => 'total', 'label' => 'Valor'],
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
            ->with('cliente')
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search, function (Builder $query) {
                $query->whereHas('cliente', function (Builder $q) {
                    $q->where('nome', 'like', "%{$this->search}%");
                });
            })
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
