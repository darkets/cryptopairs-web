<?php

namespace App\Controllers;

use App\Api;
use App\Response;

class CryptoController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        return new Response('crypto/index', [
            'cryptoCollection' => $this->api->fetchCryptoData(['ETC', 'LTC', 'DOGE'])->get(),
            'baseSymbol' => 'EUR',
        ]);
    }
}