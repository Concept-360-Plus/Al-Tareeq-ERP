<div class="x_panel">
    <div class="x_title">
        <h2>Project Information</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <table class="table table-bordered">

            <tr>
                <th width="20%">Project Code</th>
                <td width="30%"><?= $project->project_code; ?></td>

                <th width="20%">Project Name</th>
                <td width="30%"><?= $project->project_name; ?></td>
            </tr>

            <tr>
                <th>Customer</th>
                <td><?= $project->customer_name ?? $project->customer_name1; ?></td>

                <th>Project Manager</th>
                <td><?= $project->manager_name; ?></td>
            </tr>

            <tr>
                <th>Start Date</th>
                <td><?= date('d-m-Y',strtotime($project->start_date)); ?></td>

                <th>End Date</th>
                <td><?= date('d-m-Y',strtotime($project->end_date)); ?></td>
            </tr>

            <tr>
                <!--<th>Priority</th>
                <td>
                    <span class="label label-info">
                        <?= $project->priority; ?>
                    </span>
                </td>-->

                <th>Status</th>
                <td>
                    <?php
                    switch($project->status)
                    {
                        case 'Pending':
                            echo '<span class="label label-warning">Pending</span>';
                        break;

                        case 'In Progress':
                            echo '<span class="label label-primary">In Progress</span>';
                        break;

                        case 'Approved':
                            echo '<span class="label label-success">Approved</span>';
                        break;

                        case 'Cancelled':
                            echo '<span class="label label-danger">Cancelled</span>';
                        break;

                        default:
                            echo $project->status;
                    }
                    ?>
                </td>
            </tr>

           <!-- <tr>
                <th>Progress</th>
                <td colspan="3">

                    <div class="progress" style="margin-bottom:0;height:25px;">

                        <div class="progress-bar progress-bar-success"
                             role="progressbar"
                             style="width:<?= $project->progress_percentage;?>%;">

                            <?= $project->progress_percentage;?>%

                        </div>

                    </div>

                </td>
            </tr>-->

            <tr>
                <th>Project Remarks</th>
                <td colspan="3">
                    <?= nl2br($project->remarks); ?>
                </td>
            </tr>

        </table>

    </div>
</div>