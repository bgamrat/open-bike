<?php

namespace App\Service;

use App\Repository\BikeRequestRepository;
use App\Repository\EventRepository;
use App\Repository\RecurrenceRepository;
use DateTime;

/**
 * Description of CalendarService
 *
 * @author bgamrat
 */
class EventService {

    public function __construct(private EventRepository $eventRepository,
            private RecurrenceRepository $recurrenceRepository,
            private BikeRequestRepository $bikeRequestRepository) {

    }

    public function getEventMap(\DateTime $month, \DateTime $lastDayOfMonth) {

        $events = $this->eventRepository->findByDateRange($month, $lastDayOfMonth);
        $eventMap = [];
        foreach ($events as $e) {
            $startDay = $e->getStart()->format('j');
            $endDay = $e->getEnd()->format('j');
            for ($day = $startDay; $day <= $endDay; $day++) {
                $eventMap[$day][] = $e;
            }
        }

        $recurrences = $this->recurrenceRepository->findByDateRange($month, $lastDayOfMonth);
        foreach ($recurrences as $r) {
            $day = $r->getDateTime()->format('j');
            $eventMap[$day][] = $r->getEvent();
        }
        return $eventMap;
    }

    public function getBikeRequestMap(\DateTime $month, \DateTime $lastDayOfMonth) {

        $bikeRequests = $this->bikeRequestRepository->findByDateRange($month, $lastDayOfMonth);

        $bikeRequestMap = [];
        foreach ($bikeRequests as $br) {
            $date = $br->getDate()->format('j');
            $bikeRequestMap[$date][] = $br;
        }

        return $bikeRequestMap;
    }

    public function getEvents(\DateTime $day) {
        $events = $this->eventRepository->findByDate($day);

        $recurrences = $this->recurrenceRepository->findByDate($day);
        foreach ($recurrences as $r) {
            $events[] = $r->getEvent();
        }
        return $events;
    }

    public function getBikeRequests(\DateTime $day) {
        $bikeRequests = $this->bikeRequestRepository->findByDate($day);

        return $bikeRequests;
    }
}
