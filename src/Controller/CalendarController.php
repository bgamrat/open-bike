<?php

namespace App\Controller;

use App\Entity\Event;
use App\Service\CalendarService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
    public function indexAction(EntityManagerInterface $entityManager, Request $request, int $year = null, int $month = null) {
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

        CalendarService::createInstance();
        $dayNames = CalendarService::getDayNames();
        $calendar = CalendarService::getCalendar($calendarMonth);
        $lastDayOfMonth = CalendarService::getLastDayOfMonth($calendarMonth);
        $events = $entityManager->getRepository(Event::class)->findByDateRange($calendarMonth->getTimestamp(), $lastDayOfMonth);

        $eventMap = [];
        foreach ($events as $e) {
            $startDay = $e->getStart()->format('j');
            $endDay = $e->getEnd()->format('j');
            for ($day = $startDay; $day <= $endDay; $day++) {
                $eventMap[$day][] = $e;
            }
        }

        return $this->render('calendar/index.html.twig', array(
                    'calendar_month' => $calendarMonth,
                    'prev_year' => $prevYear,
                    'prev_month' => $prevMonth,
                    'next_year' => $nextYear,
                    'next_month' => $nextMonth,
                    'day_names' => $dayNames,
                    'calendar' => $calendar,
                    'events' => $eventMap
        ));
    }
}
