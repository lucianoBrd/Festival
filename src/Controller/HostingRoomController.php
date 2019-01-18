<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Entity\Hosting;
use App\Repository\RoomRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HostingRoomController extends AbstractController
{
    /**
     * @Route("/hosting/room/{id}", name="hosting_room")
     */
    public function index(Hosting $hosting, RoomRepository $repo, PaginatorInterface $paginator, Request $request, ObjectManager $manager)
    {
        $room = new Room();
        $room->setIdHosting($hosting);

        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hosting->updateNbPlace();
            $manager->persist($hosting);
            $manager->persist($room);
            $manager->flush();

            
            $this->addFlash('success', 'Chambre ajoutée');
            return $this->redirectToRoute('hosting_room', ['id' => $hosting->getId()]);
        }

        $rooms = $paginator->paginate(
            $repo->findQuery($hosting->getId()), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('hosting/room/index.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView(),
            'room' => $room,
            'hosting' => $hosting
        ]);
    }

    /**
     * @Route("/hosting/room/{id}/delete", name="hosting_room_delete")
     */
    public function delete(Room $room = null, ObjectManager $manager){
        $hosting = $room->getIdHosting();
        $id = $hosting->getId();
        $hosting->updateNbPlace();
        $manager->persist($hosting);
        $manager->remove($room);
        $manager->flush();
        $this->addFlash('success', 'Chambre supprimé');
        return $this->redirectToRoute('hosting_room', ['id' => $id]);
    }

    /**
     * @Route("/hosting/room/{id}/edit", name="hosting_room_edit")
     */
    public function registration(Room $room = null, Request $request, ObjectManager $manager){
        $hosting = $room->getIdHosting();
        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hosting->updateNbPlace();
            $manager->persist($hosting);
            $manager->persist($room);
            $manager->flush();

            $this->addFlash('success', 'Chambre modifiée');
            return $this->redirectToRoute('hosting_room', ['id' => $hosting->getId()]);
        }

        return $this->render('hosting/room/edit.html.twig', [
            'form' => $form->createView(),
            'room' => $room,
            'hosting' => $hosting
        ]);
    }

}
