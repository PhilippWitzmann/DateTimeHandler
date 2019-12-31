<?php

declare(strict_types=1);

namespace PhilippWitzmann\DateTime;

use DateTimeZone;

/**
 * Data Object for DateTime
 *
 * @author Philipp Witzmann <philipp@philippwitzmann.de>
 */
class DateTime
{
    /** @var Date */
    private $date;

    /** @var Time */
    private $time;

    /** @var DateTimeZone */
    private $timeZone;

    public function __construct(Date $date, Time $time, DateTimeZone $timeZone)
    {
        $this->date     = $date;
        $this->time     = $time;
        $this->timeZone = $timeZone;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getTime(): Time
    {
        return $this->time;
    }

    public function getTimeZone(): DateTimeZone
    {
        return $this->timeZone;
    }
}