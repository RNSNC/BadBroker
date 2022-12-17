<?php

namespace App\Service;

use GuzzleHttp\Client;

class ExchangeRatesApi
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.apilayer.com/'
        ]);
    }

    public function getCourseTimeSeries($startDate, $endDate, $base = 'USD', $symbols = 'EUR,RUB,GBP,JPY'): array
    {
        $response = $this->client->get("exchangerates_data/timeseries",[
            'query' => [
                'apikey' => $_ENV['API_LAYER'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'base' => $base,
                'symbols' => $symbols,
            ],
        ])->getBody();

        return (json_decode($response, true))['rates'];
    }

    public function getCourseOne(string $date, $base = 'USD', $symbols = 'EUR,RUB,GBP,JPY')
    {
        $response = $this->client->get("exchangerates_data/$date",[
            'query' => [
                'apikey' => $_ENV['API_LAYER'],
                'base' => $base,
                'symbols' => $symbols,
            ],
        ])->getBody();

        return (json_decode($response, true))['rates'];
    }
}