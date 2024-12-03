<?php 
include_once(__DIR__. "/classes/User.php");
include_once(__DIR__. "/classes/Order.php");
include_once(__DIR__. "/classes/Product.php");

session_start();
if(isset($_SESSION["username"])){

    $user = new User();
    $user->setUsername($_SESSION['username']);

    $role = $user->getUser()['role'];
    // VAR_DUMP($role);
    // echo "Welcome ".$_SESSION["username"];
}
else {

    header("Location: login.php");
}

$user_id = $user->getUser()['id'];
$orders = Order::getAll($user_id);
// var_dump($orders);

//Making a readable array for all of the orders with their items
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile settings</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/profile.css">
</head>

<body>
    <nav class="top_nav">

        <div class="left_content">
            <h3 onclick="window.location.href = 'index.php'">webglørpp<span class="accent_color">.</span></h3>
        </div>

        <div class="right_content">

            <?php if($role === 1): ?><a href="add_product.php">add product</a><?php endif; ?>
            <a href="cart.php">cart</a>
            <a href="profile.php">profile</a>
            <a href="logout.php">logout</a>
        </div>
    </nav>
    
    <div class="container">

        <h2><i>Welcome, <?php echo htmlspecialchars($user ->getUsername()) ?></i></h2> 

        <div class="box">
            <section class="orders_container">

                <h3>Orders</h3>

                <div class="orders">


                    <!-- Order template -->
                    <?php foreach(array_reverse($orders) as $order): ?>
                        
                        <?php $total = 0 ?>
                        <div class="order">

                            <h2 class="accent_color"><?php echo $order['date_of_order'] ?></h2>

                            <?php foreach($order['items'] as $i => $item): ?>
                                
                                <div class="product_container">

                                    <?php 
                                    //Getting the products
                                    $current_item = Product::getProductByID($item['item_id']);
                                    $productPrice = Product::getProductPrice($item['item_id'], $item['variation_id']);
                                    // var_dump($item);    
                                    ?>
                                    <?php if($item['variation_id'] == 2): ?>
                                        <p><b><i><span class='error_text' style="text-transform:uppercase">DELUXE EDITION</span></i></b></p>
                                    <?php endif; ?>
                                    <img src="<?php echo $current_item['thumbnail'] ?>" alt=""  class="album_cover">
                                    <div class="textbox">
                                        <p><b><?php echo $current_item['name'] ?></b><p>
                                        <p><span class="accent_color"><?php echo $current_item['artist'] ?></span></p>
                                        <p>Amount: <?php echo $item['quantity'] ?></p>
                                        <p><?php echo $productPrice * $item['quantity']; $total +=$productPrice * $item['quantity'];?></p>
                                    </div>
                                </div>  
                            <?php endforeach; ?>
                            <p><b>Total order price <?php echo $total?> coins</b></p>  
                        </div>
                    <?php endforeach; ?>
                    <!-- Order template -->
                        <!-- <div class="order">

                            <div class="product_container">

                                <img src="images/mgu.jpg" alt=""  class="album_cover">
                                <div class="textbox">
                                    <p><b>MG ULTRA</b><p>
                                    <p><span class="accent_color">Machine Girl</span></p>
                                    <p>250 coins</p>
                                </div>
                            </div>      
                        </div> -->
                </div>
            </section>

            <section class="account_control">
        
                <h3>Account control</h3>
                <a href="change_password.php">change password</a>
                <a href="logout.php">logout</a>
            </section>
        </div>
    </div>

</body>
</html>