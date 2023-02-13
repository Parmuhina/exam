<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CurrencyPriceRequest extends Model
{
    use HasFactory;

    public function currencyPrice():Collection
    {
        $client = new Client();
        $url = 'https://www.bank.lv/vk/ecb.xml';
        $response = $client->get($url);
        $xml = simplexml_load_string((string)$response->getBody());
        $response=[];
        foreach($xml->children()->Currencies->Currency as $child){
            $response[]=new Currency($child->ID, floatval($child->Rate));
        }
        return new Collection($response);
    }


}
