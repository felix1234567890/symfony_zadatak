<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Role;
use App\Form\MemberType;
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
    /**
     * @Route("/people",name="people", methods={"GET"})
     * @param Request $request
     * @param PersonRepository $personRepository
     * @return Response
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
     * @param PersonRepository $personRepository
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function addPerson(Request $request, MovieRepository $movieRepository,PersonRepository $personRepository,EntityManagerInterface $em)
    {
        $movie = $movieRepository->find($request->get('id'));
        $person = new Person();
        $form = $this->createForm(PersonType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $person = $form->getData();
            $personExistsOnMovie = $personRepository->personExistsOnMovie($person->getFirstName(), $person->getLastName(),$movie->getTitle() );
            if($personExistsOnMovie){
                $form->get('firstName')->addError(new FormError('User with this first and last name exists'));
                $form->get('lastName')->addError(new FormError('User with this first and last name exists'));
            }
            if($form->isValid()){
                $personExists = $personRepository->findOneBy(['firstName' => $person->getFirstName(), 'lastName' => $person->getLastName() ]);
                if($personExists) {
                    $movie->addPerson($personExists);
                }
                else{
                    $movie->addPerson($person);
                    $em->persist($person);
                }
                $em->persist($movie);
                $em->flush();
                return $this->redirectToRoute('movies');
            }

        }
        return $this->render('person/add_person.html.twig', [
            'personForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/add-existing/{id<[0-9]+>}", name="add_existing", methods={"GET","POST"})
     * @param Request $request
     * @param MovieRepository $movieRepository
     * @param PersonRepository $personRepository
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function addExisting(Request $request, MovieRepository $movieRepository,PersonRepository $personRepository,EntityManagerInterface $em)
    {
        $movie = $movieRepository->find($request->get('id'));
        $role = new Role();
        $form = $this->createForm(MemberType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $person = $form['person']->getData();
            $personExists = $personRepository->personExistsOnMovie($person->getFirstName(), $person->getLastName(),$movie->getTitle() );
            if($personExists){
                $form->get('person')->addError(new FormError('Person with this first and last name exists for this movie'));
            }
            if($form->isValid()){
                $role->setPerson($person);
                $role->setRole($form->get('role')->getData());
//                $movie->addPerson($person);
                $movie->addRole($role);
                $em->persist($role);
                $em->persist($movie);
                $em->flush();
                return $this->redirectToRoute('movies');
            }
        }

        return $this->render('person/add_existing.html.twig', [
            'existingPersonForm' => $form->createView()
        ]);
    }
}
