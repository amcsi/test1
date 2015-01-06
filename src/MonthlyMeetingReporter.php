<?php
namespace Ucs;

class MonthlyMeetingReporter
{
    private $tools;
    private $date;

    /**
     * Construct the class with a date to work with (for mockability)
     * 
     * @param \DateTime $date   The date to use. Defaults to now.
     * @access public
     * @return void
     */
    public function __construct(DateTools $tools, \DateTime $date = null)
    {
        $this->tools = $tools;
        if (!$date) {
            $date = new \DateTime("now"); // defaults to now
        }
        $this->date = $date;
    }

    /**
     * Calculates the important meeting days of the next 6 months 
     * 
     * @access public
     * @return \DateTime[][]    An array of arrays. The outer array contains
     *                          the information for a month, and the inner array
     *                          has the mid month meeting and end of month testing
     *                          dates as \DateTime.
     */
    public function report()
    {
        $date = $this->date;

        $ret = [];

        $date->modify('last day of last month'); // to reference "next month"

        for ($i = 0; $i < 6; $i++) {
            $monthData = [];
            $date = $date->modify("+1 week"); // should jump into next month
            $date->setDate(
                $date->format('Y'), $date->format('n'), 14
            );
            $date = $this->tools->findNextMondayIfOnBadDay($date);

            $monthData[] = clone $date; // mid month meeting

            $date = $date->modify("last day of this month");
            $date = $this->tools->findLastThursdayIfOnBadDay($date);

            $monthData[] = clone $date; // last day of month meeting

            $ret[] = $monthData;
        }

        return $ret;
    }
}

