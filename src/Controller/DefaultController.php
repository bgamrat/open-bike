<?php
// src/Controller/PracticeController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'organization_name' => 'Gate City Bike Coop',
            'organization_logo' => 'gcbc.webp'
        ]);
    }
}