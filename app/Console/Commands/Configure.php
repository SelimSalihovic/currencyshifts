<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use CurrencyShifts\Config;

class Configure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets everything up for use';

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
        new Config();
        $this->info('Configuration complete.');
    }
}
