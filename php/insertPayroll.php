<?php
require_once("../payroll.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    echo json_encode(["message" => $payroll->insertPayroll()]);
} 
?> 