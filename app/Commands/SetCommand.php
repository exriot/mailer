<?php

namespace App\Commands;

use App\Configuration;
use LaravelZero\Framework\Commands\Command;

class SetCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'set {name : field name} {value : field value}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Set value as the field';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $profile = Configuration::getProfile();
        $profile
            ->set($this->argument('name'), $this->argument('value'))
            ->save();
    }
}
