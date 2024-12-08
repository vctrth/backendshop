<?php

include_once(__DIR__.'/Db.php');

class Product {

    private $name;
    private $artist;
    private $genre;
    private $description;
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
        if($price < 0){

            $price = abs($price);
        }
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
        INSERT INTO tl_item(name, artist, description, genre, price, thumbnail, stock)
        VALUES (:name, :artist, :description, :genre, :price, :thumbnail, :stock);
        ");
        
        $name = $this->getName();
        $artist = $this->getArtist();
        $description = $this->getDescription();
        $genre = $this->getGenre();
        $price = floatval($this->getPrice());
        $thumbnail = $this->getThumbnail();
        $stock = intval($this->getStock());
        
        $query->bindValue(":name", $name);
        $query->bindValue(":artist", $artist);
        $query->bindValue(":description", $description);
        $query->bindValue(":genre", $genre);
        $query->bindValue(":price", $price);
        $query->bindValue(":thumbnail", $thumbnail);
        $query->bindValue(":stock", $stock);
        
        $query->execute();
    }

    public function update($selectedId){

        // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $conn = Db::getConnection();
        
        // echo $password;
        $query = $conn->prepare("
        UPDATE tl_item

        SET
            name = :name,
            artist = :artist,
            description = :description,
            genre = :genre,
            price = :price,
            thumbnail = :thumbnail,
            stock = :stock
        WHERE id = :selectedId
        ");
        
        $name = $this->getName();
        $artist = $this->getArtist();
        $description = $this->getDescription();
        $genre = $this->getGenre();
        $price = floatval($this->getPrice());
        $thumbnail = $this->getThumbnail();
        $stock = intval($this->getStock());
        
        $query->bindValue(":name", $name);
        $query->bindValue(":artist", $artist);
        $query->bindValue(":description", $description);
        $query->bindValue(":genre", $genre);
        $query->bindValue(":price", $price);
        $query->bindValue(":thumbnail", $thumbnail);
        $query->bindValue(":stock", $stock);
        $query->bindValue(":selectedId",  $selectedId);
        
        $query->execute();
    }
    
    public static function deleteItemById($id){
        
        $conn = Db::getConnection();

        if($id === ""){return;}

        try {
            // Begin transaction
            $conn->beginTransaction();

            // Get all foreign key constraints for the table
            $query = $conn->prepare("
                SELECT TABLE_NAME, COLUMN_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE REFERENCED_TABLE_NAME = 'tl_item' 
                AND REFERENCED_COLUMN_NAME = 'id'
            ");
            $query->execute();
            $foreignKeys = $query->fetchAll(PDO::FETCH_ASSOC);

            // Delete related records in all tables with foreign key constraints
            foreach ($foreignKeys as $foreignKey) {
                $table = $foreignKey['TABLE_NAME'];
                $column = $foreignKey['COLUMN_NAME'];
                $deleteQuery = $conn->prepare("DELETE FROM $table WHERE $column = :givenId");
                $deleteQuery->bindValue(":givenId", $id);
                $deleteQuery->execute();
            }

            // Delete the product
            $query = $conn->prepare("DELETE FROM tl_item WHERE id = :givenId");
            $query->bindValue(":givenId", $id);
            $query->execute();

            // Commit transaction
            $conn->commit();
        } catch (Exception $e) {
            // Rollback transaction if something failed
            $conn->rollBack();
            throw $e;
        }
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public static function getGenres(){

        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT DISTINCT genre FROM tl_item");
        $statement->execute();
        
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public static function getProductPrice($id, $variation){
        
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT price FROM tl_item WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //Deluxe price multiplier
        if(($variation == 2)){

            $statement_2 = $conn->prepare('SELECT price_mult FROM tl_variations WHERE id = :id');
            $statement_2->bindValue(':id', $variation);
            $statement_2->execute();

            $priceMult = $statement_2->fetch(PDO::FETCH_ASSOC)['price_mult'];
        } else {
            $priceMult = 1;
        }

        $total = $result['price'] * $priceMult;
        return $total;
    }
}