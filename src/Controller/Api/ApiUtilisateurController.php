<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiUtilisateurController extends AbstractController{

    private UtilisateurRepository $utilisateurRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $manager;
    private UserPasswordHasherInterface $hash;

    public function __construct(UtilisateurRepository $utilisateurRepository,
    SerializerInterface $serializer,
    EntityManagerInterface $manager, UserPasswordHasherInterface $hash ){
        $this->utilisateurRepository = $utilisateurRepository;
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->hash = $hash;
    }

    #[Route('/api/utilisateur/all', name:'app_api_utilisateur_all', methods:'GET')]
    public function getAllUtilisateur() : Response{
        return $this->json($this->utilisateurRepository->findAll(),200,[
            "Access-Control-Allow-Origin" => "*",
        ], ["groups"=>"api"]);
    }

    #[Route('api/utilisateur/add', name:'app_api_utilisateur_add', methods:'POST')]
    public function addUtilisateur(Request $request) : Response{

        //1 récupérer le contenu de la requête
        $data = $request->getContent();

        //2 convertir en objet Utilisateur
        $user = $this->serializer->deserialize($request->getContent(),Utilisateur::class ,"json");

        $newEmail = $user->getEmail();

        if($this->utilisateurRepository->findOneBy(['email' => $newEmail])){
            $message = ["erreur"=>"Non non non !"];
            $code = 400;

            // return $this->json(["erreur"=>"Non non non !"], 400,[
            //     "Access-Control-Allow-Origin" => "*",
            // ]);

        }else {

            //$user->setPassword(password_hash($user->getPassword(),PASSWORD_BCRYPT));

            $user->setPassword(md5($user->getPassword()));
            
            //3 persister la Categorie
            $this->manager->persist($user);

            //Flush (enregister en BDD)
            $this->manager->flush();

            $message = $user;
            $code = 200;

            // return $this->json($user, 200,[
            //     "Access-Control-Allow-Origin" => "*",
            // ]);            
        }

        return $this->json($message, $code,["Access-Control-Allow-Origin" => "*",]);

    }

    //Modifier des infos
    #[Route('api/utilisateur/update', name:'app_api_utilisateur_update', methods:'POST')]
    public function updateUtilisateur(Request $request) : Response {

        //récupérer le contenu de la requête
        $data = $request->getContent();

        //si le json est valide
        if($data){
            //convertir en objet Utilisateur
            $user = $this->serializer->deserialize($data,Utilisateur::class ,"json");

            $updateUser = $this->utilisateurRepository->findOneBy(['email' => $user->getEmail()]);

            if($updateUser){

                $updateUser->setNom($user->getNom());
                $updateUser->setPrenom($user->getPrenom());
                $updateUser->setUrlImg($user->getUrlImg());
                $updateUser->setPassword(md5($user->getPassword()));
                
                //3 persister 
                $this->manager->persist($updateUser);

                //Flush (enregister en BDD)
                $this->manager->flush();

                $message = $user;
                $code = 200;


            }else {

                $message = ["erreur"=>"L'utilisateur n'existe pas encore!"];
                $code = 400;
            }
        }else {
            $message = ["erreur"=>"Le json est invalide"];
            $code = 400;
        }
        return $this->json($message, $code,["Access-Control-Allow-Origin" => "*",]);     
    }

    #[Route('api/utilisateur/{id}', name:'app_api_utilisateur_delete', methods:'DELETE')]
    public function removeUtilisateur($id, ArticleRepository $articleRepository) : Response {
        $user = $this->utilisateurRepository->find($id);

        if($user){
            $articles = $articleRepository->findBy(["utilisateur"=>$user]);
            //boucle pour supprimer les articles lié à l'utilisateur
            foreach ($articles as $article){
                //supprimer les articles
                $this->manager->remove($article);
            }
            //pour supprimer l'utilisateur
            $this->manager->remove($user);
            $this->manager->flush();

            $message = ["Le compte a bien été supprimé"];
            $code = 200;
        }else {
            $message = ["erreur"=>"L'utilisateur n'existe pas!"];
            $code = 400;
        }
        return $this->json($message, $code, ["Access-Control-Allow-Origin" => "*",]);
    }
}