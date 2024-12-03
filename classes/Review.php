<?php
    include_once(__DIR__.'/Db.php');

    class Review{

        private $text;
        private $stars;
        private $product_id;
        private $user_id;

        /**
         * Get the value of text
         */ 
        public function getText()
        {
                return $this->text;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */ 
        public function setText($text)
        {
                $this->text = $text;

                return $this;
        }

        /**
         * Get the value of stars
         */ 
        public function getStars()
        {
                return $this->stars;
        }

        /**
         * Set the value of stars
         *
         * @return  self
         */ 
        public function setStars($stars)
        {
                $this->stars = $stars;

                return $this;
        }

        /**
         * Get the value of review_id
         */ 
        public function getProduct_id()
        {
                return $this->product_id;
        }

        /**
         * Set the value of review_id
         *
         * @return  self
         */ 
        public function setProduct_id($product_id)
        {
                $this->product_id = $product_id;

                return $this;
        }

        /**
         * Get the value of user_id
         */ 
        public function getUser_id()
        {
                return $this->user_id;
        }

        /**
         * Set the value of user_id
         *
         * @return  self
         */ 
        public function setUser_id($user_id)
        {
                $this->user_id = $user_id;

                return $this;
        }

        public function save(){

            $conn = Db::getConnection();
            $statement = $conn->prepare("insert into tl_review (content, stars, product_id, user_id, date_of_review) values (:text, :stars, :product_id, :user_id, :date_of_review)");

            $text = $this->getText();
            $stars = $this->getStars();
            $product_id = $this->getProduct_id();
            $user_id = $this->getUser_id();
            $date_of_review = date('Y-m-d H:i:s');

            $statement->bindValue(":text", $text);
            $statement->bindValue(":stars", $stars);    
            $statement->bindValue(":product_id", $product_id);
            $statement->bindValue(":user_id", $user_id);
            $statement->bindValue(":date_of_review", $date_of_review);
            
            $result = $statement->execute();
            return $result;
        }

        public static function getAll($product_id){

            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT * FROM tl_review WHERE product_id = :product_id");
            $statement->bindValue(':product_id', $product_id);
            $statement->execute();
            
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }