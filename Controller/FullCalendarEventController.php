<?php
/**
 * User: vtoulouse
 * Date: 27/02/2018
 * Time: 10:55
 */

namespace ADesigns\CalendarBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FullCalendarEventController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editAction(Request $request)
    {
        // TODO Get the dates.
        // TODO Update the event.
        return new JsonResponse();
    }
}