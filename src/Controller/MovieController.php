<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movies")
     */
    public function index()
    {
        return $this->render('movie/index.html.twig');
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
