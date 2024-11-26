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
</head>
<body>
    <nav class="top_nav">

    <div class="left_content">
        <h3><a href="index.php">webglørpp<span class="accent_color">.</span></a></h3>
    </div>

    <div class="right_content">
        <?php if($role === 1): ?><a href="addproduct.php">add product</a><?php endif; ?>
        <a href="logout.php">logout</a>
    </div>
    </nav>
    
    <img src="<?php echo htmlspecialchars($product['thumbnail']) ?>" alt="" class="album_cover">
    <p><b><?php echo htmlspecialchars($product['name']) ?></b></p>
    <p><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></p>
    <p>€<?php echo htmlspecialchars($product['price']) ?>.00</p>
</body>
</html>