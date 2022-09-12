<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;


use Illuminate\Http\Request;
# ini_set('memory_limit', '-1');

class WeatherController extends Controller
{
    //
    public function show(Request $request){
        $client = new Client();
        $res = $client->get('https://api.openweathermap.org/data/2.5/forecast?q='.$request->action.',JP&appid=61e8b6efbe427affcd1c6ff625ee5b91',['verify' => false]);
        //return $res->getStatusCode(); // 200
        $decoded = json_decode($res->getBody());
        return $res->getBody();
        var_dump($decoded);
        return  $decoded;
    }

    public function showForecast(Request $request){
        $client = new Client();
        if(strtolower($request->country) == 'japan'){
            $country = 'JP';
        }
        $res = $client->get('https://api.openweathermap.org/data/2.5/forecast?q='.strtolower($request->city).','.$country.'&appid=61e8b6efbe427affcd1c6ff625ee5b91&units=metric',['verify' => false]);
        //return $res->getStatusCode(); // 200
        $decoded = json_decode($res->getBody());
        return $decoded->list;
    }
    public function showPlaces(Request $request){
        if(strtolower($request->country) == 'japan'){
            $country = 'JP';
        }
        $client = new Client(['headers' => ['Authorization' => 'fsq3FARh58+KZRZ4pz22qoGLz/y4FJdVMQmCUPpECgOyLaw=']]);
        $requestapi = $client->get('https://api.foursquare.com/v3/places/search?near='.strtolower($request->city).','.$country.'&limit=5', ['verify' => false]);
        $decoded = json_decode($requestapi->getBody());
        return $decoded->results;

    }

    public function showPlacesFilter(Request $request){
        error_log(strtolower($request->city). strtolower($request->data));
        if(strtolower($request->country) == 'japan'){
            $country = 'JP';
        }
        $client = new Client(['headers' => ['Authorization' => 'fsq3FARh58+KZRZ4pz22qoGLz/y4FJdVMQmCUPpECgOyLaw=']]);
        $requestapi = $client->get('https://api.foursquare.com/v3/places/search?near='.strtolower($request->city).','.$country.'&&query='.strtolower($request->data), ['verify' => false]);
        $decoded = json_decode($requestapi->getBody());
        return $decoded->results;

    }


}
