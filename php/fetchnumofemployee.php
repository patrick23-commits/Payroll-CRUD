<?php
require_once("../payroll.php");
if($_SERVER['REQUEST_METHOD'] === "GET")
echo json_encode($payroll->fetchNumberOfEmployeesPerDepartment());