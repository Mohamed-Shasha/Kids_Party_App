<?php

namespace App\Form;

use App\Entity\Bookings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BookingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'date',
                'attr' => [
                    'min' => date('Y-m-d')
                ]


            ])
            ->add('beginAt', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'from',
                'attr' => [

                    'min' => date('hh')
                ]
            ])
            ->add('endAt', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'to',
                'attr' => [

                    'min' => date('hh')
                ]
            ])
            ->add('numberOfKids', IntegerType::class, [
                    'required' => true,
                    'error_bubbling' => true,
                    'attr' => [
                        'min' => 6,
                        ' max' => 20,

                    ]
                ]);






    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bookings::class,
        ]);
    }
}
