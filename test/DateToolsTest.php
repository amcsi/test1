<?php

class DateToolsTest extends PHPUnit_Framework_TestCase
{
    private $dateTools;

    public function setUp()
    {
        $this->dateTools = new Ucs\DateTools;
    }

    public function tearDown()
    {
        $this->dateTools = null;
    }

    public function testFindNextMonday()
    {
        $date = new DateTime("2015-01-01"); // thursday.

        $newDate = $this->dateTools->findNextMonday($date);

        $expected = "2015-01-05";
        $actual = $newDate->format("Y-m-d");

        $this->assertEquals($expected, $actual);
    }

    public function testFindNextMonday2()
    {
        $date = new DateTime("2015-01-05"); // monday.

        $newDate = $this->dateTools->findNextMonday($date);

        $expected = "2015-01-12";
        $actual = $newDate->format("Y-m-d");

        $this->assertEquals($expected, $actual);
    }

    public function testFindLastThursday()
    {
        $date = new DateTime("2015-01-01"); // thursday.

        $newDate = $this->dateTools->findLastThursday($date);

        $expected = "2014-12-25";
        $actual = $newDate->format("Y-m-d");

        $this->assertEquals($expected, $actual);
    }

    public function testFindLastThursday2()
    {
        $date = new DateTime("2015-01-02"); // friday.

        $newDate = $this->dateTools->findLastThursday($date);

        $expected = "2015-01-01";
        $actual = $newDate->format("Y-m-d");

        $this->assertEquals($expected, $actual);
    }

    /**
     * testFindNextMondayIfOnBadDay  
     * 
     * @dataProvider findNextMondayIfOnBadDayProvider
     * @access public
     * @return void
     */
    public function testFindNextMondayIfOnBadDay(
        $inputDateString,
        $expectedDateString
    ) {
        $date = new DateTime($inputDateString);

        $result = $this->dateTools->findNextMondayIfOnBadDay($date);
        $actual = $result->format("Y-m-d");
            
        $this->assertEquals($expectedDateString, $actual);
    }

    public function findNextMondayIfOnBadDayProvider()
    {
        return [
            ['2015-01-05' /* monday */, '2015-01-05',],
            ['2015-01-06', '2015-01-06',],
            ['2015-01-07', '2015-01-07',],
            ['2015-01-08', '2015-01-08',],
            ['2015-01-09', '2015-01-09',],
            ['2015-01-10' /* saturday */, '2015-01-12',], // should yield next monday
            ['2015-01-11' /* sunday */, '2015-01-12',], // should yield next monday
        ];
    }

    /**
     * testFindLastThursdayIfOnBadDay  
     * 
     * @dataProvider findLastThursdayIfOnBadDayProvider
     * @access public
     * @return void
     */
    public function testFindLastThursdayIfOnBadDay(
        $inputDateString,
        $expectedDateString
    ) {
        $date = new DateTime($inputDateString);

        $result = $this->dateTools->findLastThursdayIfOnBadDay($date);
        $actual = $result->format("Y-m-d");
            
        $this->assertEquals($expectedDateString, $actual);
    }

    public function findLastThursdayIfOnBadDayProvider()
    {
        return [
            ['2015-01-05' /* monday */, '2015-01-05',],
            ['2015-01-06', '2015-01-06',],
            ['2015-01-07', '2015-01-07',],
            ['2015-01-08', '2015-01-08',],
            ['2015-01-09'/* friday */, '2015-01-08',], // should yield last thu
            ['2015-01-10' /* saturday */, '2015-01-08',], // should yield last thu
            ['2015-01-11' /* sunday */, '2015-01-08',], // should yield last thu
        ];
    }
}
