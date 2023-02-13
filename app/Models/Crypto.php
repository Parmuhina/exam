<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Crypto
{
    public function crypto(string $symbols, string $convert):Collection
    {
        $apiKey = $_ENV['API_KEY'];
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
        $parameters = [

            'convert' => $convert,
            'symbol' => $symbols
        ];
        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: ' . $apiKey
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $response = (json_decode($response)); // print json decoded response
        curl_close($curl);
        return new Collection($response);
    }


    public function logo(?string $symbol):?string
    {
        $apiKey = $_ENV['API_KEY'];
        $url='https://pro-api.coinmarketcap.com/v2/cryptocurrency/info';
        $parameters = [
            'symbol' => $symbol
        ];
        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: ' . $apiKey
        ];
        $qs = http_build_query($parameters); // query string encode the parameters

        $request = "{$url}?{$qs}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $response = (json_decode($response)); // print json decoded response
        curl_close($curl);

        return $response->data->{$symbol}[0]->logo;
    }
}
