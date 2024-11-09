<?php 

    session_start();
    if(isset($_SESSION["username"])){

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
    <title>Home</title>
</head>
<body>

    <nav class="top_nav">
        <a href="logout.php">logout</a>
    </nav>
    
</body>
</html>