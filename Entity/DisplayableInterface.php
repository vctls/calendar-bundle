<?php
/**
 * User: Victor
 * Date: 2018-02-26
 * Time: 20:49
 */

namespace ADesigns\CalendarBundle\Entity;

/**
 * Interface DisplayableInterface
 *
 * Can be displayed in FullCalendar.
 *
 * @package ADesigns\CalendarBundle\Entity
 */
interface DisplayableInterface
{
    /**
     * @return \DateTime
     */
    public function getStartDatetime();

    /**
     * @return \DateTime
     */
    public function getEndDatetime();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return boolean
     */
    public function isAllDay();

}