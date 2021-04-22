<?php

namespace App\Controller;

use App\Entity\Article;

class PostPublishController 
{

    public function __invoke(Article $data) : Article
    {
        //$data->setContent("true");
        return $data;
    }

}