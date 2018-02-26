<?php

namespace ADesigns\CalendarBundle\Serializer;

use ADesigns\CalendarBundle\Entity\DisplayableInterface;

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
        $array = array();

//        if ($fullCalendarEvent->id !== null) {
//            $array['id'] = $fullCalendarEvent->id;
//        }
//
//        if ($fullCalendarEvent->url !== null) {
//            $array['url'] = $fullCalendarEvent->url;
//        }
//
//        if ($fullCalendarEvent->bgColor !== null) {
//            $array['backgroundColor'] = $fullCalendarEvent->bgColor;
//            $array['borderColor'] = $fullCalendarEvent->bgColor;
//        }
//
//        if ($fullCalendarEvent->fgColor !== null) {
//            $array['textColor'] = $fullCalendarEvent->fgColor;
//        }
//
//        if ($fullCalendarEvent->cssClass !== null) {
//            $array['className'] = $fullCalendarEvent->cssClass;
//        }


        if ($fullCalendarEvent instanceof DisplayableInterface) {
            $array['allDay'] = $fullCalendarEvent->isAllDay();
            $array['title'] = $fullCalendarEvent->getTitle();
            $array['start'] = $fullCalendarEvent->getStartDateTime()->format("Y-m-d\TH:i:sP");
            $array['end'] = $fullCalendarEvent->getEndDateTime()->format("Y-m-d\TH:i:sP");
        }


//        foreach ($fullCalendarEvent->otherFields as $field => $value) {
//            $array[$field] = $value;
//        }

        return $array;
    }
}