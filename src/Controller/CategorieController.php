<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategorieType;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CategorieService;

class CategorieController extends AbstractController
{
    public function __construct(private CategorieService $cs){
        $this->cs = $cs;
    }
    #[Route('/categorie/add', name: 'app_categorie_add')]
    public function addCategorie(Request $request): Response
    {
        $msg = "";
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        //Verifier si le formulaire est soumis
        if($form->isSubmitted()){
            
            if($this->cs->create($categorie)){
                $msg = "La catégorie a bien été ajoutée en BDD";
            }else {
                $msg = "Enregistrement impossible";
            }
 
        }
        return $this->render('categorie/index.html.twig', [
            'form' => $form->createView(), 
            'msg' => $msg,
        ]);
    }
}
