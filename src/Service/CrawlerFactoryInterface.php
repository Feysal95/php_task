<?php

declare(ticks=1);

namespace App\Service;

use Symfony\Component\DomCrawler\Crawler;

interface CrawlerFactoryInterface
{
    /**
     * @param string $url
     * @return Crawler
     */
    public function getCrawler(string $url): Crawler;
}