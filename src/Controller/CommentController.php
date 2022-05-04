<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PartyRepository;
use http\Client\Curl\User;
use Proxies\__CG__\App\Entity\Party;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("IS_AUTHENTICATED_FULLY")]
#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }


    #[Route('/new/{id}', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, CommentRepository $commentRepository, PartyRepository $partyRepository): Response
    {
        $comment = new Comment();


        $form = $this->createForm(CommentType::class, $comment);


        $form->handleRequest($request);
        $party = $partyRepository->find($id);
        $user = new \App\Entity\User();



        if ($form->isSubmitted() && $form->isValid()  ) {

            $comment->setAuthor($this->getUser());
            $comment->setCreatedAt(new \DateTime());
            $comment->setParty($party);
            $commentRepository->add($comment);
            return $this->redirectToRoute('app_party_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'id' => $id,
            'party'=>$party
        ]);
    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit/{partyId}', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(int $partyId, Request $request, Comment $comment, CommentRepository $commentRepository, PartyRepository $partyRepository): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment);
            return $this->redirectToRoute('app_party_show', ['id' => $partyId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'partyId' => $partyId,
            'party' => $partyRepository->find($partyId)


        ]);
    }

    #[Route('/{id}/{partyId}', name: 'app_comment_delete', methods: ['GET', 'POST'])]
    public function delete(int $partyId, Request $request, Comment $comment, CommentRepository $commentRepository, PartyRepository $partyRepository): Response
    {
        $party = new Party();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment);
            return $this->redirectToRoute('app_party_show', ['id' => $partyId], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('comment/delete.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'partyId' => $partyId,
            'party' => $partyRepository->find($partyId)


        ]);
    }
}
