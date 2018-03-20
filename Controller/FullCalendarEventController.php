<?php
/**
 * User: vtoulouse
 * Date: 27/02/2018
 * Time: 10:55
 */

namespace ADesigns\CalendarBundle\Controller;


use ADesigns\CalendarBundle\Entity\FullCalendarEvent;
use ADesigns\CalendarBundle\Form\FullCalendarEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FullCalendarEventController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $start = (new \DateTime())->setTimestamp($request->get('start'));
        $end = (new \DateTime())->setTimestamp($request->get('end'));
        $event = (new FullCalendarEvent())
            ->setStartDatetime($start)
            ->setEndDatetime($end)
        ;
        $form = $this->createForm(FullCalendarEventType::class, $event)
            ->add('submit', SubmitType::class)
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }

        return $this->render('@ADesignsCalendar/event/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * TODO Edit an event with a form.
     * @param Request $request
     * @return JsonResponse
     */
    public function editAction(Request $request)
    {
        return new JsonResponse('', 501);
    }

    /**
     * Change the dates of an event when when it is resized.
     *
     * @param Request $request
     * @param FullCalendarEvent $event
     * @return JsonResponse
     */
    public function resizeAction(Request $request, FullCalendarEvent $event)
    {
        $start = (new \DateTime())->setTimestamp($request->get('start'));
        $end = (new \DateTime())->setTimestamp($request->get('end'));
        return new JsonResponse('', 501);
    }
}