<?php

namespace App\Controller;

use App\Entity\Bookings;
use App\Form\Bookings1Type;
use App\Form\BookingsType;
use App\Repository\BookingsRepository;
use App\Repository\PartyRepository;
use App\Repository\UserRepository;
use http\Client\Curl\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[IsGranted("IS_AUTHENTICATED_FULLY")]
#[Route('/bookings')]
class BookingsController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message: 'No access! Get out!')]
    #[Route('/', name: 'app_bookings_index', methods: ['GET'])]
    public function index(BookingsRepository $bookingsRepository): Response
    {
        return $this->render('bookings/index.html.twig', [
            'bookings' => $bookingsRepository->findAll(),
        ]);
    }

    #[Route('/user', name: 'app_bookings_user_index', methods: ['GET'])]
    public function indexUser(UserInterface $user, BookingsRepository $bookingsRepository, UserRepository $userRepository): Response
    {



        return $this->render('bookings/indexUser.html.twig', [
            'bookings' => $bookingsRepository->findBy(['user' => $this->getUser()])
        ]);
    }

    #[Route('/new/{id}', name: 'app_bookings_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, BookingsRepository $bookingsRepository, PartyRepository $partyRepository): Response
    {

        $booking = new Bookings();
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $booking->setUser($this->getUser());

            $party = $partyRepository->find($id);
            $booking->setTitle($party);
            $booking->setAmount($party->getPriceperhour() * $booking->getNumberOfKids() * $booking->getDuration());
            $bookingsRepository->add($booking);

            return $this->redirectToRoute('app_bookings_show', ['id' => $booking->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('bookings/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
            'id' => $id


        ]);
    }

    #[Route('/{id}', name: 'app_bookings_show', methods: ['GET'])]
    public function show(Bookings $booking): Response
    {
        return $this->render('bookings/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[IsGranted('ROLE_BAKER', message: 'No access! Get out!')]
    #[Route('/{id}/edit', name: 'app_bookings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookings $booking, BookingsRepository $bookingsRepository): Response
    {
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingsRepository->add($booking);
            return $this->redirectToRoute('app_bookings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookings/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_BAKER', message: 'No access! Get out!')]
    #[Route('/{id}', name: 'app_bookings_delete', methods: ['POST'])]
    public function delete(Request $request, Bookings $booking, BookingsRepository $bookingsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->request->get('_token'))) {
            $bookingsRepository->remove($booking);
        }

        return $this->redirectToRoute('app_bookings_index', [], Response::HTTP_SEE_OTHER);
    }
}
