<?php
class Payroll
{
    private $DB_NAME = "payroll_crud";
    private $username = "";
    private $password = "";

    public function createDatabase()
    {
        $isDatabaseExist = FALSE;
        $con = $this->connection('root', "");
        $databases = "SHOW DATABASES";
        $result = $con->query($databases);
        while ($row = $result->fetch_assoc()) {
            if ($row['Database'] == $this->DB_NAME) {
                $isDatabaseExist = TRUE;
                break;
            }
        }

        if ($isDatabaseExist == FALSE) {
            $query = "CREATE DATABASE $this->DB_NAME";
            $db = $con->query($query);
            if ($db) {
                return "DATABASE $this->DB_NAME  CREATED !";
            } else {
                return NULL;
            }
        }
    }
    public function tablesCreated()
    {
        $tables = ["job", "employee", "attendance", "tax", "salary", "payroll"];
        $count = 0;
        $con = $this->connection("root", "");
        $con->select_db($this->DB_NAME);
        $res = $con->query("SHOW TABLES");
        foreach ($res as $row)
            foreach ($row as $_t)
                foreach ($tables as $_tb)
                    if ($_t == $_tb) $count++;
        $con->close();

        return ($count == count($tables)) ? true : false;
    }

    public function setUserInfo()
    {
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
        $this->login($this->username, $this->password);
    }
    public function connection($username, $password)
    {
        $con = new mysqli("localhost", $username, $password);
        if($con->connect_error) {
            echo "<script>alert('USER NOT FOUND!!')
            window.location.href = window.location.href;
            </script>";
            die();
            
        } 
        return $con;
    }
    public function createUser()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $con = $this->connection("root", "");
        $con->select_db("mysql");
        $createUserQuery = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password';";
        $createUserQuery .= "GRANT ALL PRIVILEGES ON *.* TO '$username'@'localhost' IDENTIFIED BY '$password'";
        $user = $con->multi_query($createUserQuery);
        $con->close();
        return $user ?  "<script>alert('$username CREATED SUCCESSFULY')</script>" : "<script>alert('USER  $username IS ALREADY REGISTERED')</script>";
    }

    public function login($username, $password)
    {
        $con = $this->connection($username, $password);
        $databaseMessage = $this->createDatabase();
    
        $_SESSION['username'] = $this->username;
        $_SESSION['password'] = $this->password;

        $script = "<script> 
                    alert('$_SESSION[username] connected successfuly!');\n";
        if($databaseMessage) {
            $script .= "alert(' ". $databaseMessage."')\n";
        }    
        $script .= "window.location.href = 'https://localhost/Payroll-CRUD/home.php';
        </script>";

        echo $script;
        
        $con->close();
    }

    public function logout()
    {
        $_SESSION['username'] = null;
        $_SESSION['password'] = null;
        header("location:login.php");
    }
    public function addEmployee()
    {
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        if (!$con->connect_error) {
            $employee = "INSERT INTO employee (`fullname`, `age`, `gender`, `job_id`) VALUES ('$_POST[fullname]', $_POST[age], '$_POST[gender]', $_POST[job_id])";
            if ($con->query($employee) === TRUE) {
                echo "<script> alert('$_POST[fullname] added.') 
                        window.location.href = 'https://localhost/Payroll-CRUD' 
                        </script>";
            } else {
                echo "<script> 
                        alert('$_POST[fullname] is already exist.');
                        window.location.href = 'https://localhost/Payroll-CRUD' ;
                    </script>";
            }
        }
        $con->close();
    }

    public function fetchAllEmployees()
    {
        $fetchEmployeesQuery = "";
        $employees = array();
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        if (!$con->connect_error) {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $fetchEmployeesQuery = "SELECT employee.emp_id,employee.fullname, job.job_name FROM employee 
                LEFT JOIN job
                ON employee.job_id = job.job_id
                ORDER BY employee.fullname ASC";
            } else {
                if (isset($_POST['search'])) {
                    $fetchEmployeesQuery = "SELECT employee.emp_id,employee.fullname, job.job_name FROM employee 
                    JOIN job
                    ON employee.job_id = job.job_id
                    WHERE employee.fullname LIKE '%" . $_POST['search_name'] . "%'
                    ORDER BY employee.fullname ASC";
                }
            }

            $result = $con->query($fetchEmployeesQuery);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($employees, $row);
                }
            } else {
                if ($_SERVER['REQUEST_METHOD'] == "GET" || ($_SERVER['REQUEST_METHOD'] == "POST" && $result->num_rows == 0 && !isset($_POST['search']))) {
                    echo "<h1>No Employee!!</h1>";
                } else {
                    if (isset($_POST['search']))
                        echo "<h1>No result for Employee $_POST[search_name]</h1>";
                }
            }
        }
        $con->close();
        return $employees;
    }

    public function fetchEmployee($emp_id)
    {
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        if (!$con->connect_error) {
            $fetchEmployeeQuery = "SELECT employee.emp_id,employee.fullname, employee.age,employee.gender,
                                    job.job_name, job.salary_range
                                    FROM employee
                                    LEFT JOIN job
                                    ON employee.job_id = job.job_id
                                    WHERE employee.emp_id = $emp_id";
            $result = $con->query($fetchEmployeeQuery);
            $con->close();
            return $result->fetch_array();
        }
    }

    public function fetchTax()
    {
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        if (!$con->connect_error) {
            $fetchTaxQuery = "SELECT * FROM tax";
            $result = $con->query($fetchTaxQuery);
            $con->close();
            return $result->fetch_array();
        }
    }

    public function createTables()
    {
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        $createTableJobQuery = "CREATE TABLE job (
                                job_id int PRIMARY KEY AUTO_INCREMENT,
                                job_name varchar(25) UNIQUE,
                                salary_range bigint
                            );";

        $con->query($createTableJobQuery);
        $createTableEmployeeQuery = "CREATE TABLE employee (
            emp_id int PRIMARY KEY AUTO_INCREMENT,
            fullname varchar(50) NOT NULL UNIQUE,
            age int NOT NULL,
            gender varchar(6) NOT NULL,
            job_id int NOT NULL,
            FOREIGN KEY(job_id) REFERENCES job(job_id)
        );";
        $con->query($createTableEmployeeQuery);

        $createTableAttendanceQuery = "CREATE TABLE attendance (
            attendance_id int PRIMARY KEY AUTO_INCREMENT,
            emp_id int NOT NULL,
            num_of_days_present int,
            late int,
            undertime int,
            overtime int,
            from_ Date,
            to_ Date,
            FOREIGN KEY(emp_id) REFERENCES employee(emp_id)
        );";
        $con->query($createTableAttendanceQuery);

        $createTableTaxQuery = "CREATE TABLE tax(
            tax_id int PRIMARY KEY AUTO_INCREMENT,
            sss int NOT NULL, 
            pagibig int NOT NULL,
            philhealth int NOT NULL
        );";
        $con->query($createTableTaxQuery);

        $createTableSalaryQuery = "CREATE TABLE salary (
            salary_id int PRIMARY KEY AUTO_INCREMENT,
            emp_id int,
            job_id int,
            gross_pay bigint,
            net_pay bigint,
            from_ Date,
            to_ Date,
            FOREIGN KEY (emp_id) REFERENCES employee(emp_id),
            FOREIGN KEY (job_id) REFERENCES job(job_id)     
        );";
        $con->query($createTableSalaryQuery);


        $createTablePayrollQuery = "CREATE TABLE payroll (
            payroll_id int PRIMARY KEY AUTO_INCREMENT,
            emp_id int, 
            job_id int,
            attendance_id int,
            tax_id int, 
            salary_id int, 
            from_ Date,
            to_ Date,
            FOREIGN KEY(emp_id) REFERENCES employee(emp_id),
            FOREIGN KEY(job_id) REFERENCES job(job_id),
            FOREIGN KEY(attendance_id) REFERENCES attendance(attendance_id),
            FOREIGN KEY(tax_id) REFERENCES tax(tax_id),
            FOREIGN KEY(salary_id) REFERENCES salary(salary_id)
        )";
        $con->query($createTablePayrollQuery);

        $this->insertDepartmentAndDeduction();
    }

    public function insertDepartmentAndDeduction()
    {

        $jobs = array(array('Web Developer', 1000), array('Data Scientist', 1500), array('Mobile Developer', 1250), array('Penetration Tester', 1500), array('Game Developer', 1000));
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        foreach ($jobs as $job) {
            $insertDepartmentQuery = "INSERT INTO job (job_name, salary_range) VALUES ('$job[0]', '$job[1]')";
            if (!$con->query($insertDepartmentQuery) === TRUE) {
                echo "$job[0] NOT INSERTED IN jobs";
            }
        }

        // CHECK TAX IF NO DATA
        $taxSelectQuery = "SELECT * FROM tax";
        if ($con->query($taxSelectQuery)->num_rows == 0) {
            $tax = array("sss" => 100, "pagibig" => 100, "philhealth" => 150);
            $insertTaxQuery = "INSERT INTO tax (sss, pagibig, philhealth) VALUES ('$tax[sss]', '$tax[pagibig]', '$tax[philhealth]')";
            if ($con->query($insertTaxQuery) === FALSE) {
                echo ("ERROR" . $con->error);
            }
        }
        $con->close();
    }

    public function fetchJobs()
    {
        $jobs = array();
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);

        $fetchJobsQuery = "SELECT * FROM job";
        $result = $con->query($fetchJobsQuery);
        echo var_dump($con->error);
        while ($row = $result->fetch_assoc()) {
            array_push($jobs, $row);
        }
        return $jobs;
    }

    public function insertPayroll()
    {

        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        $emp_id = $_POST['emp_id'];
        $doesHaveExistingPayroll = $this->doesHaveExistingPayroll($emp_id, $_POST['from_'], $_POST['to_']);
        if (!$doesHaveExistingPayroll) {
            $insertAttendanceQuery = "INSERT INTO attendance (emp_id, num_of_days_present,late,undertime,overtime, from_, to_) VALUES ('$emp_id', '$_POST[num_days_present]', '$_POST[late]', '$_POST[undertime]','$_POST[overtime]',DATE('$_POST[from_]'),DATE('$_POST[to_]'))";
            $con->query($insertAttendanceQuery);

            $fetchJobIdQuery = "SELECT job_id from job WHERE job_name = '$_POST[job_name]'";
            $job_id = $con->query($fetchJobIdQuery)->fetch_assoc();

            $fetchAttendanceIdQuery = "SELECT attendance_id from attendance WHERE from_= DATE('$_POST[from_]') AND to_= DATE('$_POST[to_]') AND emp_id='$emp_id'";
            $attendance_id = $con->query($fetchAttendanceIdQuery)->fetch_assoc();

            $insertSalaryQuery = "INSERT INTO salary (emp_id, job_id,gross_pay, net_pay, from_, to_) VALUES ('$emp_id', '$job_id[job_id]','$_POST[gross_pay]', '$_POST[net_pay]',DATE('$_POST[from_]'),DATE('$_POST[to_]'))";
            $con->query($insertSalaryQuery);

            $fetchSalaryIdQuery = "SELECT salary_id from salary WHERE from_= DATE('$_POST[from_]') AND to_= DATE('$_POST[to_]') AND emp_id='$emp_id'";
            $salary_id = $con->query($fetchSalaryIdQuery)->fetch_assoc();


            $insertPayrollQuery = "INSERT INTO `payroll`(`emp_id`, `job_id`, `attendance_id`, `tax_id`, `salary_id`, `from_`, `to_`) VALUES ('$emp_id','$job_id[job_id]','$attendance_id[attendance_id]','1', '$salary_id[salary_id]',DATE('$_POST[from_]'),DATE('$_POST[to_]'))";
            $con->query($insertPayrollQuery);
            if (!$con->error) echo "<script>alert('Payroll inserted')</script>";
        } else {
            echo "<script>alert('Employee Does have existing payroll for DATE " . $doesHaveExistingPayroll['from_'] . " to " . $doesHaveExistingPayroll['to_'] . "!!')</script>";
        }
        $con->close();
    }

    public function doesHaveExistingPayroll($emp_id, $from_, $to_)
    {
        $f = "";
        $t = "";
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        $query = "SELECT * FROM payroll WHERE emp_id='$emp_id' AND from_ BETWEEN DATE('$from_') AND DATE('$to_') AND to_ BETWEEN DATE('$from_') AND DATE('$to_')";
        $result =  $con->query($query);
        while ($row = $result->fetch_assoc()) {
            $f = $row['from_'];
            $t = $row['to_'];
        }
        return $con->query($query)->num_rows ? array("from_" => $f, "to_" => $t) : FALSE;
    }

    public function updateEmployee()
    {
        $emp_id = $_POST['emp_id'];
        $fullname = $_POST['fullname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];

        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        $employee = $this->fetchEmployee($emp_id);
        if ($fullname != $employee['fullname'] || $age != $employee['age'] || $gender != $employee['gender']) {
            $query = "UPDATE employee SET fullname='$fullname', age='$age', gender='$gender' WHERE emp_id = '$emp_id'";
            if ($con->query($query)) {
                echo "<script>alert('Employee Updated!!')</script>";
            }
        }
        $con->close();
    }

    public function deleteEmployee()
    {
        $con = $this->connection($_SESSION['username'], $_SESSION['password']);
        $con->select_db($this->DB_NAME);
        if (isset($_POST['emp_id'])) {
            foreach ($_POST['emp_id'] as $id) {
                $deletePayrollQuery = "DELETE FROM payroll WHERE emp_id = '$id'";
                $con->query($deletePayrollQuery);
                $deleteAttendanceQuery = "DELETE FROM attendance WHERE emp_id = '$id'";
                $con->query($deleteAttendanceQuery);

                $deleteSalaryQuery = "DELETE FROM salary WHERE emp_id = '$id' ";
                $con->query($deleteSalaryQuery);

                $deleteEmployeeQuery = "DELETE FROM employee WHERE emp_id = '$id' ";
                $con->query($deleteEmployeeQuery);
            }
            header("location:home.php");
        }
    }
}
$payroll = new Payroll();
