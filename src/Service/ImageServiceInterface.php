<?php

declare(ticks=1);

namespace App\Service;

interface ImageServiceInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function save(string $url): string;
}