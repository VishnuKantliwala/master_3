$(document).ready(function(){ 
   
    getTotalTime();
    // To get records
});


function clockIn() {
    $(".clockLoader").show(500);
    $(".btnClockIn").hide(100);
    setTimeout(() => {
        $.ajax({
            url: "clockIn.php",
            method: "POST",
            success: function(data) {
                // alert(data);
                // console.log(data);    
                
                
            },
        }).done(() => {
            $(".clockLoader").hide(500);
            $(".btnClockOut").show(100);
            $(".btnStartTime").show(500);

        });
    }, 700);
}

function clockOut() {
    $(".clockLoader").show(500);

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to clock in again today!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, I am sure!",
        cancelButtonText: "No, cancel!",
        confirmButtonClass: "btn btn-success mt-2",
        cancelButtonClass: "btn btn-danger ml-2 mt-2",
        buttonsStyling: !1
    }).then(function(t) {
        if (t.value) {
            $.ajax({
                type: "POST",
                async: false,
                url: "clockOut.php",
                success: function(data) {
                    console.log(data);
                    if (data == 'true') {
                        Swal.fire({
                            title: "Clock out successfull!",
                            text: "Your today's session is over. Thank you.",
                            type: "success"
                        }).then(function() {
                            // window.open('notAssignedTaskView.php', '_self');
                            $(".clockDiv").html("<h5>[Today's time is over.]</h5>");
                            getTotalTime();
                        });
                    } else {
                        Swal.fire({
                            title: "Something went to wrong!",
                            type: "error"
                        });
                    }
                }
            });
        } else if (t.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: "Cancelled",
                type: "error"
            });
        }
        $(".clockLoader").hide(500);
    });
    


}

function startTimeIn() {
    $(".clockLoader").show(500);
    $(".btnStartTime").hide(100);
    setTimeout(() => {
        $.ajax({
            url: "startClockSession.php",
            method: "POST",
            success: function(data) {
                // alert(data);
                // console.log(data);    
                
                
            },
        }).done(() => {
            $(".clockLoader").hide(500);
            $(".btnPauseTime").show(100);

        });
    }, 700);
}

function startTimeOut() {
    $(".clockLoader").show(500);
    $(".btnPauseTime").hide(100);
    
    setTimeout(() => {
        $.ajax({
            url: "pauseClockSession.php",
            method: "POST",
            success: function(data) {
                // alert(data);
                console.log(data);
            },
        }).done(() => {
            $(".clockLoader").hide(500);
            $(".btnStartTime").show(100);
            getTotalTime();
        });
    }, 700);
}

function getTotalTime() {
    $(".totalElapseTime").html("Loading...");
    
    setTimeout(() => {
        $.ajax({
            url: "getTotalClockTime.php",
            method: "POST",
            success: function(data) {
                // alert(data);
                // console.log(data);
                $(".totalElapseTime").html("[ "+data+" ]");

            },
        }).done(() => {
            
        });
    }, 300);
}