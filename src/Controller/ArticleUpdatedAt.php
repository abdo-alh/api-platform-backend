<?php

namespace App\Controller;

use App\Entity\Article;
use DateTimeImmutable;

class ArticleUpdatedAt
{
    public function __invoke(Article $data) : Article
    {
        $data->setUpdatedAt(new DateTimeImmutable("tommorow"));
        return $data;
    }
}