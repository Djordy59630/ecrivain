<?php

/**
 *
 */
class AdminController extends BaseController {


    public function index()
    {
         // on choisi la template à appeler
         $template = $this->twig->load('admin/index.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render([]);
        
    }

}