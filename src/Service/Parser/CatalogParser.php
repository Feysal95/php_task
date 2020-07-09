<?php

declare(ticks=1);

namespace App\Service\Parser;

use App\Service\CrawlerFactoryInterface;
use App\Service\Parser\Article\ArticleParserInterface;
use Symfony\Component\DomCrawler\Crawler;

class CatalogParser implements CatalogParserInterface
{
    private string $uri = 'https://www.rbc.ru/';
    private CrawlerFactoryInterface $crawler_factory;
    private ArticleParserInterface $article_parser;

    /**
     * ArticlesParser constructor.
     * @param ArticleParserInterface $article_parser
     * @param CrawlerFactoryInterface $crawler_factory
     */
    public function __construct(ArticleParserInterface $article_parser, CrawlerFactoryInterface $crawler_factory)
    {
        $this->crawler_factory = $crawler_factory;
        $this->article_parser = $article_parser;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->crawler_factory->getCrawler($this->uri)->filter('a.js-news-feed-item')->each(function(Crawler $a, $i) {
            return $this->getItem($a);
        });
    }

    /**
     * @param Crawler $a
     * @return array
     */
    private function getItem(Crawler $a): array
    {
        try {
            $data = [
                'title' => $this->article_parser->getTitle($a->attr('href')),
                'content' => $this->article_parser->getText($a->attr('href')),
                'image' => $this->article_parser->getImage($a->attr('href'))
            ];
        } catch (\Throwable $e) {
            $data = [
                'title' => $a->text(),
                'content' => $a->text(),
                'image' => ''
            ];
        }
        return $data;
    }
}