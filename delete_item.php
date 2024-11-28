<?php 

include_once(__DIR__."/classes/Product.php");
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


if(isset($_GET["id"]) and $_GET['id'] != ""){

    Product::deleteItemById($_GET["id"]);
    header("Location: index.php");
}
else {

    header("Location: index.php");
}