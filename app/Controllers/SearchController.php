<?php

namespace App\Controllers;

use App\Api;
use App\Response;

class SearchController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        $cryptoCurrency = $_GET['currency'];
        $baseCurrency = $_GET['base'];

        $response = $this->api->fetchCryptoPair($cryptoCurrency, $baseCurrency);

        if (!$response) {
            return new Response('partials/not-found', []);
        }

        return new Response('crypto/show', [
            'crypto' => $this->api->fetchCryptoPair($cryptoCurrency, $baseCurrency),
            'baseSymbol' => $baseCurrency,
        ]);
    }
}