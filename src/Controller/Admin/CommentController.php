<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(['approuve' => false]);
        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
            'pageActive' => 'comments',
        ]);
    }

    #[Route('/{id}/validate', name: 'comment_validate', methods: ['POST'])]
    public function validate(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('validate-comment', $request->request->get('_token'))) {
            $comment->setApprouve(true);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a été validé avec succès.');
            return $this->redirectToRoute('app_comment');
        }

        $this->addFlash('error', 'Échec de validation du commentaire.');
        return $this->redirectToRoute('app_comment');
    }

    #[Route('/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete-comment', $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a été supprimé avec succès.');
            return $this->redirectToRoute('app_comment');
        }

        $this->addFlash('error', 'Échec de suppression du commentaire.');
        return $this->redirectToRoute('app_comment');
    }
}
