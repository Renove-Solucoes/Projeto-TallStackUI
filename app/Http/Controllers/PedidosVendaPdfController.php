<?php

namespace App\Http\Controllers;

use App\Models\PedidosVenda;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidosVendaPdfController
{
    public function generatePdf(PedidosVenda $pedidosVenda)
    {
        // Carregar relacionamento itens + produto
        $pedidosVenda->load(['itens.produto']);

        $itens = $pedidosVenda->itens;

        // Gera o PDF passando pedido e itens
        $pdf = Pdf::loadView('pdf.pedidos-venda', [
            'pedido' => $pedidosVenda,
            'itens'  => $itens
        ]);

        return $pdf->stream("pedido_{$pedidosVenda->id}.pdf");
    }
}
