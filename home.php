<?php
session_start();
require_once("./payroll.php");
if(!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
    header("location:login.php");
}
if(isset($_POST['logout'])) {
    $payroll->logout();
}
if(isset($_POST['confirm'])) {
    $payroll->addEmployee();
}
if(isset($_POST['remove'])) {
    $payroll->deleteEmployee();
}
if(!$payroll->TableCreated())
    $payroll->createTables();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

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
        <div class="body">
            <form action="." method="post">
            <div class="content"  style="min-height: 73vh;">
                <div class="table">
                    <div class="row title">
                        <div class="tb-name">List of Employee</div>
                        <div class="search">
                            <input type="search" style="margin: 10px 0; margin-left: 20px;" placeholder="Search">
                            <button class="btn-search-go"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div class="row head">
                        <div class="col w-5P"><input type="checkbox" class="cb-head"></div>
                        <div class="col w-50P"> Name </div>
                        <div class="col w-20P"> Department </div>
                        <div class="col w-20P"> Action </div>
                    </div>
                    <?php
                        foreach($payroll->fetchAllEmployees() as $employee) {
                    ?>
                        <div class="row">
                            <div class="col w-5P"><input type="checkbox" name="emp_id[]"class="cb-item" value="<?=$employee['emp_id'];?>"></div>
                            <div class="col w-50P"><?= $employee['fullname'] ;?></div>
                            <div class="col w-20P"><?= $employee['job_name'] ;?></div>
                            <div class="col w-20P">
                                <a href="./profile.php?id=<?= $employee['emp_id'] ;?>" class="normal btn-profile"><i class="fa-solid fa-eye"></i> View</a>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    
                    
                    <div class="row footer">
                        <div>
                            <button class="deny" name="remove"><i class="fa-solid fa-trash-can"></i> Remove Selected</button>
                        </div>
                        <div>
                            <button type="button" class="accept" id="btn-add-employee"><i class="fa-solid fa-plus"></i> Add New Employee</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>  
        <div class="footer">
            Payroll System | 2022 | <i class="fa-regular fa-copyright"></i> All rights reserved
        </div>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    Add new Employee
                </div>
                <div class="close" id="btn-modal-close"><i class="fa-solid fa-xmark"></i></div>
            </div>
            <div class="modal-body">
                <form action="." method="post">
                    <input type="text" name="fullname" class="" placeholder="Full Name" />
                    <input type="number" name="age" class="" placeholder="Age" />
                    <div class="combo-box">
                        <select name="gender">
                            <option selected="true" disabled="disabled">Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="combo-box">
                        <select name="job_id" id="">
                            <option value="0" disabled selected>--JOBS--</option>
                            <?php
                                foreach($payroll->fetchJobs() as $job){
                                    ?>
                                    <?="sasasa";?>
                                    <option value="<?= $job['job_id'];?> "> <?= $job['job_name']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div style="display:flex; justify-content: space-between; width: 100%;">
                        <div></div>
                        <div style="text-align:center ;">
                            <button id="btn-modal-cancel" class="deny modal-btn">Cancel</button>
                            <button id="btn-modal-confirm" class="accept modal-btn" name="confirm" >Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
</body>
</html>

<!-- JQuery -->
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="script.js"></script>