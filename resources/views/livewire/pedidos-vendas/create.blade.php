<div>
    <x-card>
        <form id="pedidos-create" wire:submit="save" class="grid grid-cols-12 gap-4">

            <div class="md:col-span-12 text-lg font-semibold text-gray-900 dark:text-white">
                Formulario</div>
            <!-- Cliente -->
            <div class=" md:col-span-3">
                <x-select.native label="Cliente *" wire:model="pedidosVenda.cliente_id" :options="$this->clientes"
                    select="label:nome|value:id" required />
            </div>

            <!-- Tipo Pessoa -->
            <div x-data="{ tipoPessoa: @entangle('pedidosVenda.tipo_pessoa') }" class="md:col-span-12 grid md:grid-cols-12 md:gap-4">

                <div class="md:col-span-3">
                    <x-select.native label="Tipo Pessoa *" wire:model="pedidosVenda.tipo_pessoa" x-model="tipoPessoa"
                        :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id" required />
                </div>

                <div class="md:col-span-4">
                    <x-input label="CPF/CNPJ *" wire:model="pedidosVenda.cpf_cnpj"
                        x-mask:dynamic="tipoPessoa === 'J' ? '99.999.999/9999-99' : '999.999.999-99'" required />
                </div>

                <div class="md:col-span-5">
                    <x-input label="Nome *" wire:model="pedidosVenda.nome" x-ref="nome" required />
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
