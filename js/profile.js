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

    $(".btn-db").on("click", ()=>{
        window.location.href = "home.php#dashB";
        CloseLeftPanel();
        if(dashB_hide) $("#dashB-collapse").trigger("click");
    })

    $("#btn-identity").on("click", ()=>{
        window.location.href = "profile.php?id="+ $("#btn-identity").attr("prof") +"#identity";
        CloseLeftPanel();
    })
    $("#btn-tax-attnd").on("click", ()=>{
        window.location.href = "profile.php?id="+ $("#btn-tax-attnd").attr("prof") +"#tax-attnd";
        CloseLeftPanel();
    })
    $("#btn-proll").on("click", ()=>{
        window.location.href = "profile.php?id="+ $("#btn-proll").attr("prof") +"#proll";
        CloseLeftPanel();
    })
})