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

        .header {
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Pedido de Venda #{{ $pedido->id }}</h2>
        <p><strong>Cliente:</strong> {{ $pedido->cliente->nome ?? 'N/A' }}</p>
        <p><strong>Data de Emissão:</strong> {{ \Carbon\Carbon::parse($pedido->data_emissao)->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <p><strong>Nome:</strong> {{ $pedido->nome }}</p>
        <p><strong>Email:</strong> {{ $pedido->email }}</p>
        <p><strong>Telefone:</strong> {{ $pedido->telefone }}</p>
        <p><strong>Endereço:</strong> {{ $pedido->endereco }}, {{ $pedido->numero }} - {{ $pedido->bairro }}</p>
        <p><strong>Cidade:</strong> {{ $pedido->cidade }} - {{ $pedido->uf }}</p>
        <p><strong>CEP:</strong> {{ $pedido->cep }}</p>
    </div>
</body>

</html>
