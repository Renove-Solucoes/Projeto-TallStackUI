<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="mb-2 font-medium text-2xl">Cadastro de Pedidos</h1>
            <div class="flex items-center gap-2">
                <x-button href="{{ route('pedidosvendas.create') }}" icon='plus' :text="__('Novo Pedido')" sm loading />
            </div>
        </div>

        <x-table stripped striped :sort :$headers :rows="$this->rows" paginate filter :quantity="[5, 10, 20]">
            @interact('column_data_emissao', $row)
                {{ date('d/m/Y', strtotime($row->data_emissao)) }}
            @endinteract
            @interact('column_cliente_id', $row)
                {{ $row->cliente->nome }}
            @endinteract
            @interact('column_status', $row)
                <x-badge text="{{ $row->status->getText() }}" color="{{ $row->status->getColor() }}" outline />
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle href="{{ route('pedidosvendas.edit', $row->id) }}" icon="pencil" color="sky" outline
                        loading />



                    <x-button.circle href="{{ route('pedidosvendas.generate-pdf', ['pedidosVenda' => $row->id]) }}" icon="printer" color="sky"
                        outline loading  />

                    <livewire:PedidosVendas.delete :pedidosVenda="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract
        </x-table>
    </x-card>
</div>
