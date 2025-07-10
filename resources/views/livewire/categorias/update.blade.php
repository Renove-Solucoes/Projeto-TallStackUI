<div>
    <x-modal :title="__('Update Category: #:id', ['id' => $categoria?->id])" wire>
        <form id="categoria-update-{{ $categoria?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-6">
                    <x-input label="{{ __('Nome') }} *" wire:model="categoria.nome" required />
                </div>
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Status') }} *" wire:model="categoria.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="categoria-update-{{ $categoria?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
