<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecettesController extends AbstractController
{
    #[Route('/recettes', name: 'app_recettes')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $pageActive = 'recettes';
        return $this->render('recettes/index.html.twig', [
            'articles' => $articles,
            'pageActive' => $pageActive,
        ]);

    }
}
