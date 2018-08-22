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
     * Return the ID of the event.
     * @return mixed
     */
    public function getId();

    /**
     * @param \DateTime $startDatetime
     */
    public function setStartDatetime(\DateTime $startDatetime);

    /**
     * @param \DateTime $endDatetime
     */
    public function setEndDatetime(\DateTime $endDatetime);
}