<?php

namespace App\Controller;

use App\Service\CalendarService;
use App\Service\EventService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Description of Calendar
 *
 * @author bgamrat
 */
class CalendarController extends AbstractController {

    #[Route('/calendar/{year}/{month}', name: 'calendar', requirements: ['year' => '\d{4}', 'month' => '\d\d?'])]
    public function indexAction(CalendarService $calendarService, EventService $eventService, Request $request, int $year = null, int $month = null) {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        if ($year === null || $month === null) {
            $year = date('Y');
            $month = date('n');
        }

        $calendarMonth = new DateTime($year . '-' . $month . '-1'); // first day of month to be displayed
        $lastMonth = strtotime('-1month', $calendarMonth->getTimestamp());
        $prevYear = date('Y', $lastMonth);
        $prevMonth = date('m', $lastMonth);
        $followingMonth = strtotime('+1month', $calendarMonth->getTimestamp());
        $nextYear = date('Y', $followingMonth);
        $nextMonth = date('m', $followingMonth);

        $dayNames = $calendarService->getDayNames();
        $calendar = $calendarService->getCalendar($calendarMonth);
        $lastDayOfMonth = $calendarService->getLastDayOfMonth($calendarMonth);
        $bikeRequestMap = $eventService->getBikeRequestMap($calendarMonth, $lastDayOfMonth);
        $eventMap = $eventService->getEventMap($calendarMonth, $lastDayOfMonth);
//dd($eventMap);
        return $this->render('calendar/index.html.twig', array(
                    'calendar_month' => $calendarMonth,
                    'month' => $month,
                    'prev_year' => $prevYear,
                    'prev_month' => $prevMonth,
                    'next_year' => $nextYear,
                    'next_month' => $nextMonth,
                    'day_names' => $dayNames,
                    'calendar' => $calendar,
                    'bike_requests' => $bikeRequestMap,
                    'events' => $eventMap
        ));
    }
}
