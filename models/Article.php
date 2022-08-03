<?php

class Article extends DbConnect {

    public function index(){

        $db = $this->connect();
        $sql = "SELECT * FROM  article";
        $query = $db->prepare($sql);
        $query->execute();
        $articles =  $query->fetchAll();

        return $articles;
    }

    public function new($title, $chapo, $content, $slug){
        $db = $this->connect();
        $sql = "INSERT INTO article (`title`,`chapo`, `content` , `slug`, `createdAt`, `updatedAt`) VALUES (:title, :chapo, :content, :slug, NOW(), NOW())";
        $query = $db->prepare($sql);
        $query->bindValue(':title', $title);
        $query->bindValue(':chapo', $chapo);
        $query->bindValue(':content', $content);
        $query->bindValue(':slug', $slug);
        $query->execute();
        $this->updateSlug($db->lastInsertId(), $slug);
    }

    public function updateSlug($id,$slug){
        $db = $this->connect();
        $sql = "UPDATE article SET `slug` = :slug WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->bindValue(':slug', $id . '-' .$slug);
        $query->execute();
        $user =  $query->fetch();
    }

    public function edit($title, $chapo, $content, $slug, $id){

        $db = $this->connect();
        $sql = "UPDATE article SET `title` =  :title, `chapo` = :chapo, `content` = :content, `slug` = :slug WHERE `id` = $id";
        $query = $db->prepare($sql);
        $query->bindValue(':title', $title);
        $query->bindValue(':chapo', $chapo);
        $query->bindValue(':content', $content);
        $query->bindValue(':slug', $id . '-' .$slug);
        $query->execute();
    }

    public function show($slug){

        $db = $this->connect();
        $sql = "SELECT * FROM article WHERE `slug` = :slug";
        $query = $db->prepare($sql);
        $query->bindValue(':slug', $slug);
        $query->execute();
        
        $article =  $query->fetch();
        return $article;
    }

    public function delete($id){

        $db = $this->connect();
        $sql = "DELETE FROM article WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
    }
}
