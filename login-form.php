<?php
    session_start();
    require_once("./payroll.php");
    
    if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
      if($_SESSION['status'] === "A")
          header("location:home.php");
      else
        header("Location:employee/employee.php");
    }

    if(isset($_POST['login'])) {
      $payroll->setUserInfo();
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- JQuery -->
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script 
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
  ></script>
  <link rel="icon" type="image/x-icon" href="./assets/icon.png">
  <link rel="stylesheet" href="./css/login-form.css">
  <link rel="stylesheet" href="./css/modal.css">
  <title>Payroll System | Login</title>
</head>
<body>
  <?php 
    if(isset($_GET['error'])){
      include_once("./modal.php");
    }
  ?>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form method="post" class="sign-in-form">
          <h2 class="title">Payroll Login form</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" autocomplete="off">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" autocomplete="off">
          </div>
          <input type="submit" name="login" value="Login" class="btn solid">
        </form>
      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>CRUD Payroll System</h3>
          <img src="img/sign.svg" alt="" class="image">
        </div>
      </div>
    </div>
  </div>
</body>
</html>