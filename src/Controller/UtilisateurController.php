<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UtilisateurType;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use App\Service\UtilsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur/add', name: 'app_utilisateur_add')]
    public function addUtilisateur(Request $request, EntityManagerInterface $em, UtilisateurRepository $ur): Response{

        $msg = "";
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        $verifyEmail=$ur->findOneBy(['email' => $utilisateur->getEmail()]);

        //Verifier si le formulaire est soumis
        if($form->isSubmitted()){

             //nettoyer les entrées
             $utilisateur->setNom(UtilsService::cleanInput($utilisateur->getNom()));
             $utilisateur->setPrenom(UtilsService::cleanInput($utilisateur->getPrenom()));
             $utilisateur->setEmail(UtilsService::cleanInput($utilisateur->getEmail()));
             $utilisateur->setPassword(UtilsService::cleanInput($utilisateur->getPassword()));
             //tester si le champ est complété
             if($utilisateur->getUrlImg()) {
                 $utilisateur->setUrlImg(UtilsService::cleanInput($utilisateur->getUrlImg()));
             }

            //Verifier si le compte n'existe pas deja avec l'email
            if(!$verifyEmail){

                $utilisateur->setPassword(md5($utilisateur->getPassword()));

                $em->persist($utilisateur);
                $em->flush();

                $msg = "L'utilisateur a bien été ajoutée en BDD";

            }else {

                $msg = "Les informations sont incorrectes !";

            }
        }

        return $this->render('utilisateur/index.html.twig', [
            'form' => $form->createView(), 
            'msg' => $msg,
        ]);
    }
}
