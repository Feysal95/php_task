<?php

declare(ticks=1);

namespace App\Service\Parser\Article;

interface ArticleParserInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function getTitle(string $url): string;

    /**
     * @param string $url
     * @return string
     */
    public function getText(string $url): string;


    /**
     * @param string $url
     * @return string|null
     */
    public function getImage(string $url): ?string;
}