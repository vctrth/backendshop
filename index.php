<?php 

include_once(__DIR__. "/classes/Product.php");

session_start();
if(isset($_SESSION["username"])){

    // echo "Welcome ".$_SESSION["username"];
}
else {

    header("Location: login.php");
}

$products = Product::getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/store.css">
</head>
<body>

    <nav class="top_nav">
        <a href="logout.php">logout</a>
    </nav>

    <div class="products">

        <?php forEach($products as $product): ?>
            <div class="product_container">
                <img src="images/<?php echo $product['thumbnail'] ?>.jpg" alt="" class="album_cover">
                <p><?php echo $product['name'] ?></p>
                <p><span class="accent_color"><?php echo $product['artist'] ?></span></p>
                <p>€<?php echo $product['price'] ?>.00</p>
            </div>
        <?php endforeach; ?>


        <!-- Example product -->
        <!-- <div class="product_container">

            <img src="images/mgu.jpg" alt=""  class="album_cover">
            <p>MG ULTRA<p>
            <p><span class="accent_color">Machine Girl</span></p>
            <p>€25.00</p>
            <p>Only 2 left in stock!</p> 
        </div> -->

    </div>   
</body>
</html>