
function viewTask(id) {
    // alert(id);
    $("#TaskModal").modal("show");
    $("#TaskModal").css("opacity", "1");
    
    $('.modal-body').empty();
    $(".taskLoader").show(500);
    
    setTimeout(() => {
        $.ajax({
            url: "getTaskDetails.php",
            method: "POST",
            data: "task_emp_id=" + id,
            success: function(data) {
                // alert(data);
                if (data != "false") {
                    data = JSON.parse(data);
                    var length = data.length;
                    
                    //Repetition duration
                    let rd = data[0].task_emp_repetition_duration;
                    if(rd == 0)
                    {
                        rd = "One time";
                    }
                    else if(rd == 1)
                    {
                        rd = "Weekly";
                    }
                    else if(rd == 2)
                    {
                        rd = "Monthly";
                    }
                    else if(rd == 3)
                    {
                        rd = "Quarterly";
                    }
                    else if(rd == 4)
                    {
                        rd = "Half Yearly";
                    }
                    else if(rd == 5)
                    {
                        rd = "Yearly";
                    }
                    

                    let row = "<h4>"+data[0].shipper_name+"</h4><p>"+data[0].date_assign+"</p><p>Quantity - "+data[0].task_emp_quantity+" | "+rd+"</p><h5>Description : </h5>" + data[0].task_description;
                    
                    $("#task_name").html(data[0].task_name);
                    
                    $('.modal-body').html(row);

                }
            },
        }).done(() => {
            $(".taskLoader").hide(500);
        });
    }, 700);
}

function acceptTask(id) {
    $(".newTaksLoader_"+id).show(500);
    
    setTimeout(() => {
        $.ajax({
            url: "acceptTask.php",
            method: "POST",
            data: "task_emp_id=" + id,
            success: function(data) {
                // alert(data);
                console.log(data);
                getNewTasks();
            },
        }).done(() => {
            $(".taskLoader").hide(500);
        });
    }, 700);
}

function getNewTasks() {
    $.ajax({
        url: "getNewTasks.php",
        method: "POST",
        success: function(data) {
            //alert(data);
            if (data != "false") {
                data = JSON.parse(data);
                var length = data.length;
                var row = '<div class="com-md-12"><div class="inbox-widget">';
                            
                        
                
                for (i = 0; i < length; i++) {
                    row += '<div class="inbox-item">' +
                    ' '+
                        '<h5 class="inbox-item-author mt-0 mb-1">'+data[i].task_name+'</h5>' +
                        '<p class="inbox-item-text">'+data[i].shipper_name+'</p>'+
                        '<button class="btn btn-blue" title="View" onClick="viewTask('+data[i].task_emp_id+')"><i class="mdi mdi-eye"></i> View</button> '+
                        '<button class="btn btn-success" title="Accept" onClick="acceptTask('+data[i].task_emp_id+')"><i class="mdi mdi-check"></i> Accept</button> <img src="./assets/images/loading.gif" style="display:none" class="newTaksLoader_'+data[i].task_emp_id+'"/>'+
                        '<p class="inbox-item-date">'+data[i].date_assign+'</p>'+
                    ''+
                '</div>';
                }
                row += '</div></div>';


                $('.new-tasks-result').html(row);

                //openListModal('invoice');
            }
            if (data == "false") {
                var row = "No Records..!";
                $('.new-tasks-result').html(row);
            } else {
                //registerInvoice('false');
            }
            
                

        }
    });
};


$(document).ready(function(){ 
   
    getNewTasks();
    // To get records
    

    
      
    
});