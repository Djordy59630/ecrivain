<?php

require_once("DbConnect.php");

class Login extends DbConnect {

    public function userLogin($email){

        $db = $this->connect();
        $sql = "SELECT * FROM  user WHERE `email` = :email";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email);
        $query->execute();
        $user =  $query->fetch();
        
        return $user;

    }
}
