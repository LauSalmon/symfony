<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UtilsService;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository) 
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/', name: 'app_article_all')]
    public function articleAll(): Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('article/article_all.html.twig', [
            'articles' => $articles,
        ]);
    }


    #[Route('/article/id/{id}',name:'app_article_id', methods:'GET')]
    public function articleById($id) : Response 
    {
        $article = $this->articleRepository->findOneBy(['id' => $id]);
        return $this->render('article/article_detail.html.twig', [
            'article'=> $article,
        ]);
    }

    #[Route('/article/add', name: 'app_article_add')]
    public function addArticle(Request $request, EntityManagerInterface $em, ArticleRepository $ar): Response{

        $msg = "";
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        //Verifier si le formulaire est soumis
        if($form->isSubmitted() and $form->isValid()){

            //nettoyer les entrées
            $article->setTitre(UtilsService::cleanInput($article->getTitre()));
            $article->setContenu(UtilsService::cleanInput($article->getContenu()));
            $article->setDateCreation(new \DateTimeImmutable(UtilsService::cleanInput($form->getData()->getDateCreation()->format('d-m-Y'))));
            //tester si le champ est complété
            if($article->getUrlImg()) {
                $article->setUrlImg(UtilsService::cleanInput($article->getUrlImg()));
            }

            if(!$ar->findOneBy(['titre' => $article->getTitre(), 'contenu' => $article->getContenu()])){

                $em->persist($article);
                $em->flush();

                $msg = "L'article a bien été ajoutée en BDD";

            }else {

                $msg = "L'article est déjà enregistré en BDD !";
            }

        }

        return $this->render('article/index.html.twig', [
            'form' => $form->createView(), 
            'msg' => $msg,
        ]);
    }

    #[Route('/article/update/{id}',name:'app_update_article')]
    public function updateArticle(Request $request, $id,EntityManagerInterface $em, ArticleRepository $ar) : Response {

        $article = $this->articleRepository->find($id);

        if(!$article){
            return $this->redirectToRoute('app_article_all');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if($form->isSubmitted() and $form->isValid()){

            //nettoyer les entrées
            $article->setTitre(UtilsService::cleanInput($article->getTitre()));
            $article->setContenu(UtilsService::cleanInput($article->getContenu()));
            $article->setDateCreation(new \DateTimeImmutable(UtilsService::cleanInput($form->getData()->getDateCreation()->format('d-m-Y'))));
            //tester si le champ est complété
            if($article->getUrlImg()) {
                $article->setUrlImg(UtilsService::cleanInput($article->getUrlImg()));
            }

            if(!$ar->findOneBy(['titre' => $article->getTitre(), 'contenu' => $article->getContenu()])){

                $em->persist($article);
                $em->flush();

                $msg = "L'article a bien été ajoutée en BDD";

            }else {

                $msg = "L'article est déjà enregistré en BDD !";
            }

        }
        return $this->render('article/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

}