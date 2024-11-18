<?php
class User {

    private $username;
    private $password;
    private $role = 1;

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

        $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");

        // echo $password;
        $query = $conn->prepare("
        INSERT INTO tl_user(username, password, role)
        VALUES (:username, :password, 0);
        ");

        $username = $this->getUsername();
        $password = $this->getPassword();

        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);
        $query->execute();
    }

    public function login(){

        
        $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");

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

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }
}