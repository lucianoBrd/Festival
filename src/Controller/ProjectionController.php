<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProjectionController extends AbstractController
{
    /**
     * @Route("/projection", name="projection")
     */
    public function index()
    {
        return $this->render('projection/index.html.twig', [
            'controller_name' => 'ProjectionController',
        ]);
    }
}
