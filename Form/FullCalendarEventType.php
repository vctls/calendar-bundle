<?php
/**
 * User: vtoulouse
 * Date: 20/03/2018
 * Time: 12:20
 */

namespace ADesigns\CalendarBundle\Form;

use ADesigns\CalendarBundle\Entity\FullCalendarEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FullCalendarEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('startDatetime', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('endDatetime', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('allDay', CheckboxType::class, [
                'required' => false
            ])
            ->add('submit', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FullCalendarEvent::class
        ]);
    }
}