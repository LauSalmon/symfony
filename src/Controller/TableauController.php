<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableauController extends AbstractController
{
    #[Route('/tableau', name: 'app_tableau')]
    public function index(): Response
    {
        return $this->render('tableau/index.html.twig', [
            'tab' => [10,5,22,36,98],
            'user' => [
                ["nom" => "Salmon", "prenom" => "Laura"],
                ["nom" => "Jones", "prenom" => "Baghera"],
                ["nom" => "Daniel", "prenom" => "Antoine"],
            ]
        ]);
    }
}
