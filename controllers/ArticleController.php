<?php

require('../models/Article.php');

use Cocur\Slugify\Slugify;



/**
 *
 */
class ArticleController extends BaseController {


    public function new()
    {
        $this->checkUserRoles();

        $request = $this->httpRequest->request;

        if(!empty($request))
		{
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( !empty($request->get("title")) && !empty($request->get("chapo")) && !empty($request->get("content"))
			)
            {
                $title = $this->antiXss->xss_clean($request->get("title"));
                $chapo = $this->antiXss->xss_clean($request->get("chapo"));
                $content = $this->antiXss->xss_clean($request->get("content"));

                $slugify = new Slugify();
                $titleSlug = $slugify->slugify($title);
               
                $article = new Article();
				$article->new($title, $chapo, $content, $titleSlug);

                header('Location: /admin/');
            }
        }

         // on choisi la template à appeler
         $template = $this->twig->load('article/new.html');

         // Puis on affiche la page avec la méthode render
         $render = $template->render([]);
         echo $render;
         
    }

    public function edit($slug)
    {

        $this->checkUserRoles();

        $article = new Article();
        $currentArticle = $article->show($slug);

        $request = $this->httpRequest->request;

        if(!empty($request))
		{
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( !empty($request->get("title")) && !empty($request->get("chapo")) && !empty($request->get("content"))
			)
            {

                $title = $this->antiXss->xss_clean($request->get("title"));
                $chapo = $this->antiXss->xss_clean($request->get("chapo"));
                $content = $this->antiXss->xss_clean($request->get("content"));

                $slugify = new Slugify();
                $titleSlug = $slugify->slugify($title);
               
                $article = new Article();
				$article->edit($title, $chapo, $content, $titleSlug, $currentArticle['id']);
                
                header('Location: /admin/');
            }
        }
         // on choisi la template à appeler
         $template = $this->twig->load('article/edit.html');

         // Puis on affiche la page avec la méthode render
         $render = $template->render(['article' => $currentArticle]);
         echo $render;
        
    }


    public function delete($id)
    {
        $this->checkUserRoles();

        $article = new Article();
        $article = $article->delete($id);
         // on choisi la template à appeler
         header('Location: /admin/');;
    }

    public function show($slug)
    {

        $this->checkUserRoles();
        
        $article = new Article();
        $article = $article->show($slug);

        $comment = new Comment();
        $comments = $comment->show($article["id"]);

         // on choisi la template à appeler
         $template = $this->twig->load('article/show.html');

         // Puis on affiche la page avec la méthode render
         $render = $template->render(['article' => $article, 'comments' => $comments]);
         echo $render;
        
    }

}