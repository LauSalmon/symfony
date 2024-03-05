<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UtilisateurType;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    private UtilisateurRepository $utilisateurRepository;

    #[Route('/utilisateur/add', name: 'app_utilisateur_add')]
    public function addUser(Request $request, EntityManagerInterface $em): Response{

        $msg = "";
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        $verifyEmail = $this->utilisateurRepository->findOneBy(['email' => $utilisateur->getEmail()]);

        //Verifier si le formulaire est soumis
        if($form->isSubmitted()){

            if(!$verifyEmail){

                $utilisateur->setPassword(md5($utilisateur->getPassword()));

                $em->persist($utilisateur);
                $em->flush();

                $msg = "L'utilisateur a bien été ajoutée en BDD";
                                
            }else {
            $msg = "Les informations sont incorrects !";

            }
        }

        return $this->render('utilisateur/index.html.twig', [
            'form' => $form->createView(), 
            'msg' => $msg,
        ]);
    }
}
