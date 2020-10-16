<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Title',
                'attr' => [
                    'placeholder' => 'Enter movie title'
                ]
            ])
            ->add('description',TextareaType::class, [
                'label' => 'Description',
                "required" => false,
                'attr' => [
                    'placeholder' => 'Enter movie description'
                ]
            ])
            ->add('releaseYear', IntegerType::class, [
                'label' => 'Year of release',
                'attr' => [
                    'placeholder' => "Enter movie's year of release",
                    "min"=> 1900,
                    "max"=>2020,
                ]
            ])
            ->add('people', EntityType::class, [
                'class' => Person::class,
                'query_builder' => function (PersonRepository $pr) {
                    return $pr->createQueryBuilder('p')
                        ->orderBy('p.firstName', 'ASC');
                },
                'choice_label' => function($person) {
                return $person->getFirstName() . ' ' . $person->getLastName();
                },
                'multiple' => true
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
            'data_class' => Movie::class,
        ]);
    }
}
