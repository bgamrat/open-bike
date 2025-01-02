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
use App\Repository\DocumentRepository;
use App\Service\ConfigurationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function dd;

class BikeRequestController extends AbstractController {

    public function __construct(private string $documentDir){}

    #[Route('/bike-request', name: 'bike-request')]
    public function index(EntityManagerInterface $entityManager, Request $request, DocumentRepository $documentRepository,
            ): Response {
        $requestForm = $documentRepository->findByNameLike('%Request%');
        $requestFormFile = null;
        if ($requestForm !== null) {
            $requestFormFile = $this->documentDir.'/'.$requestForm->getFile();
        }
        $bikeRequest = new BikeRequest();
        $form = $this->createForm(BikeRequestType::class, $bikeRequest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bikeRequest = $form->getData();
            $entityManager->persist($bikeRequest);
            $entityManager->flush();
            return $this->redirectToRoute('bike-request-instructions', ['id' => $bikeRequest->getId()]);
        }
        return $this->render('bike_request/new.html.twig', ['form' => $form, 'request_form_file' => $requestFormFile]);
    }

    #[Route('/bike-request-instructions/{id}', name: 'bike-request-instructions', requirements: ['id' => '\d+'])]
    public function instructions(ConfigurationService $configurationService, BikeRequestRepository $bikeRequestRepository, int $id): Response {
        $bikeRequest = $bikeRequestRepository
                ->find($id);
        if ($bikeRequest === null) {
            die();
        }
        $distribution = $configurationService->getYamlConfiguration('distribution');
        return $this->render('bike_request/instructions.html.twig',
                        ['bike_request' => $bikeRequest,
                            'distribution' => $distribution]);
    }
}
