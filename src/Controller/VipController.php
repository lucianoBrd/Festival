<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VipController extends AbstractController
{
    /**
     * @Route("/vip", name="vip")
     */
    public function index()
    {
        return $this->render('vip/index.html.twig', [
            'controller_name' => 'VipController',
        ]);
    }
    
    /**
     * @Route("/Vips/new", name="Vip_create")
     * @Route("/Vips/{id}/edit", name="Vip_edit")
     */
    public function manageVips(Request $request, ObjectManager $manager, Vip $Vip = null)
    {
        if (!$Vip)
        {
            $Vip = new Vip();
        }

        $form = $this->createForm(VipType::class, $Vip);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($Vip);
            $manager->flush();

            return $this->redirectToRoute('Vips');
        }

        return $this->render('/Vip/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $Vip->getId() != null
        ]);
    }

     /**
     * @Route("/Vips/{id}/delete", name="Vip_delete")
     */
    public function deleteVip(Vip $Vip, ObjectManager $manager)
    {
        $manager->remove($Vip);
        $manager->flush();

        return $this->redirectToRoute('Vips');
    }

}