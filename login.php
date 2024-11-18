<?php
include_once(__DIR__. "/classes/User.php");

    if(!empty($_POST)){

        $user = new User();

        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        if ($user->login()){

            //LOGIN
            session_start();
            $_SESSION["username"] = $user->getUsername();
            header("Location: index.php");
        }
        else {

            //NO LOGIN
            $error = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login_card">
        
        <form action="" method="post" class="login_form">
            <h1>webshop<span class="accent_color">.</span></h1>
            <h2><i>Login</i></h2>
            

            <?php if(isset($error)): ?>
            <p class="error_text">The password or username was incorrect. Please try again</p>
            <?php endif; ?>

            <label for="username">Username</label>
            <input type="text" id="username" name="username">

            <label for="username">Password</label>
            <input type="password" id="password" name="password">

            <input type="submit" value="log in" class="btn">
            <p>No account? sign up <a href="signup.php">here</a>.</p>
        </form>
    </div>
</body>
</html>