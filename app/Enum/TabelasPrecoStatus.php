<?php

namespace App\Enum;

enum TabelasPrecoStatus: string
{
    // nome do valor  =  valor salvo no banco
    case Ativo = "A";
    case Inativo = "I";
    //   case Pendente = "P";
    //   case Bloqueado = "B";

    public function getText()
    {
        return match ($this) {
            self::Ativo => 'Ativo',
            self::Inativo => 'Inativo',
            //   self::Pendente => 'Pendente',
            //   self::Bloqueado => 'Bloqueado',
        };
    }

    public function getColor()
    {
        return match ($this) {
            self::Ativo => 'green',
            self::Inativo => 'neutral',
            //   self::Pendente => 'warning',
            //   self::Bloqueado => 'danger',
        };
    }
}
