<?php

declare(ticks=1);

namespace App\Service;

interface CatalogServiceInterface
{
    /**
     * @return array
     */
    public function getList(): array;

}