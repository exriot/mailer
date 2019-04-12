<?php

namespace App\Commands;

use App\Configuration;
use App\HtmlModifier;
use App\MarkdownUndresser;
use Illuminate\Support\Facades\App;
use LaravelZero\Framework\Commands\Command;
use Michelf\MarkdownExtra;

class TranslateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'translate';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Translate the current body.txt into body.html';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $build_dir = getcwd();
        $markdown_file = $build_dir . "/body.md";
        $text_file = $build_dir . "/body.txt";
        $html_file = $build_dir . "/body.html";

        $text = file_get_contents($markdown_file, false);

        $undressed = (new MarkdownUndresser($text))
                        ->modify()
                        ->getResult();
        file_put_contents($text_file, $undressed);

        $html = MarkdownExtra::defaultTransform($text);
        $html = (new HtmlModifier($html))
                    ->modify()
                    ->getResult();
        file_put_contents($html_file, $html);
    }
}
