<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{

    /**
     * @Route("/",name="app_main_home")
     */
    public function home():Response{
        $name = "Adel";
        return $this->render("main/home.html.twig",[
            "name"=>$name
        ]);
    }

    /**
     * @Route("/blog/article/{slug}",name="app_main_blog",requirements={"slug"="[0-9a-zA-Z\-]+"})
     */
    public function blog($slug):Response{
        return new Response("Article ".$slug);
    }

}