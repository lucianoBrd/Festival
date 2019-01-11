<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->findAll();
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/new", name="category_create")
     * @Route("/category/{id}/edit", name="category_edit")
     */
    public function manage(Request $request, ObjectManager $manager, Category $category = null)
    {
        if (!$category) {
            $category = new Category();
        }

        $editMode = $category->getId() != null;

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            if (!$editMode) {
                $this->addFlash('success', 'Catégorie créée.');
            } else {
                $this->addFlash('success', 'Catégorie modifiée.');
            }

            return $this->redirectToRoute('category');
        }

        return $this->render('category/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode,
            'category' => $category
        ]);
    }

    /**
     * @Route("/category/{id}/delete", name="category_delete")
     */
    public function delete(Category $category, ObjectManager $manager)
    {
        $manager->remove($category);
        $manager->flush();

        $this->addFlash('success', 'Catégorie supprimée.');
        return $this->redirectToRoute('category');
    }
}
