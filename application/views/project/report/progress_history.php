<div class="x_panel">

    <div class="x_title">
        <h2>Project Progress History</h2>

        <div class="clearfix"></div>
    </div>

    <div class="x_content">

<?php if(!empty($progress_history)){ ?>

<table class="table table-bordered table-striped">

    <thead>

        <tr>

            <th width="5%">#</th>

            <th width="10%">Date</th>

            <th width="10%">Time</th>

            <th width="15%">Milestone</th>

            <th width="10%">Progress</th>

            <th width="15%">Status</th>

            <th>Remarks</th>

            <th width="10%">Site Image</th>

        </tr>

    </thead>

    <tbody>

<?php

$i = 1;

foreach($progress_history as $row)
{

?>

<tr>

    <td>
        <?= $i++; ?>
    </td>

    <td>
        <?= date('d-m-Y', strtotime($row->log_date)); ?>
    </td>

    <td>

        <?php

        if(!empty($row->start_time))
        {
            echo date('h:i A', strtotime($row->start_time));
        }

        if(!empty($row->end_time))
        {
            echo ' - ';
            echo date('h:i A', strtotime($row->end_time));
        }

        ?>

    </td>

    <td>
        <?= !empty($row->milestone) ? $row->milestone : '-'; ?>
    </td>

    <td>

        <strong>
            <?= $row->progress_percentage; ?>%
        </strong>

        <div class="progress"
             style="height:15px;margin-top:5px;margin-bottom:0;">

            <div class="progress-bar progress-bar-success"
                 style="width:<?= $row->progress_percentage; ?>%;">

            </div>

        </div>

    </td>

    <td>

        <?php

        switch($row->current_status)
        {

            case 'Completed':

                echo '<span class="label label-success">
                        Completed
                      </span>';

                break;


            case 'In Progress':

                echo '<span class="label label-primary">
                        In Progress
                      </span>';

                break;


            case 'Hold':

                echo '<span class="label label-warning">
                        Hold
                      </span>';

                break;


            default:

                echo '<span class="label label-default">'
                        .$row->current_status.
                     '</span>';

                break;

        }

        ?>

    </td>

    <td>
        <?= !empty($row->remarks)
            ? nl2br($row->remarks)
            : '-'; ?>
    </td>

    <td>

        <?php if(!empty($row->site_image)){ ?>

            <img src="<?= base_url($row->site_image); ?>"
                 style="width:70px;height:60px;object-fit:cover;"
                 class="img-thumbnail">

        <?php } else { ?>

            -

        <?php } ?>

    </td>

</tr>

<?php } ?>

    </tbody>

</table>

<?php } else { ?>

<div class="alert alert-warning">

    No Progress History Available.

</div>

<?php } ?>

    </div>

</div>