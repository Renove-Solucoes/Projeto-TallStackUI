<?php

namespace App\Livewire\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 10;

    public ?string $search = null;

    public Categoria $categoria;

    public bool $slide = false;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];



    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'nome', 'label' => 'Nome'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];

    public function render(): View
    {
        return view('livewire.categorias.index');
    }


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Categoria::query()
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search !== null, fn(Builder $query) => $query->whereAny(['nome'], 'like', '%' . trim($this->search) . '%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
