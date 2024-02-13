<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $pageActive = 'accueil';
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'pageActive' => $pageActive,
        ]);

    }

// public function maPageAction(Request $request)
// {
//     $pageActive = $request->attributes->get('_route');

//     return $this->render('components/header.html.twig', ['pageActive' => $pageActive]);
// }

}
