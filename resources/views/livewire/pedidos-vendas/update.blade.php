<div>
    <x-card class="rounded-lg">
        <form id="pedidos-update-{{ $pedidosVenda?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-12 gap-4">
                <div
                    class="flex items-center justify-between md:col-span-12 text-lg font-semibold text-gray-900 dark:text-white border-b-1 border-gray-200 dark:border-gray-600 pb-4">
                    <div>Pedido {{ $pedidosVenda?->id }}</div>
                    <div>
                        <x-button href="{{ route('pedidosvendas.index') }}" color="gray" icon='chevron-left'
                            :text="__('Voltar')" sm />
                    </div>
                </div>
            </div>
            <x-tab selected="Cliente">
                <x-tab.items tab="Cliente">
                    <x-slot:left>
                        <x-icon name="user" class="w-5 h-5" />
                    </x-slot:left>
                    <div class="grid grid-cols-12 gap-4">

                        <div x-data="{ tipoPessoa: @entangle('pedidosVenda.tipo_pessoa') }" class="md:col-span-12 grid md:grid-cols-12 md:gap-4">

                            <div class=" md:col-span-3">
                                <div class="md:col-span-6 relative" x-data="{ abertoCliente: false }"
                                    @click.away="abertoCliente = false" @keydown.escape.window="abertoCliente = false">
                                    <x-input wire:model.live.debounce.500ms="pedidosVenda.nome" label="Cliente *"
                                        placeholder="Pesquise aqui por nome ou CPF/CNPJ" autocomplete="off"
                                        @focus="abertoCliente = true" @input="abertoCliente = true" require
                                        icon="magnifying-glass" position="right" />

                                    @if (!empty($sugestoesClientes))
                                        <ul x-show="abertoCliente && {{ !empty($sugestoesClientes) ? 'true' : 'false' }}"
                                            x-transition
                                            class="absolute z-100 w-full bg-white dark:bg-dark-600 border  border-gray-500 rounded-md shadow-md mt-1 max-h-60 overflow-auto">
                                            @foreach ($sugestoesClientes as $cliente)
                                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm  text-secondary-700 dark:text-dark-300 dark:hover:bg-gray-700"
                                                    wire:click="selecionarCliente('{{ $cliente['id'] }}')">
                                                    {{ $cliente['nome'] }} ( {{ $cliente['cpf_cnpj'] }} )
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>



                            <div class="md:col-span-2">
                                <x-select.native label="Tipo Pessoa *" wire:model="pedidosVenda.tipo_pessoa"
                                    x-model="tipoPessoa" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id" required />
                            </div>

                            <div class="md:col-span-2">
                                <x-input label="CPF/CNPJ *" wire:model="pedidosVenda.cpf_cnpj"
                                    x-mask:dynamic="tipoPessoa === 'J' ? '99.999.999/9999-99' : '999.999.999-99'"
                                    required />
                            </div>

                            <!-- Email -->
                            <div class=" md:col-span-3">
                                <x-input label="Email *" wire:model="pedidosVenda.email" required />
                            </div>

                            <!-- Telefone -->
                            <div class=" md:col-span-2">
                                <x-input label="Telefone *" x-mask="(99) 99999-9999" wire:model="pedidosVenda.telefone"
                                    required />
                            </div>

                            <!-- Data de Emissão -->
                            <div class=" md:col-span-2">
                                <x-input type="date" label="Data de Emissão *" wire:model="pedidosVenda.data_emissao"
                                    required />
                            </div>

                            <!-- Status -->
                            <div class=" md:col-span-2">
                                <x-select.native label="Status *" wire:model="pedidosVenda.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                                    select="label:name|value:id" required />
                            </div>


                            <!-- Tabela de Preços -->
                            <div class="md:col-span-4">
                                <x-select.native label="Tabela de Preços *" wire:model.lazy="pedidosVenda.tabela_preco_id"
                                    :options="$tabelasPrecos" select="label:name|value:id" required
                                    placeholder="Selecione uma tabela" />
                            </div>

                            <!-- Vendedor -->
                            <div class="md:col-span-4">
                                <x-select.native label="Vendedor *" wire:model="pedidosVenda.vendedor_id"
                                    :options="[['name' => 'Selecione um vendedor', 'id' => null], ...$vendedorId]" select="label:name|value:id" required
                                    placeholder="Selecione um vendedor" />
                            </div>

                            <!-- Segundo Vendedor(opcional) -->
                            <div class="md:col-span-4">
                                <x-select.native label="Vendedor 2 (Opcional)" wire:model="pedidosVenda.vendedor2_id"
                                    :options="[['name' => 'Selecione um vendedor', 'id' => null], ...$vendedorId]" select="label:name|value:id"
                                    placeholder="Selecione um vendedor" />
                            </div>

                        </div>

                    </div>
                </x-tab.items>
                <x-tab.items tab="Endereço">
                    <x-slot:left>
                        <x-icon name="map-pin" class="w-5 h-5" />
                    </x-slot:left>
                    <div class="grid grid-cols-12 gap-4">
                        <!-- CEP -->
                        <div class=" md:col-span-2">
                            <x-input label="CEP *" wire:model.blur="pedidosVenda.cep" required maxlength="8" />
                            {!! $cepErrorHtml !!}
                        </div>

                        <!-- Endereço -->
                        <div class=" md:col-span-3">
                            <x-input label="Endereço *" wire:model="pedidosVenda.endereco" required maxlength="120" />
                        </div>

                        <!-- Número -->
                        <div class=" md:col-span-2">
                            <x-input label="Número *" wire:model="pedidosVenda.numero" required maxlength="10" />
                        </div>

                        <!-- Bairro -->
                        <div class=" md:col-span-2">
                            <x-input label="Bairro *" wire:model="pedidosVenda.bairro" required maxlength="80" />
                        </div>

                        <!-- Cidade -->
                        <div class=" md:col-span-2">
                            <x-input label="Cidade *" wire:model="pedidosVenda.cidade" required maxlength="80" />
                        </div>

                        <!-- UF -->
                        <div class=" md:col-span-1">
                            <x-select.native label="UF *" wire:model="pedidosVenda.uf" :options="[
                                ['name' => 'AC', 'value' => 'AC'],
                                ['name' => 'AL', 'value' => 'AL'],
                                ['name' => 'AP', 'value' => 'AP'],
                                ['name' => 'AM', 'value' => 'AM'],
                                ['name' => 'BA', 'value' => 'BA'],
                                ['name' => 'CE', 'value' => 'CE'],
                                ['name' => 'DF', 'value' => 'DF'],
                                ['name' => 'ES', 'value' => 'ES'],
                                ['name' => 'GO', 'value' => 'GO'],
                                ['name' => 'MA', 'value' => 'MA'],
                                ['name' => 'MT', 'value' => 'MT'],
                                ['name' => 'MS', 'value' => 'MS'],
                                ['name' => 'MG', 'value' => 'MG'],
                                ['name' => 'PA', 'value' => 'PA'],
                                ['name' => 'PB', 'value' => 'PB'],
                                ['name' => 'PR', 'value' => 'PR'],
                                ['name' => 'PE', 'value' => 'PE'],
                                ['name' => 'PI', 'value' => 'PI'],
                                ['name' => 'RJ', 'value' => 'RJ'],
                                ['name' => 'RN', 'value' => 'RN'],
                                ['name' => 'RS', 'value' => 'RS'],
                                ['name' => 'RO', 'value' => 'RO'],
                                ['name' => 'RR', 'value' => 'RR'],
                                ['name' => 'SC', 'value' => 'SC'],
                                ['name' => 'SP', 'value' => 'SP'],
                                ['name' => 'SE', 'value' => 'SE'],
                                ['name' => 'TO', 'value' => 'TO'],
                            ]"
                                select="label:name|value" required maxlength="2" />
                        </div>

                        <!-- Complemento -->
                        <div class=" md:col-span-5">
                            <x-input label="Complemento" wire:model="pedidosVenda.complemento" maxlength="120" />
                        </div>

                    </div>
                </x-tab.items>
            </x-tab>



            <div class="dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300 picotado">

                <x-card header="Produtos">
                    <x-slot:header class="w-100 dark:border-b-0">
                        <div class="flex justify-between items-center p-2 ">
                            <div class="flex justify-between items-center">

                                <h1 class="text-md font-medium text-secondary-700 dark:text-dark-300 ml-2"> Itens</h1>
                            </div>


                        </div>
                    </x-slot:header>
                    <div class="grid md:grid-cols-20 md:gap-2 space-y-2">
                        <div class="md:col-span-6">
                            Descrição
                        </div>
                        <div class="md:col-span-2">
                            SKU
                        </div>
                        <div class="md:col-span-1">
                            UN
                        </div>
                        <div class="md:col-span-2">
                            Qtd
                        </div>

                        <div class="md:col-span-2">
                            Preço
                        </div>
                        <div class="md:col-span-2">
                            Desconto
                        </div>
                        <div class="md:col-span-2">
                            Preço final
                        </div>
                        <div class="md:col-span-2">
                            Total item
                        </div>
                    </div>

                    @foreach ($itens as $index => $item)

                        @if ($item['deleted'] == 0)
                            <div class="grid md:grid-cols-20 md:gap-2 space-y-2">
                                <div class="md:col-span-6 relative" x-data="{ abertoItens: false }"
                                    @click.away="abertoItens = false" @keydown.escape.window="abertoItens = false">
                                    <x-input wire:model.live.debounce.500ms="itens.{{ $index }}.descricao"
                                        placeholder="Pesquise aqui por SKU(código) ou descrição" autocomplete="off"
                                        @focus="abertoItens = true" @input="abertoItens = true" require
                                        icon="magnifying-glass" position="right" />


                                    @if (!empty($sugestoesItens[$index]))
                                        <ul x-show="abertoItens && {{ !empty($sugestoesItens[$index]) ? 'true' : 'false' }}"
                                            x-transition
                                            class="absolute z-100 w-full bg-white dark:bg-dark-600 border  border-gray-500 rounded-md shadow-md mt-1 max-h-60 overflow-auto">
                                            @foreach ($sugestoesItens[$index] as $produto)
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

                                <div class="md:col-span-1">
                                    <x-input wire:model="itens.{{ $index }}.unidade" readonly />
                                </div>

                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR"
                                        x-on:blur="$wire.set('itens.{{ $index }}.quantidade', $el.value)"
                                        wire:model="itens.{{ $index }}.quantidade" max="9999"
                                        min="1" required />
                                </div>

                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR" symbol="R$"
                                        wire:model="itens.{{ $index }}.preco" required readonly />
                                </div>

                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR" symbol="%"
                                        x-on:blur="$wire.set('itens.{{ $index }}.desconto', $el.value)"
                                        wire:model="itens.{{ $index }}.desconto" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR" symbol="R$"
                                        wire:model="itens.{{ $index }}.preco_final" required readonly />
                                </div>

                                <div class="md:col-span-2">
                                    <x-currency mutate locale="pt-BR" symbol="R$"
                                        wire:model="itens.{{ $index }}.total" readonly />
                                </div>

                                <div class="md:col-span-1">
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

            <x-card>

                <div class="grid grid-cols-12 gap-4">

                    <div class="md:col-span-2">
                        <x-currency label="{{ __('Desc. Comercial') }} " mutate locale="pt-BR" symbol="%"
                            x-on:blur="$wire.set('pedidosVenda.desc1', $el.value)" wire:model="pedidosVenda.desc1" />
                    </div>
                    <div class="md:col-span-2">
                        <x-currency label="{{ __('Frete') }} " mutate locale="pt-BR" symbol="R$"
                            x-on:blur="$wire.set('pedidosVenda.frete', $el.value)" wire:model="pedidosVenda.frete" />
                    </div>
                    <div class="md:col-span-2">
                        <x-currency label="{{ __('Total') }} " mutate locale="pt-BR" symbol="R$"
                            wire:model="pedidosVenda.total" readonly />
                    </div>

                </div>
            </x-card>

            <x-button type="submit" icon="check" form="pedidos-update-{{ $pedidosVenda?->id }}" loading>
                @lang('    Salvar     ')

            </x-button>

        </form>

    </x-card>
</div>
