<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user', function (Request $request) {
    $test = 'wwwww';
    // error_log($request->country);
    return $request->country;
});


# Route::post('city', 'App\Http\Controllers\WeatherController@show');
Route::post('forecast', 'App\Http\Controllers\WeatherController@showForecast');
Route::post('places', 'App\Http\Controllers\WeatherController@showPlaces');
Route::post('places/filter', 'App\Http\Controllers\WeatherController@showPlacesFilter');

