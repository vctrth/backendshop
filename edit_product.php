<?php

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");

//Cloudinary
require __DIR__ . '/vendor/autoload.php';
use Cloudinary\Api\Upload\UploadApi;

//API Keys
$jsonString = file_get_contents(__DIR__."/api_keys.json");
$config = json_decode($jsonString, true);

// Use the Configuration class 
use Cloudinary\Configuration\Configuration;

// Configure an instance of your Cloudinary cloud
Configuration::instance('cloudinary://'.$config['cloudinaryConfig']['API_KEY'].':'.$config['cloudinaryConfig']['API_SECRET'].'@'.$config['cloudinaryConfig']['CLOUD_NAME'].'?secure=true');

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

$selectedProduct = Product::getProductByID($_GET['id']);

if(!empty($_POST)){

    $product = new Product;

    $product->setName($_POST["name"]);
    $product->setArtist($_POST["artist"]);
    $product->setDescription($_POST["description"]);
    $product->setGenre($_POST["genre"]);
    $product->setPrice($_POST["price"]);
    // $product->setThumbnail($_POST["thumbnail"]);
    if(!empty($_FILES['thumbnail']['tmp_name'])){
        $filePath = $_FILES['thumbnail']['tmp_name'];
        $image = (new UploadApi())->upload($filePath)['secure_url'];
        $product->setThumbnail($image);
    }
    else {
        $product->setThumbnail($selectedProduct['thumbnail']);
    }
    $product->setStock($_POST["stock"]);
    // $product->setArtist($_POST["artist"]);

    $product->update($_GET['id']);
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

        <form action="" method="post" class="add_product_form" enctype="multipart/form-data">

            <label for="name">Name</label>
            <input type="text" id="name" name="name" value= '<?php echo $selectedProduct['name']?>'>

            <label for="artist">Artist</label>
            <input type="text" id="artist" name="artist" value= '<?php echo $selectedProduct['artist']?>'>

            <label for="description">Description</label>
            <input type="text" id="description" name="description" value= '<?php echo $selectedProduct['description']?>'>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" value= '<?php echo $selectedProduct['genre']?>'>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" value= '<?php echo $selectedProduct['price']?>'>

            <label for="thumbnail">Thumbnail</label>
            <!-- <input type="text" id="thumbnail" name="thumbnail" value= '<?php echo $selectedProduct['thumbnail']?>'> -->
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*">

            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value= '<?php echo $selectedProduct['stock']?>'>

            <input type="submit" value="edit" class="btn">
        </form>
    </div>
</body>
</html>