<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade;

class ScrapePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $crawler = GoutteFacade::request('GET', 'https://dantri.com.vn/lao-dong-viec-lam/can-tho-f0-f1-bot-lo-lang-vi-khong-phai-tra-vien-phi-20210829181940605.htm');
        $title = $crawler->filter('h1.dt-news__title')->each(function ($node) {
            return $node->text();
        })[0];
        $title = $crawler->filter('h1.dt-news__title')->each(function ($node) {
            return $node->text();
        })[0];

        $description = $crawler->filter('div.dt-news__sapo h2')->each(function ($node) {
            return $node->text();
        })[0];
        $description = str_replace('Dân trí', '', $description);

        $content = $crawler->filter('div.dt-news__content')->each(function ($node) {
            return $node->text();
        })[0];
        print($title);
    }
}
