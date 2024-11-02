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

    private static $calendar = null;

    public static function createInstance() {
        self::$calendar = IntlCalendar::createInstance();
    }

    public static function getCalendar(DateTime $month) {

        self::$calendar->fromDateTime($month);
        self::$calendar->set(IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $firstDayOfWeek = self::$calendar->get(IntlCalendar::FIELD_DAY_OF_WEEK);
        $daysInMonth = self::$calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_MONTH);

        $weeks = [];
        $days = [];
        $dayOfMonth = 1;
        for ($d = self::$calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= self::$calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
            $days[] = $d >= $firstDayOfWeek ? $dayOfMonth++ : null;
        }
        $weeks[] = $days;
        while ($dayOfMonth < $daysInMonth) {
            $days = [];
            for ($d = self::$calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= self::$calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
                $days[] = $dayOfMonth <= $daysInMonth ? $dayOfMonth++ : null;
            }
            $weeks[] = $days;
        }
        return $weeks;
    }

    public static function getDayNames() {
        $dayNames = [];
        self::$calendar->set(IntlCalendar::FIELD_DAY_OF_WEEK, self::$calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK));
        for ($d = self::$calendar->getMinimum(IntlCalendar::FIELD_DAY_OF_WEEK); $d <= self::$calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_WEEK); $d++) {
            self::$calendar->set(IntlCalendar::FIELD_DAY_OF_WEEK, $d);
            $dayNames[] = date('D', self::$calendar->getTime() / 1000);
        }
        return $dayNames;
    }

    public static function getLastDayOfMonth(DateTime $month) {
        self::$calendar->fromDateTime($month);
        self::$calendar->set(IntlCalendar::FIELD_DAY_OF_MONTH, self::$calendar->getMaximum(IntlCalendar::FIELD_DAY_OF_MONTH) - 1);
        return self::$calendar->toDateTime();
    }
}
