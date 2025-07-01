<div>

    <x-modal :title="__('Editar Cliente #:id', ['id' => $cliente?->id])" wire blur size="6xl">
        <livewire:enderecos.update @updated="$refresh" />

        <form id="cliente-update-{{ $cliente?->id }}" wire:submit="save" class="space-y-4">
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
                        <span id="nome-error"
                            class="error invalid-feedback d-block">{{ $errors->first('imagemTemp') }}</span>
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
                    <div x-data="{ tipoPessoa: '{{ $cliente?->tipo_pessoa }}' }" class="grid md:grid-cols-6 md:gap-4">
                        <div>
                            <x-select.native x-model="tipoPessoa" label="{{ __('Tipo Pessoa') }} *"
                                wire:model="cliente.tipo_pessoa" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id"
                                required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input label="{{ __('CPF/CNPJ') }} *" wire:model="cliente.cpf_cnpj" required
                                x-mask:dynamic="tipoPessoa === 'J' ||tipoPessoa === '' ? '99.999.999/9999-99' : '999.999.999-99'" />
                        </div>

                        <div class="md:col-span-3">
                            <x-input label="{{ __('Nome') }} *" wire:model="cliente.nome" required />
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
                            <x-date format="DD/MM/YYYY" label="{{ __('Nascimento') }}" wire:model="cliente.nascimento"
                                required />
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
                            wire:model="tags_selecionadas" :options="$tags" select="label:nome|value:id" searchable
                            multiple />
                    </div>
                </div>
            </div>
        </form>

        <div class="flex justify-end">
            <livewire:enderecos.create @created="$refresh" :key="uniqid('', true)" :cliente_id="$cliente?->id" />
        </div>
        <div class="mt-4">

            <x-table striped :$headers :rows="$this->rows">

                @interact('column_principal', $row)
                    <div class="flex items-center justify-center">
                        <x-boolean :boolean="$row['principal']" icon-when-true="star" color-when-true="yellow" icon-when-false="star" wire:click="endPrincipal({{ $row['id'] }})" />
                    </div>
                @endinteract

                @interact('column_action', $row)
                    <div class="flex items-center justify-center">
                        <x-button.circle icon="pencil" color="sky"
                            wire:click="$dispatch('load::endereco', { 'endereco' : '{{ $row['id'] }}'})" outline />
                    </div>
                @endinteract

            </x-table>
        </div>
        <x-slot:footer>
            <x-button type="submit" form="cliente-update-{{ $cliente?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>

    </x-modal>

</div>
