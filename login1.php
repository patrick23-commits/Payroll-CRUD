<?php
$con = new mysqli("localhost", "root", "");
echo var_dump($con);

$databases = "SHOW DATABASES";
echo var_dump($con->query($databases)->fetch_assoc());
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="icon" type="image/x-icon" href="https://img.freepik.com/free-vector/illustration-circle-stamp-banner-vector_53876-27183.jpg?w=2000">
    <link rel="stylesheet" href="style.css">

    <!-- FontAwsome -->
    <script src="https://kit.fontawesome.com/e0c35786e8.js" crossorigin="anonymous"></script>
</head>
<body>
    <form action="./login.php" method="post">
        <input type="text" name="username" id="" placeholder="Username">
        <input type="password" name="password" id="" placeholder="Password">
        <button type="submit" name="submit" id="btn-back">Login</button>
    </form>
    
</body>
</html>

<!-- FontAwsome -->
<script src="https://kit.fontawesome.com/e0c35786e8.js" crossorigin="anonymous"></script>

<!-- JQuery -->
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="script.js"></script>

