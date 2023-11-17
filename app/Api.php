<?php

namespace App;

use App\Collections\CryptoCollection;
use App\Models\Crypto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    private const BASE_URL = 'https://api4.binance.com/api/v3/ticker/24hr?';
    private const BASE_CRYPTO = 'EUR';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchCryptoData(array $cryptoCodes): ?CryptoCollection
    {
        $cryptoCollection = new CryptoCollection();

        foreach ($cryptoCodes as $cryptoCode) {
            $url = $this::BASE_URL . http_build_query([
                    'symbol' => $cryptoCode . $this::BASE_CRYPTO,
                ]);;

            try {
                $response = $this->client->get($url);

                $crypto = json_decode($response->getBody()->getContents());

                if (empty($crypto)) {
                    return null;
                }

                $cryptoCurrency = new Crypto(
                    $crypto->symbol,
                    (float)$crypto->priceChange,
                    (float)$crypto->priceChangePercent,
                    (float)$crypto->weightedAvgPrice,
                    (float)$crypto->prevClosePrice,
                    (float)$crypto->lastQty,
                    (float)$crypto->bidPrice,
                    (float)$crypto->bidQty,
                    (float)$crypto->askPrice,
                    (float)$crypto->askQty,
                    (float)$crypto->openPrice,
                    (float)$crypto->highPrice,
                    (float)$crypto->lowPrice,
                    (float)$crypto->volume,
                    (float)$crypto->quoteVolume,
                    $crypto->openTime,
                    $crypto->closeTime,
                    $crypto->count
                );

                $cryptoCollection->add($cryptoCurrency);
            } catch (GuzzleException $e) {
                echo $e->getMessage();
                return null;
            }
        }

        return $cryptoCollection;
    }

    public function fetchCryptoPair(string $currency, string $base): ?Crypto
    {
        $url = $this::BASE_URL . http_build_query([
                'symbol' => $currency . $this::BASE_CRYPTO,
            ]);;

        try {
            $response = $this->client->get($url);
        } catch (GuzzleException $e) {
            return null;
        }

        $crypto = json_decode($response->getBody()->getContents());

        return new Crypto(
            $crypto->symbol,
            (float)$crypto->priceChange,
            (float)$crypto->priceChangePercent,
            (float)$crypto->weightedAvgPrice,
            (float)$crypto->prevClosePrice,
            (float)$crypto->lastQty,
            (float)$crypto->bidPrice,
            (float)$crypto->bidQty,
            (float)$crypto->askPrice,
            (float)$crypto->askQty,
            (float)$crypto->openPrice,
            (float)$crypto->highPrice,
            (float)$crypto->lowPrice,
            (float)$crypto->volume,
            (float)$crypto->quoteVolume,
            $crypto->openTime,
            $crypto->closeTime,
            $crypto->count
        );
    }
}