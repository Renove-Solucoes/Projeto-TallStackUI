<?php

namespace App\Livewire\TabelasPrecos;

use App\Models\TabelasPreco;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;


    public ?int $quantity = 10;

    public ?string $search = null;

    public TabelasPreco $tabelasPreco;

    public bool $slide = false;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];



    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'descricao', 'label' => 'Descricao'],
        ['index' => 'data_de', 'label' => 'Data De'],
        ['index' => 'data_ate', 'label' => 'Data Ate'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];

    public function render()
    {
        return view('livewire.tabelas-precos.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return TabelasPreco::query()
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search !== null, fn(Builder $query) => $query->whereAny(['descricao'], 'like', '%' . trim($this->search) . '%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
