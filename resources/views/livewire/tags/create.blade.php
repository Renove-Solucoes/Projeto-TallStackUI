<div>
    <x-button icon="plus" :text="__('Adicionar Tag')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Adicionar Tag')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="xl" blur>
        <form id="tag-create" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-6">
                    <x-input label="{{ __('Nome') }} *" x-ref="nome" wire:model="tag.nome" required />
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
            <x-button type="submit" form="tag-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
