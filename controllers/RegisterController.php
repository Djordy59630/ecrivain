<?php
require('../models/Register.php');

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
				// Le Formulaire est complet
				// On récupère les données en les protégeant 
				$username = strip_tags($request->get("username"));
				// username unique
				
				// on vérifie l'adresse email
				if(!filter_var($request->get("email"), FILTER_VALIDATE_EMAIL)){
					die("L'adresse email est incorrecte");
				}
				// on vérifie si l'adresse email n'existe pas

				$checkUserEmail = new Register();
				$checkUserEmail = $checkUserEmail->checkUserEmail($request->get("email"));
				
				if($checkUserEmail != false)
				{
					die("Cette adresse email est déjà utilisée");
				}

				// on vérifie si le pseudo n'existe pas
				$checkUsername = new Register();
				$checkUsername = $checkUsername->checkUsername($username);

				if($checkUsername != false)
				{
					die("Ce pseudo est déjà utilisé");
				}

				// On hash le mot de passe
				$password = password_hash($request->get("password"), PASSWORD_ARGON2ID);

				$register = new Register();
				$register->addUser($request->get("email"), $request->get("username"), $password);

				
				// on connecte l'utilisateur
				session_start();

				//e on stocke dans $_session les information de l'utilisateur
				$_SESSION["user"] = [
					"username" => $username,
					"email" => $request->get("email"),
					"roles" => ["ROLE_USER"],
				];

				header('Location: /'); 

			}else{
				// Le formulaire n'est pas complet
				die("Le Formulaire est imcomplet");
			}
		}
	
		$template = $this->twig->load('register/index.html');
		echo $template->render([]);
	}


}