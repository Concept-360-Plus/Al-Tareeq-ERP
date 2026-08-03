<div class="row">
<div class="col-md-12">


<div class="x_panel">

    <div class="x_title">
        <h2>Search Filter</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

<form method="get" action="<?= base_url('index.php/Project_attendance/report') ?>">

<div class="row">

<div class="col-md-3">

<label>Project</label>

<select name="project_id" class="form-control">

<option value="">All Projects</option>

<?php foreach($projects as $row){ ?>

<option
value="<?= $row->project_id ?>"
<?= ($this->input->get('project_id')==$row->project_id)?'selected':''; ?>>

<?= $row->project_code ?>

-

<?= $row->project_name ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-3">

<label>Employee</label>

<select name="employee_id" class="form-control">

<option value="">All Employees</option>

<?php foreach($employees as $row){ ?>

<option
value="<?= $row->employee_id ?>"
<?= ($this->input->get('employee_id')==$row->employee_id)?'selected':''; ?>>

<?= $row->employee_name ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-2">

<label>Status</label>

<select name="status" class="form-control">

<option value="">All</option>

<option value="Working"
<?= ($this->input->get('status')=="Working")?'selected':''; ?>>
Working
</option>

<option value="Paused"
<?= ($this->input->get('status')=="Paused")?'selected':''; ?>>
Paused
</option>

<option value="Completed"
<?= ($this->input->get('status')=="Completed")?'selected':''; ?>>
Completed
</option>

<option value="Not Started"
<?= ($this->input->get('status')=="Not Started")?'selected':''; ?>>
Not Started
</option>

</select>

</div>

<div class="col-md-2">

<label>From Date</label>

<input
type="date"
name="from_date"
class="form-control"
value="<?= $this->input->get('from_date'); ?>">

</div>

<div class="col-md-2">

<label>To Date</label>

<input
type="date"
name="to_date"
class="form-control"
value="<?= $this->input->get('to_date'); ?>">

</div>

</div>

<br>

<button
type="submit"
class="btn btn btn-success">

<i class="fa fa-search"></i>

Search

</button>

<a
href="<?= base_url('index.php/Project_attendance/report'); ?>"
class="btn btn-default">

<i class="fa fa-refresh"></i>

Reset

</a>

</form>

</div>

</div>


<div class="x_panel">

<div class="x_title">

<h2>Attendance Report</h2>

<div class="clearfix"></div>

</div>

<div class="x_content">

<table
id="attendance_report"
class="table table-striped table-bordered">

<thead>

<tr>

<th>#</th>

<th>Date</th>

<th>Project</th>

<th>Employee</th>

<th>Designation</th>

<th>Task</th>

<th>Check In</th>

<th>Check Out</th>

<th>Total Hours</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$i=1;

foreach($attendance as $row){

?>

<tr>

<td><?= $i++ ?></td>

<td><?= date('d-m-Y',strtotime($row->attendance_date)); ?></td>

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

<?= $row->check_in ?>

</td>

<td>

<?= $row->check_out ?>

</td>

<td>

<?= number_format($row->total_hours,2) ?>

</td>

<td>

<?php

if($row->attendance_status=="Completed"){

?>

<span class="label label-success">

Completed

</span>

<?php

}elseif($row->attendance_status=="Working"){

?>

<span class="label label-info">

Working

</span>

<?php

}elseif($row->attendance_status=="Paused"){

?>

<span class="label label-warning">

Paused

</span>

<?php

}else{

?>

<span class="label label-danger">

Not Started

</span>

<?php

}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div></div>

<script>

$(document).ready(function(){

$('#attendance_report').DataTable({

pageLength:25,

order:[[1,'desc']],

dom:'Bfrtip',

buttons:[

{

extend:'excelHtml5',

title:'Project Employee Attendance Report'

},

{

extend:'print',

title:'Project Employee Attendance Report'

}

]

});

});

</script>