<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Services\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movies", methods={"GET"})
     * @param Request $request
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function index(Request $request, MovieRepository $movieRepository)
    {
        $qb = $movieRepository->findAllQueryBuilder();
        $page = $request->get('page', 1);
        $paginator = new Paginator($qb, $page,2);
        return $this->render('movie/index.html.twig', ['pager' => $paginator->pagerfanta]);
    }

    /**
     * @Route("/add", name="add_movie", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
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
