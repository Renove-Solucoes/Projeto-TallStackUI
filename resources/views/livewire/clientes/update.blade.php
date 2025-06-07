<div>
    <x-modal :title="__('Editar Cliente', ['id' => $cliente?->id])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="cliente-update-{{ $cliente?->id }}" wire:submit="save" class="space-y-4">
            <div>
                @if ($fotoTemp)
                    <img src="{{ $fotoTemp->temporaryUrl() }}" alt="" width="200" height="200">
                @elseif($cliente?->foto)
                    <img src="{{ 'storage/' . $cliente?->foto }}" alt="" width="200" height="200">
                @else
                    <img src="{{ asset('assets/images/no-image.png') }}" alt="" width="200" height="200">
                @endif

                @if ($errors->get('fotoTemp'))
                    <span id="nome-error" class="error invalid-feedback d-block">{{ $errors->first('fotoTemp') }}</span>
                @endif
                @if ($errors->get('cliente.foto'))
                    <span id="nome-error"
                        class="error invalid-feedback d-block">{{ $errors->first('cliente.foto') }}</span>
                @endif

            </div>
            <div>
                <x-upload close-after-upload label="Screenshot" hint="We need to analyze your screenshot"
                    tip="Drag and drop your screenshot here" wire:model='fotoTemp' required :preview="false" />
            </div>

            <div>
                
                <x-select.styled  label="{{ __('Tags') }} *" placeholder="Selecione uma Tag" wire:model="tags_selecionadas" :options="$tags" select="label:nome|value:id" multiple />
               
            </div>
            <div x-data="{ tipoPessoa: '{{ $cliente?->tipo_pessoa }}' }">
                <div class="mb-4">
                    <x-select.native x-model="tipoPessoa" label="{{ __('Tipo Pessoa') }} *"
                        wire:model="cliente.tipo_pessoa" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id" required />
                </div>
                <div>
                    <x-input label="{{ __('CPF/CNPJ') }} *" wire:model="cliente.cpf_cnpj" required
                        x-mask:dynamic="tipoPessoa === 'J' ||tipoPessoa === '' ? '99.999.999/9999-99' : '999.999.999-99'" />
                </div>
            </div>
            <div>
                <x-input label="{{ __('Nome') }} *" x-ref="nome" wire:model="cliente.nome" required />
            </div>
            <div>
                <x-input label="{{ __('Email') }} *" wire:model="cliente.email" required />
            </div>
            <div>
                <x-input x-mask="(99) 99999-9999" label="{{ __('Telefone') }} *" wire:model="cliente.telefone"
                    required />
            </div>
            <div>
                <x-date format="DD/MM/YYYY" label="{{ __('Nascimento') }}" wire:model="cliente.nascimento" required />
            </div>
            <div>
                <x-currency mutate locale="pt-BR" symbol="R$" label="{{ __('Crédito') }}"
                    wire:model="cliente.credito" required />
            </div>


            <div>
                <x-toggle label="Crédito Ativo" wire:model="cliente.credito_ativo" :checked="$cliente?->credito_ativo ? true : false" />
            </div>
            <div>
                <x-select.native label="{{ __('Status') }} *" wire:model="cliente.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                    select="label:name|value:id" required />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="cliente-update-{{ $cliente?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
