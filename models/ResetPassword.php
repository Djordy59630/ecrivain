<?php


class ResetPassword extends DbConnect {

    public function setToken($email, $token){

        $db = $this->connect();
        $sql = "UPDATE user SET `token` = :token, `expireAt` = NOW() WHERE `email` = :email";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':token', $token);
        $query->execute();
        $user =  $query->fetch();
    }

    public function deleteToken($user){

        $db = $this->connect();
        $sql = "UPDATE user SET `token` = :token WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $user);
        $query->bindValue(':token', "NULL");
        $query->execute();
        $user =  $query->fetch();
    }

    public function checkUser($token){

        $db = $this->connect();
        $sql = "SELECT * FROM user WHERE `token` = :token";
        $query = $db->prepare($sql);
        $query->bindValue(':token', $token);
        $query->execute();
        $user =  $query->fetch();

        return $user;
    }

    public function updatePassword($password, $user){

        $db = $this->connect();
        $sql = "UPDATE user SET `pwd` = :pwd WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $user);
        $query->bindValue(':pwd', $password);
        $query->execute();
        $user =  $query->fetch();

    }
}
