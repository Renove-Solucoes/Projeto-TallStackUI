<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Pedido de Venda #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .dados-pedido {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .dados-pedido td {
            padding: 4px 0;
        }

        .dados-pedido .col-esquerda {
            text-align: left;
            width: 70%;
        }

        .dados-pedido .col-direita {
            text-align: right;
            width: 30%;
        }


        .table-Produtos {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }

        .table-Total {
            margin-top: 20px;
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }

        .table-Produtos th,

        .table-Total th {
            background-color: #b1b1b1;
        }


        .total-item {
            background-color: #cfcece;
        }

        .table-Produtos th,
        .table-Produtos td,
        .table-Total th,
        .table-Total td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;


        }
    </style>
</head>

<body>
    <h2>Pedido de Venda #{{ $pedido->id }}</h2>
    <p align="right"><strong>{{ date('d/m/Y'.' - '.'H:i:s') }}</strong></p>


    <table class="dados-pedido">
        <tr>
            <td class="col-esquerda">
                <strong>Cliente:</strong> {{ $pedido->cliente->nome ?? 'N/A' }}
            </td>
            <td class="col-direita">
                <strong>Data de Emissão:</strong> {{ \Carbon\Carbon::parse($pedido->data_emissao)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td class="col-esquerda">
                <strong>Nome:</strong> {{ $pedido->nome }}
            </td>
            <td class="col-direita">
                <strong>Telefone:</strong> {{ $pedido->telefone }}
            </td>
        </tr>
        <tr>
            <td class="col-esquerda">
                <strong>Endereço:</strong> {{ $pedido->endereco }}, {{ $pedido->numero }} - {{ $pedido->bairro }}
            </td>
            <td class="col-direita">
                <strong>Email:</strong> {{ $pedido->email }}
            </td>
        </tr>
        <tr>
            <td class="col-esquerda">
                <strong>Cidade:</strong> {{ $pedido->cidade }} - {{ $pedido->uf }}
            </td>
            <td class="col-direita">
                <strong>CEP:</strong> {{ $pedido->cep }}
            </td>
        </tr>
    </table>


    <div>
        <table class="table-Produtos">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço R$</th>
                    <th>Desconto %</th>
                    <th>Preço item R$</th>
                    <th>Total item R$</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_quantidade_item = 0;
                    $total_valor_item = 0;
                @endphp

                @foreach ($pedido->itens as $item)
                    @php
                        $precoFinal = $item->preco - $item->preco * ($item->desconto / 100);
                        $total_quantidade_item += $item->quantidade;
                        $total_valor_item += $precoFinal * $item->quantidade;
                    @endphp

                    <tr>
                        <td>{{ $item->produto->nome }}</td>
                        <td>{{ number_format($item->quantidade, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->preco, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->desconto, 2, ',', '.') }}%</td>
                        <td>{{ number_format($precoFinal, 2, ',', '.') }}</td>
                        <td>{{ number_format($precoFinal * $item->quantidade, 2, ',', '.') }}</td>

                    </tr>
                @endforeach

                <tr class="total-item">
                    <td>Total</td>
                    <td>{{ number_format($total_quantidade_item, 2, ',', '.') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($total_valor_item, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table-Total">
            <thead>
                <tr>
                    <th>Desc Comercial %</th>
                    <th>Frete R$</th>
                    <th>Total R$</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ number_format($pedido->desc1, 2, ',', '.') }}%</td>
                    <td>{{ number_format($pedido->frete, 2, ',', '.') }}</td>
                    <td>{{ number_format($pedido->total, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>


</html>
