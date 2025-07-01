<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
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

    public $filtro = [
        'nome' => null,
    ];

    public bool $slide = false;

    public ?int $quantity = 10;
    public ?string $search = null;
    public array $sort = [
        'column'    => 'id',
        'direction' => 'desc',
    ];

    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'tipo_pessoa', 'label' => 'TP'],
        ['index' => 'cpf_cnpj', 'label' => 'CPF/CNPJ', 'sortable' => false],
        ['index' => 'nome', 'label' => 'Nome'],
        // ['index' => 'email', 'label' => 'Email'],
        ['index' => 'telefone', 'label' => 'Telefone', 'sortable' => false],
        ['index' => 'nascimento', 'label' => 'Nacimento'],
        ['index' => 'credito', 'label' => 'Credito'],
        // ['index' => 'credito_ativo', 'label' => 'Ativo'],
        ['index' => 'created_at', 'label' => 'Created', 'sortable' => false],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'sortable' => false],
        // ...
    ];

    public function render(): View
    {
        return view('livewire.clientes.index');
    }

    public function filtrar()
    {
        $this->rows();
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Cliente::query()
            ->when(
                filled($this->search) && blank($this->filtro['nome']),
                fn(Builder $query) =>
                $query->whereAny(['nome', 'email'], 'like', '%' . trim($this->search) . '%')
            )
            ->when(
                filled($this->filtro['nome']) && blank($this->search),
                fn(Builder $query) =>
                $query->where('nome', 'like', '%' . trim($this->filtro['nome']) . '%')
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
