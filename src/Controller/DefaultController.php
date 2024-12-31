<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\BikeRequest;
use App\Form\BikeRequestType;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class DefaultController extends AbstractController {

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'home')]
    #[Route('/page/{_locale<%app.supported_locales%>}/home', name: 'home-page')] // the home page should look the same
    public function index(): Response {
        $bikeRequest = new BikeRequest();
        $bikeRequestForm = $this->createForm(BikeRequestType::class, $bikeRequest);
        return $this->render('index.html.twig', ['bike_request_form' => $bikeRequestForm]);
    }

    #[Route('/page/{_locale<%app.supported_locales%>}/{slug}', name: 'page', requirements: ['slug' => '[\w-]+'])]
    public function page(Request $request, PageRepository $pageRepository, string $slug): Response {
        $locale = $request->getLocale();
        $page = $pageRepository->findOneBy(['slug' => $slug, 'locale' => $locale]);
        if ($page === null) {
            throw new ResourceNotFoundException();
        }
        return $this->render('page.html.twig', ['page' => $page]);
    }

    #[Route('/')]
    public function indexNoLocale(): Response {
        return $this->redirectToRoute('home', ['_locale' => 'en']);
    }
}
