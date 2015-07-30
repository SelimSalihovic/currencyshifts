<?php

$app->get('/', 'HomeController@index');
$app->get('currencies', 'CurrenciesController@index');

#API Routes
$app->group(['prefix' => 'api/v1/'], function ($app) {
    $app->get('xrates', 'App\Http\Controllers\ApiController@respond');
});
