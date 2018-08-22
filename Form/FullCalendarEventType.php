<?php

namespace ADesigns\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}