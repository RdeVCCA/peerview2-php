<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use App\Entity\Note;
use App\Repository\NoteRepository;

#[Route(path: '/api')]
final class ApiController extends AbstractController
{
    #[Route('/notes', name: 'api_note_page', methods: ['GET'])]
    public function index(NoteRepository $noteRepository, Request $request): Response
    {
        $pageNumber = $request->query->get('pageNumber');
        
        $query = $noteRepository->createQueryBuilder('n')
            ->leftJoin('n.authors', 'u')
            ->orderBy('n.id', 'ASC')
            ->select('n.id', 'n.title', 'n.description', 'u.username')
            ->getQuery()
        ;

        $notes = $noteRepository->paginate($query, $pageNumber);

        return $this->render(
            'library/_note_list.html.twig',
            [
                'notes' => $notes
            ]
        );
    }
}
