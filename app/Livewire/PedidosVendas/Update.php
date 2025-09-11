<?php

namespace App\Livewire\PedidosVendas;

use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use App\Models\PedidosVenda;
use App\Models\PedidosVendaItem;
use App\Models\Produto;
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

        // dd($this->pedidosVenda);
        // if ($this->itens != null) {
        //     $this->itens = $this->pedidosVenda->itens;
        // } else {
        //     $this->itens = [];
        //     $this->addItem();
        // }


        if ($this->pedidosVenda->itens()->count() > 0) {
            $itemsPedido = $this->pedidosVenda->itens()->get();

            foreach ($itemsPedido as $item) {

                $this->itens[] = [
                    'id' => $item->id,
                    'produto_id' => $item->produto_id,
                    'sku' => $item->produto->sku ?? '',
                    'unidade' => $item->produto->unidade ?? '',
                    'descricao' => $item->produto->nome ?? '',
                    'quantidade' => $item->quantidade,
                    'preco' => $item->preco,
                    'desconto' => $item->desconto ?? 0.00,
                    'preco_final' => 0.00,
                    'status' => $item->status,
                    'updated' => 0,
                    'deleted' => 0
                ];
            }
            $this->totalizarPedido();
        } else {
            $this->itens = [];
            $this->addItem();
        }
    }

    public function render()
    {
        return view('livewire.pedidos-vendas.update');
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
            'pedidosVenda.total' => ['required', 'numeric', 'min:0'],
            'pedidosVenda.complemento' => ['nullable', 'string', 'max:255'],
            'pedidosVenda.desc1' => ['nullable', 'numeric', 'min:0'],
            'pedidosVenda.desc2' => ['nullable', 'numeric', 'min:0'],
            'pedidosVenda.desc3' => ['nullable', 'numeric', 'min:0'],
            'pedidosVenda.frete' => ['nullable', 'numeric', 'min:0'],
            'itens.*.produto_id' => ['required', Rule::exists('produtos', 'id')],
            'itens.*.quantidade' => ['required', 'numeric', 'min:1'],

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

    public function selecionarCliente(Cliente $cliente)
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

    public function addItem()
    {
        //elimina os itens vazios que nao tenham a chave produto_id declarado. Devido comportamento do <x-currency-input>
        $this->itens = array_values(array_filter($this->itens, function ($item) {
            return array_key_exists('produto_id', $item);
        }));

        $this->itens[] =
            [
                'id' => '',
                'produto_id' => '',
                'sku' => '',
                'unidade' => '',
                'fracionar' => true,
                'descricao' => '',
                'quantidade' => 1,
                'preco' => 0.00,
                'desconto' => 0.00,
                'preco_final' => 0.00,
                'total' => 0.00,
                'status' => 1,
                'updated' => 0,
                'deleted' => 0
            ];
    }

    public function removeItem($index)
    {
        // unset($this->itens[$index]);
        $this->itens = array_values($this->itens); // reindexa
        $this->itens[$index]['deleted'] = 1;

        $this->totalizarPedido();
    }

    public function updatedItens($value, $key)
    {
        $index = explode('.', $key);
        $this->itens[$index[0]]['updated'] = 1;
        // dd($index, $key, $value);

        //se alterado descrição buscar produtos
        if (isset($index[1]) && $index[1] == 'descricao') {
            $busca = $value ?? '';
            $this->sugestoesItens = [];
            if (strlen($busca) > 2) {
                $this->sugestoesItens[$index[0]] = Produto::where('nome', 'like', '%' . $busca . '%')
                    ->orWhere('sku', 'like', '%' . $busca . '%')
                    ->limit(10)
                    ->get()
                    ->toArray();
                //se não encontrar nenhum registro
                if (count($this->sugestoesItens[$index[0]]) == 0) {
                    $this->sugestoesItens[$index[0]][] = [
                        'id' => 0,
                        'nome' => 'Nenhum produto encontrado',
                        'sku' => '!',
                    ];
                }
            } else {
                $this->sugestoesItens[$index[0]][] = [
                    'id' => 0,
                    'nome' => 'Digite pelo menos 3 caracteres',
                    'sku' => '!',
                ];
            }
        }
        //se alterado quantidade calcular total
        if ($index[1] === 'quantidade') {
            $this->totalizarPedido();
        }

        $this->totalizarPedido();
    }


    public function totalizarPedido()
    {
        //Percorrer Array Items
        $totalPedido = 0;
        $total = 0;
        foreach ($this->itens as $index => $item) {

            if ($item['deleted'] != 1) {
                $qtde = $this->currencySanitize($item['quantidade']);
                $precounitario = $this->currencySanitize($item['preco']);
                $desconto = $this->currencySanitize($item['desconto']);
                $desc1 = $this->currencySanitize($this->pedidosVenda->desc1);
                $desc2 = $this->currencySanitize($this->pedidosVenda->desc2);
                $desc3 = $this->currencySanitize($this->pedidosVenda->desc3);


                $precoFinal = $precounitario - ($precounitario * ($desconto / 100));

                $precoFinal = $precoFinal - ($precoFinal * ($desc1 / 100));
                $precoFinal = $precoFinal - ($precoFinal * ($desc2 / 100));
                $precoFinal = $precoFinal - ($precoFinal * ($desc3 / 100));

                $total = $qtde * $precoFinal;


                $total = floatval(number_format($total, 2, '.', ''));
                $precoFinal = floatval(number_format($precoFinal, 2, '.', ''));

                $this->itens[$index]['preco_final']  =  $precoFinal;
                $this->itens[$index]['total']  =  $total;

                $totalPedido += $total;
            }
        }
        $frete = $this->currencySanitize($this->pedidosVenda->frete);



        $this->pedidosVenda->total = $totalPedido + $frete;
    }


    public function updatedPedidosVenda()
    {
        $this->totalizarPedido();
    }

    public function currencySanitize($valor)
    {
        if (isset($valor) && str_contains($valor, ',')) {
            return  str_replace(['.', ','], ['', '.'], $valor);
        }

        return $valor;
    }

    public function selecionarItem($index, $produtoId)
    {

        $produto = Produto::find($produtoId);

        if ($produto) {
            $this->itens[$index]['produto_id'] = $produto->id;
            $this->itens[$index]['descricao'] = $produto->nome;
            $this->itens[$index]['sku'] = $produto->sku;
            $this->itens[$index]['unidade'] = $produto->unidade;
            $this->itens[$index]['fracionar'] = $produto->fracionar;
            $this->itens[$index]['desconto'] = 0.00;
            $this->itens[$index]['preco'] = $produto->preco_padrao;
            $this->itens[$index]['status'] = 1;
            $this->itens[$index]['updated'] = '0';
            $this->itens[$index]['deleted'] = '0';

            $this->totalizarPedido();

            $this->sugestoesItens[$index] = [];
        }
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

        foreach ($this->itens as $index => $item) {
            $this->itens[$index]['quantidade'] = $this->currencySanitize($item['quantidade']);
            $this->itens[$index]['preco'] = $this->currencySanitize($item['preco']);
            $this->itens[$index]['desconto'] = $this->currencySanitize($item['desconto']);
        }

        $this->pedidosVenda->desc1 = $this->currencySanitize($this->pedidosVenda->desc1);
        $this->pedidosVenda->desc2 = $this->currencySanitize($this->pedidosVenda->desc2);
        $this->pedidosVenda->desc3 = $this->currencySanitize($this->pedidosVenda->desc3);
        $this->pedidosVenda->frete = $this->currencySanitize($this->pedidosVenda->frete);

        $this->pedidosVenda->total = $this->currencySanitize($this->pedidosVenda->total);
        $this->validate();

        try {

            $this->pedidosVenda->save();


            foreach ($this->itens as $index => $item) {


                if (!empty($item['id']) && $item['deleted'] == 1) {
                    // Deleta
                    $itemModel = PedidosVendaItem::find($item['id']);
                    if ($itemModel) {
                        $itemModel->delete();
                    }
                } else if (!empty($item['id']) && $item['updated'] == 1) {
                    // Atualiza

                    $itemModel = PedidosVendaItem::find($item['id']);

                    if ($itemModel) {

                        $itemModel->update([
                            'produto_id' => $item['produto_id'],
                            'quantidade' => $item['quantidade'],
                            'preco' => $item['preco'],
                            'desconto' => $item['desconto'],
                            'status' => $item['status'],
                        ]);
                    }
                } else if (empty($item['id'])) {
                    // Cria

                    PedidosVendaItem::create([
                        'pedidos_venda_id' => $this->pedidosVenda->id,
                        'produto_id' => $item['produto_id'],
                        'quantidade' => $item['quantidade'],
                        'preco' => $item['preco'],
                        'desconto' => $item['desconto'],
                        'status' => $item['status'] ?? 1,
                    ]);
                }
            }


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
