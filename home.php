<?php
session_start();
require_once("./payroll.php");
extract($_GET);

// Redirect in login page if user is not logged in
if(isset($_SESSION['username'])===FALSE && isset($_SESSION['password'])===FALSE) {
    header("location:login-form.php");
} 



$fetchEmployee = $payroll->fetchAllEmployees();

$payroll->deleteEmployee();  
//$changeAccountMessage = $payroll->changeAccount($_SESSION['username'], $_SESSION['status']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll System | Home</title>

    <!-- FontAwsome -->
    <script src="https://kit.fontawesome.com/e0c35786e8.js" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Chart -->
    <!-- Source from https://canvasjs.com/jquery-charts/ -->
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

    <!-- Calendar -->
    <!-- Source from https://github.com/brospars/simple-calendar -->
    <script src="./js/jquery.simple-calendar.js"></script>
    <link rel="stylesheet" href="./css/simple-calendar.css">
    
    <!-- Page JS -->
    <script src="./js/home.js"></script>
    <link rel="shortcut icon" href="./assets/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/home.css">

</head>
<body>
    
   <div class="bg-design"></div>
    <div class="container">
        <div class="panel-left">
            <div class="common-button">
                <div class="panel-left-header">
                    <a href="home.php" id="logo" title="Payroll System">
                        <img src="./assets/icon.png" alt="" srcset="">
                    </a>
                    <span id="title">
                        <h3>Payroll System</h3>
                    </span>
                    <span id="close-left-panel" class="close-left-button arrow-to-left">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                </div>
                <div class="panel-left-body">
                    <button id="btn-db" title="Dashboard">
                        <i class="fa-solid fa-border-all"></i>
                        <p>Dashboard</p>
                    </button>
                    <button id="btn-all-employee" title="Employee List">
                        <i class="fa-solid fa-list-ol"></i>
                        <p>Employee List</p>
                    </button>
                    <button id="btn-account" title="My Account">
                        <i class="fa-solid fa-user"></i>
                        <p>My Account</p>
                    </button>
                </div>
            </div>
            <div class="panel-left-footer">
                <button id="btn-logout" title="Logout">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <p>Logout</p>
                </button>
            </div>
        </div>
        <div class="panel-right">
            <div class="panel-right-header">
                <h1> 
                    <a href="home.php" class="my-logo" title="Payroll System">
                        <img src="./assets/icon.png" alt="" srcset="">
                    </a>
                    <span id="page-title"> Payroll System </span>
                </h1>
                <span class="search-bar">
                    <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="search"  name="search" id="search" value="<?= isset($search) ? $search : null ;?>" placeholder="Search Employee" autocomplete="off" title="Press enter to search">
                </span>
            </div>
            <div class="panel-right-body">
                <div class="panel-right-body-content">
                    <div class="block" id="dashB">
                        <div class="block-title">
                            <h2><i class="fa-solid fa-border-all"></i> Dashboard</h2>
                            <button class="block-title-btn" id="dashB-collapse" title="Collapse"><i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="block-body">
                            <div class="element dash-board">
                                <div class="element-header" style="text-align: center;"><h1>Welcome!</h1></div>
                                <div class="element-body" style="max-width: 200px;">
                                    <div>
                                        Good day (<?=$_SESSION['username'];?>)!
                                    </div>
                                    <div style="font-weight:bold;"> Quick Help </div>
                                </div>
                            </div>
                            <div class="element dash-board">
                                <div class="element-body" style="justify-content:center ;">
                                    <p id="date-today"></p>
                                </div>
                            </div>
                            <div class="element dash-board">
                                <div class="element-header"><h3>Employee per department</h3></div>
                                <div class="element-body" style="justify-content:center ;">
                                    <div id="chartContainer" style="height: 250px; width: 150px;"></div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <form class="block" id="all-emp-tb" style="justify-content: center;" method="post">
                        <div class="block-title">
                            <h2><i class="fa-solid fa-list-ol"></i> Employee List</h2>
                            <button type="button" class="block-title-btn" id="all-emp-tb-collapse" title="Collapse"><i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="block-body">
                            <div class="element employee-list">
                                <div class="element-body" style="justify-content: center;">
                                    <div class="table">
                                        <div class="table-head">
                                            <?php if($fetchEmployee["count"]){ ?>
                                                <span>
                                                    <input type="checkbox" id="cb-head" title="Select All">
                                                    <p> Select All </p>
                                                </span>
                                            <?php }  ?>
                                            <button type="button" id="btn-refresh-tb" title="Refresh Content"><i class="fa-solid fa-arrows-rotate"></i> Refresh</button>
                                        </div>
                                        <div class="table-body">
                                        <?php
                                        if($fetchEmployee['message']){
                                            echo $fetchEmployee['message'];
                                        } else {
                                            foreach($fetchEmployee["employees"] as $emp){
                                                $cjobs = [
                                                            "Web Developer"=> "#5DADE2",
                                                            "Data Scientist"=>"#A569BD",
                                                            "Mobile Developer"=> "#EC7063",
                                                            "Penetration Tester"=> "#F39C12",
                                                            "Game Developer"=>"#A6ACAF",
                                                        ];
                                            ?>
                                                    <div class="emp">
                                                        <div class="check-box">
                                                            <input type="checkbox" name="emp_id[]" class="cb-index" value="<?= $emp['emp_id'] ;?>">
                                                        </div>
                                                        <a  href="./profile.php?id=<?=  $emp['emp_id'] ;?>" style="--col:<?=$cjobs[$emp['job_name']];?>" fl="<?=strtoupper($emp['fullname'][0]);?>">
                                
                                                            <div class="name">
                                                                <p>
                                                                    <?=$emp['fullname'];?>
                                                                </p>
                                                                <div class="dept">
                                                                    <?=$emp['job_name'];?>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="element-body">
                                    <button class="btn-remove-emp" name="delete" value="delete">
                                        <p>
                                            <i class="fa-solid fa-user-xmark"></i>
                                            Remove Selected
                                        </p>
                                    </button>
                                    <button class="btn-add-emp" type="button">
                                        <p>
                                            <i class="fa-solid fa-user-plus"></i>
                                            Add New
                                        </p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="block" id="account-info">
                        <div class="block-title">
                            <h2><i class="fa-solid fa-user"></i> My Acount</h2>
                            <button class="block-title-btn" id="account-info-collapse" title="Collapse"><i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="block-body">
                            <form class="element flex-col my-account" method="post" id="changeAccountForm">
                                <div class="element-header">
                                    <h3>Account Details</h3>
                                </div>
                                <div class="element-body">
                                    <div class="flex-col">
                                        <label for="username">Username</label>
                                        <input name="username" id="username" type="text" value="<?=$_SESSION['username'];?>" readonly>
                                        <label for="old-pass">Old Password</label>
                                        <input name="old_pass" id="old-pass" type="password" placeholder="Enter Old Password">
                                        <label for="new-pass">New Password</label>
                                        <input name="new_pass" id="new-pass" type="password" placeholder="Enter New Password">
                                    </div>
                                    <div class="flex-col" style="justify-content: flex-end;">
                                        <button name="btn_save" id="btn-save" type="submit" title="Save" value="save">
                                            <i class="fa-solid fa-floppy-disk"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-right-footer">
                <p> Payroll System | 2022 | <i class="fa-regular fa-copyright"></i> Alrights reserved</p>
                <p>Made by group CRUD | Fundamentals of Database System</p>
            </div>
        </div>
    </div>
    <div id="modal-add-emp" class="modal">
        <form class="modal-content form-add-new-emp" method="post" id="add_emp">
            <div class="modal-header">
                <h3 class="title">Add new Employee</h3>
            </div>
            <div class="modal-body">
                <label for="Full Name">Enter full name</label>
                <input name="fullname" id="full-name" type="text" placeholder="Full Name">

                <label for="bday">Enter birth date</label>
                <input name="bday" id="bday" type="date" placeholder="Birth Date" value="2020-10-10">

                <label for="gender">Enter gender</label>
                <select name="gender" id="gender">
                    <option selected="true" disabled="disabled">Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>

                <label for="department">Enter department</label>
                <select name="department" id="department">
                    <option selected="true" disabled="disabled">Department</option>
                    <?php
                        foreach($payroll->fetchJobs() as $job){
                            ?>
                            <option value="<?= $job['job_id'];?> "> <?= $job['job_name']; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn add" name="add" value="add"><p> Add</p></button>
                <button class="btn close-modal" type="button"> Close </button>
            </div>
        </form>
    </div>
</body>
</html>