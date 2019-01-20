<?php

namespace App\Controller;

use App\Entity\Vip;
use App\Form\VipType;
use App\Repository\VipRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VipController extends AbstractController
{
    /**
     * @Route("/vip", name="vip")
     */
    public function index(VipRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $vips = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('vip/index.html.twig', [
            'vips'=> $vips
        ]);
    }

    /**
     * @Route("/vip/new", name="vip_create")
     * @Route("/vip/{id}/edit", name="vip_edit")
     */
    public function manageVips(Request $request, ObjectManager $manager, Vip $vip = null)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        if (!$vip)
        {
            $vip = new Vip();
        }
        $editMode = $vip->getId() != null;

        $form = $this->createForm(VipType::class, $vip);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($vip);
            $manager->flush();
            if(!$editMode){
                $this->addFlash('success', 'VIP créé');
            } else {
                $this->addFlash('success', 'VIP modifié');
            }
            return $this->redirectToRoute('vip');
        }

        return $this->render('/vip/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode
        ]);
    }

     /**
     * @Route("/vip/{id}/delete", name="vip_delete")
     */
    public function deleteVip(Vip $vip, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $manager->remove($vip);
        $manager->flush();
        $this->addFlash('success', 'VIP supprimé');
        return $this->redirectToRoute('vip');
    }

}