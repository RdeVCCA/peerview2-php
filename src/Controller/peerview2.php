<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class peerview2 {
  #[Route('/peerview2')]
  public function thing() : Response {
    $number = random_int(0, 10000); 

    return new Response(
      $number
    );
  }
}
