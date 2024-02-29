<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TwigController extends AbstractController
{
    #[Route('/twig/{nom}', name: 'app_twig')]
    public function index($nom): Response
    {
        return $this->render('twig/index.html.twig', [
            'user' => $nom,
        ]);
    }
}
