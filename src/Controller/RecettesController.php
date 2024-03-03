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

class RecettesController extends AbstractController
{
    #[Route('/recettes', name: 'app_recettes')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $pageActive = 'recettes';
        $routeName = 'app_recettes_detail';

        return $this->render('recettes/index.html.twig', [
            'articles' => $articles,
            'pageActive' => $pageActive,
            'routeName' => $routeName,

        ]);

    }

    #[Route('/recettes/{id}', name: 'app_recettes_detail')]
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

            return $this->redirectToRoute('app_recettes_detail', ['id' => $article->getId()]);
        }

        return $this->render('recettes/detail.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
            'pageActive' => 'recettes',
        ]);
    }


    #[Route('/recettes/{id}/comment-form', name: 'app_recettes_comment_form')]
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

            return $this->redirectToRoute('app_recettes_detail', ['id' => $article->getId()]);
        }

        dump($commentForm->getErrors());
        return $this->render('recettes/detail.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
            'pageActive' => 'recettes',
        ]);
    }

}
