<?php

namespace App\Controller;

use App\Service\CalendarService;
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
    public function indexAction(Request $request, int $year = null, int $month = null) {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        if ($year !== null && $month !== null) {
            $calendarMonth = new DateTime($year.'-'.$month.'-1');
        } else {
            $calendarMonth = new DateTime();
        }
        $lastMonth = strtotime('-1month',$calendarMonth->getTimestamp());
        $prevYear = date('Y', $lastMonth);
        $prevMonth = date('m', $lastMonth);
        $followingMonth = strtotime('+1month',$calendarMonth->getTimestamp());
        $nextYear = date('Y', $followingMonth);
        $nextMonth = date('m', $followingMonth);

        $dayNames = CalendarService::getDayNames();
        
        $calendar = CalendarService::getCalendar($calendarMonth);


        /*
          $em = $this->getDoctrine()->getManager();
          $queryBuilder = $em->createQueryBuilder()->select( ['e.id'] )
          ->from( 'App\Entity\Schedule\Event', 'e' );
          $queryBuilder->where( $queryBuilder->expr()->lt( ':now', 'e.end' ) );
          $queryBuilder->setParameters( ['now' => date( 'Y/m/d' )] );
          $events = $queryBuilder->getQuery()->getResult();
          $ids = array_column($events,'id');
          $events = $em->getRepository( 'App\Entity\Schedule\Event' )->findBy( ['id' => $ids] ); */

        return $this->render('calendar/index.html.twig', array(
                    'calendar_month' => $calendarMonth,
                    'prev_year' => $prevYear,
                    'prev_month' => $prevMonth,
                    'next_year' => $nextYear,
                    'next_month' => $nextMonth,
                    'day_names' => $dayNames,
                    'calendar' => $calendar,
                    'events' => []
                ));
    }
}