<?php
session_start();
require_once("./payroll.php");
if ( $_SESSION['status'] != "E") {
  header("location:login-form.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/employee.css" />
    <!-- Font Awesome Cdn Link -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <title>Attendance</title>
  </head>
  <body>
    <div class="container">
      <nav>
        <ul>
          <li>
            <a href="#" class="logo">
              <img src="./assets/icon.png" />
              <span class="nav-item">Payroll System</span>
            </a>
          </li>
          <li>
            <a href="employee.php">
              <i class="fas fa-database"></i>
              <span class="nav-item">Payslip</span>
            </a>
          </li>
          <li>
            <a href="attendance.php">
              <i class="fas fa-chart-bar"></i>
              <span class="nav-item">Attendance</span>
            </a>
          </li>
          <li>
            <a href="./logout.php" id="bottom" class="logout">
              <i class="fas fa-sign-out-alt"></i>
              <span class="nav-item">Log Out</span>
            </a>
          </li>
        </ul>
      </nav>
          <section class="attendance">
            <div class="attendance-list">
                <h1>PAYSLIPS</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>From</th>
                            <th>TO</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach($payroll->fetchAllPayslipsOrAttendance("payroll") as $row){
                          ?>

                          <tr>
                              <th><a href="./payslip.php?id=<?=$row[0];?>">Open</a></th>
                              <th><?= $row[6] ;?></th>
                              <th><?= $row[7] ;?></th>
                          </tr>
                          <?php
                              }
                          ?>
                        
                    </tbody>        
                </table>
            </div>
          </section>
        </div>
      </section>
    </div>
  </body>
</html>
