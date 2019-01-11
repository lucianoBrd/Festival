<?php

namespace App\Controller;

use App\Entity\ProjectionRoom;
use App\Form\ProjectionRoomType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use App\Repository\ProjectionRoomRepository;

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
