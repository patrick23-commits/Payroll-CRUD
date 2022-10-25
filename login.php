<?php
    require_once("./payroll.php");
    session_start();
    error_reporting(0);
    if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
        header("location:home.php");
    }
    if(isset($_POST['login'])) {
      $payroll->setUserInfo();
    }
    if(isset($_POST['register'])) {
      echo $payroll->createUser();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login and Registration Form</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
  <div class="Background">
    <div class="form-box">
      <div class="title title-large">CRUD PAYROLL SYSTEM </div>
      <div class="button-box">
        <div id="btn"></div>
        <button type="button" class="toggle-btn" onclick="login()">Login</button>
        <button type="button" class="toggle-btn" onclick="Register()">Register</button>
      </div>

      <form id="login" class="input-group" method="post">
        <input type="text" name="username" class="input-field" placeholder="Username" required>
        <input type="password" name="password" class="input-field" placeholder="Enter Password">
        <input type="Checkbox" class="check-box">
        <span>Remember Password</span>
       <button type="submit" name="login" class="submit-btn">Login</button>
      </form>
      
      <form id="Register" class="input-group" method="post">
        <input type="text" name="username" class="input-field" placeholder="Username" required>
        <input type="password" name="password" class="input-field" placeholder="Enter Password">
        <input type="checkbox" class="check-box">
        <span>I agree to the terms & condition</span>
       <button type="submit" name="register" class="submit-btn">Register</button>
      </form>
      </div>
  </div>
  

  <script>
    var x = document.getElementById("login");
    var y = document.getElementById("Register");
    var z = document.getElementById("btn");

    function Register() {
      x.style.left = "-400px";
      y.style.left = "50px";
      z.style.left = "110px";
    }
    function login() {
      x.style.left = "50px";
      y.style.left = "450px";
      z.style.left = "0";
    }
  </script>
</body>

</html>

