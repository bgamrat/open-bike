<?php
// src/Controller/PracticeController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PracticeController extends AbstractController
{
    #[Route('/practice/hello')]
    public function hello(): Response
    {
        return $this->render('practice/hello.html.twig', [
            'name' => 'Me!',
        ]);
    }
}