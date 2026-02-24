<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViacepServices
{
    public function getLocation(string $cep): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->successful() && !$response->json('erro')) {
            return $response->json();
        } else {
            $response = Http::get("https://brasilapi.com.br/api/cep/v1/{$cep}");

            if ($response->successful() && !$response->json('erro')) {
                return [
                    'cep'        => $response['cep'] ?? null,
                    'logradouro' => $response['street'] ?? null,
                    'bairro'     => $response['neighborhood'] ?? null,
                    'localidade'     => $response['city'] ?? null,
                    'uf'         => $response['state'] ?? null,
                    'ibge'       => $response['city_ibge_code'] ?? null,
                ];
            }
        }

        return [];
    }
}
