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

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\ConfigurationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController {

    #[Route('/contact-us', name: 'contact-us')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('contact-thank-you');
        }
        return $this->render('contact/form.html.twig', ['contact_form' => $form]);
    }

    #[Route('/contact-thank-you', name: 'contact-thank-you')]
    public function instructions(): Response {
        return $this->render('contact/thank-you.html.twig');
    }
}
