<?php

namespace App\Commands;

use App\Configuration;
use LaravelZero\Framework\Commands\Command;

class InitCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Initialize a local configuration at the current directory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $root_dir = dirname(dirname(__DIR__));

        $local_files = [
            Configuration::getSubjectFile(),
            Configuration::getBodyTextFile(),
            Configuration::getBodyHtmlFile(),
            Configuration::getDefaultCsvFile()
        ];
        array_map(function(string $local_file)use($root_dir){
            $example_file = $root_dir . '/assets/' . basename($local_file);
            copy($example_file, $local_file);
        }, $local_files);
    }
}
