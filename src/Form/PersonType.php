<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    "placeholder" => 'First name'
                ]
            ])
            ->add('lastName',TextType::class, [
                'attr' => [
                    "placeholder" => 'Last name'
                ]
            ])
            ->add('dob', BirthdayType::class)
            ->add('role', ChoiceType::class,[
                'multiple' => false,
                'choices' => [
                    'Actor' => 'actor',
                    'Director' => 'director',
                    'Producer' => 'producer',
                    'Other' => 'other'
                ],
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Submit',
                    'attr'  => [
                        'class' => 'btn btn-success',
                    ],
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
