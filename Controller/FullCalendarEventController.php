<?php
/**
 * User: vtoulouse
 * Date: 27/02/2018
 * Time: 10:55
 */

namespace ADesigns\CalendarBundle\Controller;


use ADesigns\CalendarBundle\Entity\DisplayableInterface;
use ADesigns\CalendarBundle\Entity\EditableInterface;
use ADesigns\CalendarBundle\Entity\FullCalendarEvent;
use ADesigns\CalendarBundle\Form\FullCalendarEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FullCalendarEventController extends Controller
{
    /**
     * @param Request $request
     * @return Response|JsonResponse
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        // Get the dates from the request. They are set when someone clicks or selects a period on the calendar.
        $start = (new \DateTime())->setTimestamp($request->get('start'));
        $end = (new \DateTime())->setTimestamp($request->get('end'));

        // Get the class of the event we want to create.
        $class = $request->get('class');
        $formTypeName = $request->get('formType');

        // If the class is set try to create a corresponding object.
        if (!empty($class)) {
            // Check that it implements the correct interface.
            if (!in_array(DisplayableInterface::class, class_implements($class))) {
                throw new \Exception("The custom class $class is not a displayable event class.");
            }
            $r = new \ReflectionClass($class);
            $event = $r->newInstance();
        } else {
            // Else, fall back to the generic FullCalendarEvent.
            $event = new FullCalendarEvent();
        }

        // If the form type is not given, try to guess it from the event class.
        if ((!isset($formTypeName) || empty($formTypeName)) && isset($r)) {
            $namespace = $r->getNamespaceName();
            $baseNamespace = substr($namespace, 0, strpos($namespace, '\\Entity'));
            $formTypeName = $baseNamespace . '\\Form\\' . $r->getShortName() . 'Type';
        }

        // Define the form type.
        if (class_exists($formTypeName) && in_array(FormTypeInterface::class, class_implements($formTypeName))) {
            $formType = $formTypeName;
        } else {
            $formType = FullCalendarEventType::class;
        }

        // Set the dates.
        $event->setStartDatetime($start)->setEndDatetime($end);

        // Create the form.
        $form = $this->createForm($formType, $event, ['action' => $this->generateUrl('fullcalendarevent_new', [
            'class' => $class
        ])])
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return new JsonResponse(['message' => 'Success!'], 200);
        }

        return $this->render('@ADesignsCalendar/event/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit an event with a form.
     *
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $class = $request->get('class');
        $formTypeName = $request->get('formType');

        // If the class is set try to create a corresponding object.
        if (!empty($class)) {
            // Check that it implements the correct interface.
            if (!in_array(DisplayableInterface::class, class_implements($class))) {
                throw new \Exception("The custom class $class is not a displayable event class.");
            }
            $r = new \ReflectionClass($class);

        } else {
            // Else, fall back to the generic FullCalendarEvent class.
            $class = FullCalendarEvent::class;
        }

        // If the form type is not given, try to guess it from the event class.
        if ((!isset($formTypeName) || empty($formTypeName)) && isset($r)) {
            $namespace = $r->getNamespaceName();
            $baseNamespace = substr($namespace, 0, strpos($namespace, '\\Entity'));
            $formTypeName = $baseNamespace . '\\Form\\' . $r->getShortName() . 'Type';
        }

        // Define the form type.
        if (class_exists($formTypeName) && in_array(FormTypeInterface::class, class_implements($formTypeName))) {
            $formType = $formTypeName;
        } else {
            $formType = $formTypeName = FullCalendarEventType::class;
        }


        // Fetch the event by its ID.
        $event = $em->getRepository($class)->find($id);

        // Create the edit form.
        $form = $this->createForm($formType, $event, ['action' => $this->generateUrl('fullcalendarevent_edit', [
            'class' => $class,
            'id' => $id
        ])]);

        // Create the delete form.
        $deleteForm = $this->createDeleteForm($event, $class, $id);

        $form->add('save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return new JsonResponse(['message' => 'Success!'], 200);
        }

        return $this->render('@ADesignsCalendar/event/edit.html.twig', [
            'form_edit' => $form->createView(),
            'form_delete' => $deleteForm->createView()
        ]);
    }

    public function createDeleteForm($event, $class, $id)
    {
        return $this->createFormBuilder($event, ['action' => $this->generateUrl('fullcalendarevent_delete', [
            'class' => $class,
            'id' => $id
        ]), 'method' => 'DELETE' ])->add('delete', SubmitType::class)->getForm();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $class = $request->get('class');
        $event = $em->getRepository($class)->find($id);

        $deleteForm = $this->createDeleteForm($event, $class, $id);
        $deleteForm->handleRequest($request);
        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em->remove($event);
            $em->flush();
            return new JsonResponse(['message' => 'Success!'], 200);
        }

        return new JsonResponse(['message' => 'No action'], 200);
    }

    /**
     * Change the dates of an event when when it is resized.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function resizeAction(Request $request)
    {
        // Get the class of the event.
        $class = $request->get('class');

        // Check that it implements the correct interface.;
        if (!in_array(EditableInterface::class, class_implements($class))) {
            // TODO Should we throw, or return a custom response?
            // A non editable event should not even be editable in the view anyway.
            throw new \Exception('This event is not editable.');
        }

        $id = $request->get('id');

        // Get the event.
        $em = $event = $this->getDoctrine()->getManager();
        /** @var EditableInterface $event */
        $event = $em->getRepository($class)->find($id);

        // Change the dates.
        $start = new \DateTime($request->get('start'));
        $end = new \DateTime($request->get('end'));
        $event->setStartDatetime($start);
        $event->setEndDatetime($end);

        // Flush
        $em->flush();

        // Return a response.
        return new JsonResponse('', 200);
    }

    /**
     * Change the dates of an event when when it is resized.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function dropAction(Request $request)
    {
        // Get the class of the event.
        $class = $request->get('class');

        // Check that it implements the correct interface.;
        if (!in_array(EditableInterface::class, class_implements($class))) {
            // TODO Should we throw, or return a custom response?
            // A non editable event should not even be editable in the view anyway.
            throw new \Exception('This event is not editable.');
        }

        $id = $request->get('id');

        // Get the event.
        $em = $event = $this->getDoctrine()->getManager();
        /** @var EditableInterface $event */
        $event = $em->getRepository($class)->find($id);

        // Change the dates.
        $start = new \DateTime($request->get('start'));
        $end = new \DateTime($request->get('end'));
        $event->setStartDatetime($start);
        $event->setEndDatetime($end);

        // Flush
        $em->flush();

        // Return a response.
        return new JsonResponse('', 200);
    }
}