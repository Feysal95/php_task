<?php

namespace App\Repository;

use App\Entity\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param Article $article
     */
    public function save(Article $article): void;
}