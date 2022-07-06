<?php

require_once("DbConnect.php");

class Comment extends DbConnect {

    public function index(){

        $db = $this->connect();
        $sql = "SELECT * FROM  comment";
        $query = $db->prepare($sql);
        $query->execute();
        $articles =  $query->fetchAll();

        return $comments;
    }

    public function new($user, $comment, $article){
        $db = $this->connect();
        $sql = "INSERT INTO comment (`content`,`isValid`, `user_id` , `article_id`) VALUES (:content, :isValid, :user, :article)";
        $query = $db->prepare($sql);
        $query->bindValue(':content', $comment);
        $query->bindValue(':isValid', 0);
        $query->bindValue(':user', $user);
        $query->bindValue(':article', $article);
        $query->execute();
    }

    public function show($articleId){

        $db = $this->connect();
        $sql = 
        "SELECT u.username,c.createdAt, c.content FROM comment c
        JOIN user u ON u.id = c.user_id 
        WHERE `article_id` = :article AND `isValid` = 1";
        $query = $db->prepare($sql);
        $query->bindValue(':article', $articleId);
        $query->execute();
        $comments =  $query->fetchAll();

        return $comments;
    }

}
