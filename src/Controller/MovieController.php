<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findBy([], ['title' => 'ASC']);
        return $this->render('movie/index.html.twig', compact('movies'));
    }

    /**
     * @Route("/add", name="add_movie", methods={"GET","POST"})
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Movie successfully created!');
            return $this->redirectToRoute('movies');
//            dd($form->getData());
        }

        return $this->render('movie/add_movie.html.twig',[
            'movieForm' => $form->createView()
        ]);
    }
}
