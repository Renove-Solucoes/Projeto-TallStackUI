<div>
    <x-button icon="plus" :text="__('Adicionar Pedido')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Adicionar Pedidos de Venda')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="xl" blur>
        <form id="pedidos-create" wire:submit="save" class="flex flex-wrap gap-x-4 gap-y-2 items-end">
            <div class="flex-1 min-w-[200px]">
                <x-select.native label="{{ __('Cliente') }} *" wire:model="pedidosVenda.cliente_id" :options="$this->clientes"
                    select="label:nome|value:id" required />
            </div>
            <div class="flex-1 min-w-[200px]">
                <x-input type="date" label="{{ __('Data de Emissão') }} *" wire:model="pedidosVenda.data_emissao"
                    required />

            </div>
            <div class="flex-1 min-w-[200px]">
                <x-select.native label="{{ __('Status') }} *" wire:model="pedidosVenda.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                    select="label:name|value:id" required />
            </div>
        </form>

        <x-slot:footer>
            <x-button type="submit" form="pedidos-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
