<?php

require('../models/Article.php');


/**
 *
 */
class ArticleController extends BaseController {


    public function new()
    {

        if(!empty($_POST))
		{
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( isset($_POST["title"], $_POST["chapo"], $_POST["content"]) &&  
			!empty($_POST["title"]) && !empty($_POST["chapo"]) && !empty($_POST["content"])
			)
            {
                $article = new Article();
				$article->new($_POST["title"], $_POST["chapo"], $_POST["content"]);

            }
        }

         // on choisi la template à appeler
         $template = $this->twig->load('article/new.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render([]);
        
    }

}