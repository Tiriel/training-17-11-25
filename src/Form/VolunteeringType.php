<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\User;
use App\Entity\Volunteering;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolunteeringType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('conference', EntityType::class, [
                'class' => Conference::class,
                'choice_label' => 'name',
            ])
        ;

        $modifier = function (FormInterface $form, ?Conference $conference, ?Volunteering $volunteering = null) {
            if ($conference instanceof Conference) {
                $form
                    ->add('startAt', DateType::class, [
                        'widget' => 'single_text',
                        'input' => 'datetime_immutable',
                    ])
                    ->add('endAt', DateType::class, [
                        'widget' => 'single_text',
                        'input' => 'datetime_immutable',
                    ]);

                $form->get('startAt')->setData($conference->getStartAt());
                $form->get('endAt')->setData($conference->getEndAt());

                if ($volunteering instanceof Volunteering) {
                    $volunteering
                        ->setStartAt($conference->getStartAt())
                        ->setEndAt($conference->getEndAt());
                }
                dump($volunteering);
            }
        };

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (PreSetDataEvent $event) use ($modifier) {
                /** @var Volunteering $volunteering */
                $volunteering = $event->getData();
                $modifier($event->getForm(), $volunteering->getConference(), $volunteering);
            });

        $builder
            ->get('conference')->addEventListener(FormEvents::POST_SUBMIT, function (PostSubmitEvent $event) use ($modifier) {
                /** @var Conference $conference */
                $conference = $event->getForm()->getData();
                $form = $event->getForm()->getParent();
                $volunteering = $form->getData();

                $modifier($form, $conference, $volunteering);
            });

        $builder->setAction($options['action']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Volunteering::class,
                'conference' => null,
            ])
            ->setAllowedTypes('conference', ['null', Conference::class])
        ;
    }
}
