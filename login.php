<?php

    $conn = new mysqli("127.0.0.1", "root", "root", "backendshop", "8889");
    $users = $conn->query("SELECT * from tl_user");

    function canLogin($username, $password){

        if($username === "victor@shop.be" && $password ==="12345isnotsecure"){

            return true;
        }
        else {
            
            return false;
        }
    }

    if(!empty($_POST)){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (canLogin($username, $password)){

            //LOGIN
            session_start();
            $_SESSION["username"] = $username;
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