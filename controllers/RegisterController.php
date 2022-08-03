<?php

/**
 * 
 * 
 */
class RegisterController extends BaseController {

	// Initialisation du contructeur par défaut
	public function __construct()
    {
    	parent::__construct();
   	}

	// Index Page d'inscription
	public function index($params=array()) {
		
		
		$request = $this->httpRequest->request;

	
		// on vérifie si le formulaire a été envoyé 
		if( $this->httpRequest->isMethod('POST'))
		{
			
			// Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if(  !empty($request->get("email")) && !empty($request->get("username")) && !empty($request->get("password"))
			)
			{

				$usernameVerify = $this->antiXss->xss_clean($request->get("username"));
				$emailVerify = $this->antiXss->xss_clean($request->get("email"));
				$passwordVerify = $this->antiXss->xss_clean($request->get("password"));
				
				
				// username unique
				
				// on vérifie l'adresse email
				if(!filter_var($emailVerify, FILTER_VALIDATE_EMAIL)){
					header('Location: /message/L\'adresse email est incorrecte'); 
					exit;

					
				}
				// on vérifie si l'adresse email n'existe pas

				$checkUserEmail = new Register();
				$checkUserEmail = $checkUserEmail->checkUserEmail($emailVerify);
				
				if($checkUserEmail != false)
				{
					header('Location: /message/Cette adresse email est déjà utilisée'); 
					exit;

				}

				// on vérifie si le pseudo n'existe pas
				$checkUsername = new Register();
				$checkUsername = $checkUsername->checkUsername($usernameVerify);

				if($checkUsername != false)
				{
					header('Location: /message/Ce pseudo est déjà utilisé'); 
					exit;

				}

				// On hash le mot de passe
				$password = password_hash($passwordVerify, PASSWORD_ARGON2ID);

				$register = new Register();
				$register->addUser($emailVerify, $usernameVerify, $password);

			

				// on stocke dans $_session les information de l'utilisateur
				$this->httpSession->set('user', [
					"username" => $usernameVerify,
					"email" => $emailVerify,
					"roles" => ["ROLE_USER"],
				]);

				header('Location: /'); 
				exit;


			}else{
				// Le formulaire n'est pas complet
				header('Location: /message/Le Formulaire est imcomplet'); 
				exit;

			}
		}
	
		$template = $this->twig->load('register/index.html');
		$render = $template->render([]);
		$this->display($render);

	}


}