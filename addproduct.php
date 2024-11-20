<?php

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");

session_start();
if(isset($_SESSION["username"])){

    $user = new User();
    $user->setUsername($_SESSION['username']);

    $role = $user->getUser()['role'];

    if($role != 1){

        header("Location: index.php");
    }
    // VAR_DUMP($role);
    // echo "Welcome ".$_SESSION["username"];
}
else {

    header("Location: login.php");
}

if(!empty($_POST)){

    $product = new Product;

    $product->setName($_POST["name"]);
    $product->setArtist($_POST["artist"]);
    $product->setGenre($_POST["genre"]);
    $product->setPrice($_POST["price"]);
    $product->setThumbnail($_POST["thumbnail"]);
    $product->setStock($_POST["stock"]);
    // $product->setArtist($_POST["artist"]);

    $product->save();
    header("Location: index.php"); 
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a product</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/add_product.css">
</head>
<body>

    <nav class="top_nav">

        <div class="left_content">
            <h3><a href="index.php">webshop<span class="accent_color">.</span></a></h3>
        </div>

        <div class="right_content">

            <a href="logout.php">logout</a>
        </div>
    </nav>
    
    <div class="container">

        <form action="" method="post" class="add_product_form">

            <label for="name">Name</label>
            <input type="text" id="name" name="name">

            <label for="artist">Artist</label>
            <input type="text" id="artist" name="artist">

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre">

            <label for="price">Price</label>
            <input type="number" id="price" name="price">

            <label for="thumbnail">Thumbnail</label>
            <input type="text" id="thumbnail" name="thumbnail">

            <label for="stock">Stock</label>
            <input type="text" id="stock" name="stock">

            <input type="submit" value="add" class="btn">
        </form>
    </div>
</body>
</html>