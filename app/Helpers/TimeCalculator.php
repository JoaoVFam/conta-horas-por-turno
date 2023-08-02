<?php

namespace App\Helpers;

use DateTime;
use DateInterval;

class TimeCalculator
{
    public static function calculateDayAndNightTime($checkIn, $checkOut)
    {
        if ($checkIn < $checkOut) {
            return self::auxCalculateDayAndNightTime($checkIn, $checkOut);
        }

        $startToMidnight = self::auxCalculateDayAndNightTime($checkIn, "23:59");
        $startToMidnight['night_time'] = self::addOneMinute($startToMidnight['night_time']);
        $midnightToEnd = self::auxCalculateDayAndNightTime("00:00", $checkOut);

        $dayTime = self::addTimes($startToMidnight['day_time'], $midnightToEnd['day_time']);
        $nightTime = self::addTimes($startToMidnight['night_time'], $midnightToEnd['night_time']);

        return [
            'day_time' => $dayTime,
            'night_time' => $nightTime,
        ];
    }

    private static function auxCalculateDayAndNightTime($checkIn, $checkOut)
    {
        $timeFormat = "H:i";
        $checkInObj = DateTime::createFromFormat($timeFormat, $checkIn);
        $checkOutObj = DateTime::createFromFormat($timeFormat, $checkOut);

        $dayStart = DateTime::createFromFormat($timeFormat, "05:00");
        $dayEnd = DateTime::createFromFormat($timeFormat, "22:00");

        if ($checkOutObj <= $dayStart || $checkInObj >= $dayEnd) {
            $dayTime = "00:00";
            $nightTime = self::formatMinutesToTime(self::timeToMinutes($checkOutObj) - self::timeToMinutes($checkInObj));
            return [
                'day_time' => $dayTime,
                'night_time' => $nightTime,
            ];
        }

        $minEnd = min($checkOutObj, $dayEnd);
        $maxStart = max($checkInObj, $dayStart);

        $dayTimeMinutes = self::timeToMinutes($minEnd) - self::timeToMinutes($maxStart);
        $nightTimeMinutes = self::timeToMinutes($checkOutObj) - self::timeToMinutes($checkInObj) - $dayTimeMinutes;

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