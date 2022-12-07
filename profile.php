<?php
session_start();
require_once("./payroll.php");
if (isset($_SESSION['username']) == FALSE && isset($_SESSION['password']) == FALSE || $_SESSION['status'] != "A") {
    header("location:login-form.php");
}
$GLOBALS['employee'] = $payroll->fetchEmployee($_GET['id']);
if (isset($_POST['logout'])) {
    $payroll->logout();
}
if (isset($_POST['update'])) {
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
    <title>Payroll System | <?php echo $employee["fullname"] ?></title>

    <!-- FontAwsome -->
    <script src="https://kit.fontawesome.com/e0c35786e8.js" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Page JS -->
    <!-- <script src="./js/home.js"></script> -->
    <script src="./js/profile.js"></script>
    <script src="./js/script.js"></script>

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
                    <button class="btn-db" title="Dashboard">
                        <i class="fa-solid fa-border-all"></i>
                        <p>Dashboard</p>
                    </button>
                    <button id="btn-identity" title="Identification" prof="<?= $_GET['id']; ?>">
                        <i class="fa-solid fa-user"></i>
                        <p>Identification</p>
                    </button>
                    <button id="btn-tax-attnd" title="Tax & Attendance" prof="<?= $_GET['id']; ?>">
                        <i class="fa-solid fa-chart-line"></i>
                        <p>Tax & Attendance</p>
                    </button>
                    <button id="btn-proll" title="Payroll" prof="<?= $_GET['id']; ?>">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <p>Payroll</p>
                    </button>
                </div>
            </div>
            <div class="panel-left-footer">
                <button id="btn-logout" title="Logout" type="button">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <p>Logout</p>
                </button>
            </div>
        </div>
        <div class="panel-right">
            <div class="panel-right-header">
                <h1 style="white-space: normal;">
                    <a href="home.php" class="my-logo" title="Payroll System">
                        <img src="./assets/icon.png" alt="" srcset="">
                    </a>
                    
                </h1>
                <span>
                    <button class="btn-db btn-db-prof" title="Dashboard">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </span>
            </div>
            <form class="panel-right-body" id="payroll-form" action="./profile.php?id=<?= $_GET['id']; ?>" method="post" >
                <div class="panel-right-body-content">
                    <div class="block" id="identity">
                        <div class="block-title">
                            <h2><i class="fa-solid fa-user"></i> Employee Identification</h2>
                        </div>
                        <div class="block-body">
                            <div class="element">
                                <div class="element-header" style="text-align: center;">
                                    <h2> Profile </h2>
                                </div>
                                <form class="element-body form" style="display: flex; flex-direction: column; gap: 10px;">
                                    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
                                        <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                            <label for="id-username">Username</label>
                                            <input type="text" readonly placeholder="Username" value="<?= $employee['email']; ?>">

                                            <label for="id-id">ID</label>
                                            <input type="text" readonly name="emp_id" placeholder="ID" value="<?= $employee['emp_id']; ?>">

                                            <label for="id-fname">Full name</label>
                                            <input type="text" name="fullname" placeholder="Enter Full Name" value="<?= $employee['fullname']; ?>">
                                        </div>
                                        <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                            <label for="id-age">Age</label>
                                            <input type="text" name="age" placeholder="Age" value="<?= $employee['age']; ?>" readonly>

                                            <label for="id-bday">Birthdate</label>
                                            <input type="date" name="bdate" placeholder="Birthdate" value="<?= $employee['date_of_birth']; ?>">

                                            <label for="id-gender">Gender</label>
                                            <select name="gender" id="" class="combo-box-gender">
                                                <option value="Male" <?= $employee['gender'] == 'Male' ? 'selected' : NULL; ?>>Male</option>
                                                <option value="Female" <?= $employee['gender'] == 'Female' ? 'selected' : NULL; ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span></span>
                                        <button name="update" class="btn-update"> <i class="fa-solid fa-pen"></i> Update</button>
                                    </div>
                                </form>
                            </div>
                            <div class="element">
                                <div class="element-header" style="text-align: center;">
                                    <h2> Department </h2>
                                </div>
                                <div class="element-body" style="justify-content: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                        <label for="id-job-name">Job Department</label>
                                        <input type="text" name="job_name" tabindex="-1" readonly placeholder="Job Department" value="<?= $employee["job_name"]; ?>">

                                        <label for="id-salary-range">Salary Range</label>
                                        <input type="text" id="daily_rate" tabindex="-1" readonly placeholder="Salary Range" value="<?= $employee["salary_range"]; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block" id="tax-attnd">
                        <div class="block-title">
                            <h2><i class="fa-solid fa-chart-line"></i> Tax and Attendance</h2>
                        </div>
                        <div class="block-body">
                            <div class="element">
                                <div class="element-header" style="text-align: center;">
                                    <h2> Tax </h2>
                                </div>
                                <div class="element-body" style="justify-content: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                        <label for="id-job-name">SSS</label>
                                        <input type="text" name="sss" tabindex="-1" id="sss" readonly placeholder="SSS" value="<?= $tax['sss']; ?>">

                                        <label for="id-salary-range">PAGIBIG</label>
                                        <input type="text" name="pagibig" tabindex="-1" id="pagibig" readonly placeholder="PAGIBIG" value="<?= $tax['pagibig']; ?>">

                                        <label for="id-salary-range">PhilHealth</label>
                                        <input type="text" name="philhealth" tabindex="-1" id="philhealth" readonly placeholder="PhilHealth " value="<?= $tax['philhealth']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="element">
                                <div class="element-header" style="text-align: center;">
                                    <div>
                                        <h2> Attendance </h2>
                                        <p style="display:inline-block; color: #333; ">
                                            Total Number of Working Days :
                                            <span id="working_days">0</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="element-body" style="justify-content: center;">
                                    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
                                        <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                            <label for="id-job-name">Present</label>
                                            <input type="text" disabled id="num_days_present" name="num_days_present" placeholder="Enter Days Present">

                                            <label for="id-salary-range">Overtime</label>
                                            <input type="text" disabled id="overtime" name="overtime" placeholder="Enter Overtime">
                                        </div>
                                        <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                            <label for="id-salary-range">Undertime</label>
                                            <input type="text" disabled id="undertime" name="undertime" placeholder="Enter Undertime">

                                            <label for="id-salary-range">Late</label>
                                            <input type="text" disabled id="late" name="late" placeholder="Enter Late">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block" id="proll">
                        <div class="block-title">
                            <h2><i class="fa-solid fa-money-bill-wave"></i> Payroll</h2>
                        </div>
                        <div class="block-body" style="justify-content: center;">
                            <div class="element">
                                <div class="element-header" style="text-align: center;">
                                    <h2> Salary </h2>
                                </div>
                                <div class="element-body" style="justify-content: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                        <label for="id-job-name">Gross Pay</label>
                                        <input type="text" name="gross_pay" tabindex="-1" id="gross_pay" placeholder="Gross Pay" readonly>

                                        <label for="id-salary-range">Net Pay</label>
                                        <input type="text" name="net_pay" tabindex="-1" id="net_pay" placeholder="Net Pay" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="element">
                                <div class="element-header" style="text-align: center;">
                                    <h2> Pay Roll </h2>
                                </div>
                                <div class="element-body" style="justify-content: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                        <label for="id-job-name">From</label>
                                        <input type="date" name="from_" id="from_">

                                        <label for="id-salary-range">To</label>
                                        <input type="date" name="to_" id="to_">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-body">
                            <div class="element" style="justify-content: center; align-items: center    ;">
                                <button id="save" name="save"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
if(isset($_POST['save'])){
    $payroll->insertPayroll();
} 
?> 