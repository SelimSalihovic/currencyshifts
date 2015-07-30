<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\RetrievesExchangeRates;

class UpdateExchangeRates extends Command
{

    use RetrievesExchangeRates;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the exchange rates from Yahoo Finance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->retrieve(1);
        $this->retrieve(2, 3250);
        $this->retrieve(3, 6500);
        $this->retrieve(4, 9750);
        $this->finalize();

        return $this->info('Exchange Rates Updated!');

    }
}
