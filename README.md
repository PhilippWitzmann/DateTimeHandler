# DateTimeHandler

This library aims to provide basic functionality to work with (testable)
Date, Time and DateTime Objects. 

## Installation

````bash
composer require philippwitzmann/date-time-handler
````

## Usage

### Create an instance

#### With set time
```php
$year  = 2000;
$month = 12;
$day   = 30;

$hours    = 20;
$minutes  = 58;
$seconds  = 13;

$timeZone = new DateTimeZone('Europe/Berlin');

$dateTimeHandler = new DateTimeHandler(
    $year, $month, $day, $hours, $minutes, $seconds, $timeZone
);
```

#### With current time
```php
$dateTimeHandler = new DateTimeHandler();
```

### Diff two DateTimes
```php
$dateTimeHandler = new DateTimeHandler(
            $year, $month, $day, $hours, $minutes, $seconds, $timeZone
        );

$date                  = new Date($year + 1, $month, $day);
$time                  = new Time($hours, $minutes, $seconds);
$dateTimeToDiffAgainst = new DateTime(
    $date, $time, $timeZone
);

$dateInverval = $dateTimeHandler->diff($dateTimeToDiffAgainst);
```

### Set Test Time
```php
$dateTimeHandler = new DateTimeHandler();
$dateTimeHandler->setTestNow(); //freezes time

$dateTimeHandler->getTime(); // returns the Time, setTestNow() was called at.
```

## Running tests
```bash
php vendor/bin/phpunit tests/ --configuration=config/phpunit.xml
```