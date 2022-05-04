<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Form\AddToCartType;
use App\Form\CakeType;
use App\Manager\CartManager;
use App\Repository\CakeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cake')]
class CakeController extends AbstractController
{
    #[Route('/', name: 'app_cake_index', methods: ['GET'])]
    public function index(CakeRepository $cakeRepository): Response
    {
        return $this->render('cake/index.html.twig', [
            'cakes' => $cakeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cake_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CakeRepository $cakeRepository): Response
    {
        $cake = new Cake();
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cakeRepository->add($cake);
            return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cake/new.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    #[IsGranted("IS_AUTHENTICATED_FULLY")]

    #[Route('/{id}', name: 'app_cake_show', methods: ['GET','POST'])]
    public function show(Cake $cake, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $item = $form->getData();
            $item->setCake($cake);

            $cart = $cartManager->getCurrentCart();
            $cart->addItem($item)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            return $this->redirectToRoute('app_cake_index', ['id'=>$cake->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('cake/show.html.twig', [
            'cake' => $cake,
            'form' => $form->createView()
        ]);
    }

    #[IsGranted('ROLE_BAKER', message: 'No access! Get out!')]
    #[Route('/{id}/edit', name: 'app_cake_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cake $cake, CakeRepository $cakeRepository): Response
    {
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cakeRepository->add($cake);
            return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cake/edit.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cake_delete', methods: ['POST'])]
    public function delete(Request $request, Cake $cake, CakeRepository $cakeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cake->getId(), $request->request->get('_token'))) {
            $cakeRepository->remove($cake);
        }

        return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
    }
}
