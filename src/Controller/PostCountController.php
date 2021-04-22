<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;

class PostCountController 
{

    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke() : int
    {
        return $this->articleRepository->count([]);
    }

}