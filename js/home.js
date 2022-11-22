$(document).ready(()=>{
    let left_panel_closed = true;

    // close panel when close btn is clicked
    $("#close-left-panel").on("click", ()=>{
        if(!left_panel_closed){
            $(".panel-left").css({"width":"60px"});
            $(".panel-left #logo, #title").css({"display": "none"})
            $(".panel-left button p").css({"display": "none"})
            $(".panel-left #close-left-panel").css({"transform":"rotate(0deg)"});
            $(".panel-left button").css({"justify-content":"center", "padding": "10px"});
            left_panel_closed = true;
        }else{
            $(".panel-left").css({"width":"290px"});
            $(".panel-left #close-left-panel").css({"transform":"rotate(180deg)"});
            $(".panel-left #logo, #title").css({"display": "block"})
            $(".panel-left button").css({"justify-content":"flex-start", "padding": "10px 20px"});
            $(".panel-left button p").css({"display": "block"})
            left_panel_closed = false;
        }
    })

    function CloseLeftPanel(){
        left_panel_closed = false;
        $("#close-left-panel").trigger("click");
    }

    $("#cb-head").on("change", ()=>{
        $(".cb-index").prop("checked", $("#cb-head").prop("checked") );
    })

    $(".btn-add-emp").on("click", ()=>{
        $("#modal-add-emp").css({"display":"block"});
    })

    $(".close-modal").on("click", ()=>{
        $("#modal-add-emp").css({"display":"none"});
    })
    
    // close panel when esc is pressed
    $(this).on("keydown", (e)=>{
        if(e.key == "Escape"){
            CloseLeftPanel();
            $(".close-modal").trigger("click");
        }
    });

    // close panel when mouse clicked outside panel
    $(this).mouseup((e)=>{
        let container = $(".panel-left");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            CloseLeftPanel();
        }
    })





    // logout button
    $("#btn-logout").on("click", ()=>{
        window.location.href = "https://localhost/Payroll-CRUD/logout.php"
    })




    // search
    $("#search").on("keypress", (e)=>{
        if(e.which == 13) {
            if($("#search").val() !== ""){
                window.location.href = "home.php?search="+$("#search").val()+"#all-emp-tb  ";
            }
        }
    })


    let dashB_hide = false;
    let allEmployee_hide = false;
    let account_hide = false;

    // Go to Dashboard
    $("#btn-db").on("click", ()=>{
        window.location.href = "home.php#dashB";
        CloseLeftPanel();
        if(dashB_hide) $("#dashB-collapse").trigger("click");
    })
    
    // Go to All-employee
    $("#btn-all-employee").on("click", ()=>{
        window.location.href = "home.php#all-emp-tb";
        CloseLeftPanel();
        if(allEmployee_hide) $("#all-emp-tb-collapse").trigger("click");
    })

    // Go to Account
    $("#btn-account").on("click", ()=>{
        window.location.href = "home.php#account-info";
        CloseLeftPanel();
        if(account_hide) $("#account-info-collapse").trigger("click");
    })



    // collapse Dashboard
    $("#dashB-collapse").on("click", ()=>{
        if(!dashB_hide){
            $(".dash-board").css({"flex-wrap" : "nowrap"});
            $(".dash-board").slideToggle("linear");
            $("#dashB-collapse").css({"transform":"rotate(180deg)"});
            dashB_hide = true;
        }else{
            $(".dash-board").slideToggle("linear", ()=>{
                $(".dash-board").css({"flex-wrap" : "wrap"});
            });
            $("#dashB-collapse").css({"transform":"rotate(0)"});
            dashB_hide = false;
        }
    })
    
    // collapse All-employee
    $("#all-emp-tb-collapse").on("click", ()=>{
        if(!allEmployee_hide){
            $(".employee-list").css({"flex-wrap" : "nowrap"});
            $(".employee-list").slideToggle("linear");
            $("#all-emp-tb-collapse").css({"transform":"rotate(180deg)"});
            allEmployee_hide = true;
        }else{
            $(".employee-list").slideToggle("linear", ()=>{
                $(".employee-list").css({"flex-wrap" : "wrap"});
            });
            $("#all-emp-tb-collapse").css({"transform":"rotate(0)"});
            allEmployee_hide = false;
        }
    })

    // collapse Account
    $("#account-info-collapse").on("click", ()=>{
        if(!account_hide){
            $(".my-account").css({"flex-wrap" : "nowrap"});
            $(".my-account").slideToggle("linear");
            $("#account-info-collapse").css({"transform":"rotate(180deg)"});
            account_hide = true;
        }else{
            $(".my-account").slideToggle("linear", ()=>{
                $(".my-account").css({"flex-wrap" : "wrap"});
            });
            $("#account-info-collapse").css({"transform":"rotate(0)"});
            account_hide = false;
        }
    })





    // Initialize months
    const months = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];
    
    const date = new Date();
    // Update month today
    $("#month-today").html("("+months[date.getMonth()]+")");

    // Update Date today
    $("#date-today").html("<b>Date : </b>" + months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear());



    
    // Initialize graph of employee per dept
    // let emPerDept = {
    //     legend:{
    //         horizontalAlign: "left",
    //         verticalAlign: "center"
    //     },
    //     data: [{
    //         type: "doughnut",
    //         innerRadius: "70%",
    //         showInLegend: true,
    //         legendText: "{label}",
    //         indexLabel: "{y}",
    //         indexLabelPlacement: "inside",
    //         dataPoints: [
    //             { color:"#5DADE2", label: "Web Developer", y:  0},
    //             { color:"#A569BD", label: "Data Scientist", y: 0 },
    //             { color:"#EC7063", label: "Mobile Developer", y: 0 },
    //             { color:"#F39C12", label: "Penetration Tester", y: 3 },
    //             { color:"#A6ACAF", label: "Game Developer", y: 1 }
    //         ]
    //     }]
    // };
    
   function fetchNumberOfEmployee(){
  
    $.ajax({
        url : "./fetchnumofemployee.php",
        type : "GET",
        success : function(data) {
            let result = JSON.parse(data)
        try {
        $("#chartContainer").CanvasJSChart(
            {
                legend:{
                    horizontalAlign: "left",
                    verticalAlign: "center"
                },
                data: [{
                    type: "doughnut",
                    innerRadius: "70%",
                    showInLegend: true,
                    legendText: "{label}",
                    indexLabel: "{y}",
                    indexLabelPlacement: "inside",
                    dataPoints: [
                        { color:"#5DADE2", label: result[0][1], y: parseInt(result[0][0])},
                        { color:"#A569BD", label: result[1][1], y: parseInt(result[1][0]) },
                        { color:"#EC7063", label: result[2][1], y: parseInt(result[2][0]) },
                        { color:"#F39C12", label: result[3][1], y: parseInt(result[3][0])},
                        { color:"#A6ACAF", label: result[4][1], y: parseInt(result[4][0]) }
                    ]
                }]
            }
        )
        } catch(err) {
            console.log(err)
        }
        }
    })
    
    }
    fetchNumberOfEmployee()
    
    // display graph
    //$("#chartContainer").CanvasJSChart(emPerDept);

    function getUrlParameter(sParam) {
        const urlParams = new URLSearchParams(window.location.search);

        if(!urlParams.has(sParam)) return;
        
        return urlParams.get(sParam);
    };
    

    // function displayBlock(page_id){
    //     let toShow = "";
    //     let toHide = [];
        
    //     if(page_id == 2){
    //         curr_Page = 2;
    //         toShow = "account-info";
    //         toHide = ["all-emp-tb", "dashB"];

    //     } else if (page_id == 1){
    //         curr_Page = 1;
    //         toShow = "all-emp-tb";
    //         toHide = ["dashB", "account-info"];

    //     }else {
    //         curr_Page = 0;
    //         toShow = "dashB";
    //         toHide = ["all-emp-tb", "account-info"];
    //     }

    //     $("#"+toShow).css({
    //         "display" : "flex",
    //         "flex-direction": "row",
    //         "justify-content": " flex-start",
    //         "align-items": "stretch",
    //         "flex-wrap": "wrap",
    //         "gap" : "15px",
    //         "opacity" : "1",
    //         "height" : "auto"
    //     })

    //     $("#chartContainer").css({
    //         "height": "300px",
    //         "width": "300px",
    //     });
        
    //     $("#"+toShow+" .element").css({"height" : "auto"});
    //     $("#"+toShow+" .element .element-header").css({"height" : "auto"});
    //     $("#"+toShow+" .element .element-body").css({"height" : "auto"});

    //     for(var i in toHide){
    //         $("#"+toHide[i]).css({ "opacity" : "0", "height" : "0" })
    //         $("#"+toHide[i]+" .element .element-body").css({"height" : "0"});
    //         $("#"+toHide[i]+" .element .element-header").css({"height" : "0"});
    //         $("#"+toHide[i]+" .element").css({"height" : "0"});
    //     }
    // }
});