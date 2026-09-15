<div class="x_panel">
    <div class="x_title">
        <h2>Task Information</h2>
        <div class="clearfix"></div>
    </div>
<div class="x_content">
    <table class="table table-bordered table-striped">
    
<tbody>
     <thead>

                <tr>

                    <th width="5%">#</th>
                    <th>Category</th>
                    <th>Task</th>
                    <th>Milestone</th>
                    <th>Employee</th>
                    <th>Designation</th>
                    <th>Priority</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>

                </tr>

            </thead>

<?php
$i=1;
foreach($tasks as $row){
?>
<tr>

    <td><?= $i++; ?></td>

    <td><?= $row->category_name; ?></td>

    <td><?= $row->task_name; ?></td>

    <td><?= $row->milestone_name; ?></td>

    <td><?= $row->employee_name; ?></td>

    <td><?= $row->designation_name; ?></td>

    <td><?= $row->priority; ?></td>

    <td><?= date('d-m-Y',strtotime($row->start_date)); ?></td>

    <td><?= date('d-m-Y',strtotime($row->end_date)); ?></td>

    <td><?= ucwords(str_replace('_',' ',$row->status)); ?></td>

</tr>

<?php
}
?>
</tbody>
</table>
