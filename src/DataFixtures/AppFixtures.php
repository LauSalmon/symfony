<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Article;

use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

            $categorie = [];
            for ($i=0; $i<30; $i++){
                //Ajout de catégorie
                $cat = new Categorie();
                $cat->setNom($faker->jobTitle());
                //Persisiter la catégorie
                $manager->persist($cat);
                $categorie[] = $cat;
            }
        
            $users = [];
            for($i=0; $i<50; $i++){
                //Ajout d'un utilisateur
                $user = new Utilisateur();
                $user->setNom($faker->firstName())
                    ->setPrenom($faker->lastName())
                    ->setEmail($faker->freeEmail())
                    ->setPassword($faker->password())
                    ->setUrlImg($faker->imageUrl(640, 480, 'humain', true));

                //On fais persister l'utilisateur
                $manager->persist($user);
                $users[] = $user;                
            }
        

            for($i=0; $i<200; $i++){
                //Ajout d'un article
                $article= new Article();
                $article->setTitre($faker->sentence(3))
                        ->setContenu($faker->paragraph())
                        ->setUrlImg($faker->imageUrl(640, 480, 'Article', true))
                        ->setDateCreation($faker->dateTime())
                        ->setUtilisateur($users[$faker->numberBetween(0, 49)]);

                    // ->addCategory($categorie[$faker->numberBetween(0, 9)])
                    // ->addCategory($categorie[$faker->numberBetween(10, 19)])
                    // ->addCategory($categorie[$faker->numberBetween(20, 29)]);

                $randomCat = array_rand($categorie, 3);
                foreach ($randomCat as $key) {
                    $article->addCategory($categorie[$key]); 
                }

                //On fait persister l'article
                $manager->persist($article);
            }



        $manager->flush();
        
    }
}
