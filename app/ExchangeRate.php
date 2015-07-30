<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'exchangerates';

    public $timestamps = false;

    protected $fillable = ['id', 'name', 'rate', 'date', 'time', 'ask', 'bid'];
}
