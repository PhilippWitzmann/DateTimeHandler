<?php

declare(strict_types=1);

namespace PhilippWitzmann\DateTime;

/**
 * Data Object for Time
 *
 * @author Philipp Witzmann <philipp@philippwitzmann.de>
 */
class Time
{
    /** @var int */
    private $hours;

    /** @var int */
    private $minutes;

    /** @var int */
    private $seconds;

    public function __construct(int $hours, int $minutes, int $seconds)
    {
        $this->hours   = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    public function getHours(): int
    {
        return $this->hours;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }
}