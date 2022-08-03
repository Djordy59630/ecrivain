<?php

require('../models/Article.php');

/**
 * 
 *  
 */
class IndexController extends BaseController {

	// Page d'accueil
	public function index() {

		$article = new Article();
		$articles = $article->index();

        // on choisi la template à appeler
        $template = $this->twig->load('index/index.html');

        // Puis on affiche la page avec la méthode render
		$render = $template->render(['articles' => $articles]);

		$this->display($render);


		
	}

	// Page d'accueil
	public function contact() {
		

		$request = $this->httpRequest->request;

		// on vérifie si le formulaire a été envoyé 
		if(!empty($request))
		{
			if(empty($request->get("email")) && !empty($request->get("username")) && !empty($request->get("message")) )
			{
				
				$email = $this->antiXss->xss_clean($request->get("email"));
				$username = $this->antiXss->xss_clean($request->get("username"));
				$message = $this->antiXss->xss_clean($request->get("message"));

				// on vérifie l'adresse email
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					header('Location: /message/L\'adresse email est incorrecte'); 
					

					
				}

				$message = $message . " Adresse mail de l'expéditeur : " . $email;
				$headers = 'content-type: text/plain; charset="utf-8"'." ";

				if(mail('dev@artsetco.com', $username . ' vous a envoyé un message', $message, $headers))
                {
					header('Location: /message/mail envoyé'); 
					

                }
                else
                {
					header('Location: /message/Une erreur est survenue'); 
					

                }
			}
		}	
	}
}