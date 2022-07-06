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


                header('Location: /admin/');
            }
        }

         // on choisi la template à appeler
         $template = $this->twig->load('article/new.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render([]);
        
    }

    public function edit($slug)
    {

        $article = new Article();
        $currentArticle = $article->show($slug);


        // var_dump($article['id']);
        // die;

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
				$article->edit($_POST["title"], $_POST["chapo"], $_POST["content"], $titleSlug, $currentArticle['id']);
                
                header('Location: /admin/');
            }
        }
         // on choisi la template à appeler
         $template = $this->twig->load('article/edit.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render(['article' => $currentArticle]);
        
    }


    public function delete($id)
    {

        $article = new Article();
        $article = $article->delete($id);

         // on choisi la template à appeler
         header('Location: /admin/');;
        
    }

    public function show($slug)
    {

        $article = new Article();
        $article = $article->show($slug);

        $comment = new Comment();
        $comments = $comment->show($article["id"]);

         // on choisi la template à appeler
         $template = $this->twig->load('article/show.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render(['article' => $article, 'comments' => $comments]);
        
    }

}