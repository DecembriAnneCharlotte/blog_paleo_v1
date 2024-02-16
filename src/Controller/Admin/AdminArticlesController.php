<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\Article1Type;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/articles')]
class AdminArticlesController extends AbstractController
{
    #[Route('/', name: 'app_admin_articles_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $pageActive = 'admin_articles';
        return $this->render('admin_articles/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'pageActive' => $pageActive,
        ]);
    }

    #[Route('/new', name: 'app_admin_articles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedIngredients = $form->get('ingredients')->getData();

            foreach ($selectedIngredients as $ingredient) {
                $article->addIngredient($ingredient);
            }

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'pageActive' => 'admin_articles',
        ]);
    }

    #[Route('/{id}', name: 'app_admin_articles_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('admin_articles/show.html.twig', [
            'article' => $article,
            'pageActive' => 'admin_articles',

        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_articles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'pageActive' => 'admin_articles',

        ]);
    }

    #[Route('/{id}', name: 'app_admin_articles_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
