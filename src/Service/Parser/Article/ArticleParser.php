<?php

declare(ticks=1);

namespace App\Service\Parser\Article;

use App\Service\CrawlerFactoryInterface;
use App\Service\ImageServiceInterface;

class ArticleParser implements ArticleParserInterface
{
    private CrawlerFactoryInterface $crawler_factory;
    private ImageServiceInterface $image;

    /**
     * ArticleParser constructor.
     * @param ImageServiceInterface $image
     * @param CrawlerFactoryInterface $crawler_factory
     * @throws \Exception
     */
    public function __construct(ImageServiceInterface $image, CrawlerFactoryInterface $crawler_factory)
    {
        $this->image = $image;
        $this->crawler_factory = $crawler_factory;
    }

    /**
     * @param string $url
     * @return string
     */
    public function getTitle(string $url): string
    {
        return $this->crawler_factory->getCrawler($url)->filter('[itemprop="headline"]')->first()->text();
    }

    /**
     * @param string $url
     * @return string
     */
    public function getText(string $url): string
    {
        $text = implode(PHP_EOL, $this->crawler_factory->getCrawler($url)->filter('[itemprop="articleBody"] p')->each(function($p, $i) {
            return $p->text();
        }));
        return mb_substr(trim($text), 0, 200);
    }

    /**
     * @param string $url
     * @return string
     */
    public function getImage(string $url): string
    {
        $name = '';
        $icon = $this->crawler_factory->getCrawler($url)->filter('.article__main-image__image');
        if ($icon->count()) {
            $name = $this->image->save($icon->first()->attr('src'));
        }
        return $name;
    }
}