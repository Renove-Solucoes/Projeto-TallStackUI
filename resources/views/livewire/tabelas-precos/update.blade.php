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
                    <x-select.styled label="{{ __('Status') }} *" wire:model="tabelaPreco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>


            <div class="dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300">

                <x-card header="Produtos">
                    <x-slot:header class="w-100 dark:border-b-0">
                        <div class="flex justify-between items-center p-2 ">
                            <div class="flex justify-between items-center">

                                <h1 class="text-md font-medium text-secondary-700 dark:text-dark-300 ml-2"> Itens</h1>
                            </div>
                            

                        </div>
                    </x-slot:header>
                    <div class="grid md:grid-cols-12 md:gap-2 space-y-2">
                        <div class="md:col-span-6">
                            DESCRICAO
                        </div>
                        <div class="md:col-span-2">
                            SKU
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
                                <div class="md:col-span-6 relative" x-data="{ aberto: false }" @click.away="aberto = false"
                                    @keydown.escape.window="aberto = false">
                                    <x-input wire:model.live.debounce.500ms="itens.{{ $index }}.descricao"
                                        placeholder="Pesquise aqui por SKU(código) ou descrição" autocomplete="off"
                                        @focus="aberto = true" @input="aberto = true" re/>

                                    @if (!empty($sugestoes[$index]))
                                        <ul x-show="aberto && {{ !empty($sugestoes[$index]) ? 'true' : 'false' }}"
                                            x-transition
                                            class="absolute z-100 w-full bg-white dark:bg-dark-600 border  border-gray-500 rounded-md shadow-md mt-1 max-h-60 overflow-auto">
                                            @foreach ($sugestoes[$index] as $produto)
                                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm  text-secondary-700 dark:text-dark-300 dark:hover:bg-gray-700"
                                                    wire:click="selecionarItem({{ $index }}, '{{ $produto['id'] }}')">
                                                    {{ $produto['nome'] }} ( {{ $produto['sku'] }} )
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="md:col-span-2">
                                    <x-input wire:model="itens.{{ $index }}.sku" readonly />
                                </div>
                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR" symbol="R$" wire:model.debounce="itens.{{ $index }}.preco" required />
                                </div>
                                <div class="md:col-span-2 flex gap-1 items-center justify-between">
                                    <x-toggle label="Ativo" wire:model="itens.{{ $index }}.status"
                                        :checked="$item['status'] == 1? true : false"/>
                                    <x-button.circle icon="trash" color="amber"
                                        wire:click="removeItem({{ $index }})" outline />
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="flex gap-2">
                        <x-button icon="plus" :text="__('Adicionar Item')" wire:click="addItem" sm />
                    </div>
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
