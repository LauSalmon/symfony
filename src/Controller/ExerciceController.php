<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciceController extends AbstractController
{
    #[Route('/exercice', name: 'app_exercice')]
    public function index(): Response
    {
        return $this->render('exercice/index.html.twig', [
            'controller_name' => 'ExerciceController',
        ]);
    }

    #[Route('/afficher/{nom}', name: 'app_afficher')]
    public function afficher($nom) : Response{
       return $this->render('exercice/index.html.twig', [
        'name_var' => $nom,
       ]);
    }

    #[Route('/exercicecalcul/{nbr1}/{nbr2}/{operateur}', name: 'app_afficher')]
    public function exoCalcul($nbr1, $nbr2, $operateur){
        //try (si le code plante on passe dans le catch et on récupére notre exception)
        try {
            //opérateur ternaire (si nbr1 ou nbr2) n'est pas un nombre on crée une nouvelle exception
            !is_numeric($nbr1) || !is_numeric($nbr2)?throw new \Exception("nbr1 ou nbr2 ne sont pas des nombres"):null;
            //switch case de l'opérateur
            switch ($operateur) {
                case "add":
                    $message = "Le résultat de l'addition est égal à : " . ($nbr1 + $nbr2);
                    break;
                case "sub":
                    $message = "Le résultat de la soustraction est égal à : " . ($nbr1 - $nbr2);
                    break;
                case "multi":
                    $message = "Le résultat de la multiplication est égal à : " . ($nbr1 * $nbr2);
                    break;
                case "div":
                    //opérateur ternaire si nbr2 == 0 on crée une nouvelle exception
                    $nbr2 == 0?throw new \Exception("la division par zéro est impossible"):null;
                    $message = "Le résultat de la division est égal à : " . ($nbr1 / $nbr2);
                    break;
                //si l'opérateur n'est pas (add ou sub ou multi ou div)
                default:
                    $message = "L'opérateur n'est pas valide";
                    break;
            }
            
        }
        //récupérer l'exception si le try crache
        catch (\Throwable $th) {
            $message = "Erreur : " . $th->getMessage();
        }
        //retourner la réponse
        return $this->render('exercice/index.html.twig', [
            'nbr1' => $nbr1,
            'nbr2' => $nbr2,
            'result' => $message,
           ]);
    }
}

