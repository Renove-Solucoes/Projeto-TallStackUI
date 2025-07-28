<div>
    <x-modal :title="__('Update Tabela de Preços: #:id', ['id' => $tabelaPreco?->id])" wire size="6xl" z-index="z-40">
        <form id="tabelasPrecos-update-{{ $tabelaPreco?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-12">
                    <x-input label="{{ __('Descrição') }} *" x-ref="name" wire:model="tabelaPreco.descricao" required />
                </div>
                <div class="md:col-span-4">
                    <x-input type="date" label="{{ __('Data de') }} *" wire:model="tabelaPreco.data_de" required />
                </div>
                <div class="md:col-span-4">
                    <x-input type="date" label="{{ __('Data ate') }} *" wire:model="tabelaPreco.data_ate" required />
                </div>
                <div class="md:col-span-4">
                    <x-select.native label="{{ __('Status') }} *" wire:model="tabelaPreco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>


            <div class="overflow-hidden dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300">

                <x-card header="Produtos">
                    <x-slot:header class="cursor-pointer w-100" icon="x-mark">
                        <div class="flex justify-between items-center p-4 ">
                            <div class="flex justify-between items-center">

                                <h1 class="text-md font-medium text-secondary-700 dark:text-dark-300 ml-2"> Itens</h1>
                            </div>
                            <div class="flex gap-2">
                                <x-button icon="x-mark" :text="__('Adicionar')" wire:click="addItem" sm />
                            </div>

                        </div>
                    </x-slot:header>
                    <div class="grid md:grid-cols-12 md:gap-2 space-y-2">
                        <div class="md:col-span-2">
                            SKU
                        </div>
                        <div class="md:col-span-6">
                            DESCRICAO
                        </div>
                        <div class="md:col-span-2">
                            PRECO
                        </div>
                        <div class="md:col-span-2">
                            STATUS
                        </div>
                    </div>

                    @foreach ($itens as $index => $item)
                        @if ($item['deleted'] == 0)
                            <div class="grid md:grid-cols-12 md:gap-2 space-y-2">
                                <div class="md:col-span-2">
                                    <x-input wire:model="itens.{{ $index }}.id" />
                                    <x-input wire:model="itens.{{ $index }}.sku" />
                                    <x-input wire:model="itens.{{ $index }}.produto_id" />
                                </div>
                                <div class="md:col-span-6">
                                    <x-input wire:model="itens.{{ $index }}.descricao" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR" symbol="R$"
                                        wire:model="itens.{{ $index }}.preco" required />
                                </div>
                                <div class="md:col-span-2">
                                    <x-button.circle icon="trash" color="amber"
                                        wire:click="removeItem({{ $index }})" outline />
                                </div>
                            </div>
                        @endif
                    @endforeach
                </x-card>
            </div>

        </form>
        <x-slot:footer>
            <x-button type="submit" form="tabelasPrecos-update-{{ $tabelaPreco?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
