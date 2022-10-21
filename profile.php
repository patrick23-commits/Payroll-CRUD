<?php
session_start();
require_once("./payroll.php");
$GLOBALS['employee'] = $payroll->fetchEmployee($_GET['id']);
if(!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
    header("location:login.php");
}
if(isset($_POST['logout'])) {
    $payroll->logout();
}
if(isset($_POST['update'])) {
    $payroll->updateEmployee();
    $GLOBALS['employee'] = $payroll->fetchEmployee($_GET['id']);
}
$employee = $GLOBALS['employee'];
$tax = $payroll->fetchTax();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="icon" type="image/x-icon" href="https://img.freepik.com/free-vector/illustration-circle-stamp-banner-vector_53876-27183.jpg?w=2000">
    <link rel="stylesheet" href="style.css">

    <!-- FontAwsome -->
    <script src="https://kit.fontawesome.com/e0c35786e8.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="navigator">
                <a class="title" href="home.html">
                    <div class="logo"> 
                        <img src="https://img.freepik.com/free-vector/illustration-circle-stamp-banner-vector_53876-27183.jpg?w=2000"> 
                    </div>
                    <div> PAYROLL SYSTEM </div>
                </a>
                <div class="selector">
                    <button class="nav" id="btn-home">
                        <i class="fa-solid fa-house"></i> Home
                    </button>
                    <button class="nav" id="btn-option">
                        <i class="fa-solid fa-gear"></i> Settings
                    </button>
                    <form action="." method="post" style="display:inline;">
                        <button class="nav" id="btn-logout" name="logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="body" style="min-height: 80vh;">
            <form action="./profile.php?id=<?= $_GET['id'] ;?>" method="post">
                <div class="p-content">
                    <div class="p-row">
                        <div class="p-col"> 
                            <div class="g-title">Employee Identification</div>
                            <div class="g-content">
                                <input type="text" readonly name="emp_id" placeholder="Employee ID" value="<?= $employee['emp_id'];?>"> 
                                <input type="text" name="fullname" placeholder="Full Name" value="<?= $employee['fullname'];?>">  
                                <input type="text" name="age" placeholder="Age" value="<?= $employee['age'];?>"> 
                               
                                <select name="gender" id="" class="combo-box-gender">
                                    <option value="Male" <?=$employee['gender'] == 'Male' ? 'selected' :NULL ;?>>Male</option>
                                    <option value="Female" <?=$employee['gender'] == 'Female' ? 'selected' :NULL ;?> >Female</option>
                                </select>
                                <button name="update" class="update">Update</button>
                            </div>
                        </div>
                        <div class="p-col"> 
                            <div class="g-title">Department</div>
                            <div class="g-content" style="display:flex; flex-direction: column;">
                                <input type="text" name="job_name" placeholder="Job Department" value="<?= $employee["job_name"];?>"> 
                                <input type="text" id="daily_rate" placeholder="Salary Range" value="<?= $employee["salary_range"];?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="p-row">
                        
                        <div class="p-col"> 
                            <div class="g-title">Attendance</div>
                            <h6>Total Number of Working Days : <span id="working_days">0</span></h1>
                            <div class="g-content" style="display:flex; flex-direction: column;">
                                <input type="text" disabled id="num_days_present" name="num_days_present" placeholder="No. of Days Present">
                                <input type="text" disabled id="overtime" name="overtime" placeholder="Overtime"> 
                                <input type="text" disabled id="undertime" name="undertime" placeholder="Undertime"> 
                                <input type="text" disabled id="late" name="late" placeholder="Late"> 
                            </div>
                        </div>
                        <div class="p-col"> 
                            <div class="g-title">Tax</div>
                            <div class="g-content">
                                <input type="text" name="sss" id="sss" readonly placeholder="SSS" value="<?= $tax['sss'] ;?>"> 
                                <input type="text" name="pagibig" id="pagibig" readonly placeholder="PAGIBIG" value="<?= $tax['pagibig'] ;?>">  
                                <input type="text" name="philhealth" id="philhealth" readonly placeholder="PhilHealth " value="<?= $tax['philhealth'] ;?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="p-row">
                        <div class="p-col"> 
                            <div class="g-title">Salary</div>
                            <div class="g-content">
                                <label for="gross_pay">
                                    Gross Pay
                                    <input type="text" name="gross_pay" id="gross_pay" placeholder="Gross Pay" readonly>
                                
                                <br>
                                <label for="net_pay">
                                    Net Pay
                                    <input type="text" name="net_pay" id="net_pay" placeholder="Net Pay" readonly>
                                </label>
                                
                            </div>
                        </div>
                        <div class="p-col"> 
                            <div class="g-title">Pay Roll</div>
                            <div class="g-content">
                                <label for="from_">
                                    From : 
                                    <input type="date" name="from_" id="from_"> 
                                </label>
                                <br>
                                <label for="to_">
                                    To:
                                    <input type="date" name="to_" id="to_">
                                </label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="p-row">
                        <button type="button" class="normal" id="btn-profile-back"><i class="fa-solid fa-arrow-left"></i> Back</button>
                        <button class="accept" name="save" id="btn-profile-save"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>  
        <div class="footer">
            Payroll System | 2022 | <i class="fa-regular fa-copyright"></i> All rights reserved
        </div>
    </div>
    <?php
        if(isset($_POST['save'])) {
            $payroll->insertPayroll();
        }
        
    ?>
</body>
</html>

<!-- JQuery -->
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="script.js"></script>