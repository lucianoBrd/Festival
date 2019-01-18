<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service_all")
     */
    public function allService(ServiceRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $services = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('service/all.html.twig', [
            'services' => $services
        ]);
    }

    /**
     * @Route("/service/new", name="service_new")
     * @Route("/service/{id}/edit", name="service_edit")
     */
    public function service(Service $service = null, Request $request, ObjectManager $manager){
        
        if(!$service){
            $service = new Service();
        }

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        $editMode = $service->getId() != null;

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($service);
            $manager->flush();

            
            if(!$editMode){
                $this->addFlash('success', 'Service créé');
                return $this->redirectToRoute('service_all');
            } 
            $this->addFlash('success', 'Service modifié');
            return $this->redirectToRoute('service_all');
        }

        return $this->render('service/edit.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
            'editMode' => $editMode
        ]);
    }

    /**
     * @Route("/service/{id}/delete", name="service_delete")
     */
    public function delete(Service $service = null, ObjectManager $manager){
        $manager->remove($service);
        $manager->flush();
        $this->addFlash('success', 'Service supprimé');
        return $this->redirectToRoute('service_all');
    }
}
