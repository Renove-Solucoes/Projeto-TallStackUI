<div>
    <x-button icon="plus" :text="__('Adicionar uma Tabela de Preços')" wire:click="$toggle('modal')" sm />
    <x-modal :title="__('Adicionar Tabela de Preços')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="xl" blur>
        <form id="tabelasPrecos-create" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-12">
                    <x-input label="{{ __('Descrição') }} *" x-ref="name" wire:model="tabelasPreco.descricao" required />
                </div>
                <div class="md:col-span-4">
                    <x-input type="date" label="{{ __('Data de') }} *" wire:model="tabelasPreco.data_de" required />
                </div>
                <div class="md:col-span-4">
                    <x-input type="date" label="{{ __('Data ate') }} *" wire:model="tabelasPreco.data_ate" required />
                </div>
                <div class="md:col-span-4">
                    <x-select.native  label="{{ __('Status') }} *" wire:model="tabelasPreco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="tabelasPrecos-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
