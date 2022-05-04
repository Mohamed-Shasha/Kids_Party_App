<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\PartyType;
use App\Repository\CommentRepository;
use App\Repository\PartyRepository;
use App\Repository\UserRepository;
use http\Client\Curl\User;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/party')]
class PartyController extends AbstractController
{
    #[Route('/', name: 'app_party_index', methods: ['GET'])]
    public function index(PartyRepository $partyRepository): Response
    {
        return $this->render('party/index.html.twig', [
            'parties' => $partyRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_ADMIN', message: 'No access! Get out!')]
    #[Route('/new', name: 'app_party_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartyRepository $partyRepository): Response
    {
        $party = new Party();
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partyRepository->add($party);
            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('party/new.html.twig', [
            'party' => $party,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_party_show', methods: ['GET'])]
    public function show(int $id ,Party $party, PartyRepository $partyRepository,UserRepository $userRepository): Response
    {


        return $this->render('party/show.html.twig', [
            'party' => $party,
            'parties'=>$partyRepository->find($id),


        ]);
    }
    #[IsGranted('ROLE_ADMIN', message: 'No access! Get out!')]
    #[Route('/{id}/edit', name: 'app_party_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Party $party, PartyRepository $partyRepository): Response
    {
        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partyRepository->add($party);
            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('party/edit.html.twig', [
            'party' => $party,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN', message: 'No access! Get out!')]
    #[Route('/{id}', name: 'app_party_delete', methods: ['POST'])]
    public function delete(Request $request, Party $party, PartyRepository $partyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$party->getId(), $request->request->get('_token'))) {
            $partyRepository->remove($party);
        }

        return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
    }
}
