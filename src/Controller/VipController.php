<?php

namespace App\Controller;

use App\Entity\Vip;
use App\Form\VipType;
use App\Repository\VipRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VipController extends AbstractController
{
    /**
     * @Route("/vip", name="vip")
     */
    public function index(VipRepository $repo)
    {
        $vips = $repo->findAll();
        return $this->render('vip/index.html.twig', [
            'controller_name' => 'VipController',
            'vips'=> $vips
        ]);
    }

    /**
     * @Route("/vip/new", name="vip_create")
     * @Route("/vip/{id}/edit", name="vip_edit")
     */
    public function manageVips(Request $request, ObjectManager $manager, Vip $vip = null)
    {
        if (!$vip)
        {
            $vip = new Vip();
        }

        $form = $this->createForm(VipType::class, $vip);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($vip);
            $manager->flush();

            return $this->redirectToRoute('vip');
        }

        return $this->render('/vip/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $vip->getId() != null
        ]);
    }

     /**
     * @Route("/vip/{id}/delete", name="vip_delete")
     */
    public function deleteVip(Vip $vip, ObjectManager $manager)
    {
        $manager->remove($vip);
        $manager->flush();

        return $this->redirectToRoute('vip');
    }

}