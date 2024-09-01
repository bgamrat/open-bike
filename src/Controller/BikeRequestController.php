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
use App\Repository\BikeRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BikeRequestController extends AbstractController {

    #[Route('/bike-request', name: 'bike-request')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response {
        $bikeRequest = new BikeRequest();
        $form = $this->createForm(BikeRequestType::class, $bikeRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bikeRequest = $form->getData();
            $entityManager->persist($bikeRequest);
            $entityManager->flush();
            return $this->redirectToRoute('bike-request-instructions', ['id' => $bikeRequest->getId()]);
        }

        return $this->render('bike_request/new.html.twig', ['bike_request_form' => $form]);
    }

    #[Route('/bike-request-instructions/{id}', name: 'bike-request-instructions', requirements: ['id' => '\d+'])]
    public function instructions(BikeRequestRepository $bikeRequestRepository, int $id): Response {
        $bikeRequest = $bikeRequestRepository
                ->find($id);
        if ($bikeRequest == null) {
            die();
        }
        return $this->render('bike_request/instructions.html.twig', ['bike_request' => $bikeRequest]);
    }
}
