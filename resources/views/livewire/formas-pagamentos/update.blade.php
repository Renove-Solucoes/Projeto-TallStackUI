<div>
    <x-modal :title="__('Atualizar Forma de Pagamento: #:id', ['id' => $FormasPagamentos?->id])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="xl" blur>
        <form wire:submit.prevent="save" id="formasPagamentos-update-{{ $FormasPagamentos?->id ?? 'novo' }}">
            <div class="grid md:grid-cols-12 gap-4">
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
                    <x-input label="{{ __('Juros') }} *" wire:model="FormasPagamentos.juros" required />
                </div>

                <!-- Multa -->
                <div class="md:col-span-6">
                    <x-input label="{{ __('Multa') }} *" wire:model="FormasPagamentos.multa" required />
                </div>

                <!-- Status -->
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Status') }} *" wire:model="FormasPagamentos.status"
                        :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]" select="label:name|value:id" required />
                </div>
            </div>
        </form>


        <x-slot:footer>
            <x-button type="submit" form="formasPagamentos-update-{{ $FormasPagamentos?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
