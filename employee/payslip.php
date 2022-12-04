<?php
session_start();
require_once("../payroll.php");
if(isset($_GET['id']))
$payslipInfo = $payroll->fetchEmployeePayslip($_GET['id']);
else {
    header("Location:employee.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8/">
    <title>Payslip</title>
    <link rel="stylesheet" href="../css/payslip.css">
    <link rel="shortcut icon" href="../assets/icon.png" type="image/x-icon">
</head>
<body>
    
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">

                    <table>
                        <tr>
                            <td>
                                <h4>PAYSLIP | CRUD</h4>
                            </td>
                            <td>
                                Employee ID: <?=$payslipInfo['emp_id'];?> <br>
                                Created: <?=$payslipInfo['from_'];?> <br>
                            </td>
                        </tr>
                    </table>
                        

                </td>
            </tr>

            <tr class="information">
                <td colspan="2">

                    <table>
                        <tr>
                            <td>
                                Name of the Employee: <span style="text-decoration: underline;"> <?=$payslipInfo['fullname'];?> </span> <br>
                                Department:<span style="text-decoration: underline;"> <?=$payslipInfo['job_name'];?> </span> <br>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>

            <tr class="heading">
                <td>
                    Date From
                </td>
                <td>-----</td>
            </tr>

            <tr class="details">
                <td><?=$payslipInfo['from_'];?></td>
            </tr>

            <tr class="heading">
                <td>Date To</td>
                <td>-----</td>   
            </tr>

            <tr class="details">
                <td><?=$payslipInfo['to_'];?></td>
            </tr>

            <tr class="heading">
                <td>Gross Pay</td>
                <td>-----</td>
            </tr>

            <tr class="details">
                <td>Php</td>
                <td><?=$payslipInfo['gross_pay'];?></td>
            </tr>

            <tr class="heading">
                <td>Net Pay</td>
                <td>-----</td>
            </tr>

            <tr class="details">
                <td>Php</td>
                <td><?=$payslipInfo['net_pay'];?></td>
            </tr>

            <tr class="heading">
                <td>Deduction</td>
                <td>-----</td>
            </tr>

            <tr class="details">
                <td>Php</td>
                <td><?=$payslipInfo['Deduction'];?></td>
            </tr>

            <tr class="footer">
                <td>Thank you for the great effort this month!!!</td>
                <tr class="terms">
                    <td class="bold tc">Terms & Conditions</td>
                    <td>A Terms and Conditions agreement is where you let the public know the terms, rules and guidelines for using your website or mobile app. </td>
                </tr>
            </tr>

        </table>

    </div>
    <!-- <button type="button" id="print">Print</button>
    <script>
        document.getElementById("print").addEventListener("click", ()=>{
            window.print()
        })
    </script> -->
</body>    
</html>