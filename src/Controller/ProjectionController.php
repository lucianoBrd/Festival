<?php

namespace App\Controller;

use App\Entity\Projection;
use App\Form\ProjectionType;
use App\Repository\ProjectionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectionController extends AbstractController
{
    /**
     * @Route("/projection", name="projection")
     */
    public function index(Request $request, PaginatorInterface $paginator, ProjectionRepository $repo)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $projections = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('projection/index.html.twig', [
            'projections' => $projections
        ]);
    }

    /**
     * @Route("/projection/planning", name="projection_planning")
     */
    public function planning(ProjectionRepository $repo, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $projections = $repo->findAll();
        foreach($projections as $projection){
            $manager->remove($projection);
        }
        //lun. 13 mai 2019 – sam. 28 mai 2019
        
        $manager->flush();
        return $this->redirectToRoute('projection');
    }

    /**
     * @Route("/projection/new", name="projection_create")
     * @Route("/projection/{id}/edit", name="projection_edit")
     */
    public function manage(Request $request, ObjectManager $manager, Projection $projection = null)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        if (!$projection) {
            $projection = new Projection();
        } 

        $editMode = $projection->getId() != null;

        $form = $this->createForm(ProjectionType::class, $projection);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($projection);
            $manager->flush();

            if (!$editMode) {
                $this->addFlash('success', 'Projection créée');
            } else {
                $this->addFlash('success', 'Projection modifiée');
            }

            return $this->redirectToRoute('projection');
        }

        return $this->render('projection/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode,
            'projection' => $projection
        ]);
    }

    /**
     * @Route("/projection/{id}/delete", name="projection_delete")
     */
    public function delete(Projection $projection, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $manager->remove($projection);
        $manager->flush();
        $this->addFlash('success', 'Projection supprimée');
        return $this->redirectToRoute('projection');
    }

}
