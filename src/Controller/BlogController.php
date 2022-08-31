<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue les amis !'
        ]);
    }

    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(Article $article, int $id)
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
}
