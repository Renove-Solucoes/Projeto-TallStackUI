<?php

namespace App\Livewire\Produtos;

use App\Livewire\Traits\Alert;
use App\Models\Produto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Update extends Component
{
    use Alert;
    use WithFileUploads;

    public Produto $produto;
    public bool $modal = false;
    public $imagemTemp = '';

    public function render(): View
    {
        return view('livewire.produtos.update');
    }

    #[On('load::produto')] // Corrigido para minúsculo
    public function load(Produto $produto): void
    {
        $this->produto = $produto;
        $this->imagemTemp = ''; // Corrigida atribuição
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function rules(): array // Nome corrigido
    {
        return [
            'produto.nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produtos', 'nome')->ignore($this->produto->id),
            ],
            'produto.sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('produtos', 'sku')->ignore($this->produto->id),
            ],
            'produto.tipo' => [
                'required',
                'string',
                'in:F,D'
            ],
            'produto.unidade' => [
                'required',
                'string',
                'max:10'
            ],
            'produto.data_validade' => [
                'required',
                'date'
            ],
            'produto.preco_padrao' => [
                'required',
                'numeric',
                'min:0'
            ],
            'produto.status' => [
                'required',
                'string',
                'in:A,I'
            ],
            'imagemTemp' => [
                'nullable',
                'image',
                'max:2048'
            ],
        ];
    }

    public function deleteUpload(array $content): void
    {
        $files = Arr::wrap($this->imagemTemp);

        /** @var UploadedFile $file */
        $file = collect($files)->filter(
            fn(UploadedFile $item) => $item->getFilename() === $content['temporary_name']
        )->first();

        rescue(fn() => $file->delete(), report: false);

        $collect = collect($files)->filter(
            fn(UploadedFile $item) => $item->getFilename() !== $content['temporary_name']
        );

        $this->imagemTemp = is_array($this->imagemTemp) ? $collect->toArray() : $collect->first();
    }

    public function save(): void
    {
        try {
            $this->validate();

            if ($this->imagemTemp) {
                $path = $this->imagemTemp->store('produtos', 'public');
                $this->produto->imagem = $path;
            }

            $this->produto->update();

            $this->dispatch('updated');
            $this->resetExcept('produto');
            $this->toast()->success('Atenção!', 'Produto atualizado com sucesso.')->send();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar produto - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar o produto.');
        }
    }
}
