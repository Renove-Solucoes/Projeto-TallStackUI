<div>
    <x-modal :title="__('Update Pedido: #:id', ['id' => $pedidosVenda?->id])" wire size="6xl" z-index="z-40">
        <form id="pedidos-update-{{ $pedidosVenda?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Cliente') }} *" wire:model="pedidosVenda.cliente_id" :options="$this->clientes"
                        select="label:nome|value:id" required />
                </div>
                <div class="md:col-span-3">
                    <x-input type="date" label="{{ __('Data de Emissão') }} *" wire:model="pedidosVenda.data_emissao"
                        required />
                </div>
                <div class="md:col-span-3">
                    <x-select.native label="{{ __('Status') }} *" wire:model="pedidosVenda.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="pedidos-update-{{ $pedidosVenda?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
