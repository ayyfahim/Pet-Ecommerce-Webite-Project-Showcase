<?php

namespace App\Console\Commands;

use Spatie\Crawler\Crawler;
use Illuminate\Console\Command;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * https://github.com/spatie/laravel-sitemap
     *
     * @return mixed
     */
    public function handle()
    {
        SitemapGenerator::create(config('app.url'))
            ->shouldCrawl(function (UriInterface $url) {
                return strpos($url->getPath(), '/api') === false;
            })
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->ignoreRobots();
            })
            ->writeToFile(public_path('sitemap.xml'));
    }
}
