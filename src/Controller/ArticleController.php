<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="app_article_detail", requirements={"id"="\d+"})
     */
    public function detail(Article $article): Response
    {

        return $this->render('article/index.html.twig',compact("article"));
    }

    /**
     * @Route("/articles", name="app_article_list")
     */
    public function list(ArticleRepository $repo): Response
    {
        return $this->render('article/list.html.twig',["articles"=>$repo->findAll()]);
    }

    /**
     * @Route("/article/delete", name="app_article_delete")
     */
    public function delete(Request $request,ArticleRepository $repo){
       
        $id = $request->request->get("id");
        if($this->isCsrfTokenValid("coucou".$id,$request->request->get("_token"))){
            $repo->remove($repo->find($id),true);
            $this->addFlash("success","L'article a bien été supprimé!");
            return $this->redirectToRoute("app_article_list");
        }
        $this->addFlash("danger","L'article n'a été supprimé!");
        return $this->redirectToRoute("app_article_list");
    }

    /**
     * @Route("/article/modifier/{id}", name="app_article_edit")
     */
    public function edit(Article $article,Request $request,EntityManagerInterface $em): Response
    {
        $articleForm = $this->createForm(ArticleType::class,$article);
        $articleForm->handleRequest($request);

         // validation
         if($articleForm->isSubmitted() && $articleForm->isValid()){
            // update dans BDD          
            $em->flush();
            // ajouter un message
            $this->addFlash("success","L'article a bien été modifié!");
            // redirection vers la page détail
            return $this->redirectToRoute("app_article_detail",["id"=>$article->getId()]);
        }

        return $this->render('article/edit.html.twig',["articleForm"=>$articleForm->createView()]);
    }    

    /**
     * @Route("/article/ajouter",name="app_article_add")
     */
    public function add(Request $request,ArticleRepository $articleRepository){
        /**
         * 1.Créer une instance de l'entité
         */
         $article = new Article();
        /**
        * 2. Créer une instance du formulaire
        */
        $articleForm = $this->createForm(ArticleType::class,
        $article);
        /**
         * recup les datas depuis request
         */
        $articleForm->handleRequest($request);
        // validation
        if($articleForm->isSubmitted() && $articleForm->isValid()){
            // persister dans BDD          
            $articleRepository->add($article,true);
            // ajouter un message
            $this->addFlash("success","L'article a bien été ajouté!");
            // redirection vers la page détail
            return $this->redirectToRoute("app_article_detail",["id"=>$article->getId()]);
        }
        /**
         * 3. Passer le formulaire à Twig
         */
        return $this->render("article/add.html.twig",
        ["articleForm"=>$articleForm->createView()]);

    }
}
