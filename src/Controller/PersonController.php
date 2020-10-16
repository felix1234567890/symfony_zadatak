<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\MovieRepository;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
//    /**
//     * @Route("/add-person", name="add_person")
//     */
//    public function add()
//    {
//        $person = new Person();
//        $form = $this->createForm(PersonType::class, $person);
//
//        return $this->render('person/index.html.twig', [
//            'personForm' => $form->createView()
//        ]);
//    }
    /**
     * @Route("/people",name="people", methods={"GET"})
     */
    public function index(Request $request, PersonRepository $personRepository)
    {
        $qb = $personRepository->createQueryBuilder('p');
        $pagerfanta = new Pagerfanta(new QueryAdapter($qb));
        $page = $request->get('page', 1);
        $pagerfanta->setMaxPerPage(3);
        $pagerfanta->setCurrentPage($page);
        return $this->render('person/index.html.twig', ['pager' => $pagerfanta]);
    }

    /**
     * @Route("/add-person/{id<[0-9]+>}", name="add_person", methods={"GET","POST"})
     * @param Request $request
     * @param MovieRepository $movieRepository
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function addPerson(Request $request, MovieRepository $movieRepository,EntityManagerInterface $em)
    {
        $movie = $movieRepository->find($request->get('id'));

        $person = new Person();
        $form = $this->createForm(PersonType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $person = $form->getData();
            $personExists = $movieRepository->personExists($person->getFirstName(), $person->getLastName());
            if($personExists){
                $form->get('firstName')->addError(new FormError('User with this first and last name exists'));
                $form->get('lastName')->addError(new FormError('User with this first and last name exists'));
            }
            if($form->isValid()){
                $movie->addPerson($person);
                $em->persist($person);
                $em->persist($movie);
                $em->flush();
                return $this->redirectToRoute('movies');
            }

        }
        return $this->render('person/add_person.html.twig', [
            'personForm' => $form->createView()
        ]);
    }
}
