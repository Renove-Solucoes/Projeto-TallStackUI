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

    public Cliente $cliente;


    public $filtro = [
        'tipo_pessoa' => null,
        'telefone' => null,
        'credito_ativo' => '',
        'status' => '',
        'nascimento_de' => null,
        'nascimento_ate' => null,
        'periodo' => 'default',
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


    public function limparFiltros()
    {
        $this->search = null;
        $this->reset('filtro');
    }


    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Cliente::query()
            ->when(
                filled($this->search),
                fn(Builder $query) =>
                $query->whereAny(['nome', 'email', 'cpf_cnpj'], 'like', '%' . trim($this->search) . '%')
            )
            ->when(
                filled($this->filtro['tipo_pessoa']),
                fn(Builder $query) =>
                $query->where('tipo_pessoa', 'like', '%' . trim($this->filtro['tipo_pessoa']) . '%')
            )
            ->when(
                filled($this->filtro['telefone']),
                fn(Builder $query) =>
                $query->where('telefone', 'like', '%' . trim($this->filtro['telefone']) . '%')
            )
            ->when(
                filled($this->filtro['credito_ativo']),
                fn(Builder $query) =>
                $query->where('credito_ativo', $this->filtro['credito_ativo'])
            )
            ->when(
                filled($this->filtro['status']),
                fn(Builder $query) =>
                $query->where('status', $this->filtro['status'])
            )
            ->when(
                filled($this->filtro['nascimento_de']) && filled($this->filtro['nascimento_ate']),
                fn(Builder $query) =>
                $query->whereBetween('nascimento', [
                    $this->filtro['nascimento_de'],
                    $this->filtro['nascimento_ate']
                ])
            )
            ->when(
                blank($this->search) &&
                    blank($this->filtro['tipo_pessoa']) &&
                    blank($this->filtro['telefone']) &&
                    blank($this->filtro['credito_ativo']) &&
                    blank($this->filtro['status']) &&
                    blank($this->filtro['nascimento_de']) &&
                    blank($this->filtro['nascimento_ate']),
                fn(Builder $query) =>
                $query // Nenhum filtro ativo — retorna todos os clientes
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
