<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CanvasPixelRepository;
use App\Entity\User;

final class CanvasController extends AbstractController
{
    #[Route('/canvas', name: 'canvas')]
    public function index(CanvasPixelRepository $canvasPixelRepository): Response
    {
        $filledPixels = $canvasPixelRepository->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->select('c.colour', 'c.x', 'c.y', 'u.username')
            ->addOrderBy('c.y', 'ASC')
            ->addOrderBy('c.x', 'ASC')
            ->getQuery()
            ->getArrayResult();
                    
        $pixels = [];

        $currentPixelIndex = 0;
        for ($y = 0; $y < 50; $y++) {
            for ($x = 0; $x < 50; $x++) {
                $currentPixel = $filledPixels[$currentPixelIndex];
                if ($currentPixel['x'] === $x && $currentPixel['y'] === $y) {
                    $pixels[] = [
                        'isFilled' => true,
                        'username' => $currentPixel['username'],
                        'colour' => $currentPixel['colour'],
                    ];
                    $currentPixelIndex++;
                } else {
                    $pixels[] = [
                        'isFilled' => false,
                    ];
                }
            }
        }

        // dd($pixels);

        return $this->render('canvas/index.html.twig', [
            'pixels' => $pixels,
        ]);
    }
}
