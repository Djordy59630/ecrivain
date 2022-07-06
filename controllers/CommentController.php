<?php

require('../models/Comment.php');
/**
 *
 */
class CommentController extends BaseController {


    public function new()
    {

        if(!empty($_POST))
		{
           
            // Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if( isset($_POST["comment"], $_POST["article"]) &&  
			!empty($_POST["comment"])&&  
			!empty($_POST["article"])
			)
            {
               
                $user = $_SESSION["user"]["id"];

                $comment = new Comment();
				$comment->new($user, $_POST["comment"], $_POST["article"]);


                header('Location: /');
            }
            
        
        }

    }
}