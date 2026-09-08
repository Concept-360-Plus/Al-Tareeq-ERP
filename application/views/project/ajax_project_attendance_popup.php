<?php
$i=1;

if(!empty($attendance))
{
    foreach($attendance as $row)
    {
?>
<tr>

    <td><?= $i++; ?></td>

    <td><?= date('d-m-Y',strtotime($row['attendance_date'])); ?></td>

    <td><?= $row['employee_name']; ?></td>

    <td><?= $row['designation_name']; ?></td>

    <td><?= $row['task_name']; ?></td>

    <td><?= $row['check_in']; ?></td>

    <td><?= $row['check_out']; ?></td>

    <td><?= number_format($row['total_hours'],2); ?></td>

    <td>
        <?php
        if($row['attendance_status']=="Completed"){
            echo '<span class="label label-success">Completed</span>';
        }elseif($row['attendance_status']=="Working"){
            echo '<span class="label label-info">Working</span>';
        }elseif($row['attendance_status']=="Paused"){
            echo '<span class="label label-warning">Paused</span>';
        }else{
            echo '<span class="label label-danger">Not Started</span>';
        }
        ?>
    </td>

</tr>

<?php
    }
}
else
{
?>
<tr>
    <td colspan="9" class="text-center">
        No Time Sheet Records Found
    </td>
</tr>
<?php
}
?>