<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Currency;

class ExchangeRateStringsProvider
{
    public function getAll()
    {
        if (static::valid(Cache::get('rates'))) {
            return Cache::get('rates');
        } elseif (static::valid(app('Config')->rates)) {
            return app('Config')->rates;
        } elseif ($currencies = Currency::all()) {
            if (static::valid($currencies)) {
                $exchange_rate_strings = [];
                foreach ($currencies as $currency) {
                    $exchange_rate_strings[] = $currency->name;
                }

                return $exchange_rate_strings;
            }
        }
    }

    public function valid($rates)
    {
        if ($rates != null and !empty($rates) and count($rates) == 13924) {
            return true;
        }

        return false;
    }
}
