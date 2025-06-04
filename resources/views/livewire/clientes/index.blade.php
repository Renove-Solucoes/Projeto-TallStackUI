<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:clientes.create @created="$refresh" />
        </div>

        <x-table striped :$headers :$sort :rows="$this->rows" paginate filter :quantity="[5, 10, 20]">
            @interact('column_status', $row)
                <x-badge text="{{$row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
            @endinteract

            @interact('column_nascimento', $row)
                {{ date('d/m/Y', strtotime($row->nascimento)) }}
            @endinteract

            @interact('column_credito', $row)
                {{ number_format($row->credito, 2, ',', '.') }}
            @endinteract

            @interact('column_created_at', $row)
                {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" color="sky"
                        wire:click="$dispatch('load::cliente', { 'cliente' : '{{ $row->id }}'})" outline />
                    <livewire:clientes.delete :cliente="$row" :key="uniqid('', true)" @deleted="$refresh"  />
                </div>
            @endinteract

        </x-table>
        <livewire:clientes.update @updated="$refresh" />
    </x-card>
</div>
