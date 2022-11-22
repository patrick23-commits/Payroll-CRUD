<?php
session_start();
require_once("./payroll.php");
extract($_GET);

setlocale(LC_MONETARY, "en_PH");
if(isset($_SESSION['username'])===FALSE && isset($_SESSION['password'])===FALSE) {
    header("location:login-form.php");
} 
$fetch = $payroll->fetchAllEmployees();
$totalEarnings = $payroll->fetchTotalEarnings()[1];
$month = $payroll->fetchTotalEarnings()[0];

$payroll->addEmployee();
$payroll->deleteEmployee();
$payroll->searchEmployees();    
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
                    <span id="page-title">
                        Payroll System
                    </span>
                </h1>
                <span class="search-bar">
                    <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="search"  name="search" id="search" value="<?= isset($search) ? $search : null ;?>" placeholder="Search Employee" autocomplete="off" title="Press enter to search">
                </span>
            </div>
            <div class="panel-right-body">
                <div class="panel-right-body-content">
                    <div class="block" id="dashB">
                        <div class="element-title">
                            <h3>Dashboard</h3>
                            <button class="element-title-btn" id="dashB-collapse" title="Collapse"><i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="element dash-board">
                            <div class="element-header"><h3>Overview</h3></div>
                            <div class="element-body" style="justify-content:flex-start ;">
                                <div class="flex-col">
                                    <p id="date-today"></p>
                                </div>
                            </div>
                            <div class="element-body" style="justify-content:flex-start ;">
                                <div class="flex-col">
                                    <label for="total-employee">Total Employees</label>
                                    <input readonly type="text" name="total-employee" value="21" id="total-employee">
                                </div>
                                <div class="flex-col">
                                    <label for="time-in">Timed in today</label>
                                    <input readonly type="text" name="time-in" value="18" id="time-in">
                                    <label for="time-out">Timed out today</label>
                                    <input readonly type="text" name="time-out" value="1" id="time-out">
                                </div>
                            </div>
                        </div>
                        <div class="element dash-board">
                            <div class="element-header"><h3>Employee per department</h3></div>
                            <div class="element-body" style="justify-content:center ;">
                                <div id="chartContainer" style="height: 300px; width: 300px;"></div>
                            </div>  
                        </div>
                        <div class="element dash-board">
                            <div class="element-header">
                                <h3> Total Earnings this Month</h3>
                                <p id="month-today"> (<?= $month ;?>)</p>
                            </div>
                            <div class="element-body" style="justify-content:flex-start ;">
                                <label for="total-earnings">₱</label>
                                <input readonly type="text" name="total-earnings" value="<?= $totalEarnings ;?>" id="total-earnings">
                            </div>  
                        </div>
                    </div>
                    <form method="post">
                        <div class="block" id="all-emp-tb" style="justify-content: center;">
                            <div class="element-title">
                                <h3>Employee List</h3>
                                <button class="element-title-btn" id="all-emp-tb-collapse" title="Collapse"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                            <div class="element employee-list">
                                <div class="element-body" style="justify-content: center;">
                                    <div class="table">
                                        <div class="row head">
                                            <?php
                                                if($fetch["count"]){
                                            ?>
                                            <div class="col check-box"><input type="checkbox" id="cb-head"></div>
                                            <?php
                                                }
                                            ?>
                                            <div class="col">Full Name</div>
                                            <div class="col">Department</div>
                                            <div class="col">Action</div>
                                        </div>
                                        <?php
                                        if($fetch['message']){
                                            echo $fetch['message'];
                                        } else {
                                            foreach($fetch["employees"] as $emp){
                                            ?>
                                            <div class="row">
                                                <div class="col check-box"><input type="checkbox" name="emp_id[]" class="cb-index" value="<?= $emp['emp_id'] ;?>"></div>
                                                <div class="col"><?=$emp['fullname'];?></div>
                                                <div class="col"><?=$emp['job_name'];?></div>
                                                <div class="col"><a href="./profile.php?id=<?=  $emp['emp_id'] ;?>"><i class="fa-solid fa-user"></i> View Profile</a></div>
                                                
                                            </div>
                                            <?php
                                            }
                                        }
                                        ?>
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
                        <div class="element-title">
                            <h3>My Acount</h3>
                            <button class="element-title-btn" id="account-info-collapse" title="Collapse"><i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <form class="element flex-col my-account" method="post">
                            <div class="element-header">
                                <h3>Account Details</h3>
                            </div>
                            <div class="element-body">
                                <div class="flex-col">
                                    <label for="username">Username</label>
                                    <input name="username" id="username" type="text" value="<?=$_SESSION['username'];?>" readonly>
                                    <label for="old-pass">Old Password</label>
                                    <input name="old-pass" id="old-pass" type="password" placeholder="Enter Old Password">
                                    <label for="new-pass">New Password</label>
                                    <input name="new-pass" id="new-pass" type="password" placeholder="Enter New Password">
                                </div>
                                <div class="flex-col" style="justify-content: flex-end;">
                                    <button name="btn-save" id="btn-save" type="submit" title="Save" value="save">
                                        <i class="fa-solid fa-floppy-disk"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
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
        <form class="modal-content form-add-new-emp" method="post">
            <div class="modal-header">
                <h3 class="title">Add new Employee</h3>
            </div>
            <div class="modal-body">
                <label for="Full Name">Enter full name</label>
                <input name="fullname" id="full-name" type="text" placeholder="Full Name">

                <label for="age">Enter age</label>
                <input name="age" id="age" type="number" placeholder="Age">

                <label for="gender">Enter gnder</label>
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
                <button class="btn add" name="add" value="add"><p><i class="fa-solid fa-plus"></i> Add</p></button>
                <button class="btn close-modal" type="button"> Close </button>
            </div>
        </form>
    </div>
</body>
</html>