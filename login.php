<?php
include_once(__DIR__. "/classes/User.php");
session_start();

if(!empty($_POST)){

    $user = new User();

    // $user->setUsername($_POST['username']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);

    if ($user->login()){

        //LOGIN
        session_start();
        $_SESSION["username"] = $user->getUsernameByEmail();
        header("Location: index.php");
    }
    else {

        //NO LOGIN
        $error = true;
    }
}

if(isset($_SESSION["username"])){

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login_card">
        
        <form action="" method="post" class="login_form">
            <h1>webglørpp<span class="accent_color">.</span></h1>
            <h2><i>Login</i></h2>
            

            <?php if(isset($error)): ?>
            <p class="error_text">The password or email was incorrect. Please try again</p>
            <?php endif; ?>

            <!-- <label for="username">Username</label>
            <input type="text" id="username" name="username"> -->
            
            <label for="email">e-mail</label>
            <input type="text" id="email" name="email">

            <label for="username">Password</label>
            <input type="password" id="password" name="password">

            <input type="submit" value="log in" class="btn">
            <p>No account? sign up <a href="signup.php">here</a>.</p>
        </form>
    </div>
</body>
</html>