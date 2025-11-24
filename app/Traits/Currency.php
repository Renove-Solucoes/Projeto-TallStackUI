<?php

namespace App\Traits;

trait Currency
{
    public function currencySanitize($value): float
    {
        // if (is_numeric($value)) return floatval($value);
        // return floatval(str_replace(['.', ','], ['', '.'], $value));


        if (isset($value) && str_contains($value, ',')) {
            return  str_replace(['.', ','], ['', '.'], $value);
        }

        return $value;
    }
}
