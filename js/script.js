$(document).ready(()=>{ 
    if(window.history.replaceState){
        window.history.replaceState(null, null, window.location.href)
    }

    $("#btn-home").on("click", ()=>{
        window.location.href = "home.php";
    });

    $(".cb-head").on("change", ()=>{
        if($(".cb-head").prop("checked") == true){
            $('.cb-item').prop('checked', true);
        }else{
            $('.cb-item').prop('checked', false);
        }
    });

    
    $("#btn-add-employee").on("click",()=>{
        $("#modal").fadeToggle(200);
    });

    $("#btn-modal-close").on("click", ()=>{
        $("#modal").fadeToggle(200);
    });

    $("#btn-modal-cancel").on("click", ()=>{
        $("#modal").fadeToggle(200);
    });

    $("#btn-modal-confirm").on("click", ()=>{
        $("#modal").fadeToggle(200);
    });

    $("#btn-profile-back").on("click", ()=>{
        window.location.href = "home.php";
    });


    $("#from_").on("change",(e)=>{
        getWorkingDays(e.target.value, $("#to_").val())
    });

    $("#to_").on("change",(e)=>{
        getWorkingDays($("#from_").val(), e.target.value)
    });

    $("#num_days_present").on("keyup", (e)=>{
        if(e.target.value) {
            $("#overtime").prop("disabled", false)
            $("#undertime").prop("disabled", false)
            $("#late").prop("disabled", false)
        } else {
            $("#overtime").prop("disabled", true)
            $("#undertime").prop("disabled", true)
            $("#late").prop("disabled", true)
        }
        if(parseInt(e.target.value) > $("#working_days").text()) {
            $("#num_days_present").val("")
            alert("Invalid : Days of present must be less or equal to Working Days")
        }
        computeNetPay()
    });
    $("#overtime").on("keyup", (e)=>{
        computeNetPay()
    });
    $("#undertime").on("keyup", (e)=>{
        computeNetPay()
    });
    $("#late").on("keyup", (e)=>{
        computeNetPay()
    });

    function getWorkingDays(from, to) {
        // CHECK BOTH input[date] if value is valid
        if(from && to) {
            $("#num_days_present").prop("disabled", false)
            let setFrom = new Date(from)
            let setTo = new Date(to)

            let timeDiff = setTo.getTime() - setFrom.getTime();
            let number_of_rest_day = Math.floor(((timeDiff / (1000 * 3600 * 24)  + 1) / 15) * 2);
            number_of_rest_day == 5 ? number_of_rest_day -= 1 : null 
            let working_days = Math.ceil((timeDiff / (1000 * 3600 * 24)  + 1) - number_of_rest_day);
            console.log(Math.ceil((timeDiff / (1000 * 3600 * 24)  + 1)) + " " + number_of_rest_day)
            
            if(working_days == 13 || working_days == 26 || working_days == 27) {
                $("#working_days").text(working_days)
                computeGrossPay(working_days)
            } else {
                alert("This System Computes the payroll by EVERY 15 DAYS  OR BY EVERY 30 DAYS OR BY EVERY 31 DAYS")
                $("#working_days").text("0")
                $("#num_days_present").val("")
                $("#net_pay").val("")
                $("#to_").val("")
                $("#from_").val("")
            }
            
        }
    }

    function getDaysAbsent(working_days, num_days_present) {
        return working_days - num_days_present

    }
    function computeGrossPay(working_days) {
        let gross_salary = parseInt($("#daily_rate").val() * parseInt(working_days))
        $("#gross_pay").val(gross_salary);
    }

    function computeNetPay() {
       
        let total = 0
        total = total + computeDaysOfPresent()
        total += computeOvertime()
        total = total - deduct_undertime()
        total = total- (deduct_late())
        total = total - deductTaxes()
        total > 0 ? $("#net_pay").val(total.toFixed(2)) : $("#net_pay").val("");
    }
    function deduct_undertime(){
        // Per hour
        let hourly_rate = parseInt($("#daily_rate").val()) / 8
        return  hourly_rate * parseInt($("#undertime").val()) ? hourly_rate * parseInt($("#undertime").val()) : 0;
    }
    function deduct_late() {
        // Per minute 
        let hourly_rate = parseInt($("#daily_rate").val()) / 8
        return hourly_rate * ($("#late").val()) ?((hourly_rate / 60) * parseInt($("#late").val())): 0 ;
    }

    function computeDaysOfPresent() {
        return parseInt($("#daily_rate").val()) * parseInt($("#num_days_present").val()) ? parseInt($("#daily_rate").val()) * parseInt($("#num_days_present").val()) : 0
    }

    function deductTaxes() {
        return (parseInt($("#sss").val()) + parseInt($("#pagibig").val()) + parseInt($("#philhealth").val())) 
    }
    function computeOvertime() {
        // Per hour
        let hourly_rate = parseInt($("#daily_rate").val()) / 8
        return hourly_rate * parseInt($("#overtime").val()) ?  hourly_rate * parseInt($("#overtime").val()) : 0;
    }

    $("#add-employee-form").on("submit",(e)=>{
        if(!$("#fullname").val() || !$("#age").val() || !$("#gender").val() || !$("#job").val()){
            alert("Invalid Inputs")
            e.preventDefault()
        }
    })

    $("#save").on("click",(e)=>{
        if(!$("#net_pay").val()){
            alert("Data is Not Complete")
        } else {
            let late_amount = deduct_late()
            let undertime_amount = deduct_undertime()
            let overtime_amount = computeOvertime()
            $.ajax({
                url : "./php/insertPayroll.php",
                type : "POST",
                contentType : "application/x-www-form-urlencoded;charset=UTF-8",
                data : { gross_pay : $("#gross_pay").val(), net_pay : $("#net_pay").val(), job_name : $("#job_name").val(),
                        from_: $("#from_").val(), to_:$("#to_").val(), emp_id : $("#emp_id").val(),
                        num_days_present : $("#num_days_present").val(), late : $("#late").val(), undertime : $("#undertime").val(),
                        overtime : $("#overtime").val(), late_amount : late_amount,
                    undertime_amount : undertime_amount, overtime_amount : overtime_amount,
                    absent :getDaysAbsent(parseInt($("#working_days").text()), parseInt($("#num_days_present").val()))},
                success : (message)=>{
                    let resp = JSON.parse(message)
                    alert(resp['message'])
                    window.location.reload()
                    
                }
            })
        }
    })

    $("#search").on("click",(e)=>{
        if(!$("#name_search").val()){
            e.preventDefault()
        }
    })

    $("#remove").on("click", (e)=>{
        let submit = false;
        $(".check-id").each((index)=>{
            if($('.check-id')[index].checked) {
                submit = true
                return false
            }
        })
        if(submit == false) {
            e.preventDefault()
        } 
    }) 

});