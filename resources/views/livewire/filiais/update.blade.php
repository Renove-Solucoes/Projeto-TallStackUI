<div>
    <x-modal :title="__('Update Filial: #:id', ['id' => $filial?->id])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="xl" blu>
        <form id="categoria-update-{{ $filial?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-12 md:gap-4">
                <div class="md:col-span-3">
                    <x-select.native label="{{ __('Tipo') }} *" wire:model="filial.tipo_pessoa" :options="[['name' => 'fisico', 'id' => 'F'], ['name' => 'Juridico', 'id' => 'J']]"
                        select="label:name|value:id" required />
                </div>
                <div class="md:col-span-4">
                    <x-input label="{{ __('Razão social') }} *" x-ref="nome" wire:model="filial.razao_social" />
                </div>
                <div class="md:col-span-4">
                    <x-input label="{{ __('Nome Fantasia') }} *" x-ref="nome" wire:model="filial.nome_fantasia" />
                </div>
                <div class="md:col-span-3">
                    <x-select.native label="{{ __('Status') }} *" wire:model="filial.status" :options="[['name' => 'Ativo', 'id' => 'A'], ['name' => 'Inativo', 'id' => 'I']]"
                        select="label:name|value:id" required />
                </div>
                <div class="md:col-span-6">
                    <x-select.native label="{{ __('Empresa') }} *" wire:model="filial.empresa_id" :options="$empresas"
                        select="label:nome|value:id" required placeholder="{{ __('Selecione uma Empresa') }}" />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="categoria-update-{{ $filial?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
