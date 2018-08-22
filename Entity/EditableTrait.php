<?php

namespace ADesigns\CalendarBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

trait EditableTrait
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
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
     * @ORM\Column(nullable=true)
     */
    private $title;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $allDay;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return EditableTrait
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
    
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

    /**
     * @param \DateTime $startDatetime
     * @return $this
     */
    public function setStartDatetime(\DateTime $startDatetime)
    {
        $this->startDatetime = $startDatetime;
        return $this;
    }

    /**
     * @param \DateTime $endDatetime
     * @return $this
     */
    public function setEndDatetime(\DateTime $endDatetime)
    {
        $this->endDatetime = $endDatetime;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param bool $allDay
     * @return $this
     */
    public function setAllDay(bool $allDay)
    {
        $this->allDay = $allDay;
        return $this;
    }
    
    
}