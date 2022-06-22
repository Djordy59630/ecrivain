<?php

require('../models/Article.php');
use Cocur\Slugify\Slugify;



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

                $slugify = new Slugify();
                $titleSlug = $slugify->slugify($_POST["title"]); // hello-world
               

                $article = new Article();
				$article->new($_POST["title"], $_POST["chapo"], $_POST["content"], $titleSlug);

            }
        }

         // on choisi la template à appeler
         $template = $this->twig->load('article/new.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render([]);
        
    }

    public function edit($id)
    {
        if(!empty($_POST))
		{
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( isset($_POST["title"], $_POST["chapo"], $_POST["content"]) &&  
			!empty($_POST["title"]) && !empty($_POST["chapo"]) && !empty($_POST["content"])
			)
            {

                $slugify = new Slugify();
                $titleSlug = $slugify->slugify($_POST["title"]); // hello-world
               

                $article = new Article();
				$article->new($_POST["title"], $_POST["chapo"], $_POST["content"], $titleSlug);

            }
        }

         // on choisi la template à appeler
         $template = $this->twig->load('article/edit.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render([]);
        
    }

}