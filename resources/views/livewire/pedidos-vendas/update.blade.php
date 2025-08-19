<div>
    <x-card>
        <form id="pedidos-update-{{ $pedidosVenda?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-12 gap-4">
                <div
                    class="flex items-center justify-between md:col-span-12 text-lg font-semibold text-gray-900 dark:text-white border-b-1 border-gray-200 dark:border-gray-600 pb-4">
                    <div>Pedido {{ $pedidosVenda?->id }}</div>
                    <div>
                        <x-button href="{{ route('pedidosvendas.index') }}" color="gray" icon='chevron-left'
                            :text="__('Voltar')" sm loading />
                    </div>
                </div>


                <div x-data="{ tipoPessoa: @entangle('pedidosVenda.tipo_pessoa') }" class="md:col-span-12 grid md:grid-cols-12 md:gap-4">

                    <div class=" md:col-span-3">
                        <div class="md:col-span-6 relative" x-data="{ abertoCliente: false }" @click.away="abertoCliente = false"
                            @keydown.escape.window="abertoCliente = false">
                            <x-input wire:model.live.debounce.500ms="pedidosVenda.nome" label="Cliente *"
                                placeholder="Pesquise aqui por nome ou CPF/CNPJ" autocomplete="off"
                                @focus="abertoCliente = true" @input="abertoCliente = true" require />

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


                    <div class="md:col-span-3">
                        <x-select.native label="Tipo Pessoa *" wire:model="pedidosVenda.tipo_pessoa"
                            x-model="tipoPessoa" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id" required />
                    </div>

                    <div class="md:col-span-4">
                        <x-input label="CPF/CNPJ *" wire:model="pedidosVenda.cpf_cnpj"
                            x-mask:dynamic="tipoPessoa === 'J' ? '99.999.999/9999-99' : '999.999.999-99'" required />
                    </div>

                </div>

                <!-- Email -->
                <div class=" md:col-span-3">
                    <x-input label="Email *" wire:model="pedidosVenda.email" required />
                </div>

                <!-- Telefone -->
                <div class=" md:col-span-3">
                    <x-input label="Telefone *" x-mask="(99) 99999-9999" wire:model="pedidosVenda.telefone" required />
                </div>

                <div class="md:col-span-12 text-lg font-semibold text-gray-900 dark:text-white">
                    Endereço
                </div>

                <!-- CEP -->
                <div class=" md:col-span-3">
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

                <!-- Cidade -->
                <div class=" md:col-span-4">
                    <x-input label="Cidade *" wire:model="pedidosVenda.cidade" required maxlength="80" />
                </div>

                <!-- Bairro -->
                <div class=" md:col-span-5">
                    <x-input label="Bairro *" wire:model="pedidosVenda.bairro" required maxlength="80" />
                </div>

                <!-- UF -->
                <div class=" md:col-span-2">
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

                <!-- Data de Emissão -->
                <div class=" md:col-span-6">
                    <x-input type="date" label="Data de Emissão *" wire:model="pedidosVenda.data_emissao" required />
                </div>

                <!-- Status -->
                <div class=" md:col-span-2">
                    <x-select.native label="Status *" wire:model="pedidosVenda.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>

            <div class="dark:ring-dark-600 rounded-lg shadow ring-1 ring-gray-300 picotado">

                <x-card header="Produtos">
                    <x-slot:header class="w-100 dark:border-b-0">
                        <div class="flex justify-between items-center p-2 ">
                            <div class="flex justify-between items-center">

                                <h1 class="text-md font-medium text-secondary-700 dark:text-dark-300 ml-2"> Itens</h1>
                            </div>


                        </div>
                    </x-slot:header>
                    <div class="grid md:grid-cols-12 md:gap-2 space-y-2">
                        <div class="md:col-span-4">
                            DESCRICAO
                        </div>
                        <div class="md:col-span-1">
                            SKU
                        </div>
                        <div class="md:col-span-1">
                            UN
                        </div>
                        <div class="md:col-span-2">
                            QTD
                        </div>

                        <div class="md:col-span-2">
                            PRECO
                        </div>
                        <div class="md:col-span-2">
                            Total
                        </div>
                    </div>

                    @foreach ($itens as $index => $item)

                        @if ($item['deleted'] == 0)
                            <div class="grid md:grid-cols-12 md:gap-2 space-y-2">
                                <div class="md:col-span-4 relative" x-data="{ abertoItens: false }"
                                    @click.away="abertoItens = false" @keydown.escape.window="abertoItens = false">
                                    <x-input wire:model.live.debounce.500ms="itens.{{ $index }}.descricao"
                                        placeholder="Pesquise aqui por SKU(código) ou descrição" autocomplete="off"
                                        @focus="abertoItens = true" @input="abertoItens = true" require />


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
                                <div class="md:col-span-1">
                                    <x-input wire:model="itens.{{ $index }}.sku" readonly />
                                </div>
                                <div class="md:col-span-1">
                                    <x-input wire:model="itens.{{ $index }}.unidade" readonly />
                                </div>

                                    <div class="md:col-span-2">
                                        <x-number mutate locale="pt-BR"
                                            wire:model.blur="itens.{{ $index }}.quantidade"
                                             step="0.5" min="0" max="9999" required/>
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-currency mutate locale="pt-BR" symbol="R$"
                                            wire:model="itens.{{ $index }}.preco" required readonly
                                             />
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-currency mutate locale="pt-BR" symbol="R$"
                                            wire:model="itens.{{ $index }}.total" readonly />
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
                <x-currency mutate locale="pt-BR" symbol="R$" wire:model="pedidosVenda.total" readonly />
            </x-card>

        </form>
        <x-slot:footer>
            <x-button type="submit" icon="check" form="pedidos-update-{{ $pedidosVenda?->id }}">
                @lang('    Salvar     ')
            </x-button>
        </x-slot:footer>
    </x-card>
</div>
