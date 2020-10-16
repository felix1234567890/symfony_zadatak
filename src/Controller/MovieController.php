<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movies")
     * @param MovieRepository $movieRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findAll();
        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }

    /**
     * @Route("/add", name="add_movie")
     */
    public function add()
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        return $this->render('movie/add_movie.html.twig',[
            'movieForm' => $form->createView()
        ]);
    }
}
