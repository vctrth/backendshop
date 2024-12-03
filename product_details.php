<?php 

include_once(__DIR__. "/classes/Product.php");
include_once(__DIR__. "/classes/User.php");
include_once(__DIR__.'/settings/settings.php');
include_once(__DIR__.'/classes/Review.php');


$product = Product::getProductByID($_GET['id']);
$allReviews = Review::getAll($_GET['id']);

session_start();

//functions
function checkNestedArrays($bool){

    $bProduct = [
        'item_id' => $_GET['add_to_cart'], 
        'variation' => $_GET['variation']
    ];

    // var_dump($bProduct);
    // var_dump($_SESSION['cart']);
    
    foreach($_SESSION['cart'] as $i => $product){

        if(!$bool){

            if(in_array($bProduct['item_id'], $product)){

                return $i;
            }
        }
        else {

            if(in_array($bProduct['item_id'], $product) && in_array($bProduct['variation'], $product)){

                return $i;
            }
        }
    }
}

if(isset($_SESSION["username"])){

    $user = new User();
    $user->setUsername($_SESSION['username']);

    $role = $user->getUser()['role'];
    // VAR_DUMP($role);
    // echo "Welcome ".$_SESSION["username"];
}

if(!empty($_POST)){

    header('Location: product_details.php?id='.$product['id'].'&add_to_cart='.$product['id'].'&variation='.$_POST['variation']);
}

if(!empty($_GET['add_to_cart'])){

    if(empty($_SESSION['cart'])){
                    
        $_SESSION['cart'] = [];
        $_SESSION['cart']['product_'.count($_SESSION['cart'])] = [

            'item_id' =>  $_GET['add_to_cart'],
            'variation' => $_GET['variation']
        ];
        header('Location: cart.php');
    }
    
    else {
        
        if(checkNestedArrays(true)){

            $position = checkNestedArrays(true);
            // var_dump($_SESSION['cart']);
            

            if(isset($_SESSION['cart'][$position]['quantity'])){

                $_SESSION['cart'][$position]['quantity']  ++;
                header('Location: cart.php');
            }
            else {

                $_SESSION['cart'][$position]['quantity']  = 2;
                header('Location: cart.php');
            }

        }
        else{

            $_SESSION['cart']['product_'.strval(count($_SESSION['cart']))] = [
    
                'item_id' =>  $_GET['add_to_cart'],
                'variation' => $_GET['variation']
            ];
            header('Location: cart.php');
        }
    }
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
            <h3 onclick="window.location.href = 'index.php'">webglørpp<span class="accent_color">.</span></h3>
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

                <!-- product template -->
                <h2 class="title"><b><?php echo htmlspecialchars($product['name']) ?></b></h2>
                <h3 class="artist"><span class="accent_color"><?php echo htmlspecialchars($product['artist']) ?></span></h3>
                <p class="price"><b><?php echo htmlspecialchars($product['price']) ?> coins</b></p>

                <?php if(!empty($product['description'])): ?>
                    <p class="description"><?php echo htmlspecialchars($product['description']) ?> </p>
                <?php endif; ?>

                <form action="" class="buy_item" method="POST">

                    <select name="variation" id="variation">
                        <option value="1">NORMAL</option>
                        <option value="2">DELUXE</option>
                    </select>
                    <button type="submit" class="btn">add to cart</button>
                </form>

                <!-- Reviews -->
                <h3>Write your own review</h3>
                <div class="review_input">

                    <label for="review_text">Write a review</label>
                    <input type="text" name="review" id="review_text">
                    <label for="review_stars">How many stars would you give this album</label>
                    <input type="number" name="" id="review_stars" max="5">
                    <a class="btn" data-reviewid='<?php echo $_GET['id'] ?>' id='submit_review'>add review</a>
                </div>

                <div class="review_container">
                    <h3>Reviews</h3>
                    <ul class="reviews">
                        <?php foreach($allReviews as $i => $review): ?>

                            <li><b><?php echo User::getUserByID($review['user_id'])['username'] ?></b>: <?php echo $review['content'].' '.$review['stars'].'/5 stars' ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>  
        </div>
    </div>

    <script src='js/reviews.js'></script>
</body>
</html>