<?php
require('../models/Article.php');

/**
 *
 */
class AdminController extends BaseController {


    public function index()
    {

        $this->checkUserRoles();
        
        $article = new Article();
		$articles = $article->index();

         // on choisi la template à appeler
         $template = $this->twig->load('admin/index.html');

         // Puis on affiche la page avec la méthode render

         $render = $template->render(['articles' => $articles]);
         $this->display($render);


        
    }

}