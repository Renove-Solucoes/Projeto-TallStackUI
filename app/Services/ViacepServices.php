<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViacepServices
{
    public function getLocation(string $cep): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->successful() && !$response->json('erro')) { return $response->json(); }

        return [];
    }
}