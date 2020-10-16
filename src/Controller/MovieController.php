<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MoviePersonType;
use App\Form\MovieType;
use App\Form\PersonType;
use App\Repository\MovieRepository;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movies", methods={"GET"})
     * @param MovieRepository $movieRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, MovieRepository $movieRepository)
    {
//        $movies = $movieRepository->findBy([], ['title' => 'ASC']);
        $qb = $movieRepository->findAllQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($qb));
        $page = $request->get('page', 1);
        $pagerfanta->setMaxPerPage(3);
        $pagerfanta->setCurrentPage($page);
        return $this->render('movie/index.html.twig', ['pager' => $pagerfanta]);
    }

    /**
     * @Route("/add", name="add_movie", methods={"GET","POST"})
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $em->persist($movie);
            $em->flush();
            return $this->redirectToRoute('movies');
        }

        return $this->render('movie/add_movie.html.twig', [
            'movieForm' => $form->createView()
        ]);
    }
}
