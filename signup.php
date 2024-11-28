<?php
// $conn = new mysqli("127.0.0.1", "root", "root", "backendshop", "8889");
include_once(__DIR__. "/classes/User.php");

$conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");

    if(!empty($_POST)){

        if($_POST['password'] === $_POST['confirm_password']){
            $options = [

                "cost" => 12
            ];

            $user = new User();
            $user->setUsername($_POST["username"]);
            $user->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT, $options));
            $user->save();

            session_start();
            $_SESSION["username"] = $user->getUsername();
            header("Location: index.php");
        }
        else {

            $error = true;
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <div class="login_card">
        
        
        <form action="" method="post" class="login_form">

            <h1>webglørpp<span class="accent_color">.</span></h1>
            <h2><i>Sign up</i></h2>

            <?php if(isset($error)): ?>
            <p class="error_text">The passwords aren't the same. Please try again</p>
            <?php endif; ?>

            <label for="username">Username</label>
            <input type="text" id="username" name="username">

            <!-- <label for="username">E-mail</label>
            <input type="text" id="email" name="email"> -->

            <label for="username">Password</label>
            <input type="password" id="password" name="password">

            <label for="username">Confirm password</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <input type="submit" value="sign up" class="btn">
            <p>Already have an account? log in <a href="login.php">here</a>.</p>
        </form>
    </div>
</body>
</html>