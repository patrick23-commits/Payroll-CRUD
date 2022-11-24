<?php
session_start();
include_once("./payroll.php");
if($_SERVER['REQUEST_METHOD'] == "POST")
echo json_encode(["message"=>$payroll->changeAccount($_SESSION['username'], $_SESSION['status'])]);
else
header("Location:home.php");