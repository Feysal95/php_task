<?php

declare(ticks=1);

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/single/{article}", name="single_article")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function single(Article $article)
    {
        return $this->render('single.html.twig', [
            'article' => $article
        ]);
    }
}
