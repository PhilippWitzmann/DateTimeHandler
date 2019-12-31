<?php

declare(strict_types=1);

namespace PhilippWitzmann\DateTime;

use PhilippWitzmann\Testing\TestCase;
use DateInterval;
use DateTimeZone;
use Throwable;
use TypeError;

/**
 * Testcase
 *
 * @author Philipp Witzmann <philipp@philippwitzmann.de>
 */
class DateTimeHandlerTest extends TestCase
{
    public function testCreateDateTime()
    {
        $subject      = new DateTimeHandler();
        $dateTimeZone = new DateTimeZone('Europe/Berlin');
        $result       = $subject->createDateTime($dateTimeZone);

        $this->assertInstanceOf(DateTime::class, $result);
    }

    public function testAddSeconds()
    {
        $subject          = new DateTimeHandler();
        $dateTimeZone     = new DateTimeZone('Europe/Berlin');
        $dateTime         = $subject->createDateTime($dateTimeZone, 2000, 12, 31, 23, 59, 0);
        $expectedDateTime = $subject->createDateTime($dateTimeZone, 2000, 12, 31, 23, 59, 10);
        $subject->setTest($dateTime);

        $result = $subject->addSeconds($dateTime, 10);

        $this->assertEquals($expectedDateTime, $result);
    }

    public function testDiff()
    {
        $year  = 2000;
        $month = 12;
        $day   = 30;

        $hours    = 20;
        $minutes  = 58;
        $seconds  = 13;
        $timeZone = new DateTimeZone('Europe/Berlin');

        $subject = new DateTimeHandler();

        $dateTime              = $subject->createDateTime($timeZone, $year, $month, $day, $hours, $minutes, $seconds);
        $dateTimeToDiffAgainst = $subject->createDateTime(
            $timeZone, $year + 1, $month, $day, $hours, $minutes, $seconds
        );

        $expectedResult = new DateInterval('P1Y');
        $result         = $subject->diff($dateTime, $dateTimeToDiffAgainst);

        $this->assertSame($expectedResult->y, $result->y);
        $this->assertSame($expectedResult->m, $result->m);
        $this->assertSame($expectedResult->d, $result->d);
        $this->assertSame($expectedResult->h, $result->h);
        $this->assertSame($expectedResult->i, $result->i);
        $this->assertSame($expectedResult->s, $result->s);
        $this->assertSame($expectedResult->f, $result->f);
    }

    /**
     * Provides invalid Parameters for the setAttribute Method.
     *
     * @return mixed[]
     */
    public function invalidParametersForCreateDateTimeProvider(): array
    {
        $correctYear     = 2010;
        $correctMonth    = 12;
        $correctDay      = 30;
        $correctHour     = 23;
        $correctMinute   = 59;
        $correctSecond   = 59;
        $correctTimeZone = new DateTimeZone('Europe/Berlin');

        return [
            'wrongYear'     => [
                $correctTimeZone,
                (string) $correctYear,
                $correctMonth,
                $correctDay,
                $correctHour,
                $correctMinute,
                $correctSecond,
            ],
            'wrongMonth'    => [
                $correctTimeZone,
                $correctYear,
                (string) $correctMonth,
                $correctDay,
                $correctHour,
                $correctMinute,
                $correctSecond,
            ],
            'wrongDay'      => [
                $correctTimeZone,
                $correctYear,
                $correctMonth,
                (string) $correctDay,
                $correctHour,
                $correctMinute,
                $correctSecond,
            ],
            'wrongHour'     => [
                $correctTimeZone,
                $correctYear,
                $correctMonth,
                $correctDay,
                (string) $correctHour,
                $correctMinute,
                $correctSecond,
            ],
            'wrongMinute'   => [
                $correctTimeZone,
                $correctYear,
                $correctMonth,
                $correctDay,
                $correctHour,
                (string) $correctMinute,
                $correctSecond,
            ],
            'wrongSecond'   => [
                $correctTimeZone,
                $correctYear,
                $correctMonth,
                $correctDay,
                $correctHour,
                $correctMinute,
                (string) $correctSecond,
            ],
            'wrongTimezone' => [
                'Europe/Berlin',
                $correctYear,
                $correctMonth,
                $correctDay,
                $correctHour,
                $correctMinute,
                $correctSecond,
            ],
        ];
    }

    /**
     * @param DateTimeZone|string $timezone
     * @param int|string          $year
     * @param int|string          $month
     * @param int|string          $day
     * @param int|string          $hour
     * @param int|string          $minute
     * @param int|string          $second
     *
     * @return void
     * @dataProvider invalidParametersForCreateDateTimeProvider
     */
    public function testCreateDateTimeTypehints($timezone, $year, $month, $day, $hour, $minute, $second)
    {
        $this->expectException(TypeError::class);
        $subject = new DateTimeHandler();
        $subject->createDateTime($timezone, $year, $month, $day, $hour, $minute, $second);
    }

    /**
     * Provides invalid Parameters for the setAttribute Method.
     *
     * @return mixed[]
     */
    public function edgeCasesParametersForConstructorEdgeCasesProvider(): array
    {
        $year     = 9999;
        $month    = 12;
        $day      = 31;
        $hour     = 23;
        $minute   = 59;
        $second   = 59;
        $timeZone = new DateTimeZone('Europe/Berlin');

        return [
            'wrongMonth'  => [
                $timeZone,
                $year,
                13,
                $day,
                $hour,
                $minute,
                $second,
            ],
            'wrongDay'    => [
                $timeZone,
                $year,
                $month,
                32,
                $hour,
                $minute,
                $second,
            ],
            'wrongHour'   => [
                $timeZone,
                $year,
                $month,
                $day,
                61,
                $minute,
                $second,
            ],
            'wrongMinute' => [
                $timeZone,
                $year,
                $month,
                $day,
                $hour,
                61,
                $second,
            ],
            'wrongSecond' => [
                $timeZone,
                $year,
                $month,
                $day,
                $hour,
                $minute,
                61,
            ],
        ];
    }

    /**
     * @dataProvider edgeCasesParametersForConstructorEdgeCasesProvider
     *
     * @param DateTimeZone $timezone
     * @param int|string   $year
     * @param int|string   $month
     * @param int|string   $day
     * @param int|string   $hour
     * @param int|string   $minute
     * @param int|string   $second
     *
     * @return void
     */
    public function testConstructorValidates(DateTimeZone $timezone, $year, $month, $day, $hour, $minute, $second)
    {
        $this->expectException(Throwable::class);
        $subject = new DateTimeHandler();
        $subject->createDateTime($timezone, $year, $month, $day, $hour, $minute, $second);
    }

    /**
     * @inheritDoc
     */
    protected function setUpTest(): void
    {
        // TODO: Implement setUpTest() method.
    }

    /**
     * @inheritDoc
     */
    protected function tearDownTest(): void
    {
        // TODO: Implement tearDownTest() method.
    }
}