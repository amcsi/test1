<?php
namespace Ucs;

class DateTools
{
    public function findNextMonday(\DateTime $date)
    {
        return $date->modify('next monday');
    }

    public function findLastThursday(\DateTime $date)
    {
        return $date->modify('last thursday');
    }

    /**
     * Returns the date of next monday if the given date's day
     * is on a Saturday or Sunday, otherwise returns the same date. 
     * 
     * @param \DateTime $date 
     * @access public
     * @return \DateTime
     */
    public function findNextMondayIfOnBadDay(\DateTime $date)
    {
        $dayNumber = $date->format('N');

        $badDay = $dayNumber == 6 || $dayNumber == 7; // saturday or sunday
        $goodDay = !$badDay; // for readability

        if ($goodDay) {
            // return the same inputted date
            return $date;
        }

        // Bad date. Find next monday.
        return $this->findNextMonday($date);
    }

    /**
     * Returns the date of last thursday if the given date's day
     * is on a Saturday or Sunday, otherwise returns the same date. 
     * 
     * @param \DateTime $date 
     * @access public
     * @return \DateTime
     */
    public function findLastThursdayIfOnBadDay(\DateTime $date)
    {
        $dayNumber = $date->format('N');

        // saturday or sunday
        $badDay = $dayNumber == 5 || $dayNumber == 6 || $dayNumber == 7;
        $goodDay = !$badDay; // for readability

        if ($goodDay) {
            // return the same inputted date
            return $date;
        }

        // Bad date. Find last thursday.
        return $this->findLastThursday($date);
    }
}
