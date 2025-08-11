<?php

namespace App\Livewire\PedidosVendas;

use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use App\Models\PedidosVenda;
use App\Services\ViacepServices;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Update extends Component
{
    use Alert;
    use WithPagination;

    public ?PedidosVenda $pedidosVenda;
    public array $clientes = [];
    public string $cepErrorHtml = '';

    public $sugestoesClientes = [];

    public $itens = [];
    public $sugestoesItens = [];

    public function mount()
    {

        $this->clientes = Cliente::orderBy('nome')->get(['id', 'nome'])->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.pedidos-vendas.update');
    }

    public function load(PedidosVenda $pedidosVenda)
    {
        $this->pedidosVenda = $pedidosVenda;
        $this->resetErrorBag();
        $this->redirectRoute('pedidosvendas.edit', ['pedidosVenda' => $pedidosVenda->id]);
    }

    public function rules()
    {
        return [
            'pedidosVenda.cliente_id' => ['required', Rule::exists('clientes', 'id')],
            'pedidosVenda.data_emissao' => ['required', 'date'],
            'pedidosVenda.status' => ['required', 'string', 'max:1'],
            'pedidosVenda.tipo_pessoa' => ['required', 'string', 'max:1'],
            'pedidosVenda.cpf_cnpj' => ['required', 'string', 'max:14'],
            'pedidosVenda.nome' => ['required', 'string', 'max:255'],
            'pedidosVenda.email' => ['required', 'email', 'max:100'],
            'pedidosVenda.telefone' => ['required', 'string', 'max:15'],
            'pedidosVenda.cep' => ['required', 'string', 'max:9'],
            'pedidosVenda.endereco' => ['required', 'string', 'max:50'],
            'pedidosVenda.bairro' => ['required', 'string', 'max:30'],
            'pedidosVenda.numero' => ['required', 'string', 'max:10'],
            'pedidosVenda.cidade' => ['required', 'string', 'max:255'],
            'pedidosVenda.uf' => ['required', 'string', 'max:2'],
            'pedidosVenda.complemento' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function updatedPedidosVendaNome()
    {

        $caracters = strlen(trim($this->pedidosVenda->nome));

        $this->sugestoesClientes = [];
        if ($caracters > 2) {
            $this->sugestoesClientes = Cliente::where('nome', 'like', '%' . trim($this->pedidosVenda->nome) . '%')->get(['id', 'nome', 'cpf_cnpj'])->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                    'cpf_cnpj' => $cliente->cpf_cnpj
                ];
            })->toArray();
            if (count($this->sugestoesClientes) == 0) {
                $this->sugestoesClientes[] = [
                    'id' => 0,
                    'nome' => 'Nenhum cliente encontrado',
                    'cpf_cnpj' => '!',
                ];
            };
        } elseif ($caracters > 0) {
            $this->sugestoesClientes[] = [
                'id' => 0,
                'nome' => 'Digite pelo menos 3 caracteres',
                'cpf_cnpj' => '!',
            ];
        }
    }

    public function selecionarItem(Cliente $cliente)
    {
        $this->pedidosVenda->cliente_id = $cliente->id;
        $this->pedidosVenda->nome = $cliente->nome;
        $this->pedidosVenda->tipo_pessoa = $cliente->tipo_pessoa;
        $this->pedidosVenda->cpf_cnpj = $cliente->cpf_cnpj;
        $this->pedidosVenda->email = $cliente->email;
        $this->pedidosVenda->telefone = $cliente->telefone;

        $endereco = $cliente->enderecos()->where('principal', true)->first();
        if (!$endereco) {
            $endereco = $cliente->enderecos()->first();
        }

        $this->pedidosVenda->cep = $endereco->cep;
        $this->pedidosVenda->endereco = $endereco->endereco;
        $this->pedidosVenda->bairro = $endereco->bairro;
        $this->pedidosVenda->numero = $endereco->numero;
        $this->pedidosVenda->cidade = $endereco->cidade;
        $this->pedidosVenda->uf = $endereco->uf;
        $this->pedidosVenda->complemento = $endereco->complemento;

        $this->sugestoesClientes = [];
    }

    public function updatedPedidosVendaCep()
    {


        $viacepService = new ViacepServices();

        $result = $viacepService->getLocation($this->pedidosVenda->cep);


        if (!empty($result) or $result != null) {
            $this->pedidosVenda->endereco = $result['logradouro'];
            $this->pedidosVenda->bairro = $result['bairro'];
            $this->pedidosVenda->cidade = $result['localidade'];
            $this->pedidosVenda->uf = $result['uf'];
            $this->cepErrorHtml = '';
        } else {
            $this->pedidosVenda->endereco = '';
            $this->pedidosVenda->bairro = '';
            $this->pedidosVenda->cidade = '';
            $this->pedidosVenda->uf = '';
            $this->cepErrorHtml = '<span class="text-red-500 text-sm mt-1">CEP não encontrado. Verifique e tente novamente.</span>';
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $this->pedidosVenda->save();
            $this->dispatch('updated');
            $this->modal = false;
            $this->toast()->success('Atenção!', 'Pedido de venda atualizado com sucesso.')->flash()->send();
            return redirect()->route('pedidosvendas.index');
        } catch (\Throwable $e) {
            logger()->error('Erro ao salvar pedido', ['exception' => $e]);
            $this->toast()->error('Erro', 'Erro ao salvar: ' . $e->getMessage())->send();
        }
    }
}
