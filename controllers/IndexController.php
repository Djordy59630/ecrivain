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
		
		// on vérifie si le formulaire a été envoyé 
		if(!empty($_POST))
		{
	
			if(isset($_POST['email']) && !empty($_POST['username']) && !empty($_POST['message']) )
			{
				
				// on vérifie l'adresse email
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					die("L'adresse email est incorrecte");
				}

				$message = $_POST['message'] . " Adresse mail de l'expéditeur : " . $_POST['email'];
				$headers = 'content-type: text/plain; charset="utf-8"'." ";
			

				if(mail('dev@artsetco.com', $_POST['username'] . ' vous a envoyé un message', $message, $headers))
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