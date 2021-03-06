<?php

namespace App\Controller;

use App\Entity\ProjectionRoom;
use App\Form\ProjectionRoomType;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ProjectionRoomRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectionRoomController extends AbstractController
{
    /**
     * @Route("/projection/room", name="projection_room")
     */
    public function index(Request $request, PaginatorInterface $paginator, ProjectionRoomRepository $repo)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $rooms = $paginator->paginate(
            $repo->findQuery(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('projection/room/index.html.twig', [
            'controller_name' => 'ProjectionRoomController',
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("/projection/room/new", name="projection_room_create")
     * @Route("/projection/room/{id}/edit", name="projection_room_edit")
     */
    public function manage(Request $request, ObjectManager $manager, ProjectionRoom $room = null)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        if (!$room) {
            $room = new ProjectionRoom();
        }

        $editMode = $room->getId() != null;

        $form = $this->createForm(ProjectionRoomType::class, $room);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($room);
            $manager->flush();

            if (!$editMode) {
                $this->addFlash('success', 'Salle créée');
            } else {
                $this->addFlash('success', 'Salle modifiée');
            }

            return $this->redirectToRoute('projection_room');
        }

        return $this->render('projection/room/manage.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode,
            'room' => $room
        ]);
    }

    /**
     * @Route("/projection/room/{id}/delete", name="projection_room_delete")
     */
    public function delete(ProjectionRoom $room, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_STAFF']);
        $manager->remove($room);
        $manager->flush();
        $this->addFlash('success', 'Salle supprimée');
        return $this->redirectToRoute('projection_room');
    }
}
