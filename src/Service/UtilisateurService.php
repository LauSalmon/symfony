<?php

namespace App\Service;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;

class UtilisateurService{

    public function __construct(
        private EntityManagerInterface $em, 
        private UtilisateurRepository $repo){
        $this->em = $em;
        $this->repo = $repo;
    }
    public function create(?Utilisateur $utilisateur) : bool{

        //test si l'objet existe
        if($utilisateur){
            //tester si elle existe deja en BDD
            if(!$this->repo->findOneBy(["email"=>$utilisateur->getEmail()])){
                $this->em->persist($utilisateur);
                $this->em->flush();    
                return true;   
            }
            return false;
        }
        return false;
    }
}