<?php

/**
 * 
 * 
 */
class ErrorController extends BaseController {

	public function index() {
		  // on choisi la template à appeler
		  $template = $this->twig->load('errors/404.html');

		  // Puis on affiche la page avec la méthode render
		  echo $template->render();
	}

	public function message($message) {

		// on choisi la template à appeler
		$template = $this->twig->load('errors/message.html');

		// Puis on affiche la page avec la méthode render
		echo $template->render(['message' => $message]);
  }

}