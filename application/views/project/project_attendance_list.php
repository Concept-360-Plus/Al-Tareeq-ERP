<div class="row">
<div class="col-md-12">
<div class="x_panel">


<div class="page-title">

<div class="title_left">
<h3>Project Employee Attendance</h3>
</div>

</div>

<div class="clearfix"></div>
<div class="x_panel">

<div class="x_title">

<h2>Search Filter</h2>

<div class="clearfix"></div>

</div>

<div class="x_content">

<form method="get">

<div class="row">

<div class="col-md-3">

<label>Project</label>

<select class="form-control" id="project_filter">

<option value="">All Projects</option>

<?php

$projects=array();

foreach($attendance_list as $row){

if(!isset($projects[$row->project_id])){

$projects[$row->project_id]=$row->project_name;

?>

<option value="<?= $row->project_name ?>">

<?= $row->project_code ?> -
<?= $row->project_name ?>

</option>

<?php

}

}

?>

</select>

</div>

<div class="col-md-3">

<label>Employee</label>

<input
type="text"
id="employee_filter"
class="form-control"
placeholder="Employee Name">

</div>

<div class="col-md-3">

<label>Status</label>

<select id="status_filter" class="form-control">

<option value="">All</option>

<option>Working</option>

<option>Paused</option>

<option>Completed</option>

<option>Not Started</option>

</select>

</div>

<div class="col-md-3">

<label>Date</label>

<input

type="date"

class="form-control"

value="<?= date('Y-m-d')?>"

>

</div>

</div>

</form>

</div>

</div>

<div class="x_panel">

<div class="x_title">

<h2>Today's Attendance</h2>

<div class="clearfix"></div>

</div>

<div class="x_content">

<table

id="datatable-responsive1" class="table table-striped table-bordered">

<thead>

<tr>

<th>#</th>

<th>Project</th>

<th>Employee</th>

<th>Designation</th>

<th>Task</th>

<th>Priority</th>

<th>Status</th>

<th>Check In</th>

<th>Check Out</th>

<th>Hours</th>

<th width="220">Action</th>

</tr>

</thead>

<tbody>

<?php

$i=1;

foreach($attendance_list as $row){

?>

<tr>

<td><?= $i++ ?></td>

<td>

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

</tbody>

</table>

</div>

</div></div>

</div>
<link rel="stylesheet" href="<?= base_url('public/assets/datatables/datatables.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('public/assets/datatables/buttons.dataTables.min.css'); ?>">

<script src="<?= base_url('public/assets/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('public/assets/datatables/dataTables.bootstrap.min.js'); ?>"></script>

<script src="<?= base_url('public/assets/datatables/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('public/assets/datatables/buttons.html5.min.js'); ?>"></script>
<script src="<?= base_url('public/assets/datatables/buttons.print.min.js'); ?>"></script>

<script>

$(document).ready(function(){

    $('#datatable-responsive1').DataTable({

        pageLength:25,

        order:[[0,'desc']],

        responsive:true,

        dom:'Bfrtip',

        buttons:[

        'excel',

        'print'

        ]

    });

});

</script>
<script>

$(document).ready(function(){

    /*
    -------------------------------------
    Start Attendance
    -------------------------------------
    */

    $(document).on('click','.start',function(){

        if(!confirm("Start attendance?")){
            return false;
        }

        var task_id=$(this).data('task');
        var employee_id=$(this).data('employee');
        var project_id=$(this).data('project');

        $.ajax({

            url:"<?= base_url('Project_attendance/start_attendance');?>",

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

        if(!confirm("Pause attendance?")){
            return false;
        }

        var attendance_id=$(this).data('id');

        $.ajax({

            url:"<?= base_url('Project_attendance/pause_attendance');?>",

            type:"POST",

            data:{
                attendance_id:attendance_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Attendance Paused");

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

        if(!confirm("Resume attendance?")){
            return false;
        }

        var attendance_id=$(this).data('id');

        $.ajax({

            url:"<?= base_url('Project_attendance/resume_attendance');?>",

            type:"POST",

            data:{
                attendance_id:attendance_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Attendance Resumed");

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

        if(!confirm("Finish attendance?")){
            return false;
        }

        var attendance_id=$(this).data('id');

        $.ajax({

            url:"<?= base_url('Project_attendance/finish_attendance');?>",

            type:"POST",

            data:{
                attendance_id:attendance_id
            },

            dataType:"json",

            success:function(res){

                if(res.status){

                    alert("Attendance Completed");

                    location.reload();

                }

            }

        });

    });

});
</script>