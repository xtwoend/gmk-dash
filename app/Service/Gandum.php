<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class Gandum
{
    protected $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(config('gandum.base_url'));
    }

    public function getProduct($por)
    {
        if (env('DEMO', false)) {
            return [
                'prodId' => $por,
                'itemId' => '6200181',
                'name' => 'Colatta Glaze White',
                'schedDate' => '2024-08-22T08:00:00',
                'qtySched' => 1000.00,
                'prodPoolId' => 'G',
                'inventBatchId' => '72318916'
            ];
        }

        $response = $this->client->get('/api/Por', [
            'id' => $por,
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
