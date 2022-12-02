<?php
session_start();
require_once("./payroll.php");
if (isset($_SESSION['username']) === FALSE && isset($_SESSION['password']) === FALSE || $_SESSION['status'] != "E") {
  header("location:login-form.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/attendance.css" />
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
            <a href="#">
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
          <se class="attendance">
            <div class="attendance-list">
                <h1>Attendance</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>FROM</th>
                            <th>TO</th>
                            <th>LATE</th>
                            <th>UNDERTIME</th>
                            <th>OVERTIME</th>
                        </tr>
                    </thead>
                    <tbody>
                          <?php
                            foreach($payroll->fetchAllPayslipsOrAttendance("attendance") as $row){
                          ?>
                        <tr>   
                            <td><?= $row[6] ;?></td>    
                            <td><?= $row[7] ;?></td>
                            <td><?= $row[3] ;?> Hours</td>
                            <td><?= $row[4] ;?> Hours</td>
                            <td><?= $row[5] ;?> Hours</td>
                        </tr>
                          <?php
                            }
                          ?>
                    </tbody>
                </table>
            </div>
          </se>
        </div>
      </section>
    </div>
  </body>
</html>
