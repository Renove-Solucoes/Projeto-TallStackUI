<div>
    <x-modal :title="__('Editar Endereço', ['id' => $endereco?->id])" wire blur size="6xl">
        <form id="endereco-update-{{ $endereco?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('CEP') }} *"  wire:model="endereco.cep" required />
            </div>
            <div>
                <x-input label="{{ __('Endereço') }} *"  wire:model="endereco.endereco" required />
            </div>
            <div class="md:col-span-3">
                <x-input label="{{ __('Cidade') }} *"  wire:model="endereco.cidade" required />
            </div>
            <div>
                <x-input label="{{ __('Bairro') }} *"  wire:model="endereco.bairro" required />
            </div>
            <div class="md:col-span-3">
                <x-input label="{{ __('Sigla do Estado') }} *"  wire:model="endereco.uf" required />
            </div>
            <div class="md:col-span-3">
                <x-input label="{{ __('Complemento') }} *"  wire:model="endereco.complemento" required />
            </div>
            <div>
                <x-input label="{{ __('Descrição') }} *"  wire:model="endereco.descricao" required />
            </div>
            <div>
                <x-select.native label="{{ __('Status') }} *" wire:model="endereco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                    select="label:name|value:id" required />

            </div>

        </form>
	        <x-slot:footer>
            <x-button type="submit" form="endereco-update-{{ $endereco?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>

    </x-modal>
</div>
