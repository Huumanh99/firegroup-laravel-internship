<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Collection;
use Weidner\Goutte\Goutte;
use Weidner\Goutte\GoutteFacade;

class crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:dantri';

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
        $crawl = GoutteFacade::request('GET', 'https://dantri.com.vn/the-gioi.htm');
        $links = $crawl->filter('h3.article-title a')->each(function ($node) {
            return $node->attr('href');
        });
        foreach ($links as $link) {
            $this->getData($link);
        }
    }

    protected function crawlData(string $type, $crawler){
        $result = $crawler->filter($type)->each(function ($node){
            return $node->text();
        });

        if (!empty($result)){
            return $result[0];
        }
        return '';
    }

    protected function crawlImage(string $type, $crawler){
        $result = $crawler->filter($type)->each(function ($node){
            return $node->attr('data-original');
        });

        if (!empty($result)){
            return $result[0];
        }
        return '';
    }

    public function getData($url) {

        $crawl = GoutteFacade::request('GET', $url);
        
        $title = $this->crawlData('h1.title-page.detail', $crawl);

        $content = $this->crawlData('h2.singular-sapo', $crawl);
        $content = str_replace('(Dân trí) ', '', $content);

        $description = $this->crawlData('div.singular-content', $crawl);

        $image =$this->crawlImage('figure.image.align-center img', $crawl);

        Post::create([
            'title' => $title,
            'image' => $image,
            'description' => $description,
            'content' => $content
        ]);
    }

}
