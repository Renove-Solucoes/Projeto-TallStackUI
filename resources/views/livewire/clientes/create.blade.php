<div>
    <x-button icon="plus" :text="__('Novo Cliente')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Criar Novo Cliente')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="6xl" blur>
        <form id="cliente-create" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-3">
                    @if ($imagemTemp)
                        <img src="{{ $imagemTemp->temporaryUrl() }}" class="rounded-lg">
                    @elseif($cliente?->foto)
                        <img src="{{ 'storage/' . $cliente?->foto }}" class="rounded-lg">
                    @else
                        <img src="{{ asset('assets/images/no-image.png') }}" class="rounded-lg">
                    @endif

                    @if ($errors->get('imagemTemp'))
                        <span id="nome-error" class="error invalid-feedback d-block">{{ $errors->first('imagemTemp') }}
                        </span>
                    @endif
                    @if ($errors->get('cliente.foto'))
                        <span id="nome-error"
                            class="error invalid-feedback d-block">{{ $errors->first('cliente.foto') }}</span>
                    @endif


                    <div class="mt-2">
                        <x-upload close-after-upload tip="Arraste e Solte a imagem aqui" wire:model='imagemTemp'
                            required :preview="false" />
                    </div>
                </div>

                <div class="md:col-span-9">
                    <div x-data="{ tipoPessoa: '' }" x-init="tipoPessoa = 'F'" class="grid md:grid-cols-6 md:gap-4">
                        <div>
                            <x-select.native label="{{ __('Tipo Pessoa') }} *" wire:model="cliente.tipo_pessoa"
                                :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id" x-model="tipoPessoa" required />
                        </div>

                        <div class="md:col-span-2">
                            <x-input label="{{ __('CPF/CNPJ') }} *" wire:model="cliente.cpf_cnpj" required
                                x-mask:dynamic="tipoPessoa === 'J' ||tipoPessoa === '' ? '99.999.999/9999-99' : '999.999.999-99'" />
                        </div>

                        <div class="md:col-span-3">
                            <x-input label="{{ __('Nome') }} *" x-ref="nome" wire:model="cliente.nome" required />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 md:gap-4">
                        <div>
                            <x-input label="{{ __('Email') }} *" wire:model="cliente.email" required />
                        </div>
                        <div>
                            <x-input x-mask="(99) 99999-9999" label="{{ __('Telefone') }} *"
                                wire:model="cliente.telefone" required />
                        </div>
                        <div>
                            <x-input type="date" wire:model="cliente.nascimento" label="Nascimento" />
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3 md:gap-4">
                        <div>
                            <x-currency mutate locale="pt-BR" symbol="R$" label="{{ __('Crédito') }}"
                                wire:model="cliente.credito" required />
                        </div>
                        <div class="md:pt-8">
                            <x-toggle label="Crédito Ativo" wire:model="cliente.credito_ativo" :checked="$cliente?->credito_ativo ? true : false" />
                        </div>
                        <div>
                            <x-select.native label="{{ __('Status') }} *" wire:model="cliente.status"
                                :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]" select="label:name|value:id" required />

                        </div>
                    </div>
                    <div>
                        <x-select.styled label="{{ __('Tags') }} *" placeholder="Selecione uma Tag"
                            wire:model="tags_selecionadas" :options="$tags" select="label:nome|value:id" multiple />

                    </div>
                </div>

            </div>

            <div>
                <div class="grid md:grid-cols-12 md:gap-4">
                    <div class="md:col-span-4">
                        <x-input label="{{ __('CEP') }} *" wire:model.blur="endereco.cep" required
                            maxlength="8" />
                    </div>
                    <div class="md:col-span-6">
                        <x-input label="{{ __('Endereço') }} *" wire:model="endereco.endereco" required
                            maxlength="120" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input label="{{ __('Número') }} *" wire:model="endereco.numero" required maxlength="10" />
                    </div>
                </div>

                <div class="grid md:grid-cols-12 md:gap-4">
                    <div class="md:col-span-5">
                        <x-input label="{{ __('Cidade') }} *" wire:model="endereco.cidade" required maxlength="80" />
                    </div>
                    <div class="md:col-span-5">
                        <x-input label="{{ __('Bairro') }} *" wire:model="endereco.bairro" required maxlength="80" />
                    </div>
                    <div class="md:col-span-2">
                        <x-select.native label="{{ __('UF') }} *" :options="[
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
                        ]" wire:model="endereco.uf"
                            select="label:name|value" required maxlength="2" />
                    </div>
                </div>


                <div class="grid md:grid-cols-12 md:gap-4">
                    <div class="md:col-span-3">
                        <x-input label="{{ __('Complemento') }}" wire:model="endereco.complemento" maxlength="120" />
                    </div>
                    <div class="md:col-span-6">
                        <x-input label="{{ __('Descrição') }} *" wire:model="endereco.descricao" required
                            maxlength="20" placeholder="Ex: Casa, Trabalho" />
                    </div>
                    <div class="md:col-span-3">
                        <x-select.native label="{{ __('Status') }} *" wire:model="endereco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                            select="label:name|value:id" required />
                    </div>
                </div>
            </div>




        </form>
        <x-slot:footer>
            <x-button type="submit" form="cliente-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
