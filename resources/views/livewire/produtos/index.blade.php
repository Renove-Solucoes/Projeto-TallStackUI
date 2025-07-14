<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="mb-2 font-medium text-2xl">Cadastro de Produtos</h1>
            <div class="flex items-center gap-2">
                <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideOpen('filtro')" sm />
                <x-button icon="x-mark" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm />
                <livewire:produtos.create @created="$refresh" />
            </div>
        </div>
        <x-slide id="filtro">
            <x-select.native label="Categoria" :options="array_merge([['nome' => 'Todos', 'id' => '']], $categorias)" select="label:nome|value:id"
                wire:model="filtro.categoria" />

            <x-select.native label="Tags" :options="array_merge([['nome' => 'Todos', 'id' => '']], $tags)" select="label:nome|value:id" wire:model="filtro.tag" />
            <x-select.native label="Status" :options="[
                ['name' => 'Todos', 'id' => ''],
                ['name' => 'Ativo', 'id' => 'A'],
                ['name' => 'Inativo', 'id' => 'I'],
            ]" select="label:name|value:id" wire:model="filtro.status" />
            <x-select.native label="Tipo" :options="[
                ['name' => 'Todos', 'id' => ''],
                ['name' => 'Fisico', 'id' => 'F'],
                ['name' => 'Digital', 'id' => 'D'],
                ['name' => 'Serviço', 'id' => 'S'],
            ]" select="label:name|value:id" wire:model="filtro.tipo" />


            <div class="mt-4">

                <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideClose('filtro')" wire:click='filtrar' sm />
                <x-button icon="x-mark" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm />
            </div>
        </x-slide>


        <x-table stripped striped :sort :$headers :rows="$this->rows" paginate filter :quantity="[5, 10, 20]"
            :placeholders="['search' => 'Pesquisar por nome']">
            @interact('column_data_validade', $row)
                {{ date('d/m/Y', strtotime($row->data_validade)) }}
            @endinteract
            @interact('column_preco_padrao', $row)
                <div class="flex items-center">
                    R$ {{ number_format($row->preco_padrao, 2, ',', '.') }}
                </div>
            @endinteract
            @interact('column_status', $row)
                <x-badge text="{{ $row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" color="sky"
                        wire:click="$dispatch('load::produto', { 'produto' : '{{ $row->id }}'})" outline />
                    <livewire:produtos.delete :produto="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract
        </x-table>
        <livewire:produtos.update @updated="$refresh" />
    </x-card>
</div>
