<?php 

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");
include_once(__DIR__.'/settings/settings.php');

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

if(!isset($_GET["genre"])){ $products = Product::getAll(); }
else{ $products = Product::getProductsByGenre($_GET["genre"]);};

if(isset($_GET["search"])){
    $products = Product::getProductsBySearch($_GET["search"]);
};

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
            <h3><a href="index.php">webglørpp<span class="accent_color">.</span></a></h3>
        </div>
        
        <div class="right_content">
            <a href="" style="text-decoration:none; color: black;">coins: <?php echo $coins ?></a>

            <?php if($role === 1): ?><a href="add_product.php">add product</a><?php endif; ?>
            <a href="profile.php">profile</a>
            <a href="logout.php">logout</a>
        </div>
    </nav>

    <div class="container">
        <h2><i>Welcome, <?php echo htmlspecialchars($_SESSION['username']) ?>!</i></h2>

        <label for="searchbar"></label>
        <input type="text" name="" id="searchbar" onchange="
            window.location.href=`index.php?search=${document.querySelector('#searchbar').value}`"
            placeholder='Search for an artist, album or description'
        >

        <div class="filter_container">

            <div class="filters">

                <?php foreach(SETTINGS["genres"] as $genre): ?>
                    <a href="index.php?genre=<?php echo htmlspecialchars($genre) ?>"><?php echo htmlspecialchars($genre) ?></a>
                <?php endforeach; ?>
            </div>

            <?php if(isset($_GET['genre']) || isset($_GET['search'])): ?>
                <a href="index.php">reset filter</a>
            <?php endif; ?>
        </div>

        <div class="products">

            <?php forEach($products as $product): ?>

                <div class="product_container" onclick="window.location.href='product_details.php?id=<?php echo $product['id']; ?>'">
                    <img src="<?php echo htmlspecialchars($product['thumbnail']) ?>" alt="" class="album_cover">
                    <p><b><?php echo htmlspecialchars($product['name']) ?></b></p>
                    <p><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></p>
                    <p><?php echo htmlspecialchars($product['price']) ?> coins</p>
                </div>
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