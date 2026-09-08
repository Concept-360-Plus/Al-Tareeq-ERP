<?php

$i=1;

if(!empty($tasks))
{
    foreach($tasks as $row)
    {
?>
<tr>

    <td><?= $i++; ?></td>

    <td><?= $row['task_name']; ?></td>

    <td><?= $row['category_name']; ?></td>

    <td><?= $row['milestone_name']; ?></td>

    <td><?= $row['employee_name']; ?></td>

    <td><?= $row['priority']; ?></td>

    <td><?= date('d-m-Y',strtotime($row['start_date'])); ?></td>

    <td><?= date('d-m-Y',strtotime($row['end_date'])); ?></td>

    <td>
        <?php
        switch($row['status'])
        {
            case 'not_started':
                echo '<span class="badge badge-secondary">Not Started</span>';
                break;

            case 'in_progress':
                echo '<span class="badge badge-primary">In Progress</span>';
                break;

            case 'hold':
                echo '<span class="badge badge-warning">On Hold</span>';
                break;

            case 'completed':
                echo '<span class="badge badge-success">Completed</span>';
                break;
        }
        ?>
    </td>

    <!--<td>

        <?php if($row['status']=='not_started'){ ?>

            <button class="btn btn-success btn-xs startTask"
                    data-id="<?= $row['id']; ?>">
                <i class="fa fa-play"></i> Start
            </button>

        <?php }elseif($row['status']=='in_progress'){ ?>

            <button class="btn btn-warning btn-xs holdTask"
                    data-id="<?= $row['id']; ?>">
                <i class="fa fa-pause"></i> Hold
            </button>

            <button class="btn btn-primary btn-xs finishTask"
                    data-id="<?= $row['id']; ?>">
                <i class="fa fa-check"></i> Finish
            </button>

        <?php }elseif($row['status']=='hold'){ ?>

            <button class="btn btn-success btn-xs resumeTask"
                    data-id="<?= $row['id']; ?>">
                <i class="fa fa-play"></i> Resume
            </button>

            <button class="btn btn-primary btn-xs finishTask"
                    data-id="<?= $row['id']; ?>">
                <i class="fa fa-check"></i> Finish
            </button>

        <?php }else{ ?>

            <span class="badge badge-success">
                Completed
            </span>

        <?php } ?>

    </td>-->

</tr>

<?php
    }
}
else
{
?>

<tr>

    <td colspan="10" class="text-center">
        No Project Tasks Found
    </td>

</tr>

<?php
}
?>