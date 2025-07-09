<?php

namespace App\Livewire\Enderecos;

use App\Livewire\Traits\Alert;
use App\Models\Endereco;
use App\Services\ViacepServices;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Update extends Component
{
    use Alert;

    public Endereco $endereco;

    public bool $modal = false;

    public function rules(): array
    {
        return [

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
            'endereco.principal' => [
                'required',
                'boolean',
            ],
            'endereco.status' => [
                'required',
                'string',
                'max:1'
            ],

        ];
    }


    #[On('load::endereco')]
    public function load(Endereco $endereco): void
    {
        $this->endereco = $endereco;
        $this->resetErrorBag();
        $this->modal = true;
    }



    public function render(): View
    {
        return view('livewire.enderecos.update');
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

    public function updatedEnderecoPrincipal()
    {
        if ($this->endereco->principal) {
            Endereco::where('cliente_id', $this->endereco->cliente_id)->where('principal', true)->update(['principal' => false]);
        }
    }


    public function save(): void
    {
        try {
            $this->validate();
            $this->endereco->update();
            $this->modal = false;
            $this->dispatch('refresh::endereco');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar endereco - User ID: ' . auth()->user()->id . ' nome: ' . auth()->user()->name . '', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            $this->error('Atenção!', 'Não foi possivel atualizar o endereco.');
        }
    }
}
