<?php 

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile settings</title>

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
    

    <h2><i>Welcome, <?php echo htmlspecialchars($user ->getUsername()) ?></i></h2>

    <section class="orders_container">

        <h3>Orders</h3>

        <div class="orders">
            <div class="order">

                <div class="product_container">

                    <img src="images/mgu.jpg" alt=""  class="album_cover">
                    <div class="textbox">
                        <p>MG ULTRA<p>
                        <p><span class="accent_color">Machine Girl</span></p>
                        <p>€25.00</p>
                    </div>
                </div>      
            </div>
        </div>
    </section>

    <section class="account_control">

        <h3>Account control</h3>
        <a href="#">change password</a>
        <a href="logout.php">logout</a>
    </section>
</body>
</html>