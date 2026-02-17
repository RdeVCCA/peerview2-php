<?php

namespace App\Controller;

use finfo;
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
            ->leftJoin('n.authors', 'a')
            ->leftJoin('n.comments', 'c')
            ->leftJoin('n.ratings', 'r')
            ->groupBy('n.id')
            ->orderBy('n.id', 'ASC')
            ->select(
                'n.id', 'n.title', 'n.description', 'n.timeCreated', 'n.isFile', 'n.link',
                'a.username', 'COUNT(a.id) AS authorCount', 'COUNT(DISTINCT c.id) AS commentCount', 'COUNT(DISTINCT r.id) AS ratingCount', 'AVG(r.rating) AS rating'
            )
        ;

        $notes = iterator_to_array($noteRepository->paginate($query, $pageNumber));
        foreach ($notes as $idx => $note) {
            if ($note['isFile']) {
                // determine file type
                // code is currently broken as we have yet to determine filesystem structure
                // $finfo = finfo_open(FILEINFO_NONE);
                // $fileType = finfo_file($finfo, $note['link']);
                // finfo_close($finfo);
                // $notes[$idx]['fileType'] = $fileType;
                $notes[$idx]['fileType'] = 'placeholder filetype';
            } else {
                // determine website domain
                $notes[$idx]['hostName'] = parse_url($note['link'], PHP_URL_HOST);
            }
        }

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
