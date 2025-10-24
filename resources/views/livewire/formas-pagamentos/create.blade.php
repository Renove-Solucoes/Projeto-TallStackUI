<div>
    <x-button icon="plus" :text="__('Adicionar Forma de Pagamento')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Adicionar Forma de Pagamento')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="xl" blu>
        <form id="formasPagamentos-create" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <!-- Descrição -->
                <div class="md:col-span-6">
                    <x-input label="{{ __('Descrição') }} *" wire:model="FormasPagamentos.descricao" required />
                </div>

                <!-- Tipo de Pagamento -->
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Tipo de Pagamento') }} *" wire:model="FormasPagamentos.tipo_pagamento"
                        :options="collect(\App\Enum\FormasPagamentosTipos::cases())->map(
                            fn($tipo) => [
                                'label' => $tipo->getText(),
                                'value' => $tipo->value,
                            ],
                        )" required />
                </div>

                <!-- Condição de Pagamento -->
                <div class="md:col-span-6">
                    <x-input label="{{ __('Condição de Pagamento') }} *"
                        wire:model="FormasPagamentos.condicao_pagamento" required />
                </div>

                <!-- Aplicável em -->
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Aplicável em:') }} *" wire:model="FormasPagamentos.aplicavel_em"
                        :options="[
                            ['name' => 'Ambos', 'id' => 'A'],
                            ['name' => 'Pagamentos', 'id' => 'P'],
                            ['name' => 'Recebimentos', 'id' => 'R'],
                        ]" select="label:name|value:id" required />
                </div>

                <!-- Juros -->
                <div class="md:col-span-6">
                    <x-currency mutate locale="pt-BR" symbol="%" label="{{ __('Juros') }} *" wire:model="FormasPagamentos.juros" required />
                </div>

                <!-- Multa -->
                <div class="md:col-span-6">
                    <x-currency mutate locale="pt-BR" symbol="%" label="{{ __('Multa') }} *" wire:model="FormasPagamentos.multa" required />
                </div>

                <!-- lança dia util -->
                <div class="md:col-span-6">
                   <x-checkbox label="lançar no dia util?" wire:model="FormasPagamentos.lancar_dia_util" />
                </div>

                <!-- Status -->
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Status') }} *" wire:model="FormasPagamentos.status"
                        :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]" select="label:name|value:id" required />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="formasPagamentos-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>


</div>
