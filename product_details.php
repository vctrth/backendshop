<?php 

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");
include_once(__DIR__.'/settings/settings.php');

$product = Product::getProductByID($_GET['id']);

session_start();
if(isset($_SESSION["username"])){

    $user = new User();
    $user->setUsername($_SESSION['username']);

    $role = $user->getUser()['role'];
    // VAR_DUMP($role);
    // echo "Welcome ".$_SESSION["username"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product["name"]) ?></title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/product_details.css">
</head>
<body>
    <nav class="top_nav">

        <div class="left_content">
            <h3><a href="index.php">webglørpp<span class="accent_color">.</span></a></h3>
        </div>

        <div class="right_content">
            <?php if($role === 1): ?><a href="add_product.php">add product</a><?php endif; ?>
            <a href="logout.php">logout</a>
        </div>
    </nav>
    
    <div class="container">

        <div class="product_info">
            <img src="<?php echo htmlspecialchars($product['thumbnail']) ?>" alt="" class="album_cover">
            
            <div class="right_content">
                <h2 class="title"><b><?php echo htmlspecialchars($product['name']) ?></b></h2>
                <h3 class="artist"><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></h3>
                <p class="price"><b><?php echo htmlspecialchars($product['price']) ?> coins</b></p>
                <p class="description"><?php echo htmlspecialchars($product['description']) ?> </p>
                <a href="" class="btn">add to cart</a>
            </div>
        </div>
    </div>
</body>
</html>