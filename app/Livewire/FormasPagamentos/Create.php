<?php

namespace App\Livewire\FormasPagamentos;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\FormasPagamentos;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class Create extends Component
{
    use Alert;

    public FormasPagamentos $FormasPagamentos;

    public bool $modal = false;

    public function mount()
    {
        $this->FormasPagamentos = new FormasPagamentos();
        $this->FormasPagamentos->tipo_pagamento = 0;
        $this->FormasPagamentos->aplicavel_em = 'A';
        $this->FormasPagamentos->status = 'A';

        $this->FormasPagamentos->lancar_dia_util = false;
    }

    public function rules(): array
    {
        return [
            'FormasPagamentos.descricao' => ['required', 'string', 'max:20', Rule::unique('formas_pagamentos', 'descricao')],
            'FormasPagamentos.tipo_pagamento' => ['required', 'string', 'max:50'],
            'FormasPagamentos.condicao_pagamento' => ['required', 'string', 'max:20'],
            'FormasPagamentos.aplicavel_em' => [
                'required',
                'string',
                'max:1',
            ],
            'FormasPagamentos.juros' => ['required', 'numeric'],
            'FormasPagamentos.multa' => ['required', 'numeric'],
            'FormasPagamentos.lancar_dia_util' => ['required', 'boolean'],
            'FormasPagamentos.status' => ['required', 'string', 'max:1'],
        ];
    }


    public function render()
    {
        return view('livewire.formas-pagamentos.create');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->FormasPagamentos->save();
            $this->modal = false;

            $this->reset('FormasPagamentos', 'modal');
            $this->FormasPagamentos = new FormasPagamentos();
            $this->FormasPagamentos->aplicavel_em = 'A';
            $this->FormasPagamentos->status = 'A';


            $this->dispatch('created');
            $this->toast()
                ->success('Atenção!', 'Forma de pagamento criada com sucesso.')
                ->send();
        } catch (\Exception $e) {
            \Log::error('Erro ao criar forma de pagamento', [
                'user_id' => auth()->id(),
                'message' => $e->getMessage(),
            ]);
            $this->error('Atenção!', 'Não foi possível criar a forma de pagamento.');
        }
    }
}
