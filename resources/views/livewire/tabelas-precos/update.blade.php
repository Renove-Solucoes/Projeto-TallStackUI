<div>
    <x-modal :title="__('Update Tabela de Preços: #:id', ['id' => $tabelasPreco?->id])" wire>
        <form id="tabelasPrecos-update-{{ $tabelasPreco?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-12">
                    <x-input label="{{ __('Descrição') }} *" x-ref="name" wire:model="tabelasPreco.descricao" required />
                </div>
                <div class="md:col-span-4">
                    <x-input type="date" label="{{ __('Data de') }} *" wire:model="tabelasPreco.data_de" required />
                </div>
                <div class="md:col-span-4">
                    <x-input type="date" label="{{ __('Data ate') }} *" wire:model="tabelasPreco.data_ate"
                        required />
                </div>
                <div class="md:col-span-4">
                    <x-select.native label="{{ __('Status') }} *" wire:model="tabelasPreco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="tabelasPrecos-update-{{ $tabelasPreco?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
