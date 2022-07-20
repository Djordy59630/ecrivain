<?php

require('../models/Comment.php');
/**
 *
 */
class CommentController extends BaseController {


    public function new()
    {

        $request = $this->httpRequest->request;

        if(!empty($request))
		{
            // Le formulaire a été envoyé
			// on vérifie que TOUS les champs sont remplis
			if(!empty($request->get("comment")) &&  !empty($request->get("article")))
            {
                $user = $_SESSION["user"]["id"];

                $comment = new Comment();
				$comment->new($user, $request->get("comment"), $request->get("article"));

                header('Location: /');
            }
            
        
        }

    }
}