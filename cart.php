<?php

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");
include_once(__DIR__. "/classes/Order.php");

session_start();
if(isset($_SESSION["username"])){

    // $user = new User();
    // $user->setUsername($_SESSION['username']);
    // $role = $user->getUser()['role'];

    $user = User::sGetUser($_SESSION['username']);
    $role = $user['role'];
    $coins = $user['coins'];
    // VAR_DUMP($role);
    // echo "Welcome ".$_SESSION["username"];
}
else {

    header("Location: login.php");
}

$cartItems = $_SESSION['cart'];

$products = array();
forEach($cartItems as $id){

    $product = Product::getProductByID($id);
    array_push($products, $product);
}

if(!empty($_GET['ordered'])){

    Order::getAll($user['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/store.css">
</head>
<body>

<nav class="top_nav">

<div class="left_content">
    <h3><a href="index.php">webglørpp<span class="accent_color">.</span></a></h3>
</div>

<div class="right_content">

    <?php if($role === 1): ?><a href="add_product.php">add product</a><?php endif; ?>
    <a href="profile.php">profile</a>
    <a href="logout.php">logout</a>
</div>
</nav>

<a href="clear_cart.php">clear cart</a>
    
<?php forEach($products as $product): ?>

    <div class="product_container" onclick="window.location.href='product_details.php?id=<?php echo $product['id']; ?>'">
        <img src="<?php echo htmlspecialchars($product['thumbnail']) ?>" alt="" class="album_cover">
        <p><b><?php echo htmlspecialchars($product['name']) ?></b></p>
        <p><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></p>
        <p><?php echo htmlspecialchars($product['price']) ?> coins</p>
    </div>
<?php endforeach; ?>

<a href="cart.php?ordered=true">order</a>
</div>
</body>
</html>