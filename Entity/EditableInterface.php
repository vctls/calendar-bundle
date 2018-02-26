<?php
/**
 * User: Victor
 * Date: 2018-02-26
 * Time: 20:08
 */

namespace ADesigns\CalendarBundle\Entity;

/**
 * Interface EditableInterface
 *
 * Can be edited in FullCalendar.
 *
 * @package ADesigns\CalendarBundle\Entity
 */
interface EditableInterface extends DisplayableInterface
{

    /**
     * @param \DateTime $startDateTime
     */
    public function setStartDateTime(\DateTime $startDateTime);

    /**
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime(\DateTime $endDateTime);
}