<?php
//** : DB connection



class Dbh {

    private $host = "127.0.0.1";
    private $user = "root";
    private $pwd = "";
    private $dbName = "townchat";


    protected function connect(){
        try {
            $username = $this->user;
            $password = $this->pwd;
            $dbh = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print 'Error  : ' . $e->getMessage() . '<br>';
            die();
        }
    }
}