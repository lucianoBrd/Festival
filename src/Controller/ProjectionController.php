<?php

namespace App\Controller;

use App\Entity\ProjectionRoom;
use App\Form\ProjectionRoomType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/projection/rooms/new", name="room_create")
     * @Route("/projection/rooms/{id}/edit", name="room_edit")
     */
    public function manageRooms(Request $request, ObjectManager $manager, ProjectionRoom $room = null)
    {
        if (!$room)
        {
            $room = new ProjectionRoom();
        }

        $form = $this->createForm(ProjectionRoomType::class, $room);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($room);
            $manager->flush();

            return $this->redirectToRoute('projection');
        }

        return $this->render('projection/manageRooms.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
