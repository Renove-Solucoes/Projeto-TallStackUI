<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="mb-2 font-medium text-2xl">Cadastro de Clientes</h1>
            <div class="flex items-center gap-2">
                <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideOpen('filtro')" sm />
                <x-button icon="x-mark" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm />
                <livewire:clientes.create @created="$refresh" />
            </div>
        </div>
        <x-slide id="filtro">
            <x-select.native label="Tipo Pessoa(F/J)" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id"
                wire:model="filtro.tipo_pessoa" />
            <x-input label="Telefone" wire:model="filtro.telefone" />
            <x-select.native label="Crédito Ativo" wire:model="filtro.credito_ativo" :options="[
                ['name' => 'Ativo', 'id' => 1],
                ['name' => 'Inativo', 'id' => 0],
                ['name' => 'Todos', 'id' => ''],
            ]" :checked="$cliente?->credito_ativo ? true : false"
                select="label:name|value:id" />
            <div>
                <x-select.native label="Status" wire:model="filtro.status" :options="[
                    ['name' => 'Ativo', 'id' => 'A'],
                    ['name' => 'Inativo', 'id' => 'I'],
                    ['name' => 'Todos', 'id' => ''],
                ]"
                    select="label:name|value:id" required />

            </div>
            <div>
                <x-dates-period modelDataDe="filtro.nascimento_de" modelDataAte="filtro.nascimento_ate"
                    filtroPeriodo="filtro.periodo" :dataDe="$filtro['nascimento_de'] ?? ''" :dataAte="$filtro['nascimento_ate'] ?? ''" labelPeriodo="Periodo"
                    labelDataDe="Nascimento de" labelDataAte="Nascimento até" />
            </div>
            <div>
                <x-select.native label="tag" wire:model="filtro.tag" :options="array_merge([['nome' => 'Todos', 'id' => '']], $tags)" select="label:nome|value:id" />
            </div>

            <div class="mt-4">

                <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideClose('filtro')" wire:click='filtrar' sm />
                <x-button icon="x-mark" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm />
            </div>
        </x-slide>

        {{-- //TODO na table index, colocar coluna da tabela fixa
            definir altura da div para que a tabela tenha rolagem horizontal
            mudar local do botão criar para ganhar espaço --}}
        <x-table striped :$headers :$sort :rows="$this->rows" paginate filter :quantity="[5, 10, 20]" :placeholders="['search' => 'Pesquisar por nome, email ou CPF']">


            @interact('column_nascimento', $row)
                {{ date('d/m/Y', strtotime($row->nascimento)) }}
            @endinteract

            @interact('column_credito', $row)
                <div class="flex items-center justify-end gap-1">
                    R$ {{ number_format($row->credito, 2, ',', '.') }}
                    <x-boolean :boolean="$row->credito_ativo" icon-when-true="currency-dollar" icon-when-false="currency-dollar" />
                </div>
            @endinteract




            {{-- @interact('column_credito_ativo', $row)
                <x-toggle :checked="$row->credito_ativo ? true : false" />
            @endinteract --}}

            @interact('column_created_at', $row)
                {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_status', $row)
                <x-badge text="{{ $row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" color="sky"
                        wire:click="$dispatch('load::cliente', { 'cliente' : '{{ $row->id }}'})" outline />
                    <livewire:clientes.delete :cliente="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract

        </x-table>
        <livewire:clientes.update @updated="$refresh" />
    </x-card>
</div>
