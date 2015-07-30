<?php

use App\Repositories\ExchangeRatesProvider;
use App\Repositories\CacheExchangeRatesProvider;
use App\Repositories\DbExchangeRatesProvider;

class FunctionalityTest extends TestCase
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExchangeRatesProvider(new CacheExchangeRatesProvider(), new DbExchangeRatesProvider());
    }

    /**
     * Tests the getAllFromBase function from the ExchangeRatesProvider
     */
    public function testGetByBase()
    {
        $exchange_rates = $this->provider->getAllFromBase('USD');
        $this->assertCount(2, $exchange_rates);
        $this->assertArrayNotHasKey('error', $exchange_rates);
    }

    /**
     * Tests the get function from the ExchangeRatesProvider
     */
    public function testGet()
    {
        $amount = 1;
        $data = $this->provider->get('BAM', $amount, 'USD');
        $this->assertArrayNotHasKey('error', $data);
    }

    /**
     * Tests the getFromSymbols function from the ExchangeRatesProvider
     */
    public function testGetFromSymbols()
    {
        $data = $this->provider->getFromSymbols(['EUR', 'UZS', 'ZAR'], 'USD', 1);
        $this->assertArrayNotHasKey('error', $data);
    }
}
