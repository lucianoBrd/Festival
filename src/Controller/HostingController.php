<?php

namespace App\Controller;

use App\Entity\Hosting;
use App\Form\HostingType;
use App\Repository\HostingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HostingController extends AbstractController
{
    /**
     * @Route("/hosting/new", name="new_hosting")
     * @Route("/hosting/{id}/edit", name="hosting_edit")
     */
    public function newHosting(Hosting $hosting = null, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if(!$hosting){
            $hosting = new Hosting();
        }

        $form = $this->createForm(HostingType::class, $hosting);

        $form->handleRequest($request);

        $editMode = $hosting->getId() != null;

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($hosting);
            $manager->flush();

            return $this->redirectToRoute('hosting_room', ['id' => $hosting->getId()]);
        }

        return $this->render('hosting/newHosting.html.twig', [
            'form' => $form->createView(),
            'hosting' => $hosting,
            'editMode' => $editMode
        ]);
    }

    /**
     * @Route("/hosting", name="hosting_all")
     */
    public function allHosting(HostingRepository $repo, PaginatorInterface $paginator, Request $request){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $hostings = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('hosting/all.html.twig', [
            'hostings' => $hostings
        ]);
    }

    /**
     * @Route("/hosting/{id}/delete", name="hosting_delete")
     */
    public function delete(Hosting $hosting = null, ObjectManager $manager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $manager->remove($hosting);
        $manager->flush();
        $this->addFlash('success', 'Hébergement supprimé');
        return $this->redirectToRoute('hosting_all');
    }
}
