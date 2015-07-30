<?php

namespace CurrencyShifts;

class ExchangeRate
{

    public $id;
    public $name;
    public $rate;
    public $date;
    public $time;
    public $ask;
    public $bid;

    public function __construct($params)
    {
        $this->id = $params['id'];
        $this->name = $params['Name'];
        $this->rate = $params['Rate'];
        $this->date = $params['Date'];
        $this->time = $params['Time'];
        $this->ask = $params['Ask'];
        $this->bid = $params['Bid'];
    }
}
