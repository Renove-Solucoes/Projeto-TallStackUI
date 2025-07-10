<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produtos_nomes = [
            'Camiseta',
            'Calça Jeans',
            'Vestido',
            'Blusa',
            'Shorts',
            'Jaqueta',
            'Moletom',
            'Saia',
            'Regata',
            'Terno',
            'Pijama',
            'Cardigã',
            'Tênis',
            'Sapatênis',
            'Bota',
            'Sandália',
            'Chinelo',
            'Sapato Social',
            'Mocassim',
            'Scarpin',
            'Rasteirinha',
            'Sapatilha',
            'Papete',
            'Alpargata',
            'Geladeira',
            'Fogão',
            'Micro-ondas',
            'Lava-louças',
            'Lava-roupas',
            'Secadora',
            'Aspirador de pó',
            'Ferro de passar',
            'Cafeteira',
            'Liquidificador',
            'Batedeira',
            'Airfryer',
            'Sofá',
            'Cama',
            'Mesa de jantar',
            'Cadeira',
            'Guarda-roupa',
            'Escrivaninha',
            'Estante',
            'Rack',
            'Aparador',
            'Cômoda',
            'Poltrona',
            'Mesa de centro',
            'iPhone',
            'Samsung Galaxy',
            'Xiaomi',
            'Motorola',
            'Nokia',
            'Sony Xperia',
            'Huawei',
            'OnePlus',
            'Asus Zenfone',
            'LG',
            'Google Pixel',
            'Realme',
            'Televisão',
            'Laptop',
            'Tablet',
            'Câmera digital',
            'Fone de ouvido',
            'Smartwatch',
            'Monitor',
            'Impressora',
            'Projetor',
            'Leitor de eBook',
            'Speaker Bluetooth',
            'Roteador Wi-Fi',
            'Teclado',
            'Mouse',
            'SSD',
            'HD Externo',
            'Placa de Vídeo',
            'Processador',
            'Memória RAM',
            'Fonte',
            'Gabinete',
            'Placa-mãe',
            'Webcam',
            'Headset',
            'PlayStation 5',
            'Xbox Series X',
            'Nintendo Switch',
            'Controle DualSense',
            'Controle Xbox',
            'Joy-Con',
            'Headset Gamer',
            'Cadeira Gamer',
            'Teclado Gamer',
            'Mouse Gamer',
            'VR Headset',
            'Console Retro'
        ];
        return [
            'nome' => $this->faker->randomElement($produtos_nomes),
            'sku' =>  fake()->bothify('???####'),
            'tipo' => $this->faker->randomElement(['F', 'D']), // Juridica ou Fisica
            'unidade' => $this->faker->randomElement(['UN', 'CX', 'MT', 'EM']),
            'data_validade' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'preco_padrao' => $this->faker->randomFloat(2, 500.5, 2000),
            'status' => 'A'
        ];
    }
}
