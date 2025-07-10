<div>
    <x-button icon="plus" :text="__('Adicionar Categoria')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Adicionar Categoria')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="sm" blu>
        <form id="categoria-create" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-6">
                    <x-input label="{{ __('Nome') }} *" x-ref="nome" wire:model="categoria.nome"  />
                </div>
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Status') }} *" wire:model="categoria.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>
        </form>
            <x-slot:footer>
                <x-button type="submit" form="categoria-create">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
    </x-modal>


</div>
