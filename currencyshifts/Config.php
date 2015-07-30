<?php

namespace CurrencyShifts;

use Illuminate\Support\Facades\Cache;
use App\Currency;

class Config
{

    protected $config = array(
        'endpoint'   => 'https://query.yahooapis.com/v1/public/yql',
        'currencies' => [],
        'rates' => []
    );

    public function __construct()
    {
        $this->config = \Illuminate\Support\Facades\Config::get('currencies.config');
        $rates = [];
        foreach ($this->config['currencies'] as $key1 => $currency) {
            foreach ($this->config['currencies'] as $key2 => $value) {
                    array_push($rates, $currency . $value);
                    Currency::create(['name' => $currency . $value]);
            }

        }
        $this->config['rates'] = $rates;
        Cache::forever('rates', $rates);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            return null;
        }
    }
}
