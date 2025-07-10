<div>
    <x-modal :title="__('Update Tag: #:id', ['id' => $tag?->id])" wire>
        <form id="tag-update-{{ $tag?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-6">

                    <x-input label="{{ __('Nome') }} *" wire:model="tag.nome" required />
                </div>

                <div class="md:col-span-3">

                    <x-select.native label="{{ __('Tipo') }} *" wire:model="tag.tipo" :options="[['name' => 'Cliente', 'id' => 'C'], ['name' => 'Produto', 'id' => 'P']]"
                        select="label:name|value:id" required />
                </div>

                <div class="md:col-span-3">
                    <x-select.native label="{{ __('Status') }} *" wire:model="tag.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />

                </div>


            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="tag-update-{{ $tag?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
