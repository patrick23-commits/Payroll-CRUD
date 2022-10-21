$(document).ready(()=>{
    

    $("#btn-home").on("click", ()=>{
        window.location.href = "home.php";
    });

    $("#btn-option").on("click", ()=>{
        //Open Modal
    });

    // $("#btn-back").on("click", ()=>{
    //     window.location.href = "home.html";
    // });

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
    })

    $("#to_").on("change",(e)=>{
        getWorkingDays($("#from_").val(), e.target.value)
    })

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
    })
    $("#overtime").on("keyup", (e)=>{
        computeNetPay()
    })
    $("#undertime").on("keyup", (e)=>{
        computeNetPay()
    })
    $("#late").on("keyup", (e)=>{
        computeNetPay()
    })
    

    function getWorkingDays(from, to) {
        // CHECK BOTH input[date] if value is valid
        if(from && to) {
            $("#num_days_present").prop("disabled", false)
            let setFrom = new Date(from)
            let setTo = new Date(to)

            let timeDiff = Math.abs(setTo.getTime() - setFrom.getTime());
            let working_days = Math.ceil(timeDiff / (1000 * 3600 * 24)) - 1;
            console.log(("#working_days").innerText)
            $("#working_days").text(working_days)
            computeGrossPay(working_days)
        }
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
        console.log(total)
        total > 0 ? $("#net_pay").val(total) : $("#net_pay").val("");
    }
    function deduct_undertime(){
        let hourly_rate = parseInt($("#daily_rate").val()) / 8
        return  hourly_rate * parseInt($("#undertime").val()) ? hourly_rate * parseInt($("#undertime").val()) : 0;
    }
    function deduct_late() {
        let hourly_rate = parseInt($("#daily_rate").val()) / 8
        return  hourly_rate * parseInt($("#late").val()) ? hourly_rate * parseInt($("#late").val()): 0 ;
    }

    function computeDaysOfPresent() {
        return parseInt($("#daily_rate").val()) * parseInt($("#num_days_present").val()) ? parseInt($("#daily_rate").val()) * parseInt($("#num_days_present").val()) : 0
    }

    function deductTaxes() {
        return (parseInt($("#sss").val()) + parseInt($("#pagibig").val()) + parseInt($("#philhealth").val())) 
    }
    function computeOvertime() {
        let hourly_rate = parseInt($("#daily_rate").val()) / 8
        return hourly_rate * parseInt($("#overtime").val()) ?  hourly_rate * parseInt($("#overtime").val()) : 0;
    }
});