<?php

declare(ticks=1);

namespace App\Service\Parser;

interface CatalogParserInterface
{
    /**
     * @return array
     */
    public function getList(): array;
}