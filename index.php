<?php 

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");

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

$genres = Product::getGenres();
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

        <section class="header">
        
            <h2><i>Welcome, <?php echo htmlspecialchars($_SESSION['username']) ?>!</i></h2>
            <h3 class="accent_color">coins: <?php echo $coins ?></h3>
        </section>

        <div class="shop">

            <div class="left">

                <h3><b>FILTERS</b></h3>
                <label for="searchbar"></label>
                <input type="text" name="" id="searchbar" onchange="
                    window.location.href=`index.php?search=${document.querySelector('#searchbar').value}`"
                    placeholder='Search artist, album or description'
                >

                <div class="filter_container">

                    <div class="filters">

                        <?php if(isset($_GET['genre']) || isset($_GET['search'])): ?>
                            <a href="index.php" class='filter_link'>reset filter</a>
                        <?php endif; ?>

                        <?php foreach($genres as $genre): ?>
                            <a href="index.php?genre=<?php echo htmlspecialchars($genre['genre']) ?>" class="filter_link"><?php echo htmlspecialchars($genre['genre']) ?></a>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
            
            <div class="products">
                
                <?php forEach($products as $product): ?>
                    
                    <div class="product_container" onclick="window.location.href='product_details.php?id=<?php echo $product['id']; ?>'">
                        <img src="<?php echo htmlspecialchars($product['thumbnail']) ?>" alt="" class="album_cover">
                        <p><b><?php echo htmlspecialchars($product['name']) ?></b></p>
                        <p><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></p>
                        <p><?php echo htmlspecialchars($product['price']) ?> coins</p>
                        
                        <?php if($role === 1): ?>
                            <a href="delete_product.php?id=<?php echo $product['id'] ?>" >delete product</a>
                            <a href="edit_product.php?id=<?php echo $product['id'] ?>" >edit product</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
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