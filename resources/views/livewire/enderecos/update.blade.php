<div>


    <x-modal :title="__('Editar Endereço', ['id' => $endereco?->id])" wire blur size="5xl">
        <form id="endereco-create" wire:submit="save" class="space-y-6">

            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-4">
                    <x-input label="{{ __('CEP') }} *" wire:model="endereco.cep" required />
                </div>
                <div class="md:col-span-6">
                    <x-input label="{{ __('Endereço') }} *" wire:model="endereco.endereco" required />
                </div>
                <div class="md:col-span-2">
                    <x-input label="{{ __('Número') }} *" wire:model="endereco.numero" required />
                </div>
            </div>

            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-5">
                    <x-input label="{{ __('Cidade') }} *" wire:model="endereco.cidade" required />
                </div>
                <div class="md:col-span-5">
                    <x-input label="{{ __('Bairro') }} *" wire:model="endereco.bairro" required />
                </div>
                <div class="md:col-span-2">
                    <x-input label="{{ __('Sigla do Estado') }} *" wire:model="endereco.uf" required />
                </div>
            </div>


            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-3">
                    <x-input label="{{ __('Complemento') }} *" wire:model="endereco.complemento" required />
                </div>
                <div class="md:col-span-6">
                    <x-input label="{{ __('Descrição') }} *" wire:model="endereco.descricao" required />
                </div>
                <div class="md:col-span-3">
                    <x-select.native label="{{ __('Status') }} *" wire:model="endereco.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
            </div>

        </form>

        <x-slot:footer>
            <x-button type="submit" form="endereco-update-{{ $endereco?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>

    </x-modal>
</div>
