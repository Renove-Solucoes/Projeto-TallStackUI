<?php

namespace App\Livewire\Clientes;

use App\Enum\TagsStatus;
use App\Livewire\Traits\Alert;
use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Tag;
use App\Services\ViacepServices;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use Alert;

    public Cliente $cliente;
    public Endereco $endereco;

    public $imagemTemp = '';


    public $cep;
    public $tags;
    public $tags_selecionadas = [];

    public bool $modal = false;


    public function mount(): void
    {
        $this->cliente = new Cliente();
        $this->cliente->tipo_pessoa = 'F';
        $this->cliente->status = 'A';
        $this->cliente->credito = '';
        $this->cliente->credito_ativo = 1;
        $this->imagemTemp = '';

        $this->tags = Tag::where('tipo', 'C')
            ->where('status', 'A')
            ->get(['id', 'nome'])
            ->map(fn($tag) => [
                'id' => $tag->id,
                'nome' => $tag->nome,
            ])
            ->toArray();



        $this->endereco = new Endereco();
        $this->endereco->status = 'A';
    }


    public function render()
    {
        return view('livewire.clientes.create');
    }

    public function rules(): array
    {
        return [
            'imagemTemp' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,png,jpg,svg,bmp',
                'max:2048'
            ],
            'cliente.tipo_pessoa' => [
                'required',
                'string',
                'min:1',
                'max:1'
            ],
            'cliente.cpf_cnpj' => [
                'required',
                'string',
                'min:14',
                'max:18',
                Rule::unique('clientes', 'cpf_cnpj'),
            ],

            'cliente.nome' => [
                'required',
                'string',
                'max:255'
            ],
            'cliente.email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clientes', 'email'),
            ],
            'cliente.telefone' => [
                'required',
                'string',
            ],
            'cliente.credito' => [
                'required',
                'numeric',
            ],
            'cliente.credito_ativo' => [
                'required',
                'boolean',
            ],

            'cliente.nascimento' => [
                'required',
                'date',
            ],
            'cliente.status' => [
                'required',
                'string',
                'min:1',
                'max:1'
            ],
            'endereco.descricao' => [
                'required',
                'string',
                'max:20'
            ],

            'endereco.cep' => [
                'required',
                'string',
                'max:8'
            ],
            'endereco.endereco' => [
                'required',
                'string',
                'max:120'

            ],
            'endereco.bairro' => [
                'required',
                'string',
                'max:80'
            ],
            'endereco.numero' => [
                'required',
                'string',
                'max:10'
            ],
            'endereco.uf' => [
                'required',
                'string',
                'uppercase',
                'max:2'
            ],
            'endereco.cidade' => [
                'required',
                'string',
                'max:80'
            ],
            'endereco.complemento' => [
                'nullable',
                'string',
                'max:120'
            ],
            'endereco.status' => [
                'required',
                'string',
                'max:1'
            ],

        ];
    }

    public function updatedEnderecoCep()
    {

        // $this->endereco->cep = str_replace(['.', '-'], ['', ''], $this->endereco->cep);

        $viacepService = new ViacepServices();

        $result = $viacepService->getLocation($this->endereco->cep);


        if (!empty($result)) {
            $this->endereco->endereco = $result['logradouro'];
            $this->endereco->bairro = $result['bairro'];
            $this->endereco->cidade = $result['localidade'];
            $this->endereco->uf = $result['uf'];
        } else {
            $this->endereco->endereco = '';
            $this->endereco->bairro = '';
            $this->endereco->cidade = '';
            $this->endereco->uf = '';
            $this->dispatch('message', ['tipo_message' => 'info', 'message' => 'CEP não encontrado']);
        }
    }


    public function updatedClienteCredito()
    {

        $this->cliente->credito = str_replace(['.', ','], ['', '.'], $this->cliente->credito);
    }



    public function save(): void
    {

        $this->validate();
        try {



            DB::transaction(function () {
                $this->cliente->save();
                $this->endereco->cliente_id = $this->cliente->id;
                $this->endereco->principal = true;
                $this->endereco->save();
                $this->cliente->tags()->sync($this->tags_selecionadas);
            });

            $this->dispatch('created');

            //TODO: Limpar o campo moeda do formulario create depois que salvar o registro.
            $this->reset();
            $this->cliente = new Cliente();
            $this->cliente->tipo_pessoa = 'J';
            $this->cliente->status = 'I';

            $this->tags = Tag::all(['id', 'nome'])->map(fn($tag) => [
                'nome' => $tag->nome,
                'id' => $tag->id,
            ])->toArray();

            $this->success();
        } catch (\Exception $e) {
            Log::error('Erro ao criar cliente - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel criar o cliente.');
        }
    }
}
