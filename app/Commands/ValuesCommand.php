<?php

namespace App\Commands;

use App\Configuration;
use LaravelZero\Framework\Commands\Command;

class ValuesCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'values';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List all values in the global configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $profile = Configuration::getProfile();
        $profile
            ->map(function(string $value, string $key){
                echo "${key}: ${value}\n";
            });
    }
}
