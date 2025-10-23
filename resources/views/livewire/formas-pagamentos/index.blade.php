<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="mb-2 font-medium text-2xl">Cadastro de Formas de Pagamentos</h1>
            <div class="flex items-center gap-2">
                {{-- <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideOpen('filtro')" sm />
                <x-button icon="x-mark" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm /> --}}
                <livewire:formas-pagamentos.create @created="$refresh" />
            </div>
        </div>
        <x-table stripped striped :sort :$headers :rows="$this->rows" paginate filter :quantity="[5, 10, 20]" :placeholders="['search' => 'Pesquisar por Forma de Pagamento']">
            @interact('column_status', $row)
                <x-badge text="{{ $row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
            @endinteract
            @interact('column_tipo_pagamento', $row)
                {{ $row->tipo_pagamento->getText() }}
            @endinteract

            @interact('column_juros', $row)
                {{ number_format($row->juros, 2, ',', '.') }} %
            @endinteract


            @interact('column_multa', $row)
                 {{ number_format($row->multa, 2, ',', '.') }} %
            @endinteract

            @interact('column_aplicavel_em', $row)
                <x-badge text="{{ $row->aplicavel_em->getText() }}" color="{{ $row->aplicavel_em->getColor() }}" outline />
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" color="sky"
                        wire:click="$dispatch('load::FormasPagamentos', { FormasPagamentos: {{ $row->id }} })"
                        outline />

                    {{-- <livewire:formas-pagamentos.delete :forma_pagamento="$row" :key="uniqid('', true)" @deleted="$refresh" /> --}}
                </div>
            @endinteract

        </x-table>
        <livewire:formas-pagamentos.update @updated="$refresh" />
    </x-card>
</div>
