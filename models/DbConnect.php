<?php

class DbConnect {

    public function connect(){

        try {

            $config = new Config();
            $params = $config->load();
            $hostname = $params['hostname'];
            $dbname   = $params['dbname'];
            $username = $params['user'];
            $password = $params['password'];




            $dBUsername = "root";
            $dBUPassword = "";
            $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            return $dbh;
        }
        catch(PDOException $e){
            print "Error DB!" .$e->getMessage() . "<br/>";
            throw new \Exception('DB ERROR');
        }
    }

}