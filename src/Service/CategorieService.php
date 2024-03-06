<?php

namespace App\Service;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;

class CategorieService{

    public function __construct(
        private EntityManagerInterface $em, 
        private CategorieRepository $repo){
        $this->em = $em;
        $this->repo = $repo;
    }
    public function create(?Categorie $categorie) : bool{

        //test si l'objet existe
        if($categorie){
            //tester si elle existe deja en BDD
            if(!$this->repo->findOneBy(["nom"=>$categorie->getNom()])){
                $this->em->persist($categorie);
                $this->em->flush();    
                return true;   
            }
            return false;
        }
        return false;
    }
}