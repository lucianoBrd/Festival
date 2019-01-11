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
     */
    public function newHosting(Request $request, ObjectManager $manager)
    {
        $hosting = new Hosting();

        $form = $this->createForm(HostingType::class, $hosting);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($hosting);
            $manager->flush();

            
            return $this->redirectToRoute('hosting_room', ['id' => $hosting->getId()]);
        }

        return $this->render('hosting/newHosting.html.twig', [
            'form' => $form->createView(),
            'hosting' => $hosting
        ]);
    }

    /**
     * @Route("/hosting", name="hosting_all")
     */
    public function allUser(HostingRepository $repo, PaginatorInterface $paginator, Request $request){
        
        $hostings = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('hosting/all.html.twig', [
            'hostings' => $hostings
        ]);
    }
}
