<?php

namespace App\Controller;

use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
            public function index(PartyRepository $partyRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'parties' => $partyRepository->findAll(),
        ]);
    }


}
