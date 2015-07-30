<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class CurrenciesController extends Controller
{
    public function index()
    {
        $data = Config::get('currencies-public');
        return response(json_encode($data, JSON_NUMERIC_CHECK), 200);
    }
}
