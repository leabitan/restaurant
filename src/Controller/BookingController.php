<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/booking')]
class BookingController extends AbstractController
{


    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository, Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $dateMin = $search->getDateMin();
        $dateMax = $search->getDateMax();


        // Utilisation des dates pour filtrer les réservations

        $bookings = $bookingRepository->findByDateRange($dateMin, $dateMax);

        // Calcul de la somme des couverts
        $totalCouverts = 0;
        foreach ($bookings as $booking) {
            $totalCouverts += $booking->getPeopleNumber();
        }

        // Calcul de la somme des couverts confirmé
        $totalConfirmed = 0;
        foreach ($bookings as $booking) {
            if ($booking->isBookingConfirmed()) {
                $totalConfirmed += $booking->getPeopleNumber();
            }
        }

        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,
            'form' => $form->createView(),
            'totalCouverts' => $totalCouverts, // Somme des couverts
            'totalConfirmed' => $totalConfirmed, // Somme des couverts
        ]);
    }


    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking, ['action' => 'new']);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();
            $this->addFlash('success', 'La demande de réservation a bien été envoyée !');


            return $this->redirectToRoute('app_booking_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingType::class, $booking, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
