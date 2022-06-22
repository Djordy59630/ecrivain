<?php

/**
 *
 */
class ArticleController extends BaseController {


    public function new()
    {
         // on choisi la template à appeler
         $template = $this->twig->load('article/new.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render([]);
        
    }

}