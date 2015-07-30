<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ExchangeRatesProvider;

class ApiController extends Controller
{
    protected $provider;

    public function respond(Request $request, ExchangeRatesProvider $provider)
    {
        $this->provider = $provider;
        $base = $request->get('base');
        $to = $request->get('to');
        $symbols = $request->get('symbols');
        $amount = $request->get('amount');

        if (isEmpty($base) and isEmpty($to) and isEmpty($symbols) and isEmpty($amount)) {
            return $this->filterBase('USD');
        }

        if (!isEmpty($to)) {
            if (isEmpty($amount)) {
                $amount = 1;
            }
            return $this->convert($to, $amount, $base);
        }

        if (!isEmpty($base) and isEmpty($symbols) and isEmpty($amount)) {
            return $this->filterBase($base);
        } elseif (!isEmpty($symbols)) {
            if (!isEmpty($base)) {
                if (!isEmpty($amount)) {
                    return $this->respondToSymbols($symbols, $base, $amount);
                }
                return $this->respondToSymbols($symbols, $base);
            }

            if (!isEmpty($amount)) {
                return $this->respondToSymbols($symbols, 'USD', $amount);
            }
            return $this->respondToSymbols($symbols);
        }

        //default case

        $data['success'] = false;
        $data['error'] = 'Invalid parameters';

        return response($data, 422);
    }

    public function convert($to, $amount, $base = 'USD')
    {
        $data = $this->provider->get($to, $amount, $base);

        if (!array_has($data, 'error')) {
            return response(json_encode($data, JSON_NUMERIC_CHECK), 200);
        } else {
            return response($data, 422);
        }
    }

    public function filterBase($base)
    {
        $data = $this->provider->getAllFromBase($base);
        if (!array_has($data, 'error')) {
            return response(json_encode($data, JSON_NUMERIC_CHECK), 200);
        } else {
            return response($data, 422);
        }
    }

    public function respondToSymbols($symbols, $base = 'USD', $amount = 1)
    {
        $symbols = explode(',', $symbols);
        if ($symbols != null and !empty($symbols)) {
            $data = $this->provider->getFromSymbols($symbols, $base, $amount);
            if (!array_has($data, 'error')) {
                return response(json_encode($data, JSON_NUMERIC_CHECK), 200);
            } else {
                return response($data, 422);
            }
        }
    }
}
