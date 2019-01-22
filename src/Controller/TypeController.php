<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="type_all")
     */
    public function allType(TypeRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $types = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('type/all.html.twig', [
            'types' => $types
        ]);
    }

    /**
     * @Route("/type/new", name="type_new")
     * @Route("/type/{id}/edit", name="type_edit")
     */
    public function service(Type $type = null, Request $request, ObjectManager $manager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if(!$type){
            $type = new Type();
        }

        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);

        $editMode = $type->getId() != null;

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($type);
            $manager->flush();

            
            if(!$editMode){
                $this->addFlash('success', 'Type créé');
                return $this->redirectToRoute('type_all');
            } 
            $this->addFlash('success', 'Type modifié');
            return $this->redirectToRoute('type_all');
        }

        return $this->render('type/edit.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
            'editMode' => $editMode
        ]);
    }

    /**
     * @Route("/type/{id}/delete", name="type_delete")
     */
    public function delete(Type $type = null, ObjectManager $manager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $manager->remove($type);
        $manager->flush();
        $this->addFlash('success', 'Type supprimé');
        return $this->redirectToRoute('type_all');
    }
}
