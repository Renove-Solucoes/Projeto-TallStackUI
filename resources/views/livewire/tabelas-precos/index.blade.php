<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="mb-2 font-medium text-2xl">Cadastro de Tabelas de Preços</h1>
            <div class="flex items-center gap-2">
                {{-- <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideOpen('filtro')" sm />
                <x-button icon="x-mark" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm /> --}}
                <livewire:tabelas-precos.create @created="$refresh" />
            </div>
        </div>
            <x-table stripped striped :sort :$headers :rows="$this->rows" paginate filter :quantity="[5, 10, 20]"
                :placeholders="['search' => 'Pesquisar por nome']">

                @interact('column_data_de', $row)
                    {{ date('d/m/Y', strtotime($row->data_de)) }}
                @endinteract

                @interact('column_data_ate', $row)
                    {{ date('d/m/Y', strtotime($row->data_ate)) }}
                @endinteract

                @interact('column_status', $row)
                    <x-badge text="{{ $row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
                @endinteract

                @interact('column_action', $row)
                    <div class="flex gap-1">
                        <x-button.circle icon="pencil" color="sky"
                            wire:click="$dispatch('load::tabelaPreco', { 'tabelaPreco' : '{{ $row->id }}'})" outline />
                        <livewire:tabelas-precos.delete :tabelaPreco="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    </div>
                @endinteract
            </x-table>
            <livewire:tabelas-precos.update @updated="$refresh" />
    </x-card>
</div>
