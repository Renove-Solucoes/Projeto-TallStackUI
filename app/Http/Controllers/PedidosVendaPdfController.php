<?php

namespace App\Http\Controllers;

use App\Models\PedidosVenda;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidosVendaPdfController
{



    public function generatePdf(PedidosVenda $pedidosVenda)
    {
        $pdf = Pdf::loadView('pdf.pedidos-venda', ['pedido' => $pedidosVenda]);
        return $pdf->stream("pedido_{$pedidosVenda->id}.pdf");
    }
}
