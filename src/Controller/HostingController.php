<?php

namespace App\Controller;

use App\Entity\Hosting;
use App\Form\HostingType;
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

            
            $this->addFlash('success', 'Hébergement créé');
            return $this->redirectToRoute('new_hosting');
        }

        return $this->render('hosting/newHosting.html.twig', [
            'form' => $form->createView(),
            'hosting' => $hosting
        ]);
    }
}
