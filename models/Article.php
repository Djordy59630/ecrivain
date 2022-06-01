<?php

require_once("DbConnect.php");

class Article extends DbConnect {

    public function index(){

        $db = $this->connect();
        $sql = "SELECT * FROM  article";
        $query = $db->prepare($sql);
        $query->execute();
        $articles =  $query->fetch();

        return $articles;
    }

    public function new(){

       

    }

    public function edit(){

       

    }

    public function show($id){

        $db = $this->connect();
        $sql = "SELECT * FROM article WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $article =  $query->fetch();

        return $article;

    }

    public function delete(){

        $db = $this->connect();
        $sql = "DELETE * FROM article WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
