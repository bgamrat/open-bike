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

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppointmentController extends AbstractController {

    #[Route('/make-appointment', name: 'make-appointment')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $appointment = $form->getData();
            $entityManager->persist($appointment);
            $entityManager->flush();
            return $this->redirectToRoute('appointment-instructions', ['id' => $appointment->getId()]);
        }

        return $this->render('appointment/new.html.twig', ['form' => $form]);
    }

    #[Route('/appointment-instructions/{id}', name: 'appointment-instructions')]
    public function instructions(AppointmentRepository $appointmentRepository, int $id): Response {
        $appointment = $appointmentRepository
                ->find($id);
        if ($appointment == null) {
            die();
        }
        return $this->render('appointment/instructions.html.twig', ['appointment' => $appointment]);
    }
}
