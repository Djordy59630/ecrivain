<?php

require('../models/Article.php');

use Cocur\Slugify\Slugify;



/**
 *
 */
class ArticleController extends BaseController {


    public function new()
    {
        $request = $this->httpRequest->request;

        if(!empty($request))
		{
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( !empty($request->get("title")) && !empty($request->get("chapo")) && !empty($request->get("content"))
			)
            {
                $slugify = new Slugify();
                $titleSlug = $slugify->slugify($request->get("title")); // hello-world
               
                $article = new Article();
				$article->new($request->get("title"), $request->get("chapo"), $request->get("content"), $titleSlug);

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

        $request = $this->httpRequest->request;

        if(!empty($request))
		{
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( !empty($request->get("title")) && !empty($request->get("chapo")) && !empty($request->get("content"))
			)
            {
                $slugify = new Slugify();
                $titleSlug = $slugify->slugify($request->get("title")); // hello-world
               
                $article = new Article();
				$article->edit($request->get("title"), $request->get("chapo"), $request->get("content"), $titleSlug, $currentArticle['id']);
                
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