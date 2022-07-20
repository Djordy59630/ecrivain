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
              
                $commentVerify = $this->antiXss->xss_clean($request->get("comment"));

                $user = $this->httpSession->get('user')['id'];

                $comment = new Comment();
				$comment->new($user, $commentVerify, $request->get("article"));

                header('Location: /');
            }
        }
    }

    public function management($id)
    {
        $this->checkUserRoles();

        $commentsIsValid = new Comment();
        $commentsIsValid = $commentsIsValid->show($id);

        $commentsIsNotValid = new Comment();
        $commentsIsNotValid = $commentsIsNotValid->commentIsNotValid($id);

         // on choisi la template à appeler
         $template = $this->twig->load('article/comment.html');

         // Puis on affiche la page avec la méthode render
         echo $template->render(['commentsIsValid' => $commentsIsValid, 'commentsIsNotValid' => $commentsIsNotValid]);
    }

    public function delete($commentId, $articleId)
    {

        $this->checkUserRoles();

        $comment = new Comment();
        $comment = $comment->delete($commentId);

         // on choisi la template à appeler
         header('Location: /comment/' . $articleId . '/');;
    }

    public function valid($commentId, $articleId)
    {

        $this->checkUserRoles();
        
        $comment = new Comment();
        $comment = $comment->valid($commentId);

         // on choisi la template à appeler
         header('Location: /comment/' . $articleId . '/');;
    }
}