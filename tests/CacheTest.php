<?php

use App\Repositories\CacheExchangeRatesProvider;

class CacheTest extends TestCase
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new CacheExchangeRatesProvider();
    }

    /**
     * Tests the getAllFromBase function from the CacheExchangeRatesProvider
     */
    public function testGetByBase()
    {
        $exchange_rates = $this->provider->getAllFromBase('USD');
        $this->assertCount(2, $exchange_rates);
        $this->assertArrayNotHasKey('error', $exchange_rates);
    }

    /**
     * Tests the get function from the CacheExchangeRatesProvider
     */
    public function testGet()
    {
        $amount = 1;
        $data = $this->provider->get('BAM', $amount, 'USD');
        $this->assertArrayNotHasKey('error', $data);
    }

    /**
     * Tests the getFromSymbols function from the CacheExchangeRatesProvider
     */
    public function testGetFromSymbols()
    {
        $data = $this->provider->getFromSymbols(['EUR', 'UZS', 'ZAR'], 'USD', 1);
        $this->assertArrayNotHasKey('error', $data);
    }
}
