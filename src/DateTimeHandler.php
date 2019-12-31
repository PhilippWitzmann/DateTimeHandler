<?php

declare(strict_types=1);

namespace PhilippWitzmann\DateTime;

use Carbon\Carbon;
use DateInterval;
use DateTimeZone;

/**
 * This class handles all things related to dates and times.
 *
 * @author Philipp Witzmann <philipp@philippwitzmann.de>
 */
class DateTimeHandler
{
    /** @var Carbon */
    private $testDateTimeApi;

    /**
     * Calculates the difference in time between this DateTime and a given DateTime.
     *
     * @param DateTime $dateTime
     * @param DateTime $datetimeToDiffAgainst
     *
     * @return DateInterval
     */
    public function diff(DateTime $dateTime, DateTime $datetimeToDiffAgainst): DateInterval
    {
        $datetimeApiToDiffAgainst = $this->createInstance($datetimeToDiffAgainst, false);
        $datetimeApiOriginal      = $this->createInstance($dateTime, true);
        $diff                     = $datetimeApiOriginal->diff($datetimeApiToDiffAgainst);

        return $diff;
    }

    /**
     * Adds a given amount of seconds to a newly created DateTime instance, based on the given DateTime.
     *
     * @param DateTime $dateTime
     * @param int      $seconds
     *
     * @return DateTime
     */
    public function addSeconds(DateTime $dateTime, int $seconds): DateTime
    {
        $dateTimeApi = $this->createInstance($dateTime);
        $dateTimeApi->addSeconds($seconds);

        $newDateTime = $this->createNewDateTime($dateTimeApi);

        return $newDateTime;
    }

    /**
     * Acts as a factory for DateTimes.
     *
     * @param DateTimeZone $timezone
     * @param int          $years
     * @param int          $months
     * @param int          $days
     * @param int          $hours
     * @param int          $minutes
     * @param int          $seconds
     *
     * @return DateTime
     */
    public function createDateTime(DateTimeZone $timezone,
                                   int $years = 0,
                                   int $months = 0,
                                   int $days = 0,
                                   int $hours = 0,
                                   int $minutes = 0,
                                   int $seconds = 0): DateTime
    {
        if ($this->testDateTimeApi instanceof Carbon)
        {
            $years   = $this->testDateTimeApi->year;
            $months  = $this->testDateTimeApi->month;
            $days    = $this->testDateTimeApi->day;
            $hours   = $this->testDateTimeApi->hour;
            $minutes = $this->testDateTimeApi->minute;
            $seconds = $this->testDateTimeApi->second;
        }

        if ($years === 0 && $months === 0 && $days === 0
            && $hours === 0 && $minutes === 0 && $seconds === 0
        )
        {
            $dateTimeApi = new Carbon();
            $date        = new Date($dateTimeApi->year, $dateTimeApi->month, $dateTimeApi->day);
            $time        = new Time($dateTimeApi->hour, $dateTimeApi->minute, $dateTimeApi->second);
            $newDateTime = new DateTime($date, $time, $dateTimeApi->getTimezone());
        }
        else
        {
            $date        = new Date($years, $months, $days);
            $time        = new Time($hours, $minutes, $seconds);
            $newDateTime = new DateTime($date, $time, $timezone);

            $this->getValidatedDateTimeApi($timezone, $date, $time);
        }

        return $newDateTime;
    }

    /**
     * Creates an instance this Handler works with.
     *
     * @param DateTime $dateTime
     * @param bool     $useTestApi
     *
     * @return Carbon
     */
    private function createInstance(DateTime $dateTime, bool $useTestApi = true): Carbon
    {
        $datetimeApi = $this->testDateTimeApi;

        if (!$useTestApi || $this->testDateTimeApi !== null)
        {
            $date     = $dateTime->getDate();
            $time     = $dateTime->getTime();
            $timeZone = $dateTime->getTimeZone();

            $datetimeApi = $this->getValidatedDateTimeApi($timeZone, $date, $time);
        }

        return $datetimeApi;
    }

    /**
     * Sets an test Instance of now. In this Instance, time does not advance automatically.
     *
     * @param DateTime $dateTime
     *
     * @return void
     */
    public function setTest(DateTime $dateTime): void
    {
        $dateTimeApi = $this->createInstance($dateTime);

        $dateTimeApi->setTestNow($dateTimeApi);
        $this->testDateTimeApi = $dateTimeApi;
    }


    /**
     * Creates a new DateTime based on a given Carbon Instance or the test Instance if one is set.
     *
     * @param Carbon $datetimeApi
     *
     * @return DateTime
     */
    private function createNewDateTime(Carbon $datetimeApi): DateTime
    {
        if ($this->testDateTimeApi !== null)
        {
            $datetimeApi = $this->testDateTimeApi;
        }

        $datetime = $this->createDateTime($datetimeApi->getTimezone(),
                                          $datetimeApi->year,
                                          $datetimeApi->month,
                                          $datetimeApi->day,
                                          $datetimeApi->hour,
                                          $datetimeApi->minute,
                                          $datetimeApi->second);

        return $datetime;
    }

    private function getValidatedDateTimeApi(DateTimeZone $timezone, Date $date, Time $time): Carbon
    {
        $date = implode('-', [$date->getYear(), $date->getMonth(), $date->getDay()]);
        $time = implode(':', [$time->getHours(), $time->getMinutes(), $time->getSeconds()]);

        $datetimeApi = new Carbon($date . ' ' . $time, $timezone);

        return $datetimeApi;
    }
}