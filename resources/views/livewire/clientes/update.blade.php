<div>
        <x-modal :title="__('Editar Cliente', ['id' => $cliente?->id])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="cliente-update-{{ $cliente?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.native label="{{ __('Tipo Pessoa') }} *" wire:model="cliente.tipo_pessoa" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]"
                    select="label:name|value:id" required />
            </div>
            <div>
                <x-input label="{{ __('CPF/CNPJ') }} *" wire:model="cliente.cpf_cnpj" required />
            </div>
            <div>
                <x-input label="{{ __('Nome') }} *" x-ref="nome" wire:model="cliente.nome" required />
            </div>
            <div>
                <x-input label="{{ __('Email') }} *" wire:model="cliente.email" required />
            </div>
            <div>
                <x-input label="{{ __('Telefone') }} *" wire:model="cliente.telefone" required />
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
