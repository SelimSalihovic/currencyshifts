<?php

namespace App\Repositories;

use App\Repositories\ExchangeRatesProvider;

class ExampleResponseProvider
{
    protected $provider;

    public function __construct(ExchangeRatesProvider $provider)
    {
        $this->provider = $provider;
    }

    public function defaultCase()
    {
        return json_encode($this->provider->getAllFromBase('USD'), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }

    public function specificBase()
    {
        return json_encode($this->provider->getAllFromBase('EUR'), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }

    public function symbols()
    {
        return json_encode($this->provider->getFromSymbols(['EUR', 'GBP']), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }

    public function convert()
    {
        return json_encode($this->provider->get('EUR', 1, 'GBP'), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }

    public function convertAmount()
    {
        return json_encode($this->provider->get('EUR', 10, 'GBP'), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }

    public function symbolsAmount()
    {
        return json_encode($this->provider->getFromSymbols(['EUR', 'GBP', 'CHF'], 'USD', 10), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }

    public function symbolsAmountBase()
    {
        return json_encode($this->provider->getFromSymbols(['EUR', 'GBP', 'CHF'], 'BAM', 10), JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
    }
}
