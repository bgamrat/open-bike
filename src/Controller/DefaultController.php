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

use App\Config\Bike\Status;
use App\Entity\BikeRequest;
use App\Form\BikeRequestType;
use App\Repository\BikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController {

    #[Route('/', name: 'home')]
    public function index(BikeRepository $bikeRepository): Response {
        $bikeRequestForm = null;
        if ($bikeRepository->countByStatus(Status::ReadyForClient) > 0) {
            $bikeRequest = new BikeRequest();
            $bikeRequestForm = $this->createForm(BikeRequestType::class, $bikeRequest);
        }
        return $this->render('index.html.twig', ['bike_request_form' => $bikeRequestForm]);
    }
}
