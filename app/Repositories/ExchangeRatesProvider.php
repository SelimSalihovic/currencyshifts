<?php

namespace App\Repositories;

use App\Repositories\CacheExchangeRatesProvider;
use App\Repositories\DbExchangeRatesProvider;

class ExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    protected $cacheProvider;
    protected $dbProvider;

    public function __construct(CacheExchangeRatesProvider $cacheProvider, DbExchangeRatesProvider $dbProvider)
    {
        $this->cacheProvider = $cacheProvider;
        $this->dbProvider = $dbProvider;
    }

    /**
     * Checks which repository returns a valid response and returns it
     * @param string $base
     * @return array
     */
    public function getAllFromBase($base = 'USD')
    {
        $cache = $this->cacheProvider->getAllFromBase($base);

        if (isset($cache['data']) && !empty($cache['data'])) {
            return $cache;
        } else {
            return $this->dbProvider->getAllFromBase($base);
        }
    }

    /**
     * Checks which repository returns a valid response and returns it
     * @param $to
     * @param $amount
     * @param string $base
     * @return mixed
     */
    public function get($to, $amount, $base = 'USD')
    {
        $cache = $this->cacheProvider->get($to, $amount, $base);

        if (isset($cache['data']) && !empty($cache)) {
            return $cache;
        } else {
            return $this->dbProvider->get($to, $amount, $base);
        }
    }

    /**
     * Checks which repository returns a valid response and returns it
     * @param array $symbols
     * @param string $base
     * @param int $amount
     * @return array|mixed
     */
    public function getFromSymbols(array $symbols, $base = 'USD', $amount = 1)
    {
        $cache = $this->cacheProvider->getFromSymbols($symbols, $base, $amount);

        if (isset($cache['data']) && !empty($cache)) {
            return $cache;
        } else {
            return $this->dbProvider->getFromSymbols($symbols, $base, $amount);
        }
    }

}
