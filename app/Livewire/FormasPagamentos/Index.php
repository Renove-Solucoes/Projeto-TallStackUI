<?php

namespace App\Livewire\FormasPagamentos;

use App\Models\FormasPagamentos;
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

    public FormasPagamentos $formaPagamento;

    public bool $slide = false;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'asc',
    ];


    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'descricao', 'label' => 'Descrição'],
        ['index' => 'tipo_pagamento', 'label' => 'Tipo Pagamento'],
        ['index' => 'condicao_pagamento', 'label' => 'Condiçao Pagamento'],
        ['index' => 'aplicavel_em', 'label' => 'Aplicavel Em'],
        ['index' =>  'juros', 'label' => 'Juros'],
        ['index' => 'multa', 'label' => 'Multa'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];

    public function render()
    {
        return view('livewire.formas-pagamentos.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return FormasPagamentos::query()
            ->when($this->search, function (Builder $query) {
                $query->where('descricao', 'like', "%{$this->search}%");
            })
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
