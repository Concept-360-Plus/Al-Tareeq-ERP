<?php

$i=1;

foreach($attendance_list as $row){

?>

    <tr>

    <td><?= $i++ ?></td>

    <td>
    <span style="display:none"><?= $row->project_id ?></span>
    <?= $row->project_code ?>

    <br>

    <?= $row->project_name ?>

    </td>

    <td>

    <?= $row->employee_name ?>

    </td>

    <td>

    <?= $row->designation_name ?>

    </td>

    <td>

    <?= $row->task_name ?>

    </td>

    <td>

    <span class="label label-info">

    <?= $row->priority ?>

    </span>

    </td>

    <td>

    <?php

    switch($row->attendance_status){

    case 'Working':

    echo '<span class="label label-success">Working</span>';

    break;

    case 'Paused':

    echo '<span class="label label-warning">Paused</span>';

    break;

    case 'Completed':

    echo '<span class="label label-primary">Completed</span>';

    break;

    default:

    echo '<span class="label label-danger">Not Started</span>';

    }

    ?>

    </td>

    <td>

    <?= $row->check_in ?>

    </td>

    <td>

    <?= $row->check_out ?>

    </td>

    <td>

    <?= $row->total_hours ?>

    </td>

    <td>

    <?php

    if(empty($row->attendance_status)
    ||$row->attendance_status=="Not Started"){

    ?>

    <button

    class="btn btn-success btn-xs start"

    data-task="<?= $row->task_item_id ?>"

    data-project="<?= $row->project_id ?>"

    data-employee="<?= $row->employee_id ?>">

    <i class="fa fa-play"></i>

    Start

    </button>

    <?php

    }elseif($row->attendance_status=="Working"){

    ?>

    <button

    class="btn btn-warning btn-xs pause"

    data-id="<?= $row->attendance_id ?>">

    Pause

    </button>

    <button

    class="btn btn-danger btn-xs finish"

    data-id="<?= $row->attendance_id ?>">

    Finish

    </button>

    <?php

    }elseif($row->attendance_status=="Paused"){

    ?>

    <button

    class="btn btn-info btn-xs resume"

    data-id="<?= $row->attendance_id ?>">

    Resume

    </button>

    <button

    class="btn btn-danger btn-xs finish"

    data-id="<?= $row->attendance_id ?>">

    Finish

    </button>

    <?php

    }else{

    ?>

    <span

    class="label label-success">

    Completed

    </span>

    <?php

    }

    ?>

    </td>

    </tr>

<?php

}

?>


<script>
$(document).ready(function(){
    /*
    -------------------------------------
    Start Attendance
    -------------------------------------
    */

    $(document).on('click','.start',function(){

        if(!confirm("Start Project Task?")){
            return false;
        }

        var task_id=$(this).data('task');
        var employee_id=$(this).data('employee');
        var project_id=$(this).data('project');

        $.ajax({

            url:"<?= base_url('index.php/Project_attendance/start_attendance');?>",

            type:"POST",

            data:{
                task_id:task_id,
                employee_id:employee_id,
                project_id:project_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Attendance Started");

                    location.reload();

                }

            }

        });

    });

    /*
    -------------------------------------
    Pause
    -------------------------------------
    */

    $(document).on('click','.pause',function(){

        if(!confirm("Pause Task?")){
            return false;
        }

        var attendance_id=$(this).data('id');

        $.ajax({

            url:"<?= base_url('index.php/Project_attendance/pause_attendance');?>",

            type:"POST",

            data:{
                attendance_id:attendance_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Task Paused");

                    location.reload();

                }

            }

        });

    });

    /*
    -------------------------------------
    Resume
    -------------------------------------
    */

    $(document).on('click','.resume',function(){

        if(!confirm("Resume Task?")){
            return false;
        }

        var attendance_id=$(this).data('id');

        $.ajax({

            url:"<?= base_url('index.php/Project_attendance/resume_attendance');?>",

            type:"POST",

            data:{
                attendance_id:attendance_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Task Resumed");

                    location.reload();

                }

            }

        });

    });

    /*
    -------------------------------------
    Finish
    -------------------------------------
    */

    $(document).on('click','.finish',function(){

        if(!confirm("Finish Task?")){
            return false;
        }

        var attendance_id=$(this).data('id');

        $.ajax({

            url:"<?= base_url('index.php/Project_attendance/finish_attendance');?>",

            type:"POST",

            data:{
                attendance_id:attendance_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Task Completed");

                    location.reload();

                }

            }

        });

    });

});
</script>