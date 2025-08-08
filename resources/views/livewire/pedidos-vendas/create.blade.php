<div class="picotado">
    <x-card>
        <form id="pedidos-create" wire:submit="save" class="grid grid-cols-12 gap-4">

            <div
                class="flex items-center justify-between md:col-span-12 text-lg font-semibold text-gray-900 dark:text-white border-b-1 border-gray-200 dark:border-gray-600 pb-4">
                <div>Novo Pedido</div>
                <div>
                    <x-button href="{{ route('pedidosvendas.index') }}" color="gray" icon='chevron-left'
                        :text="__('Voltar')" sm loading />
                </div>
            </div>

            <!-- Tipo Pessoa -->
            <div x-data="{ tipoPessoa: @entangle('pedidosVenda.tipo_pessoa') }" class="md:col-span-12 grid md:grid-cols-12 md:gap-4">

                                    <div class=" md:col-span-3">
                        <div class="md:col-span-6 relative" x-data="{ aberto: false }" @click.away="aberto = false"
                            @keydown.escape.window="aberto = false">
                            <x-input wire:model.live.debounce.500ms="pedidosVenda.nome" label="Cliente *"
                                placeholder="Pesquise aqui por nome ou CPF/CNPJ" autocomplete="off"
                                @focus="aberto = true" @input="aberto = true" re />

                            @if (!empty($sugestoes))
                                <ul x-show="aberto && {{ !empty($sugestoes) ? 'true' : 'false' }}" x-transition
                                    class="absolute z-100 w-full bg-white dark:bg-dark-600 border  border-gray-500 rounded-md shadow-md mt-1 max-h-60 overflow-auto">
                                    @foreach ($sugestoes as $cliente)
                                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm  text-secondary-700 dark:text-dark-300 dark:hover:bg-gray-700"
                                            wire:click="selecionarItem('{{ $cliente['id'] }}')">
                                            {{ $cliente['nome'] }} ( {{ $cliente['cpf_cnpj'] }} )
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                <div class="md:col-span-3">
                    <x-select.native label="Tipo Pessoa *" wire:model="pedidosVenda.tipo_pessoa" x-model="tipoPessoa"
                        :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id" required />
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
                ]" select="label:name|value"
                    required maxlength="2" />
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

        </form>
        <x-slot:footer>
            <x-button type="submit" form="pedidos-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-card>


</div>
