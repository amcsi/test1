<?php

class MonthlyMeetingReporter extends PHPUnit_Framework_TestCase
{
    private $instance;

    public function setUp()
    {
        $dateTime = new DateTime('2015-07-01');

        $this->instance = new Ucs\MonthlyMeetingReporter(
            new Ucs\DateTools,
            $dateTime
        );
    }

    public function tearDown()
    {
        $this->instance = null;
    }

    public function testReport()
    {
        $result = $this->instance->report();

        $expected = [
            [
                '2015-07-14', // ok
                '2015-07-30', // friday, so last thursday
            ],
            [
                '2015-08-14', // ok
                '2015-08-31', // ok
            ],
            [
                '2015-09-14', // ok
                '2015-09-30', // ok
            ],
            [
                '2015-10-14', // ok
                '2015-10-29', // saturday, so last thursday
            ],
            [
                '2015-11-16', // saturday, so next monday
                '2015-11-30', // ok 
            ],
            [
                '2015-12-14', // ok
                '2015-12-31', // ok
            ],
        ];

        // change DateTime objects to strings for easier comparison
        array_walk_recursive($result, function (&$item) {
            $item = $item->format("Y-m-d");
        });
        /*
        $actual = [];
        foreach ($result as $dates) {
            $stringDates = [];
            foreach ($dates as $date) {
                $stringDates[] = $date->format("Y-m-d");
            }
            $actual[] = $stringDates;
        }
         */

        $this->assertEquals($expected, $result);
    }
}

