<?php

declare(strict_types=1);

namespace PhilippWitzmann\DateTime;

/**
 * Data Object for Dates
 *
 * @author Philipp Witzmann <philipp@philippwitzmann.de>
 */
class Date
{
    /** @var int */
    private $year;

    /** @var int */
    private $month;

    /** @var int */
    private $day;

    public function __construct(int $year, int $month, int $day)
    {
        $this->year  = $year;
        $this->month = $month;
        $this->day   = $day;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getDay(): int
    {
        return $this->day;
    }
}