<?php

include_once(__DIR__.'/Db.php');

class Product {

    private $name;
    private $artist;
    private $genre;
    private $category_id;
    private $price;
    private $thumbnail;
    private $stock;

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getGenre()

    {
        return $this->genre;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get the value of category_id
     */ 
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of thumbnail
     */ 
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set the value of thumbnail
     *
     * @return  self
     */ 
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get the value of stock
     */ 
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */ 
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of artist
     */ 
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set the value of artist
     *
     * @return  self
     */ 
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    public static function getAll(){

        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM tl_item');
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public static function getProductsByGenre($genre){

        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM tl_item WHERE genre = :genre');
        $statement->bindValue(":genre", $genre);
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    
    public static function getProductsBySearch($query){
        
        
        $conn = Db::getConnection();

        $query = "%".$query."%"; // This allows the search to find any part of the column value that contains the query.

        $statement = $conn->prepare("SELECT * FROM tl_item WHERE name LIKE :query OR artist LIKE :query OR description LIKE :query");
        $statement->bindValue(":query", $query);
        $statement->execute();
        
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public static function getProductByID($id){

        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM tl_item WHERE id = :id');
        $statement->bindValue(":id", $id);
        $statement->execute();

        $products = $statement->fetch();
        return $products;
    }

    public function save(){

        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();
        
        // echo $password;
        $query = $conn->prepare("
        INSERT INTO tl_item(name, artist, genre, price, thumbnail, stock)
        VALUES (:name, :artist, :genre, :price, :thumbnail, :stock);
        ");
        
        $name = $this->getName();
        $artist = $this->getArtist();
        $genre = $this->getGenre();
        $price = $this->getPrice();
        $thumbnail = $this->getThumbnail();
        $stock = $this->getStock();
        
        $query->bindValue(":name", $name);
        $query->bindValue(":artist", $artist);
        $query->bindValue(":genre", $genre);
        $query->bindValue(":price", $price);
        $query->bindValue(":thumbnail", $thumbnail);
        $query->bindValue(":stock", $stock);
        
        $query->execute();
    }
    
    public static function deleteItemById($id){
        
        $conn = Db::getConnection();

        if($id === ""){return;};

        $query = $conn->prepare("DELETE FROM tl_item WHERE id = :givenId");
        $query->bindValue(":givenId", $id);

        $query->execute();
    }
}