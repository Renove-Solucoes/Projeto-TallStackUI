<?php

namespace App\Enum;

enum FormasPagamentosAplicavel: string
{
    case Ambos = "A";
    case Recebimento = "R";
    case Pagamento = "P";


    public function getText()
    {
        return match ($this) {
            self::Ambos => 'Ambos',
            self::Recebimento => 'Recebimento',
            self::Pagamento => 'Pagamento',
        };
    }

    public function getColor()
    {
        return match ($this) {
            self::Ambos => 'sky',
            self::Recebimento => 'green',
            self::Pagamento => 'orange',
        };
    }
}
