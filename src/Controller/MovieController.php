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
     * @Route("/movie", name="movie")
     */
    public function index(MovieRepository $repo)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $movies = $repo->findAll();
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $movies
        ]);
    }

   /**
     * @Route("/movie/new", name="movie_create")
     * @Route("/movie/{id}/edit", name="movie_edit")
     */
    public function managemovies(Request $request, ObjectManager $manager, movie $movie = null)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
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

            return $this->redirectToRoute('movie');
        }

        return $this->render('/movie/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $movie->getId() != null
        ]);
    }

     /**
     * @Route("/movie/{id}/delete", name="movie_delete")
     */
    public function deletemovie(movie $movie, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $manager->remove($movie);
        $manager->flush();

        return $this->redirectToRoute('movie');
    }

}
