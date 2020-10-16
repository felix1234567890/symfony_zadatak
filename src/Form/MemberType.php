<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person',EntityType::class,[
                'class' => Person::class,
                'multiple' => false,
                'choice_label' => function($person){
                    return $person->getFirstName() . " " . $person->getLastName();
                },
            ])
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
            // Configure your form options here
        ]);
    }
}
