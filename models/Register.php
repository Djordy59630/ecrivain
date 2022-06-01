<?php

require_once("DbConnect.php");

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
}
