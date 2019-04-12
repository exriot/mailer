<?php

namespace App\Commands;

use App\Configuration;
use LaravelZero\Framework\Commands\Command;

class SendCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'send';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Send a mail from the cache file(s)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $profile = Configuration::getProfile();

        $transport = new \Swift_SmtpTransport(
            $profile->get('host'),
            (int)$profile->get('port', '587'),
            'tls');
        $transport->setUsername($profile->get('username'));
        $transport->setPassword($profile->get('password'));

        $mailer = new \Swift_Mailer($transport);

        $cache_files = Configuration::getCacheFiles();
        array_map(function(string $cache_file)use($mailer){
            $content = file_get_contents($cache_file, false);
            $message = unserialize($content);
            if($message) $mailer->send($message);
            unlink($cache_file);
            sleep(1);
        }, $cache_files);
    }
}
