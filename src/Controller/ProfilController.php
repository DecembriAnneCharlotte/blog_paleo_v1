<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $pageActive = 'profil';
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'pageActive' => $pageActive,
        ]);
    }

     
    #[Route('/profil/{id}', name: 'user_profil')]
     
    public function show(User $user): Response
    {
        return $this->render('profil/show.html.twig', [
            'user' => $user,
            'pageActive' =>'profil',
        ]);
    }

    //  #[Route('/profil/{id}/edit', name:'user_profil_edit')]
    // public function edit(User $user): Response
    // {
        

    //     return $this->render('profil/edit.html.twig', [
    //         'user' => $user,
    //         'pageActive' =>'profil',
    //     ]);
    // }

    #[Route('/profil/{id}/edit', name:'user_profil_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfilEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_profil', ['id' => $user->getId()]);
        }

        return $this->render('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'pageActive' =>'profil',
        ]);
    }
}
