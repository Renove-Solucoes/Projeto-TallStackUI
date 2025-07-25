<div>

    <x-card color="primary" bordered minimize minimize="mount">
        <x-slot:header class="cursor-pointer w-100" icon="x-mark">
            <div class="flex justify-between items-center p-4 cursor-pointer" x-on:click="minimize = !minimize">
                <div class="flex justify-between items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-secondary-700 dark:text-dark-300">
                        <path fill-rule="evenodd"
                            d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                            clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-md font-medium text-secondary-700 dark:text-dark-300 ml-2"> Filtros avançados</h1>
                </div>
                <div class="flex gap-2">
                    <x-button icon="x-mark" color="amber" :text="__('Limpar Filtro')" wire:click="limparFiltros()" sm />
                </div>

            </div>
        </x-slot:header>
        <div class="grid md:grid-cols-4 md:gap-3">
            <div class="md:col-span-2 space-y-2">
                <x-dates-period modelDataDe="filtro.nascimento_de" modelDataAte="filtro.nascimento_ate"
                    filtroPeriodo="filtro.periodo" :dataDe="$filtro['nascimento_de'] ?? ''" :dataAte="$filtro['nascimento_ate'] ?? ''" labelPeriodo="Periodo"
                    labelDataDe="Nascimento de" labelDataAte="Nascimento até" />
            </div>
            <x-select.styled label="Tipo Pessoa(F/J)" :options="[['name' => 'Fisica', 'id' => 'F'], ['name' => 'Juridica', 'id' => 'J']]" select="label:name|value:id"
                wire:model="filtro.tipo_pessoa" />
            <x-input label="Telefone" wire:model="filtro.telefone" />
            <x-select.styled label="Crédito Ativo" wire:model="filtro.credito_ativo" :options="[
                ['name' => 'Todos', 'id' => ''],
                ['name' => 'Ativo', 'id' => 1],
                ['name' => 'Inativo', 'id' => 0],
            ]"
                select="label:name|value:id" />
            <div>
                <x-select.styled label="Status" wire:model="filtro.status" :options="[
                    ['name' => 'Todos', 'id' => ''],
                    ['name' => 'Ativo', 'id' => 'A'],
                    ['name' => 'Inativo', 'id' => 'I'],
                ]"
                    select="label:name|value:id" />

            </div>
            <div>
                <x-select.native label="tag" wire:model="filtro.tag" :options="array_merge([['nome' => 'Todos', 'id' => '']], $tags)"
                    select="label:nome|value:id" />
            </div>

            <div class="mt-6">

                <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideClose('filtro')" wire:click='filtrar' sm />
                <x-button class="ml-2" icon="x-mark" color="amber" :text="__('Limpar Filtro')" wire:click="limparFiltros()"
                    sm />
            </div>
        </div>
    </x-card>
    <br>
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
            ]"
                select="label:name|value:id" />
            <div>
                <x-select.styled label="Status" wire:model="filtro.status" :options="[
                    ['name' => 'Ativo', 'id' => 'A'],
                    ['name' => 'Inativo', 'id' => 'I'],
                    ['name' => 'Todos', 'id' => ''],
                ]"
                    select="label:name|value:id" />

            </div>
            <div>
                <x-dates-period modelDataDe="filtro.nascimento_de" modelDataAte="filtro.nascimento_ate"
                    filtroPeriodo="filtro.periodo" :dataDe="$filtro['nascimento_de'] ?? ''" :dataAte="$filtro['nascimento_ate'] ?? ''" labelPeriodo="Periodo"
                    labelDataDe="Nascimento de" labelDataAte="Nascimento até" />
            </div>
            <div>
                <x-select.native label="tag" wire:model="filtro.tag" :options="array_merge([['nome' => 'Todos', 'id' => '']], $tags)"
                    select="label:nome|value:id" />
            </div>

            <div class="mt-4">

                <x-button icon="funnel" :text="__('Filtrar')" x-on:click="$slideClose('filtro')" wire:click='filtrar'
                    sm />
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
                <div class="flex items-center justify-start gap-1">
                    R$ {{ number_format($row->credito, 2, ',', '.') }}
                    <x-boolean :boolean="$row->credito_ativo" icon-when-true="currency-dollar" icon-when-false="currency-dollar" />
                </div>
            @endinteract


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
