<div>
    <x-modal :title="__('Editar Endereço', ['id' => $endereco?->id])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" blur size="6xl">
        <form id="endereco-update-{{ $endereco?->id }}" wire:submit="save" class="space-y-4">
            <div class="md:col-span-3">
                <x-input label="{{ __('Endereço') }} *" x-ref="name" wire:model="endereco.cidade" required />

            </div>
        </form>
    </x-modal>
</div>
