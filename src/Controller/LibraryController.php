<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Note;
use App\Repository\NoteRepository;

#[Route('/library')]
final class LibraryController extends AbstractController
{
    #[Route('/', name: 'library',  methods: ['GET'])]
    public function library(NoteRepository $noteRepository, Request $request): Response
    {
        $pageNumber = $request->query->getInt('pageNumber', 0);

        $query = $noteRepository->createQueryBuilder('n')
            ->leftJoin('n.authors', 'u')
            ->orderBy('n.id', 'ASC')
            ->select('n.id', 'n.title', 'n.description', 'u.username')
            ->getQuery()
        ;

        $notes = $noteRepository->paginate($query, $pageNumber);

        if ($request->isXmlHttpRequest()) {
            return $this->render(
                'library/_note_list.html.twig',
                [
                    'notes' => $notes
                ]
            );
	    }

        return $this->render(
            'library/index.html.twig',
            [
                'notes' => $notes,
            ]
        );
    }

    #[Route('/{id<\d+>}', name: 'note_preview')]
    public function preview(Note $note): Response
    {
        $ratings = $note->getRatings()->toArray();

        $totalRating = 0;
        foreach ($ratings as $rating) {
            $totalRating += $rating->getRating();
        }

        $averageRating = count($ratings) === 0 ? 0 : $totalRating / count($ratings);
        
        return $this->render(
            'library/note/show.html.twig', 
            [
                'note' => $note,
                'rating' => $averageRating,
            ]
        );
    }

    #[Route('/{id<\d+>}/redirect', name: 'note_redirect')]
    public function redirectUrl(Note $note): Response
    {
        return $this->redirect($note->getLink());
    }
}
