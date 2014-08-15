<?php

namespace Application\Controller;

use Application\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class NewsController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /**
     * @param \Twig_Environment $twig
     * @param EntityManagerInterface $em
     */
    public function __construct(\Twig_Environment $twig, EntityManagerInterface $em)
    {
        $this->twig = $twig;
        $this->em   = $em;
    }

    /**
     * @return string
     */
    public function showArticleListAction()
    {
        $articleList = $this->em->getRepository('Application\Entity\Article')->findAll();

        return $this->twig->render('news/article_list.html.twig', ['article' => $articleList]);
    }

    /**
     * @param Article $article
     * @return string
     */
    public function showNewsArticleAction(Article $article)
    {
        return $this->twig->render('news/article.html.twig', ['article' => $article]);
    }
}