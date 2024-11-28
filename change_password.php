<?php 
include_once(__DIR__. "/classes/User.php");

session_start();
if(isset($_SESSION["username"])){

    $user = User::sGetUser($_SESSION['username']);
}
else {

    header("Location: login.php");
}
if(!empty($_POST)){

    $userInst = new User();
    $userInst->setUsername($user["username"]);
    $userInst->setPassword($user["password"]);
    var_dump($userInst);

    $result = $userInst->changePassword($_POST['oldPassword'], $_POST['newPassword'], $user['password']);
    if(!$result){

        $error = true;
    }
    else if($result) {

        header("Location: logout.php");
    }
}

?>
<!DOCTYPE html>
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
            <h2><i>Change your password</i></h2>


            <!-- <label for="username">E-mail</label>
            <input type="text" id="email" name="email"> -->
            <?php if(isset($error)): ?>
            <p class="error_text">The old password isn't correct!</p>
            <?php endif; ?>

            <label for="oldPassword">Old Password</label>
            <input type="password" id="oldPassword" name="oldPassword">

            <label for="newPassword">New password</label>
            <input type="password" id="newPassword" name="newPassword">

            <input type="submit" value="change" class="btn">
        </form>
    </div>
</body>
</html>