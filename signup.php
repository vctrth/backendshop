<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>

    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <div class="login_card">
        
    <h1>webshop<span class="accent_color">.</span></h1>
        <form action="" method="post" class="login_form">
            
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