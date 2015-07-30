<?php

namespace CurrencyShifts\Request;

use CurrencyShifts\ExchangeRate;
use GuzzleHttp\Client;

class Request
{
    private $client;
    private $args;

    protected $endpoint = 'https://query.yahooapis.com/v1/public/yql';
    protected $yql_query = '?q=SELECT * FROM yahoo.finance.xchange WHERE pair IN ';
    protected $yql_args;
    protected $format = 'xml';

    public $path;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Set the base endpoint for a request
     * @param $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Store the arguments so that they are applied to the request
     * @param Array $args The args to be added to the request
     * @throws \Exception
     */
    public function setArgs($args)
    {
        if (count($args) > 0) {
            $this->args = $args;
            static::constructYql($args);
        } else {
            throw new \Exception('Invalid argument');
        }
    }

    /**
     * Sets the response format
     * @param $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Construct yql params
     * @param $args
     * The params string representation for yql
     */
    public function constructYql($args)
    {
        $yql = "(";
        $last_value = last($args);
        if (count($args) > 0) {
            foreach ($args as $key => $value) {
                $yql .= "'$value'";
                if ($value != $last_value) {
                    $yql .= ',';
                }
            }
            $yql .= ")";
        }

        $this->yql_args = $yql;
        $this->setPath();
    }

    /**
     * Sets the request path
     */
    public function setPath()
    {
        $this->path = $this->endpoint . $this->yql_query . $this->yql_args;
        $this->path .= '&format=' .$this->format;
        $this->path .= '&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';
    }

    /**
     * @param $method
     * @param $path
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function send($method, $path)
    {
        switch ($method) {
            case 'get':
                return $this->get($path);
                break;
            default:
                throw new \Exception('Invalid Request Type');
        }
    }

    /**
     * @param $path
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function get($path)
    {
        return $this->client->get($path);
    }

    /**
     * Format the response to proper ExchangeRate
     * @param $rates
     * @return Arraymixed
     */
    public function formatResponse($rates)
    {
        foreach ($rates as $key => $rate) {
            $rate['id'] = $rate['@attributes']['id'];
            $rate['Date'] = date('Y-m-d', strtotime($rate['Date']));
            $rates[$key] = new ExchangeRate($rate);
        }

        return $rates;
    }

    /**
     * Convert the passed in response to true JSON
     * @param $response
     * @return array
     */
    public function toJson($response)
    {
        $xml = simplexml_load_string($response->getBody());
        $json = json_encode($xml);
        $result = json_decode($json, true);

        return $result['results']['rate'];
    }
}
