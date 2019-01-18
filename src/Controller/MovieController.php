<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use App\Repository\VipRepository;
use App\Repository\MovieRepository;

class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     */
    public function index(MovieRepository $repo)
    {
        $movies = $repo->findAll();
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $movies
        ]);
    }

   /**
     * @Route("/movies/new", name="movie_create")
     * @Route("/movies/{id}/edit", name="movie_edit")
     */
    public function managemovies(Request $request, ObjectManager $manager, movie $movie = null)
    {
        if (!$movie)
        {
            $movie = new movie();
        }

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($movie);
            $manager->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('/movie/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $movie->getId() != null
        ]);
    }

     /**
     * @Route("/movies/{id}/delete", name="movie_delete")
     */
    public function deletemovie(movie $movie, ObjectManager $manager)
    {
        $manager->remove($movie);
        $manager->flush();

        return $this->redirectToRoute('movies');
    }

}
