
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
                    

                    let row = "<h4>"+data[0].shipper_name+"</h4><p>"+data[0].date_assign+"</p><p>Quantity - "+data[0].task_emp_quantity+" | "+rd+"</p><h5>Description : </h5>" + data[0].task_emp_description;
                    
                    $("#task_name").html(data[0].task_name);
                    
                    $('.modal-body').html(row);

                }
            },
        }).done(() => {
            $(".taskLoader").hide(500);
        });
    }, 700);
}

function viewRunningTask(id) {
    // alert(id);
    $("#RunningTaskModal").modal("show");
    $("#RunningTaskModal").css("opacity", "1");
    
    $('.modal-body').empty();
    $('.quantityList').empty();
    $(".taskLoader").show(500);
    
    setTimeout(() => {
        $.ajax({
            url: "getTaskDetails.php",
            method: "POST",
            data: "task_emp_id=" + id,
            success: function(data) {
                // alert(data);
                if (data != "false") {
                    // console.log(data);
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
                    

                    let row = "<h4>"+data[0].shipper_name+"</h4><p>"+data[0].date_assign+"</p><p>Quantity - "+data[0].task_emp_quantity+" | "+rd+"</p><h5>Description : </h5>";
                    

                    let rowQuantity = '';
                    for(let i=0; i<data[0].task_emp_status.length ; i++)
                    {
                        let chkStatus = '';
                        if(data[0].task_emp_status[i] == 1 )
                        {
                            chkStatus = "checked";
                        }
                        rowQuantity += '<div class="col-md-4" style="padding:10px 0px">' +
                        '<input '+chkStatus+' type="checkbox" name="chkQuantity[]" data-plugin="switchery" data-color="#1AB394" data-secondary-color="#ED5565" data-size="small" class="switchery_'+i+'" value="'+data[0].task_emp_qty_id[i]+'" /> '+ data[0].task_name + " " + (i+1) +
                        "</div>";
                        
                    }
                    $('.quantityList').html(rowQuantity);

                    $("#task_name").html(data[0].task_name);
                    $("#modal_task_emp_id").val(data[0].task_emp_id);
                    $("#modal_task_emp_quantity").val(data[0].task_emp_quantity);
                    $("#task_emp_description").val(data[0].task_emp_description);
                    CKEDITOR.replace('task_emp_description');

                    $('[data-plugin="switchery"]').each(function(e, t) {
                        new Switchery($(this)[0], $(this).data())
                    });

                    $('.modal-body').html(row);

                }
            },
        }).done(() => {
            $(".taskLoader").hide(500);            
            
        });
    }, 700);
}

$('#runningTaskForm').submit(function(e) {

    e.preventDefault();
    // alert("call");
    $(".taskLoader").show(500);
    // $(".btnRunningTask").hide();

    const formData = $(this);
    setTimeout(() => {
        $.ajax({
            type: "POST",
            url: "updateRunningTask.php",
            data: formData.serialize(),
            cache: false,
            processData: false,
            success: (result) => {
                console.log(result);
                return result;
            }
        }).then((result) => {
            
            if ($.trim(result) =='<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Task Updated Successfully! </div>') {
                
                getRunningTasks();
                getCompleteTasks();
                

            } else {
                $(".btnRunningTask").show();
                
            }
            $('.taskUpdateResult').html(result);
            $('.taskLoader').hide(500);

        });
    }, 500);


});


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
                getRunningTasks();
            },
        }).done(() => {
            $(".newTaksLoader_"+id).hide(500);
        });
    }, 700);
}

function startTask(id) {
    $(".runningTaksLoader_"+id).show(500);
    
    setTimeout(() => {
        $.ajax({
            url: "startTask.php",
            method: "POST",
            data: "task_emp_id=" + id,
            success: function(data) {
                // alert(data);
                // console.log(data);
                getRunningTasks();
            },
        }).done(() => {
            $(".runningTaksLoader_"+id).hide(500);
        });
    }, 700);
}

function pauseTask(id) {
    $(".runningTaksLoader_"+id).show(500);
    
    setTimeout(() => {
        $.ajax({
            url: "pauseTask.php",
            method: "POST",
            data: "task_emp_id=" + id,
            success: function(data) {
                // alert(data);
                // console.log(data);
                getRunningTasks();
            },
        }).done(() => {
            $(".runningTaksLoader_"+id).hide(500);
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

function getRunningTasks() {
    $.ajax({
        url: "getRunningTasks.php",
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
                        '<p class="inbox-item-text" >'+data[i].shipper_name+'</p>' +
                        '<p class="inbox-item-date" >'+data[i].time+'</p>';
                        if(data[i].task_emp_running_status === '0')
                            row +='<button class="btn btn-blue" title="Start" onClick="startTask('+data[i].task_emp_id+')"><i class="mdi mdi-play"></i> </button> ';
                        else
                            row +='<button class="btn btn-danger" title="Pause" onClick="pauseTask('+data[i].task_emp_id+')"><i class="mdi mdi-pause"></i> </button> '

                        row +='<button class="btn btn-success" title="View" onClick="viewRunningTask('+data[i].task_emp_id+')"><i class="mdi mdi-eye"></i> View</button> '+
                        '<img src="./assets/images/loading.gif" style="display:none" class="runningTaksLoader_'+data[i].task_emp_id+'"/>'+
                        // '<p class="inbox-item-date">'+data[i].date_assign+'</p>'+
                    ''+
                '</div>';
                }
                row += '</div></div>';

                $('.running-tasks-result').html(row);

                //openListModal('invoice');
            }
            if (data == "false") {
                var row = "No Records..!";
                $('.running-tasks-result').html(row);
            } else {
                //registerInvoice('false');
            }
            
                

        }
    });
};


function getCompleteTasks() {
    $.ajax({
        url: "getCompleteTasks.php",
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
                        
                        '<p class="inbox-item-date">'+data[i].date_assign+'</p>'+
                    ''+
                '</div>';
                }
                row += '</div></div>';


                $('.completed-tasks-result').html(row);

                //openListModal('invoice');
            }
            if (data == "false") {
                var row = "No Records..!";
                $('.completed-tasks-result').html(row);
            } else {
                //registerInvoice('false');
            }
            
                

        }
    });
};


$(document).ready(function(){ 
   
    getNewTasks();
    getRunningTasks();
    getCompleteTasks();
    // To get records
});