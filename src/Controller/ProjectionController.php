<?php

namespace App\Controller;

use App\Entity\Projection;
use App\Form\ProjectionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProjectionRepository;

class ProjectionController extends AbstractController
{
    /**
     * @Route("/projection", name="projection")
     */
    public function index(ProjectionRepository $repo)
    {
        $projections = $repo->findAll();
        return $this->render('projection/index.html.twig', [
            'controller_name' => 'ProjectionController',
            'projections' => $projections
        ]);
    }

    /**
     * @Route("/projection/new", name="projection_create")
     * @Route("/projection/{id}/edit", name="projection_edit")
     */
    public function manage(Request $request, ObjectManager $manager, Projection $projection = null)
    {
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
                $this->addFlash('success', 'Projection créée.');
            } else {
                $this->addFlash('success', 'Projection modifiée.');
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
        $manager->remove($projection);
        $manager->flush();

        $this->addFlash('success', 'Projection supprimée.');
        return $this->redirectToRoute('projection');
    }

}
