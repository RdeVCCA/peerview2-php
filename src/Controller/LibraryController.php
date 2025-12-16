<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\NoteRepository;

#[Route('/library')]
final class LibraryController extends AbstractController
{
    #[Route('/', name: 'library')]
    public function library(NoteRepository $noteRepository): Response
    {
        $notes = $noteRepository->findAll();

        return $this->render(
            'library/index.html.twig',
            [
                'notes' => $notes,
            ]
        );
    }
    #[Route('/{noteId}', name: 'note_preview', methods: ['GET', 'POST'])]
    public function preview($noteId, NoteRepository $noteRepository): Response
    {
        $note = $noteRepository->find($noteId);
        if ($note === null) {
            throw $this->createNotFoundException('Note not found');
        }
        
        return $this->render(
            'library/note/show.html.twig', 
            [
                'note' => $note
            ]
        );
    }

    #[Route('/{noteId}/redirect', name: 'note_redirect', methods: ['GET', 'POST'])]
    public function redirectUrl($noteId, NoteRepository $noteRepository): Response
    {
        $note = $noteRepository->find($noteId);
        return $this->redirect($note->getLink());
    }
}
