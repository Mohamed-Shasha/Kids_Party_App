<?php

namespace App\Form;

use App\Entity\Comment;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('createdAt', DateType::class, [
//        'widget' => 'single_text',
//        'label' => 'to',
//        'attr' => [
//
//            '' => date('Y-m-d')
//        ]
//    ])

            ->add('rating', IntegerType::class, [
                'required' => true,
                'error_bubbling' => true,
                'attr' => [
                    'min' => 1,
                    ' max' => 5,

                ]
            ])
        ->add('content',TextareaType::class);
//        ->add('author')
//        ->add('party');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
