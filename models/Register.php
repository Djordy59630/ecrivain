<?php


class Register extends DbConnect {

    public function addUser($email, $username, $password){

        $db = $this->connect();
        $sql = "INSERT INTO user (`email`,`username`, `pwd` , `user_roles`) VALUES (:email, :username, :pwd, :user_roles)";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':username', $username);
        $query->bindValue(':pwd', $password);
        $query->bindValue(':user_roles', 'ROLE_USER');
        $query->execute();
    }

    public function checkUserEmail($email){

        $db = $this->connect();
        $sql = "SELECT * FROM  user WHERE `email` = :email";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email);
        $query->execute();
        $user =  $query->fetch();

        return $user;

    }

    public function checkUsername($username){

        $db = $this->connect();
        $sql = "SELECT * FROM  user WHERE `username` = :username";
        $query = $db->prepare($sql);
        $query->bindValue(':username', $username);
        $query->execute();
        $user =  $query->fetch();

        return $user;

    }
}
