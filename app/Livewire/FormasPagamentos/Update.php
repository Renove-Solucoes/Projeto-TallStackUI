<?php

namespace App\Livewire\FormasPagamentos;

use App\Livewire\Traits\Alert;
use App\Models\FormasPagamentos;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Update extends Component
{
    use Alert;
    use WithPagination;

    public ?FormasPagamentos $FormasPagamentos;

    public bool $modal = false;

    #[On('load::FormasPagamentos')]
    public function load(FormasPagamentos $FormasPagamentos): void
    {
        $this->FormasPagamentos = $FormasPagamentos;
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'FormasPagamentos.descricao' => ['required', 'string', 'max:20'],
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

    public function render(): View
    {
        return view('livewire.formas-pagamentos.update');
    }


    public function save(): void
    {
        $this->validate();

        try {
            $this->FormasPagamentos->save();

            $this->reset(['modal', 'FormasPagamentos']);
            $this->dispatch('updated');
            $this->toast()
                ->success('Atenção!', 'Forma de pagamento atualizada com sucesso.')
                ->send();
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar forma de pagamento', [
                'user_id' => auth()->id(),
                'message' => $e->getMessage(),
            ]);
            $this->error('Atenção!', 'Não foi possível atualizar a forma de pagamento.');
        }
    }
}
