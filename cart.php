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
}

else {

    header("Location: login.php");
}

if(!empty($_SESSION['cart'])){

    $cartItems = $_SESSION['cart'];

    $products = array();
    forEach($cartItems as $product){

        $cProduct = Product::getProductByID($product['item_id']);
        array_push($products, $cProduct);
    }
}
else {

    header("Location: index.php");
}

if(!empty($_GET['ordered'])){

    if(Order::canBuyCart($_SESSION['cart'], $user['id'])){

        Order::addToOrder($_SESSION['cart'], $user['id']);
        $_SESSION['cart'] = [];
    }

    else {

        $error = true;
    }
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
    <h3 onclick="window.location.href = 'index.php'">webglørpp<span class="accent_color">.</span></h3>
</div>

<div class="right_content">

    <?php if($role === 1): ?><a href="add_product.php">add product</a><?php endif; ?>
    <a href="cart.php">cart</a>
    <a href="profile.php">profile</a>
    <a href="logout.php">logout</a>
</div>
</nav>

<a href="clear_cart.php">clear cart</a>

<?php if(isset($error)): ?>
    <p class='error_text'>you don't have enough coins to buy this cart</p>
<?php endif; ?>

<?php if(!empty($_SESSION['cart'])): ?>
<?php forEach($products as $key => $product): ?>


    <div class="product_container" onclick="window.location.href='product_details.php?id=<?php echo $product['id']; ?>'">
        <img src="<?php echo htmlspecialchars($product['thumbnail']) ?>" alt="" class="album_cover">
        <p><b><?php echo htmlspecialchars($product['name']) ?></b></p>
        <p><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></p>
        <p><?php echo htmlspecialchars($product['price']) ?> coins</p>
        <?php if(isset($cartItems['product_'.$key]['quantity'])): ?>
            <p>Quantity: <?php echo htmlspecialchars($cartItems['product_'.$key]['quantity']) ?> Total price: <?php echo htmlspecialchars($cartItems['product_'.$key]['quantity'] * $product['price']) ?></p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php endif; ?>

<p>order total is <?php echo Order::getTotalOfCart($_SESSION['cart']) ?></p>
<a href="cart.php?ordered=true">order</a>
</div>
</body>
</html>