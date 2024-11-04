<?php

namespace App\Service;

use App\Repository\BikeRequestRepository;
use App\Repository\EventRepository;
use DateTime;

/**
 * Description of CalendarService
 *
 * @author bgamrat
 */
class EventService {

    public function __construct(private BikeRequestRepository $bikeRequestRepository, private EventRepository $eventRepository) {

    }

    public function getEventMap(DateTime $month, DateTime $lastDayOfMonth) {

        $events = $this->eventRepository->findByDateRange($month->getTimestamp(), $lastDayOfMonth);

        $eventMap = [];
        foreach ($events as $e) {
            $startDay = $e->getStart()->format('j');
            $endDay = $e->getEnd()->format('j');
            for ($day = $startDay; $day <= $endDay; $day++) {
                $eventMap[$day][] = $e;
            }
        }
        return $eventMap;
    }


    public function getBikeRequestMap(DateTime $month, DateTime $lastDayOfMonth) {

        $bikeRequests = $this->bikeRequestRepository->findByDateRange($month->getTimestamp(), $lastDayOfMonth);

        $bikeRequestMap = [];
        foreach ($bikeRequests as $br) {
            $date = $br->getDate()->format('j');
            $bikeRequestMap[$date][] = $br;
        }

        return $bikeRequestMap;
    }
}
