<?php

include_once(__DIR__.'/Db.php');
include_once(__DIR__.'/Product.php');

class Order {

    //Order table
    private $id;
    private $user_id;

    //Itemorder table
    private $item_id;
    private $variation_id;
    private $order_id;
    private $quantity;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

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

    /**
     * Get the value of item_id
     */ 
    public function getItem_id()
    {
        return $this->item_id;
    }

    /**
     * Set the value of item_id
     *
     * @return  self
     */ 
    public function setItem_id($item_id)
    {
        $this->item_id = $item_id;

        return $this;
    }

    /**
     * Get the value of variation_id
     */ 
    public function getVariation_id()
    {
        return $this->variation_id;
    }

    /**
     * Set the value of variation_id
     *
     * @return  self
     */ 
    public function setVariation_id($variation_id)
    {
        $this->variation_id = $variation_id;

        return $this;
    }

    /**
     * Get the value of order_id
     */ 
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */ 
    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    //Get all orders by the user
    public static function getAll($user){

        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM tl_order WHERE user_id = :id");
        $statement->bindValue(':id', $user);
        $statement->execute();

        $result_1 = $statement->fetchAll(PDO::FETCH_ASSOC);
        //Architecture of the resulting array
        // $result = [
        //     'order_1' => [

        //         // Order values
        //         'user_id' => 'temp',
        //         'items' => [

        //             'item_1' => [

        //                 // Item order values
        //                 'item_id' => 'temp',
        //                 'quantity' => 'temp',
        //                 'variation_id' => 'temp'
        //             ]
        //         ],
        //         'date_of_order' => 'dd-mm-yyyy'
        //     ]
        // ];
        $result = [];

        foreach($result_1 as $key => $order){

            //Get contents of the order
            $statement_2 = $conn->prepare("SELECT * FROM tl_itemorder WHERE order_id = :id");
            $statement_2->bindValue(':id', $order['id']);
            $statement_2->execute();

            $result_2 = $statement_2->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($result_2);

            //Making it into a readable array
            $result_temp = [

                "user_id" => $result_1[$key]['id'],
                "items" => $result_2,
                "date_of_order" => $result_1[$key]['date_of_order']
            ];
            array_push($result, $result_temp); 
        }
        return $result;
    }

    public static function addToOrder($orderArray, $user){
        
        $conn = Db::getConnection();

        $statement = $conn->prepare('INSERT INTO tl_order(user_id, date_of_order) VALUES (:user_id, :doo)');
        $statement->bindValue(':user_id', $user);
        $statement->bindValue(':doo', date("Y-m-d h:i:s"));
        $statement->execute();
        $last_id = $conn->lastInsertId();

        foreach($orderArray as $i => $order){

            $statement = $conn->prepare('INSERT INTO tl_itemorder(item_id, order_id, quantity, variation_id) VALUES (:item_id, :order_id, :quantity, 1)');
            $statement->bindValue(':item_id', $order['item_id']);
            $statement->bindValue(':order_id', $last_id);
            if(isset($order['quantity'])){
                
                $statement->bindValue(':quantity', $order['quantity']);
            }
            else {
                
                $statement->bindValue(':quantity', 1);
            }

            $statement->execute();
        }
    }

    public static function getTotalOfCart($cart){

        $total = 0;

        $conn = Db::getConnection();

        foreach($cart as $i => $order){

            $statement = $conn->prepare('SELECT price FROM tl_item WHERE id = :id');
            $statement->bindValue(':id', $order['item_id']);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if(isset($order['quantity'])){

                $total += $result['price'] * $order['quantity'];
            }
            else {

                $total += $result['price'];
            }
        }

        return $total;
    }

    public static function canBuyCart($cart, $user){

        $total = 0;

        $conn = Db::getConnection();

        $statement = $conn->prepare('SELECT coins FROM tl_user WHERE id = :id');
        $statement->bindValue(':id', $user);
        $statement->execute();

        $coins = $statement->fetch(PDO::FETCH_ASSOC);

        $total = Order::getTotalOfCart($cart);

        if($coins['coins'] >= $total){

            return true;
        }
        else {

            return false;
        }

    }
}