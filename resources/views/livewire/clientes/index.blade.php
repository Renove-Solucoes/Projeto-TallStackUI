<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:clientes.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate filter :quantity="[5, 10, 20]">

            @interact('column_created_at', $row)
                {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" color="blue"
                        wire:click="$dispatch('load::cliente', { 'cliente' : '{{ $row->id }}'})" />
                    <livewire:clientes.delete :cliente="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract

        </x-table>
        <livewire:clientes.update @updated="$refresh" />
    </x-card>
</div>
