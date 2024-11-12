<?php

function canLogin($username, $password){
        $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
        $statement = $conn->prepare("SELECT * FROM tl_user WHERE username = :username");
        $statement->bindValue(":username", $username);
        $statement->execute();
        $user = $statement->fetch();

        if(!$user){

            return false;
        } 
        $hash = $user['password'];
        if(password_verify($password, $hash)){
 
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