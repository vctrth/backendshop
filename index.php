<?php 

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");

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

$products = Product::getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/store.css">
</head>
<body>

    <nav class="top_nav">

        <div class="left_content">
            <h3><a href="index.php">webshop<span class="accent_color">.</span></a></h3>
        </div>
        
        <div class="right_content">
            <?php if($role === 1): ?><a href="addproduct.php">add product</a><?php endif; ?>
            <a href="logout.php">logout</a>
        </div>
    </nav>

    <div class="container">
        <h2><i>Welcome, <?php echo $_SESSION['username'] ?>!</i></h2>

        <div class="filters">

            <form action="" method="post" class="filter_form">

                <select name="genre" id="genre">
                    <option value="" disabled selected>filter by genre</option>

                    <option value="">all</option>

                    <option value="shoegaze">Shoegaze</option>
                    <option value="postpunk">Post-Punk</option>
                    <option value="jazzrock">Jazz-Rock</option>
                    <option value="rock">Rock</option>
                </select>

                <input type="submit" value="filter" class="btn">
            </form>
        </div>

        <div class="products">

            <?php forEach($products as $product): ?>

                <?php if($product['genre'] === $_POST['genre'] || $_POST['genre'] === ''): ?>
                
                    <div class="product_container">
                        <img src="<?php echo $product['thumbnail'] ?>" alt="" class="album_cover">
                        <p><b><?php echo $product['name'] ?></b></p>
                        <p><span class="accent_color"><?php echo $product['artist'] ?></span></p>
                        <p>€<?php echo $product['price'] ?>.00</p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

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