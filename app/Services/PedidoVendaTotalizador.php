<?php

namespace App\Services;

use App\Traits\Currency;

class PedidoVendaTotalizador
{
    use Currency;

    public function calcular(array &$itens, $pedido): void
    {
        $total = 0;

        // Sanitiza apenas 1 vez
        $desc1 = $this->currencySanitize($pedido->desc1);
        $desc2 = $this->currencySanitize($pedido->desc2);
        $desc3 = $this->currencySanitize($pedido->desc3);
        $frete = $this->currencySanitize($pedido->frete);

        foreach ($itens as $index => &$item) {
            if ($item['deleted'] == 1) {
                continue;
            }

            $preco = $this->currencySanitize($item['preco']);
            $qtde = $this->currencySanitize($item['quantidade']);
            $descItem = $this->currencySanitize($item['desconto']);

            // preço base
            $precoFinal = $preco;

            // aplica descontos do item
            $precoFinal -= $precoFinal * ($descItem / 100);

            // descontos globais
            $precoFinal -= $precoFinal * ($desc1 / 100);
            $precoFinal -= $precoFinal * ($desc2 / 100);
            $precoFinal -= $precoFinal * ($desc3 / 100);

            // total por item
            $itemTotal = $qtde * $precoFinal;

            // arredonda
            $item['preco_final'] = round($precoFinal, 2);
            $item['total'] = round($itemTotal, 2);

            $total += $item['total'];
        }

        // total final = itens + frete
        $pedido->total = round($total + $frete, 2);
    }
}
