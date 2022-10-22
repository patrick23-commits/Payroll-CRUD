<?php
session_start();
require_once("./payroll.php");
$rand = floor(microtime(true) * 1000);
$_SESSION['sec'] = floor(microtime(true) * 1000);
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
                <a class="title" href="home.php">
                    <div class="logo"> 
                        <img src="https://img.freepik.com/free-vector/illustration-circle-stamp-banner-vector_53876-27183.jpg?w=2000"> 
                    </div>
                    <div> PAYROLL SYSTEM </div>
                </a>
                <div class="selector">
                    <button class="nav" id="btn-home">
                        <i class="fa-solid fa-house"></i> Home
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
            <form id="payroll-form" action="./profile.php?id=<?= $_GET['id'] ;?>" method="post">
            
                <div class="p-content">
                    <div class="p-row">
                        <div class="p-col"> 
                            <div class="g-title">Employee Identification</div>
                            <div class="g-content">
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label">ID</div>
                                        <div class="input-value">
                                            <input type="text" readonly name="emp_id" placeholder="ID" value="<?= $employee['emp_id'];?>" style="width:50px;"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label">Name</div>
                                        <div class="input-value">
                                            <input type="text" name="fullname" placeholder="Full Name" value="<?= $employee['fullname'];?>">  
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label">Age</div>
                                        <div class="input-value">
                                            <input type="text" name="age" placeholder="Age" value="<?= $employee['age'];?>" style="width:50px;"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="combo-box">
                                    <select name="gender" id="" class="combo-box-gender">
                                        <option value="Male" <?=$employee['gender'] == 'Male' ? 'selected' :NULL ;?>>Male</option>
                                        <option value="Female" <?=$employee['gender'] == 'Female' ? 'selected' :NULL ;?> >Female</option>
                                    </select>
                                </div>    
                            </div>
                            <div class="g-footer" style="display: flex; justify-content: space-between;">
                                <div class=""></div>
                                <button name="update" class="accept update"> <i class="fa-solid fa-pen"></i> Update</button>
                            </div>
                        </div>
                        <div class="p-col"> 
                            <div class="g-title">Department</div>
                            <div class="g-content" style="display:flex; flex-direction: column;">
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-80P">Job Department</div>
                                        <div class="input-value">
                                            <input type="text" name="job_name" tabindex="-1" readonly placeholder="Job Department" value="<?= $employee["job_name"];?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-80P">Salary Range</div>
                                        <div class="input-value">
                                            <input type="text" id="daily_rate" tabindex="-1" readonly placeholder="Salary Range" value="<?= $employee["salary_range"];?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-row">
                        <div class="p-col"> 
                        <div class="g-title">Tax</div>
                            <div class="g-content" style="display:flex; flex-direction: column;">
                                <div class="input-tag"  >
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">SSS</div>
                                        <div class="input-value">
                                            <input type="text" name="sss" tabindex="-1" id="sss" readonly placeholder="SSS" value="<?= $tax['sss'] ;?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">PAGIBIG</div>
                                        <div class="input-value">
                                            <input type="text" name="pagibig" tabindex="-1" id="pagibig" readonly placeholder="PAGIBIG" value="<?= $tax['pagibig'] ;?>">  
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">PhilHealth</div>
                                        <div class="input-value">
                                            <input type="text" name="philhealth" tabindex="-1" id="philhealth" readonly placeholder="PhilHealth " value="<?= $tax['philhealth'] ;?>"> 
                                        </div>
                                    </div>
                                </div>
                               </div>
                        </div>
                        <div class="p-col"> 
                            <div class="g-title">
                                Attendance | <h5 style="display:inline-block; color: #333; ">Total Number of Working Days : <span id="working_days">0</span><h5>
                            </div>
                            <div class="g-content" >
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label" style="width: 70px;">Present</div>
                                        <div class="input-value">
                                            <input type="text" disabled id="num_days_present" name="num_days_present" placeholder="Days Present">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label" style="width: 70px;">Overtime</div>
                                        <div class="input-value">
                                            <input type="text" disabled id="overtime" name="overtime" placeholder="Overtime">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label" style="width: 70px;">Undertime</div>
                                        <div class="input-value">
                                            <input type="text" disabled id="undertime" name="undertime" placeholder="Undertime">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label" style="width: 70px;">Late</div>
                                        <div class="input-value">
                                            <input type="text" disabled id="late" name="late" placeholder="Late">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-row">
                        <div class="p-col"> 
                            <div class="g-title">Salary</div>
                            <div class="g-content">
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">Gross Pay</div>
                                        <div class="input-value">
                                            <input type="text" name="gross_pay" tabindex="-1" id="gross_pay" placeholder="Gross Pay" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">Net Pay</div>
                                        <div class="input-value">
                                            <input type="text" name="net_pay" tabindex="-1" id="net_pay" placeholder="Net Pay" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-col"> 
                            <div class="g-title">Pay Roll</div>
                            <div class="g-content">
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">From </div>
                                        <div class="input-value">
                                            <input type="date" name="from_" id="from_"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="input-tag">
                                    <div class="input-tag-content">
                                        <div class="input-label w-50P">To </div>
                                        <div class="input-value">
                                            <input type="date" name="to_" id="to_">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-row">
                        <button type="button" class="normal" id="btn-profile-back"><i class="fa-solid fa-arrow-left"></i> Back</button>
                        <button id="save" class="accept" name="save" id="btn-profile-save"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>  
        <div class="footer">
            Payroll System | 2022 | <i class="fa-regular fa-copyright"></i> All rights reserved
        </div>
    </div>
    <?php
    if(isset($_POST['save'])){
        $payroll->insertPayroll();
    } 
    ?>    
</body>
</html>

<!-- JQuery -->
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="script.js"></script>
