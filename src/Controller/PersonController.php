<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/add-person", name="add_person")
     */
    public function add()
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        return $this->render('person/index.html.twig', [
            'personForm' => $form->createView()
        ]);
    }
}
