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

				

				// on vérifie que l'email en est un
				if(!filter_var($request->get("email"), FILTER_VALIDATE_EMAIL)){
					die("ce n'est pas un email");
				}
				
				$userLogin = new Login();
				$user = $userLogin->userLogin($request->get("email"));

			
				// Ici on a un user existant, on peut vérifier le mot de passe
				if(!$user || !password_verify($request->get("password"), $user["pwd"]) ){
					die("L'utilisateur et/ou le mot de passe est incorrect");
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

			}
		}
	
		$template = $this->twig->load('login/index.html');
		echo $template->render([]);
	}

	// Logout
	public function logout() {

		$this->httpSession->remove('user');
		header('Location: /'); 
	}

}