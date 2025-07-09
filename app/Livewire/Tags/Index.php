<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;


    public ?int $quantity = 10;

    public ?string $search = null;

    public Tag $tag;

    public bool $slide = false;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];



    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'tipo_nome', 'label' => 'Tipo'],
        ['index' => 'nome', 'label' => 'Nome'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];



    public function render()
    {
        return view('livewire.tags.index');
    }


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Tag::query()
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search !== null, fn(Builder $query) => $query->whereAny(['nome', 'tipo_nome'], 'like', '%' . trim($this->search) . '%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
