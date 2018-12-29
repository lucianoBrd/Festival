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

    /**
     * @Route("/projection/rooms/", name="rooms")
     */
    public function indexRoom(ProjectionRoomRepository $repo)
    {
        $rooms = $repo->findAll();
        return $this->render('projection/rooms/index.html.twig', [
            'rooms' => $rooms
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

            return $this->redirectToRoute('rooms');
        }

        return $this->render('projection/rooms/manage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/projection/rooms/{id}/delete", name="room_delete")
     */
    public function deleteRoom(ProjectionRoom $room, ObjectManager $manager)
    {
        $manager->remove($room);
        $manager->flush();

        return $this->redirectToRoute('rooms');
    }
}
