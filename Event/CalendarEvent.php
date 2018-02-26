<?php

namespace ADesigns\CalendarBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

use ADesigns\CalendarBundle\Entity\FullCalendarEvent;

/**
 * Event used to store EventEntitys
 * 
 * @author Mike Yudin <mikeyudin@gmail.com>
 */
class CalendarEvent extends Event
{
    const CONFIGURE = 'calendar.load_events';

    private $startDatetime;
    
    private $endDatetime;
    
    private $request;

    private $events;

    /**
     * Constructor method requires a start and end time for event listeners to use.
     *
     * @param \DateTime $start Begin datetime to use
     * @param \DateTime $end End datetime to use
     * @param Request $request
     */
    public function __construct(\DateTime $start, \DateTime $end, Request $request = null)
    {
        $this->startDatetime = $start;
        $this->endDatetime = $end;
        $this->request = $request;
        $this->events = new ArrayCollection();
    }

    public function getEvents()
    {
        return $this->events;
    }
    
    /**
     * If the event isn't already in the list, add it
     * 
     * @param FullCalendarEvent $event
     * @return CalendarEvent $this
     */
    public function addEvent(FullCalendarEvent $event)
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }
        
        return $this;
    }

    /**
     * Set the events.
     * The collection will be overwritten.
     *
     * @param array $events
     */
    public function setEvents(array $events)
    {
        $this->events = $events;
    }
    
    /**
     * Get start datetime 
     * 
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Get end datetime 
     * 
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Get request
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
