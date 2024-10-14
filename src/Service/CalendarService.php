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

    public static function getDayNames() {
        $dayNames = [];
        $calendar = IntlCalendar::createInstance();
        $calendar->set(IntlCalendar::FIELD_DAY_OF_WEEK, $calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK));
        for ($d = $calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= $calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
            $calendar->set(IntlCalendar::FIELD_DAY_OF_WEEK, $d);
            $dayNames[] = date('D', $calendar->getTime() / 1000);
        }
        return $dayNames;
    }

    public static function getCalendar(DateTime $month) {
        $calendar = IntlCalendar::createInstance();
        $calendar->fromDateTime($month);
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
        while ($dayOfMonth < $daysInMonth) {
            $days = [];
            for ($d = $calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= $calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
                $days[] = $dayOfMonth <= $daysInMonth ? $dayOfMonth++ : null;
            }
            $weeks[] = $days;
        }
        return $weeks;
    }
}
