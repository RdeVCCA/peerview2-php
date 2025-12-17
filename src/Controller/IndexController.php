<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(NoteRepository $noteRepository, UserRepository $userRepository): Response
    {
        $numUsers = $userRepository->count();
        $numNotes = $noteRepository->count();

        $topNotes = $noteRepository->createQueryBuilder('n')
            ->orderBy('n.visits', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult()
        ;
        
        $newestNotes = $noteRepository->createQueryBuilder('n')
            ->orderBy('n.timeCreated', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getArrayResult()
        ;

        return $this->render('index/index.html.twig', [
            'userCount' => $numUsers,
            'noteCount' => $numNotes,
            'topNotes' => $topNotes,
            'newestNotes' => $newestNotes,
        ]);
    }
}
