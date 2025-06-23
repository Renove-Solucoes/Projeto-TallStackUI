<div>
    <x-button :text="__('Adicionar Tag')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Adicionar Tag')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)" size="6xl" blur>
        teste
    </x-modal>
</div>
