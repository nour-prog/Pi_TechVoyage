<?php

namespace App\Service;

use GuzzleHttp\Client;

class CountryInfoService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getCountryInfo(string $countryCode)
    {
        $url = sprintf('https://restcountries.com/v3.1/alpha/%s', $countryCode);

        $response = $this->client->get($url);
        return json_decode($response->getBody(), true);
    }
}