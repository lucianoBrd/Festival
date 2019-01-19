<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\VipRepository;
use App\Repository\MovieRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="movie")
     */
    public function index(Request $request, MovieRepository $repo, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $movies = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('movie/index.html.twig', [
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
        $editMode = $movie->getId() != null;

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($movie);
            $manager->flush();
            if(!$editMode){
                $this->addFlash('success', 'Film créé');
            } else {
                $this->addFlash('success', 'Film modifié');
            }
            return $this->redirectToRoute('movie');
        }

        return $this->render('/movie/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode
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
        $this->addFlash('success', 'Film supprimé');
        return $this->redirectToRoute('movie');
    }

}
