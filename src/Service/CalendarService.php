<?php

namespace App\Service;

use DateTime;
use IntlCalendar;

/**
 * Description of CalendarService
 *
 * @author bgamrat
 */
class CalendarService {

    private $calendar = null;

    public function __construct() {

        $this->calendar = IntlCalendar::createInstance();
    }

    public function getCalendar(\DateTime $month) {

        $calendar = $this->calendar->fromDateTime($month);
        $calendar->set(IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $firstDayOfWeek = $calendar->get(IntlCalendar::FIELD_DAY_OF_WEEK);
        $daysInMonth = $calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_MONTH);

        $weeks = [];
        $days = [];
        $dayOfMonth = 1;
        for ($d = $calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= $calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
            $days[] = $d >= $firstDayOfWeek ? $dayOfMonth++ : null;
        }
        $weeks[] = $days;
        while ($dayOfMonth <= $daysInMonth) {
            $days = [];
            for ($d = $calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= $calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
                $days[] = $dayOfMonth <= $daysInMonth ? $dayOfMonth++ : null;
            }
            $weeks[] = $days;
        }
        return $weeks;
    }

    public function getDayNames() {
        $dayNames = [];
        $this->calendar->set(IntlCalendar::FIELD_DAY_OF_WEEK, $this->calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK));
        for ($d = $this->calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= $this->calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
            $this->calendar->set(IntlCalendar::FIELD_DAY_OF_WEEK, $d);
            $dayNames[] = date('D', $this->calendar->getTime() / 1000);
        }
        return $dayNames;
    }

    public function getLastDayOfMonth(\DateTime $month) {
        $calendar = $this->calendar->fromDateTime($month); 
        $calendar->set(IntlCalendar::FIELD_DAY_OF_MONTH, $this->calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_MONTH));
        return $calendar->toDateTime();
    }
}
