<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;
use App\Livewire\Traits\Alert;
use App\Models\Endereco;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

use function Pest\Laravel\delete;

class Update extends Component
{
    use WithFileUploads;
    use Alert;

    public ?Cliente $cliente;

    public $enderecos = [];
    public bool $modal = false;
    public $imagemTemp = '';

    public $tags;
    public $tags_selecionadas = [];

    public $setPrincipal;

    public function mount()
    {
        $this->tags = Tag::where('tipo', 'C')
            ->where('status', 'A')
            ->get(['id', 'nome'])
            ->map(fn($tag) => [
                'id' => $tag->id,
                'nome' => $tag->nome,
            ])
            ->toArray();
    }


    public function render(): View
    {
        return view('livewire.clientes.update');
    }

    #[On('load::cliente')]
    public function load(Cliente $cliente): void
    {


        $this->cliente = $cliente;
        $this->tags_selecionadas = $cliente->tags ? $cliente->tags()->pluck('tag_id')->toArray() : [];
        $this->imagemTemp = '';
        $this->enderecos = $this->cliente->enderecos()->get()->toArray();
        $this->resetErrorBag();
        $this->modal = true;
    }

    public array $sort = [
        'column'    => 'cidade',
        'direction' => 'desc',
    ];


    public $headers = [
        ['index' => 'dados', 'label' => 'Endereço(s)'],
        ['index' => 'principal', 'label' => 'Principal'],
        ['index' => 'action', 'sortable' => false],

    ];

    #[On('refresh::endereco')]
    public function loadEndereco(Endereco $endereco)
    {
        $this->enderecos = $this->cliente->enderecos()->get()->toArray();
        $this->rows();
    }

    #[Computed]
    public function rows()
    {
        return collect($this->enderecos)->map(function ($endereco) {
            return [
                'id' => $endereco['id'] ?? null,
                'dados' => "{$endereco['endereco']}, {$endereco['numero']}, {$endereco['bairro']}, {$endereco['cidade']} - {$endereco['uf']} CEP: {$endereco['cep']}",
                'principal' => $endereco['principal'],

            ];
        })->toArray();
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
                Rule::unique('clientes', 'cpf_cnpj')->ignore($this->cliente->id),
            ],

            'cliente.nome' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'cliente.email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clientes', 'email')->ignore($this->cliente->id),
            ],
            'cliente.telefone' => [
                'required',
                'string',
            ],
            'cliente.nascimento' => [
                'required',
                'date',
            ],
            'cliente.credito' => [
                'required',
                'numeric',

            ],
            'cliente.credito_ativo' => [
                'required',
                'boolean',
            ],

            'cliente.status' => [
                'required',
                'string',
                'min:1',
                'max:1'
            ],
        ];
    }



    public function updatedClienteCredito()
    {
        $this->cliente->credito = str_replace(['.', ','], ['', '.'], $this->cliente->credito);
    }

    public function deleteUpload(array $content): void
    {


        $files = Arr::wrap($this->imagemTemp);

        /** @var UploadedFile $file */
        $file = collect($files)->filter(fn(UploadedFile $item) => $item->getFilename() === $content['temporary_name'])->first();

        rescue(fn() => $file->delete(), report: false);

        $collect = collect($files)->filter(fn(UploadedFile $item) => $item->getFilename() !== $content['temporary_name']);

        $this->photo = is_array($this->imagemTemp) ? $collect->toArray('') : $collect->first();
    }


    public function endPrincipal(Endereco $endereco)
    {
        $endereco->principal = $endereco->principal ? false : true;
        if ($endereco->principal) {
            Endereco::where('cliente_id', $endereco->cliente_id)->where('principal', true)->update(['principal' => false]);
        }
        $endereco->save();
        $this->dispatch('refresh::endereco');
    }


    public function save(): void
    {


        try {
            if ($this->imagemTemp) {
                $path = $this->imagemTemp->store('clientes', 'public');
                $this->cliente->foto = $path;
            }

            $this->validate();

            DB::transaction(function () {
                $this->cliente->update();
                $this->cliente->tags()->sync($this->tags_selecionadas);
            });


            $this->dispatch('updated');
            $this->resetExcept('cliente', 'tags');
            $this->success();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar cliente - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar o cliente.');
        }
    }
}
