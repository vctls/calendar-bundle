<?php

namespace ADesigns\CalendarBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

trait DisplayableTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $startDatetime;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $endDatetime;

    /**
     * @var string
     * @ORM\Column()
     */
    private $title;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $allDay = false;

    /**
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }
    
    /**
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @return bool
     */
    public function isAllDay()
    {
        return $this->allDay;
    }
    
}