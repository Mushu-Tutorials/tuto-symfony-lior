<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue les amis !'
        ]);
    }

    #[Route('/blog', name: 'blog')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show', requirements: ['id' => '\d+'])]
    public function show(Article $article, int $id)
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/blog/new', name: 'blog_create', priority: 2)]
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article;
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre de l\'article'
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Contenu de l\'article'
                ]
            ])
            ->add('image', TextType::class, [
                'attr' => [
                    'placeholder' => 'Image  de l\'article'
                ]
            ])
            ->getForm();

        return $this->render('blog/create.html.twig', [
            'form_article' => $form->createView(),
        ]);
    }
}
