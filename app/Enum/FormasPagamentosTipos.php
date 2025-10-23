<?php

namespace App\Enum;

enum FormasPagamentosTipos: int
{
    //
    case PIX = 0;
    case DINHEIRO = 1;
    case BOLETO = 2;
    case TRANSF_BANCO = 3;
    case CARTAO_DEBITO = 4;
    case CARTAO_CREDITO = 5;


    public function getText(): string
    {
        return match ($this) {
            self::PIX => 'PIX',
            self::DINHEIRO => 'DINHEIRO',
            self::BOLETO => 'BOLETO',
            self::TRANSF_BANCO => 'TRANSF. BANCO',
            self::CARTAO_DEBITO => 'CARTÃO DÉBITO',
            self::CARTAO_CREDITO => 'CARTÃO CREDITO',
        };
    }
}
