<?php
require('../models/Login.php');

/**
 * 
 * 
 */
class LoginController extends BaseController {

	// Initialisation du contructeur par défaut
	public function __construct()
    {
    	parent::__construct();
   	}

	// Index Page d'inscription
	public function index($params=array()) {
		
		$request = $this->httpRequest->request;

		// on vérifie si le formulaire a été envoyé 
		if(!empty($request))
		{
		
			// Le formulaire a été envoyé 
			// on vérifie que TOUS les champs sont remplis
			if(!empty($request->get("email")) && !empty($request->get("password")))
			{

				$emailVerify = $this->antiXss->xss_clean($request->get("email"));
				$passwordVerify = $this->antiXss->xss_clean($request->get("password"));

				// on vérifie que l'email en est un
				if(!filter_var($emailVerify, FILTER_VALIDATE_EMAIL)){
					header('Location: /message/Ceci n\'est pas un mail'); 
					exit;
				}
				
				$userLogin = new Login();
				$user = $userLogin->userLogin($emailVerify);

			


				// Ici on a un user existant, on peut vérifier le mot de passe
				if(!$user || !password_verify($request->get("password"), $user["pwd"]) ){
					header('Location: /message/L\'utilisateur et/ou le mot de passe est incorrect'); 
					exit;
				}

				// L'utilisateur est le mot de passe sont corrects
				
	
				//e on stocke dans $_session les information de l'utilisateur
				$this->httpSession->set('user', [
					"id" => $user["id"],
					"username" => $user["username"],
					"email" => $user["email"],
					"roles" => $user["user_roles"],
				]);
				
				header('Location: /'); 
				exit;

			}
		}
	
		$template = $this->twig->load('login/index.html');

		$render = $template->render([]);
		print_r ( $render );
	}

	// Logout
	public function logout() {

		$this->httpSession->remove('user');
		header('Location: /'); 
		exit;
	}

}