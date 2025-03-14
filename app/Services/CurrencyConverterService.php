<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverterService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('EXCHANGE_API_KEY');
        $this->baseUrl = "https://v6.exchangerate-api.com/v6/{$this->apiKey}/latest/";
    }

    public function convert($amount, $from, $to)
    {
        $response = Http::get("{$this->baseUrl}{$from}");

        if ($response->successful()) {
            $rates = $response->json()['conversion_rates'];
            return $amount * ($rates[$to] ?? 1);
        }

        return null;
    }
}
