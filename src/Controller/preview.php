<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Dotenv\Dotenv;


class preview extends AbstractController{
  #[Route("library/{note_id}", name: "preview_url", methods: ['GET', 'POST'])] 
  public function preview(int $note_id): Response {
    $dotenv = new Dotenv(); 
    $dotenv->load($this->getParameter("kernel.project_dir"). "/.env"); 
    
    $database = mysqli_connect($_ENV["HOSTNAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DATABASE"], $_ENV["DB_PORT"]); 
    if ($database->connect_errno) {
      return new Response("<h1>Unable to connect to database. Blame someone else.</h1>");
    }

    $data = mysqli_query($database, "SELECT * FROM notes WHERE id = {$note_id};");

    return $this->render('preview.html.twig', ['gdocs_url' =>$data->fetch_assoc()["link"]]);
  }

}