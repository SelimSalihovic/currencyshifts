<?php

namespace App\Repositories;

use App\ExchangeRate;

class DbExchangeRatesProvider implements ExchangeRatesProviderInterface
{

    /** Returns all exchange rates from a specified base
     * @param $base
     * @return array
     */
    public function getAllFromBase($base = 'USD')
    {
        $exchange_rates = ExchangeRate::where('id', 'like', "$base%")->get();

        if (count($exchange_rates) == 118) {
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
        $exchange_rate = ExchangeRate::find($base . $to);

        if (!is_null($exchange_rate)) {
            $data['success'] = true;
            $data['data']['amount'] = $amount;
            $data['data']['result'] = $amount * $exchange_rate->rate;
            $data['data']['exchange_rate'] = $exchange_rate;
        } else {
            $data['success'] = false;
            $data['error'] = 'Invalid base/to pair, check your currencies';
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

        if (!is_null(ExchangeRate::find($base . $base))) {
            $result['success'] = true;
            $result['data'] = [];
            foreach ($symbols as $symbol) {
                $exchange_rate = ExchangeRate::find($base . $symbol);
                $data = [];
                $data['amount'] = $amount;
                $data['result'] = $exchange_rate->rate * $amount;
                $data['exchange_rate'] = $exchange_rate['attributes'];
                array_push($result['data'], $data);
            }
        } else {
            $result['success'] = false;
            $result['error'] = 'Invalid base';
        }

        return $result;
    }
}
