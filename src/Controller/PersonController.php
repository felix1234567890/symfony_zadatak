<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Role;
use App\Form\MemberType;
use App\Form\RolePersonType;
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
    public function addPersonWithRole(Request $request, MovieRepository $movieRepository,PersonRepository $personRepository,EntityManagerInterface $em)
    {
        $movie = $movieRepository->find($request->get('id'));
        $person = new Person();

        $role = new Role();
        $form = $this->createForm(RolePersonType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $personExistsOnMovie = $movieRepository->personExistsOnMovie($form['firstName']->getData(), $form['lastName']->getData(),$movie->getTitle() );
            if($personExistsOnMovie){
                $form->get('firstName')->addError(new FormError('User with this first and last name exists for this movie'));
                $form->get('lastName')->addError(new FormError('User with this first and last name exists for this movie'));
            }
            if($form->isValid()){
                $person->setFirstName($form['firstName']->getData());
                $person->setLastName($form['lastName']->getData());
                $person->setDob($form['dob']->getData());
                $personExists = $personRepository->findOneBy(['firstName' => $form['firstName']->getData(), 'lastName' => $form['lastName']->getData() ]);
                if($personExists) {
                    $role->setRole($form['role']->getData());
                    $role->setPerson($personExists);
                    $movie->addRole($role);
                    $em->persist($role);
                    $em->persist($movie);
                }
                else{
                    $role->setRole($form['role']->getData());
                    $em->persist($person);
                    $role->setPerson($person);
                    $movie->addRole($role);
                    $em->persist($role);
                    $em->persist($movie);
                }
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
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function addExistingPersonWithRole(Request $request, MovieRepository $movieRepository,EntityManagerInterface $em)
    {
        $movie = $movieRepository->find($request->get('id'));
        $role = new Role();
        $form = $this->createForm(MemberType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $person = $form['person']->getData();
            $personExists = $movieRepository->personExistsOnMovie($person->getFirstName(), $person->getLastName(),$movie->getTitle() );
            if($personExists){
                $form->get('person')->addError(new FormError('Person with this first and last name exists for this movie'));
            }
            if($form->isValid()){
                $role->setPerson($person);
                $role->setRole($form->get('role')->getData());
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
