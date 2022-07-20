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
		echo $template->render(['articles' => $articles]);
	}

	// Page d'accueil
	public function contact() {
		

		$request = $this->httpRequest->request;

		// on vérifie si le formulaire a été envoyé 
		if(!empty($request))
		{
	
			if(empty($request->get("email")) && !empty($request->get("username")) && !empty($request->get("message")) )
			{
				
				// on vérifie l'adresse email
				if(!filter_var($request->get("email"), FILTER_VALIDATE_EMAIL)){
					die("L'adresse email est incorrecte");
				}

				$message = $request->get("message") . " Adresse mail de l'expéditeur : " . $request->get("email");
				$headers = 'content-type: text/plain; charset="utf-8"'." ";
			

				if(mail('dev@artsetco.com', $request->get("username") . ' vous a envoyé un message', $message, $headers))
                {
					die('mail envoyé');
                }
                else
                {
                    die('Une erreur est survenue"');
                }

			}
		
		}
			
	}

}