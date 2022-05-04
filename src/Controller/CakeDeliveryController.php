<?php

namespace App\Controller;

use App\Entity\CakeDelivery;
use App\Form\CakeDeliveryType;
use App\Manager\CartManager;
use App\Repository\CakeDeliveryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/delivery')]
class CakeDeliveryController extends AbstractController
{
    #[Route('/', name: 'app_delivery_index', methods: ['GET'])]
    public function index(CakeDeliveryRepository $cakeDeliveryRepository): Response
    {
        return $this->render('cake_delivery/index.html.twig', [
            'cake_deliveries' => $cakeDeliveryRepository->findAll(),
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/new', name: 'app_delivery_new', methods: ['GET', 'POST'])]
    public function new(CartManager $cartManager,Request $request, CakeDeliveryRepository $cakeDeliveryRepository): Response
    {
        $cakeDelivery = new CakeDelivery();
        $form = $this->createForm(CakeDeliveryType::class, $cakeDelivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $cartManager->getCurrentCart();
            $cakeDelivery->setName($this->getUser());
            $cakeDelivery->setCadeorder($cart);
            $cakeDeliveryRepository->add($cakeDelivery);
            $cart->removeItems();

            return $this->redirectToRoute('app_delivery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cake_delivery/new.html.twig', [
            'cake_delivery' => $cakeDelivery,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delivery_show', methods: ['GET'])]
    public function show(CakeDelivery $cakeDelivery): Response
    {
        return $this->render('cake_delivery/show.html.twig', [
            'cake_delivery' => $cakeDelivery,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_delivery_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CakeDelivery $cakeDelivery, CakeDeliveryRepository $cakeDeliveryRepository): Response
    {
        $form = $this->createForm(CakeDeliveryType::class, $cakeDelivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cakeDeliveryRepository->add($cakeDelivery);
            return $this->redirectToRoute('app_delivery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cake_delivery/edit.html.twig', [
            'cake_delivery' => $cakeDelivery,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delivery_delete', methods: ['POST'])]
    public function delete(Request $request, CakeDelivery $cakeDelivery, CakeDeliveryRepository $cakeDeliveryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cakeDelivery->getId(), $request->request->get('_token'))) {
            $cakeDeliveryRepository->remove($cakeDelivery);
        }

        return $this->redirectToRoute('app_delivery_index', [], Response::HTTP_SEE_OTHER);
    }
}
