<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:clientes.create @created="$refresh" />
        </div>

        {{-- //TODO na table index, colocar coluna da tabela fixa
            definir altura da div para que a tabela tenha rolagem horizontal
            mudar local do botão criar para ganhar espaço --}}
        <x-table striped :$headers :$sort :rows="$this->rows" paginate filter :quantity="[5, 10, 20]">


            @interact('column_nascimento', $row)
                {{ date('d/m/Y', strtotime($row->nascimento)) }}
            @endinteract

            @interact('column_credito', $row)
                <div class="flex items-center justify-end gap-1">
                    R$ {{ number_format($row->credito, 2, ',', '.') }}
                    <x-boolean :boolean="$row->credito_ativo" icon-when-true="currency-dollar"
                        icon-when-false="currency-dollar" />
                </div>
            @endinteract

            {{-- @interact('column_credito_ativo', $row)
                <x-toggle :checked="$row->credito_ativo ? true : false" />
            @endinteract --}}

            @interact('column_created_at', $row)
                {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_status', $row)
                <x-badge text="{{ $row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" color="sky"
                        wire:click="$dispatch('load::cliente', { 'cliente' : '{{ $row->id }}'})" outline />
                    <livewire:clientes.delete :cliente="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract

        </x-table>
        <livewire:clientes.update @updated="$refresh" />
    </x-card>
</div>
