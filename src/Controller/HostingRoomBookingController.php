<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\HostingRoomBooking;
use App\Form\HostingRoomBookingType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HostingRoomBookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HostingRoomBookingController extends AbstractController
{ 
    /**
     * @Route("/hosting/room/{id}/booking", name="hosting_room_booking")
     */
    public function index(Room $room, HostingRoomBookingRepository $repo, PaginatorInterface $paginator, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $booking = new HostingRoomBooking();
        $booking->setHostingRoom($room);
        $hosting = $room->getIdHosting();

        $form = $this->createForm(HostingRoomBookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($booking);
            $manager->flush();

            
            $this->addFlash('success', 'Réservation ajoutée');
            return $this->redirectToRoute('hosting_room_booking', ['id' => $room->getId()]);
        }

        $bookings = $paginator->paginate(
            $repo->findQuery($room->getId()), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('hosting/room/booking/index.html.twig', [
            'bookings' => $bookings,
            'form' => $form->createView(),
            'room' => $room,
            'booking' => $booking,
            'hosting' => $hosting
        ]);
    }

    /**
     * @Route("/hosting/room/booking/{id}/delete", name="hosting_room_booking_delete")
     */
    public function delete(HostingRoomBooking $booking = null, ObjectManager $manager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $room = $booking->getHostingRoom();
        $id = $room->getId();
        $manager->remove($booking);
        $manager->flush();
        $this->addFlash('success', 'Réservation supprimé');
        return $this->redirectToRoute('hosting_room_booking', ['id' => $id]);
    }

    /**
     * @Route("/hosting/room/booking/{id}/email", name="hosting_room_booking_email")
     */
    public function email(HostingRoomBooking $booking = null){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $room = $booking->getHostingRoom();
        $id = $room->getId();
        $this->addFlash('success', 'Les VIPs ont reçu un email');
        return $this->redirectToRoute('hosting_room_booking', ['id' => $id]);
    }

    /**
     * @Route("/hosting/room/booking/{id}/edit", name="hosting_room_booking_edit")
     */
    public function registration(HostingRoomBooking $booking = null, Request $request, ObjectManager $manager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $room = $booking->getHostingRoom();
        $hosting = $room->getIdHosting();
        $form = $this->createForm(HostingRoomBookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($booking);
            $manager->flush();

            $this->addFlash('success', 'Réservation modifiée');
            return $this->redirectToRoute('hosting_room_booking', ['id' => $room->getId()]);
        }

        return $this->render('hosting/room/booking/edit.html.twig', [
            'form' => $form->createView(),
            'room' => $room,
            'booking' => $booking,
            'hosting' => $hosting
        ]);
    }
}
