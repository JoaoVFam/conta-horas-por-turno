<?php

namespace App\Helpers;

use DateTime;
use DateInterval;

class TimeCalculator
{
    public static function calculateDayAndNightTime($timeStart, $timeEnd)
    {
        if ($timeStart < $timeEnd) {
            return self::auxCalculateDayAndNightTime($timeStart, $timeEnd);
        }

        $startToMidnight = self::auxCalculateDayAndNightTime($timeStart, "23:59");
        $startToMidnight['night_time'] = self::addOneMinute($startToMidnight['night_time']);
        $midnightToEnd = self::auxCalculateDayAndNightTime("00:00", $timeEnd);

        $dayTime = self::addTimes($startToMidnight['day_time'], $midnightToEnd['day_time']);
        $nightTime = self::addTimes($startToMidnight['night_time'], $midnightToEnd['night_time']);

        return [
            'day_time' => $dayTime,
            'night_time' => $nightTime,
        ];
    }

    private static function auxCalculateDayAndNightTime($timeStart, $timeEnd)
    {
        $timeFormat = "H:i";
        $timeStartObj = DateTime::createFromFormat($timeFormat, $timeStart);
        $timeEndObj = DateTime::createFromFormat($timeFormat, $timeEnd);

        $dayStart = DateTime::createFromFormat($timeFormat, "05:00");
        $dayEnd = DateTime::createFromFormat($timeFormat, "22:00");

        if ($timeEndObj <= $dayStart || $timeStartObj >= $dayEnd) {
            $dayTime = "00:00";
            $nightTime = self::formatMinutesToTime(self::timeToMinutes($timeEndObj) - self::timeToMinutes($timeStartObj));
            return [
                'day_time' => $dayTime,
                'night_time' => $nightTime,
            ];
        }

        $minEnd = min($timeEndObj, $dayEnd);
        $maxStart = max($timeStartObj, $dayStart);

        $dayTimeMinutes = self::timeToMinutes($minEnd) - self::timeToMinutes($maxStart);
        $nightTimeMinutes = self::timeToMinutes($timeEndObj) - self::timeToMinutes($timeStartObj) - $dayTimeMinutes;

        $dayTime = self::formatMinutesToTime($dayTimeMinutes);
        $nightTime = self::formatMinutesToTime($nightTimeMinutes);

        return [
            'day_time' => $dayTime,
            'night_time' => $nightTime,
        ];
    }

    private static function timeToMinutes($time)
    {
        return $time->format("H") * 60 + $time->format("i");
    }

    private static function formatMinutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes %= 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    private static function addTimes($time1, $time2)
    {
        $minutes1 = self::timeToMinutes(DateTime::createFromFormat("H:i", $time1));
        $minutes2 = self::timeToMinutes(DateTime::createFromFormat("H:i", $time2));
        $totalMinutes = $minutes1 + $minutes2;
        return self::formatMinutesToTime($totalMinutes);
    }

    private static function addOneMinute($time)
    {
        $timeObj = DateTime::createFromFormat("H:i", $time);
        $timeObj->add(new DateInterval('PT1M'));
        return $timeObj->format("H:i");
    }
}