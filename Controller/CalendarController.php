<?php

namespace ADesigns\CalendarBundle\Controller;

use ADesigns\CalendarBundle\Serializer\ArrayNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    /**
     * Dispatch a CalendarEvent and return a JSON Response of any events returned.
     * 
     * @param Request $request
     * @return Response
     */
    public function loadCalendarAction(Request $request)
    {
        $startDatetime = new \DateTime($request->get('start'));
        $endDatetime = new \DateTime($request->get('end'));
        
        $events = $this->container->get('event_dispatcher')->dispatch(
            CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request)
        )->getEvents();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        $return_events = array();

        $normalizer = new ArrayNormalizer();
        
        foreach($events as $event) {
            $return_events[] = $normalizer->normalize($event);
        }
        
        $response->setContent(json_encode($return_events));
        
        return $response;
    }
}
