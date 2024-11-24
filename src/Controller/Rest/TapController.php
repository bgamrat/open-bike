<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Rest;

use App\Entity\Shift;
use App\Repository\ShiftRepository;
use App\Repository\VolunteerRepository;
use App\Service\ConfigurationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\InvalidArgumentException;
use function dd;
use function Symfony\Component\Clock\now;

/**
 * Description of TapController
 *
 * @author bgamrat
 */
class TapController extends AbstractController {

    #[Route('/api/tap/{id}', name: 'tap', requirements: ['id' => '\d+'])]
    public function indexAction(ConfigurationService $configurationService,
            EntityManagerInterface $entityManager,
            VolunteerRepository $volunteerRepository,
            ShiftRepository $shiftRepository,
            int $id
    ): Response {
        $configuration = $configurationService->getYamlConfiguration('volunteers');
        $volunteer = $volunteerRepository->findOneByTagId($id);
        if ($volunteer === null) {
            throw new InvalidArgumentException("Invalid tag");
        }
        $shift = $shiftRepository->findOneByShiftStarted($volunteer);
        if ($shift === null) {
            $shift = new Shift();
            $shift->setVolunteer($volunteer);
            $shift->setStartDateTime(now());
        } else {
            $now = now();
            $earliestShiftStart = $now->modify('-'.$configuration['shift']['max_length']);
            //$latestShiftStart = $now->modify('-'.$configuration['shift']['min_length']);
            if ($earliestShiftStart < $shift->getStartDateTime()) {
                $shift->setStartDateTime($earliestShiftStart);
                $shift->setAdjusted(true);
            }
            $shift->setEndDateTime(now());
        }
        $entityManager->persist($shift);
        $entityManager->flush();
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
