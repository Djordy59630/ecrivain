<?php

require_once("DbConnect.php");

class Article extends DbConnect {

    public function index(){

        $db = $this->connect();
        $sql = "SELECT * FROM  article";
        $query = $db->prepare($sql);
        $query->execute();
        $articles =  $query->fetchAll();

        return $articles;
    }

    public function new($title, $chapo, $content){
        $db = $this->connect();
        $sql = "INSERT INTO article (`title`,`chapo`, `content` , `slug`, `createdAt`, `updatedAt`) VALUES (:title, :chapo, :content, :slug, NOW(), NOW())";
        $query = $db->prepare($sql);
        $query->bindValue(':title', $title);
        $query->bindValue(':chapo', $chapo);
        $query->bindValue(':content', $content);
        $query->bindValue(':slug', 'test');
        $query->execute();
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
