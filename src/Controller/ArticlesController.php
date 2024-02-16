<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $pageActive = 'articles';
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'pageActive' => $pageActive,
        ]);
    }

    #[Route('/articles/{id}', name: 'app_articles_detail')]
    public function detail(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment->setUser($this->getUser());
            $comment->setArticle($article);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_articles_detail', ['id' => $article->getId()]);
        }

        return $this->render('articles/detail.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
            'pageActive' => 'articles',
        ]);
    }

    // #[Route('/articles/{id}/comment-form', name: 'app_articles_comment_form')]
    // public function commentForm(Article $article): Response
    // {
    //     $comment = new Comment();
    //     $commentForm = $this->createForm(CommentType::class, $comment);

    //     return $this->render('articles/detail.html.twig', [
    //         'article' => $article,
    //         'commentForm' => $commentForm->createView(),
    //         'pageActive' => 'articles',
    //     ]);
    // }

    #[Route('/articles/{id}/comment-form', name: 'app_articles_comment_form')]
    public function commentForm(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setArticle($article);
            $comment->setDate(new DateTime());
            $comment->setApprouve(false);

            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirection vers une autre route après le traitement du formulaire
            return $this->redirectToRoute('app_articles_detail', ['id' => $article->getId()]);
        }

        dump($commentForm->getErrors());
        return $this->render('articles/detail.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
            'pageActive' => 'articles',
        ]);
    }
}
