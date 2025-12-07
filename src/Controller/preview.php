<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Dotenv\Dotenv;


class preview extends AbstractController
{
  #[Route("library/{note_id}", name: "preview_url", methods: ['GET', 'POST'])]
  public function preview(int $note_id): Response
  {
    $dotenv = new Dotenv();
    $dotenv->load($this->getParameter("kernel.project_dir") . "/.env");

    $database = mysqli_connect($_ENV["HOSTNAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DATABASE"], $_ENV["DB_PORT"]);
    if ($database->connect_errno) {
      return new Response("<h1>Unable to connect to database. Blame someone else.</h1>");
    }

    $data = mysqli_query($database, "SELECT * FROM notes WHERE id = {$note_id};")->fetch_assoc();

    $preview_url = $data["link"];
    switch ($data["type"]) {
      case "GoogleDocument":
        $preview_url .= "&embedded=true";
        break;

      //       case "Quizlet":
//         $ch = curl_init($preview_url);
//         // curl_setopt($ch, CURLOPT_NOBODY, true); // we only want headers
//         // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects
//         // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         // curl_setopt($ch, CURLOPT_HEADER, true);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects
//         curl_setopt($ch, CURLOPT_MAXREDIRS, 10);        // prevent infinite loops
// 
//         curl_exec($ch);
//         $preview_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
//         curl_close($ch);
// 
// 
//         // $preview_url = strtok($preview_url, "?")."/flashcards/embed?".strtok(""); 
//         // $preview_url.="/flashcards/embed";
//         break;

      case "GoogleDriveFolder":
        $url_stem = strtok($preview_url, "?");
        $url_part = strtok($url_stem, "/");
        $count = 10;
        while ($url_part != "folders") {
          $url_part = strtok(strtok(""), "/");
          $count--;
        }

        $preview_url = "https://drive.google.com/embeddedfolderview?id=" . strtok(strtok(""), "/") . "#list";

        break;


      default:
        return new Response("<h1>Preview is currently not available for files of type: " . $data["type"] . ". Please check back next time</h1>");
    }

    return $this->render('preview.html.twig', ['preview_url' => $preview_url]);
  }

  #[Route("library/{note_id}/redirect", name: "redirect_url", methods: ['GET', 'POST'])]
  public function redirect_url(int $note_id): Response
  {
    $dotenv = new Dotenv();
    $dotenv->load($this->getParameter("kernel.project_dir") . "/.env");

    $database = mysqli_connect($_ENV["HOSTNAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DATABASE"], $_ENV["DB_PORT"]);
    if ($database->connect_errno) {
      return new Response("<h1>Unable to connect to database. Blame someone else.</h1>");
    }

    $data = mysqli_query($database, "SELECT * FROM notes WHERE id = {$note_id};")->fetch_assoc();

    return $this->redirect($data["link"]);
  }

}