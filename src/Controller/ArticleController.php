<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{

    public function __construct(EntityManagerInterface $manager)
    
    {
        $this->manager = $manager;
    }


    /**
     * @Route("admin/article", name="app_article")
     */
    public function index(Request $request): Response
    {
        $article = new Article();// Nouvelle instance de l'article
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        // récuperer l'utilisteur connecter et envoyer le prenom dans le setAuteur 
            //dd($this->getUser());
            //dd($this->getUser()->getPrenom);

        
            $article->setAuteur($this->getUser()->getNomComplet());
        

            $this->manager->persist($article); //prépare l'envoie des données
            $this->manager->flush(); //envoie des données

        }


        return $this->render('article/index.html.twig', [
            'FormArticle' => $form->createView(), ///  creatView() matérialise l'affichage dans la vue
        
        
        ]);
    }

    
    /**
     * @Route("admin/article/delete/{id}", name="app_article_delete")
     */
    public function articleDelete(Article $article): Response
    {
       $this->manager->remove($article);
       $this->manager->flush();
       return $this->redirectToRoute('app_home');

        }

  /**
     * @Route("admin/article/update/{id}", name="app_article_update")
     */
     public function articleUpdate(Article $article, Request $request): Response

     { 
        $formUpdate = $this->createForm(ArticleType::class,$article);
        $formUpdate->handleRequest($request);
        if($formUpdate->isSubmitted() && $formUpdate->isValid()){
        $this->manager->persist($article); //prépare l'envoie des données
        $this->manager->flush(); //envoie des données

        }
         
        return $this->render('article/updateArticle.html.twig', [
            'FormArticle' => $formUpdate->createView(), ///  creatView() matérialise l'affichage dans la vue
        
        
        ]);

    }

}
