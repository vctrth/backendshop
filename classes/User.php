<?php

include_once(__DIR__.'/Db.php');

class User {

    private $username;
    private $password;
    private $role;
    private $coins;

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function save(){

    // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
    $conn = Db::getConnection();

        // echo $password;
        $query = $conn->prepare('INSERT INTO tl_user(username, password, role, coins) VALUES (:username, :password, 0, 1000);');

        $username = $this->getUsername();
        $password = $this->getPassword();

        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);
        $query->execute();
    }

    public function login(){

        
        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();

        $username = $this->getUsername();
        $password = $this->getPassword();

        $statement = $conn->prepare("SELECT * FROM tl_user WHERE username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();
        $user = $statement->fetch();

        if(!$user){

            return false;
        } 
        $hash = $user['password'];
        if(password_verify($password, $hash)){
    
            return true;
        }
        else {

            return false;
        }
    }

public function changePassword($oldPassword, $newPassword){

        // $user = $this->getUser();
        $hash = $this->getPassword();
        var_dump($oldPassword);
        if(password_verify($oldPassword, $hash)){
            
            $options = [

                "cost" => 12
            ];
            $this->setPassword(password_hash($newPassword, PASSWORD_DEFAULT, $options));

            $conn = Db::getConnection();
            $query = $conn->prepare('UPDATE tl_user SET password = :password WHERE username = :username');
            $query->bindValue(":username", $this->getUsername());
            $query->bindValue(":password", $this->getPassword());
            $query->execute();

            return true;
        }
        else{

            return false;
        }
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    public function getUser(){
        
        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();

        $username = $this->getUsername();

        $statement = $conn -> prepare('SELECT * FROM tl_user WHERE username = :username');

        $statement->bindValue(":username", $username);
        $statement->execute();
    
        return($statement->fetch(PDO::FETCH_ASSOC));
    }

    public static function sGetUser($username){
        
        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();

        $statement = $conn -> prepare('SELECT * FROM tl_user WHERE username = :username');

        $statement->bindValue(":username", $username);
        $statement->execute();
    
        return($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get the value of coins
     */ 
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * Set the value of coins
     *
     * @return  self
     */ 
    public function setCoins($coins)
    {
        $this->coins = $coins;

        return $this;
    }

    public static function getUserByID($id){
        
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM tl_user WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}