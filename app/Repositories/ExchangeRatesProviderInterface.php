<?php

namespace App\Repositories;

interface ExchangeRatesProviderInterface
{
    public function getAllFromBase($base);

    public function get($to, $amount, $base);

    public function getFromSymbols(array $symbols, $base, $amount);
}
