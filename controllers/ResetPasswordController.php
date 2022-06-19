<?php

use Carbon\Carbon;

require('../models/ResetPassword.php');

/**
 * 
 * 
 */
class ResetPasswordController extends BaseController {

	// Initialisation du contructeur par défaut
	public function __construct()
    {
    	parent::__construct();
   	}

	// Index Page Reset password
	public function index($params=array()) {
		
		// on vérifie si le formulaire a été envoyé 
		if(!empty($_POST))
		{
			// Le formulaire a été envoyé 
			// on vérifie que TOUS les champs sont remplis
			if(isset($_POST['email']) && !empty($_POST['email']))
			{
				$token = uniqid();
                $url = "http://mvc/resetpasswordIsValid/?token=$token";
                
                $message = "Bonjour, voici votre lien pour la réinitialisation de mot de passe : $url";
                $headers = 'content-type: text/plain; charset="utf-8"'." ";

                // on vérifie l'adresse email
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					die("L'adresse email est incorrecte");
				}

                if(mail($_POST['email'], 'Mot de passe oublié', $message, $headers))
                {
                    $resetPassword = new ResetPassword();
				    $resetPassword = $resetPassword->setToken($_POST["email"], $token);
                }
                else
                {
                    die('Une erreur est survenue"');
                }
                
			}
		}
	
		$template = $this->twig->load('reset_password/index.html');
		echo $template->render([]);
	}

    // Index Page d'inscription
	public function newPassword($params=array()) {
		
        // Le formulaire a été envoyé 
        // on vérifie le token
        if(!empty($_GET['token']))
        {
			$checkUser = new ResetPassword();
			$user = $checkUser->checkUser($_GET['token']);

			$created = new Carbon($user['expireAt']);
			$now = Carbon::now();
			$difference = ($created->diff($now)->days);

			// on vérifie si le formulaire a été envoyé 
			if(!empty($_POST) && $difference < 1 )
			{
				// On hash le mot de passe
				$password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

				$updatePassword = new ResetPassword();
				$updatePassword->updatePassword($password, $user['id']);
				
				$deleteToken = new ResetPassword();
				$deleteToken->deleteToken($user['id']);

				header('Location: /'); 
			}

			if($user)
			{
				$template = $this->twig->load('reset_password/new_password.html');
				echo $template->render([]);
			}
           
			
        }
	
	}
}