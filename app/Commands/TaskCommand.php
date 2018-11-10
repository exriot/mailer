<?php

namespace App\Commands;

use App\Configuration;
use LaravelZero\Framework\Commands\Command;

class TaskCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'task {csv? : CSV file}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Task email cache from CSV file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $profile = Configuration::getProfile();

        $csv_file = $this->argument('csv');
        if(empty($csv_file)){
            $csv_file = Configuration::getDefaultCsvFile();
        }

        $csv_content = file_get_contents($csv_file);
        $csv_content = trim($csv_content);
        $names = (new \Econic\CsvReader\Reader())
                    ->setTrim(true)
                    ->setSource($csv_content)
                    ->parse()[0];
        $csv = (new \Econic\CsvReader\Reader())
                    ->setTrim(true)
                    ->setSource($csv_content)
                    ->addKeys($names)
                    ->parse();

        $nth = Configuration::getLastCacheNth();

        $subject_file = Configuration::getSubjectFile();
        $body_file = Configuration::getBodyTextFile();
        for($i=1, $k=count($csv); $i<$k; $i++){
            $line = $csv[$i];
            var_dump($line);

            $subject = new \Text_Template($subject_file, '<%', '%>');
            $body = new \Text_Template($body_file, '<%', '%>');
            $subject->setVar($line);
            $body->setVar($line);

            $message = new \Swift_Message($subject->render());
            $message->setFrom([
                $profile->get('email') => $profile->get('name')
            ]);
            $message->setTo([
                $line['email'] => $line['name']
            ]);
            $message->setBody($body->render());

            $nth++;
            $cache_file = Configuration::getCacheFile($nth);
            file_put_contents($cache_file, serialize($message));
        }
    }
}
