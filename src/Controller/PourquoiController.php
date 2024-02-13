<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PourquoiController extends AbstractController
{
    #[Route('/pourquoi', name: 'app_pourquoi')]
    public function index(): Response
    {
        $pageActive = 'pourquoi';
        return $this->render('pourquoi/index.html.twig', [
            'controller_name' => 'PourquoiController',
            'pageActive' => $pageActive,

        ]);
    }
}
