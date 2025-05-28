<div>
    <x-card>
        <x-table :$headers :$sort :rows="$this->rows" paginate filter :quantity="[5, 10, 20]">

        @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" color="blue" wire:click="$dispatch('load::cliente', { 'cliente' : '{{ $row->id }}'})" />
                {{-- <livewire:users.delete :user="$row" :key="uniqid('', true)" @deleted="$refresh" /> --}}
            </div>
        @endinteract
        
        </x-table>
    </x-card>
</div>
