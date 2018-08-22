<?php

namespace ADesigns\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class for holding a calendar event's details.
 *
 * @author Mike Yudin <mikeyudin@gmail.com>
 * @ORM\Entity()
 */
class FullCalendarEvent implements EditableInterface, ColorableInterface
{

    use EditableTrait, ColorableTrait;

    /**
     * @var string URL Relative to current path.
     * @ORM\Column(nullable=true)
     */
    protected $url;

    /**
     * @var string css class for the event label
     * @ORM\Column(nullable=true)
     */
    protected $cssClass;

    /**
     * @var array Non-standard fields
     * @ORM\Column(type="json_array")
     */
    protected $otherFields = array();

    /**
     * FullCalendarEvent constructor.
     * @param string $title
     * @param \DateTime|null $startDatetime
     * @param \DateTime|null $endDatetime
     * @param bool $allDay
     */
    public function __construct($title = "", \DateTime $startDatetime = null, \DateTime $endDatetime = null, $allDay = false)
    {
        $this->title = $title;
        $this->startDatetime = $startDatetime;
        $this->endDatetime = $endDatetime;
        $this->setAllDay($allDay);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setCssClass($class)
    {
        $this->cssClass = $class;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addField($name, $value)
    {
        $this->otherFields[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function removeField($name)
    {
        if (!array_key_exists($name, $this->otherFields)) {
            return;
        }

        unset($this->otherFields[$name]);
    }

}
