<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class CacheExchangeRatesProvider implements ExchangeRatesProviderInterface
{

    /** Returns all exchange rates from a specified base
     * @param $base
     * @return array
     */
    public function getAllFromBase($base = 'USD')
    {
        $data = [];
        $exchange_rates = Cache::get('base_' . $base);
        if (count($exchange_rates) > 0) {
            $data['success'] = true;
            $data['data'] = $exchange_rates;
        } else {
            $data['success'] = false;
            $data['error'] = 'Invalid base';
        }

        return $data;
    }

    /** Converts the amount of a certain currency to another currency
     * @param $base
     * @param $to
     * @param $amount
     * @return mixed
     */
    public function get($to, $amount, $base = 'USD')
    {
        $data = [];
        if (Cache::has($base . $to)) {
            $exchange_rate = Cache::get($base . $to);
            $data['success'] = true;
            $data['data']['amount'] = $amount;
            $data['data']['result'] = $amount * $exchange_rate->rate;
            $data['data']['exchange_rate'] = $exchange_rate;
        } else {
            $data['success'] = false;
            $data['error'] = 'Invalid base/to pair';
        }

        return $data;
    }

    /** Retrieves all exchange rates for the given symbols
     * @param array $symbols
     * @param string $base
     * @param int $amount
     * @return array|mixed
     */
    public function getFromSymbols(array $symbols, $base = 'USD', $amount = 1)
    {
        $result = [];
        if (Cache::has('base_' . $base)) {
            $result['success'] = true;
            $result['data'] = [];
            foreach ($symbols as $symbol) {
                if (Cache::has($base . $symbol)) {
                    $exchange_rate = Cache::get($base . $symbol);
                    $data = [];
                    $data['amount'] = $amount;
                    $data['result'] = $exchange_rate->rate * $amount;
                    $data['exchange_rate'] = $exchange_rate;
                    array_push($result['data'], $data);
                }
            }

        } else {
            $result['success'] = false;
            $result['error'] = 'Invalid base';
        }

        return $result;
    }
}
