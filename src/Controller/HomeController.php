<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    #Permet de définir une route
    #[Route('/home', name:'app_home')]
    public function homeMessage():Response{
        return new Response ("Hello Laura");
    }


    public function afficherMessage(){
        return new Response ("Bonjour !");
    }

    #[Route('/message/bis', name:'app_message_bis')]
    public function afficherMessageBis(){
        return new Response ("Bonjour Bis !");
    }

    #[Route('/bonjour/{utilisateur}', name:'app_bonjour')]
    public function bonjourUtilisateur($utilisateur):Response{
        return new Response($utilisateur);
    }

    #[Route('/calcul/{nb1}/{nb2}', name:'app_calcul')]
    public function ajouterNombre($nb1, $nb2) :Response{
        if($nb1 != (int)$nb1 && $nb2 != (int)$nb2 ){
            return new Response ("nbr1 et nbr2 ne sont pas des nombres ! Concentrez vous !");
        } else if ($nb1 != (int)$nb1 || $nb2 != (int)$nb2 ){
            return new Response ("nbr1 ou nbr2 ne sont pas des nombres !");
        }else {
            $somme = $nb1+$nb2;
            return new Response ("La somme des 2 nombres est égale à  $somme") ;            
        }
 
    }

    #[Route('/cal/{nbr1}/{nbr2}/{operateur}', name:'app_calculate')]
    public function calculate($nbr1, $nbr2, $operateur) : Response{
        if ($nbr1 == (int)$nbr1 && $nbr2 == (int)$nbr2){
            if($operateur === "add" ){
                $add = $nbr1 + $nbr2;
                return new Response ("L'addition de ".$nbr1. "et $nbr2 vaut : $add");
            } else if ($operateur === "sub"){
                $sub = $nbr1 - $nbr2;
                return new Response ("La soustraction de $nbr1 et $nbr2 vaut : $sub");
            } else if ($operateur === "multi"){
                $multi = $nbr1 * $nbr2;
                return new Response ("La multiplication de $nbr1 et $nbr2 vaut : $multi");
            } else if ($operateur === "div"){
                if ($nbr2 == 0){
                    return new Response ("La division par 0 n'est pas possible.");                    

                } else {
                    $div = $nbr1 / $nbr2;
                    return new Response ("La division de $nbr1 et $nbr2 vaut : $div");
                }           
            }else {
                return new Response ("Opérateur non valide.");
            }
        } else {
            return new Response ("nbr1 ou nbr2 ou les 2 ne sont pas des nombres ...");
        }

    }
}

// Correction 1 :
// #[Route('/calculer/{nbr1}/{nbr2}/{operateur}', name:'app_calculer')]
// public function calculate($nbr1, $nbr2, $operateur) : Response 
// {

//     if(!is_numeric($nbr1)&&!is_numeric($nbr2)) {
//         $message = "Les 2 valeurs ne correspondent pas à des nombres";
//     }
//     else {
        
//         switch ($operateur) {
//             case "add":
//                 $message = "Le resultat de l'addition est égal : " . ($nbr1 + $nbr2);
//                 break;
//             case "sub":
//                 $message = "Le resultat de la soustraction est égal : " . ($nbr1 - $nbr2);
//                 break;
//             case "div":
//                 if($nbr2 == 0) {
//                     $message = "Division par zéro impossible";
//                 }
//                 else {
//                     $message = "Le resultat de la division est égal : ". ($nbr1 / $nbr2);
//                 }
//                 break;
//             case "multi":
//                 $message = "Le resultat de la multiplication est égal : " . ($nbr1 * $nbr2);
//                 break;
//             default:
//                 $message = "L'opérateur n'est pas valide";
//                 break;
//         }
//     }
//     return new Response($message);
// }


//Correction 2 :
// #[Route('/calculerex/{nbr1}/{nbr2}/{operateur}', name:'app_calculer_exception')]
//     public function calculateException($nbr1, $nbr2, $operateur) : Response 
//     {
//         //try (si le code plante on passe dans le catch et on récupére notre exception)
//         try {
//             //opérateur ternaire (si nbr1 ou nbr2) n'est pas un nombre on crée une nouvelle exception
//             !is_numeric($nbr1) || !is_numeric($nbr2)?throw new \Exception("nbr1 ou nbr2 ne sont pas des nombres"):null;
//             //switch case de l'opérateur
//             switch ($operateur) {
//                 case "add":
//                     $message = "Le résultat de l'addition est égal à : " . ($nbr1 + $nbr2);
//                     break;
//                 case "sub":
//                     $message = "Le résultat de la soustraction est égal à : " . ($nbr1 - $nbr2);
//                     break;
//                 case "multi":
//                     $message = "Le résultat de la multiplication est égal à : " . ($nbr1 * $nbr2);
//                     break;
//                 case "div":
//                     //opérateur ternaire si nbr2 == 0 on crée une nouvelle exception
//                     $nbr2 == 0?throw new \Exception("la division par zéro est impossible"):null;
//                     $message = "Le résultat de la division est égal à : " . ($nbr1 / $nbr2);
//                     break;
//                 //si l'opérateur n'est pas (add ou sub ou multi ou div)
//                 default:
//                     $message = "L'opérateur n'est pas valide";
//                     break;
//             }
            
//         }
//         //récupérer l'exception si le try crache
//         catch (\Throwable $th) {
//             $message = "Erreur : " . $th->getMessage();
//         }
//         //retourner la réponse
//         return new Response($message);
//     }


?>