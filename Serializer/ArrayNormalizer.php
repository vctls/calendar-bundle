<?php

namespace ADesigns\CalendarBundle\Serializer;

use ADesigns\CalendarBundle\Entity\ColorableInterface;
use ADesigns\CalendarBundle\Entity\DisplayableInterface;
use ADesigns\CalendarBundle\Entity\EditableInterface;

/**
 * User: Victor
 * Date: 2018-02-26
 * Time: 21:59
 */

class ArrayNormalizer
{
    /**
     * @param $fullCalendarEvent
     * @return array
     */
    public function normalize($fullCalendarEvent)
    {
        $arr = array();

        $arr['class'] = get_class($fullCalendarEvent);

        if ($fullCalendarEvent instanceof EditableInterface) {
            $arr['id'] = $fullCalendarEvent->getId();
        }

        if ($fullCalendarEvent instanceof DisplayableInterface) {
            $arr['allDay'] = $fullCalendarEvent->isAllDay();
            $arr['title'] = $fullCalendarEvent->getTitle();
            $arr['start'] = $fullCalendarEvent->getStartDatetime()->format("Y-m-d\TH:i:sP");
            $arr['end'] = $fullCalendarEvent->getEndDatetime()->format("Y-m-d\TH:i:sP");
        }
        
        if ($fullCalendarEvent instanceof ColorableInterface) {
            $arr['color'] = $fullCalendarEvent->getColor();
            $arr['backgroundColor'] = $fullCalendarEvent->getBackgroundColor();
            $arr['borderColor'] = $fullCalendarEvent->getBorderColor();
            $arr['textColor'] = $fullCalendarEvent->getTextColor();
        }

        return $arr;
    }
}