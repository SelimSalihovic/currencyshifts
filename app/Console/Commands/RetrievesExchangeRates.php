<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Cache;
use CurrencyShifts\Request\Request;
use App\Repositories\ExchangeRateStringsProvider;
use Illuminate\Support\Facades\DB;
use App\ExchangeRate;

trait RetrievesExchangeRates
{
    /**
     * @param $order
     * @param int $base
     * @throws \Exception
     */
    protected function retrieve($order, $base = 0)
    {
        $provider = new ExchangeRateStringsProvider();

        $returned = array();
        $all_rates = $provider->getAll();
        for ($i = 1; $i <= 13; $i++) {
            $increment = 250;
            $request = new Request();
            $rates = array_slice($all_rates, $base, $increment);
            $request->setArgs($rates);
            $response = $request->send('get', $request->path);
            $result = $request->toJson($response);
            $result = $request->formatResponse($result);

            $base += 250;
            $increment += 250;

            $returned = array_merge($returned, $result);
        }

        if ($order == 1) {
            Cache::forever('exchange_rates', $returned);
        } else {
            $exchange_rates = Cache::get('exchange_rates');
            $exchange_rates = array_merge($exchange_rates, $returned);
            Cache::forget('exchange_rates');
            Cache::forever('exchange_rates', $exchange_rates);
        }
    }

    /**
     * Finishes the exchange rate updates
     */
    public function finalize()
    {
        $provider = new ExchangeRateStringsProvider();
        $all_rates = $provider->getAll();
        $returned = [];

        $dat_base = 13000;
        $dat_increment = 250;

        for ($i = 1; $i <= 4; $i++) {
            if ($i == 4) {
                $base = 13750;
                $increment = 174;
            } else {
                $base = $dat_base;
                $increment = $dat_increment;
            }

            $request = new Request();
            $rates = array_slice($all_rates, $base, $increment);
            $request->setArgs($rates);
            $response = $request->send('get', $request->path);
            $result = $request->toJson($response);
            $result = $request->formatResponse($result);

            $returned = array_merge($returned, $result);
            $dat_base += 250;
            $dat_increment += 250;
        }

        $exchange_rates = Cache::get('exchange_rates');
        $exchange_rates = array_merge($exchange_rates, $returned);

        Cache::forget('exchange_rates');
        Cache::forever('exchange_rates', $exchange_rates);

        if (count($exchange_rates) == 13924) {
            if (Cache::has('public_rates')) {
                Cache::forget('public_rates');
            }

            Cache::forever('public_rates', $exchange_rates);
            DB::table('exchangerates')->delete();

            foreach ($exchange_rates as $exchange_rate) {
                ExchangeRate::create((array)$exchange_rate);
                if (Cache::has($exchange_rate->id)) {
                    Cache::forget($exchange_rate->id);
                } else {
                    Cache::forever($exchange_rate->id, $exchange_rate);
                }
            }

            $currencies = \Illuminate\Support\Facades\Config::get('currencies.config')['currencies'];

            foreach ($currencies as $currency) {
                $base_array = [];
                foreach (Cache::get('public_rates') as $exchange_rate) {
                    if (starts_with($exchange_rate->id, $currency)) {
                        $base_array[] = $exchange_rate;
                    }
                }

                if (Cache::has('base_' . $currency)) {
                    Cache::forget('base_' . $currency);
                }
                Cache::forever('base_' . $currency, $base_array);

            }
        }
    }
}
