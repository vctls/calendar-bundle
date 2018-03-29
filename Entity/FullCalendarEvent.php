<?php
namespace ADesigns\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class for holding a calendar event's details.
 * 
 * @author Mike Yudin <mikeyudin@gmail.com>
 * @ORM\Entity()
 */
class FullCalendarEvent implements EditableInterface
{
    /**
     * @var mixed Unique identifier of this event (optional).
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string Title/label of the calendar event.
     * @ORM\Column(nullable=true)
     */
    protected $title;
    
    /**
     * @var string URL Relative to current path.
     * @ORM\Column(nullable=true)
     */
    protected $url;
    
    /**
     * @var string HTML color code for the bg color of the event label.
     * @ORM\Column(nullable=true)
     */
    protected $bgColor;
    
    /**
     * @var string HTML color code for the foregorund color of the event label.
     * @ORM\Column(nullable=true)
     */
    protected $fgColor;
    
    /**
     * @var string css class for the event label
     * @ORM\Column(nullable=true)
     */
    protected $cssClass;
    
    /**
     * @var \DateTime DateTime object of the event start date/time.
     * @ORM\Column(type="datetime")
     */
    protected $startDatetime;
    
    /**
     * @var \DateTime DateTime object of the event end date/time.
     * @ORM\Column(type="datetime")
     */
    protected $endDatetime;
    
    /**
     * @var boolean Is this an all day event?
     * @ORM\Column(type="boolean")
     */
    protected $allDay = false;

    /**
     * @var array Non-standard fields
     * @ORM\Column(type="json_array")
     */
    protected $otherFields = array();
    
    public function __construct($title = "", \DateTime $startDatetime = null, \DateTime $endDatetime = null, $allDay = false)
    {
        $this->title = $title;
        $this->startDatetime = $startDatetime;
        $this->endDatetime = $endDatetime;
        $this->setAllDay($allDay);
    }

    /**
     * Convert calendar event details to an array
     * 
     * @return array $event 
     */
    public function toArray()
    {
        $event = array();
        
        if ($this->id !== null) {
            $event['id'] = $this->id;
        }
        
        $event['title'] = $this->title;
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:sP");
        
        if ($this->url !== null) {
            $event['url'] = $this->url;
        }
        
        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }
        
        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }
        
        if ($this->cssClass !== null) {
            $event['className'] = $this->cssClass;
        }

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:sP");
        }
        
        $event['allDay'] = $this->allDay;

        foreach ($this->otherFields as $field => $value) {
            $event[$field] = $value;
        }
        
        return $event;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTitle($title) 
    {
        $this->title = $title;
        return $this;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setBgColor($color)
    {
        $this->bgColor = $color;
        return $this;
    }
    
    public function getBgColor()
    {
        return $this->bgColor;
    }
    
    public function setFgColor($color)
    {
        $this->fgColor = $color;
        return $this;
    }
    
    public function getFgColor()
    {
        return $this->fgColor;
    }
    
    public function setCssClass($class)
    {
        $this->cssClass = $class;
        return $this;
    }
    
    public function getCssClass()
    {
        return $this->cssClass;
    }
    
    public function setStartDatetime(\DateTime $start)
    {
        $this->startDatetime = $start;
        return $this;
    }
    
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }
    
    public function setEndDatetime(\DateTime $end)
    {
        $this->endDatetime = $end;
        return $this;
    }
    
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }
    
    public function setAllDay($allDay = false)
    {
        $this->allDay = (boolean) $allDay;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllDay()
    {
        return $this->allDay;
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
