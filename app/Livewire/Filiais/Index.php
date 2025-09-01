<?php

namespace App\Livewire\Filiais;

use App\Models\Filial;
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

    public Filial $filial;

    public function render()
    {
        return view('livewire.filiais.index');
    }


    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];

    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'empresa_nome', 'label' => 'Empresa'],
        ['index' => 'razao_social', 'label' => 'Razão Social'],
        ['index' => 'nome_fantasia', 'label' => 'Nome Fantasia'],
        ['index' => 'tipo_pessoa_nome', 'label' => 'Tipo Pessoa'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Filial::query()
            ->with('empresa')
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search !== null, fn(Builder $query) => $query->whereAny(['nome'], 'like', '%' . trim($this->search) . '%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
