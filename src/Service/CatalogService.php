<?php

declare(ticks=1);

namespace App\Service;

use App\Service\Parser\CatalogParserInterface;

class CatalogService implements CatalogServiceInterface
{
    /**
     * @var CatalogParserInterface
     */
    private CatalogParserInterface $catalog_parser;

    /**
     * CatalogService constructor.
     * @param CatalogParserInterface $catalog_parser
     */
    public function __construct(CatalogParserInterface $catalog_parser)
    {
        $this->catalog_parser = $catalog_parser;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->catalog_parser->getList();
    }
}