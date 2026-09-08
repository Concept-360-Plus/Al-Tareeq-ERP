<div class="x_panel">
            <div class="x_title">
                <h2>Today's Time sheet</h2>
                <div class="clearfix"></div>
            </div>

            <table class="table table-bordered table-striped">
            <div class="x_content">
        <tbody>

            <thead>

                <tr>

                    <th width="5%">#</th>

                    <th>Employee</th>

                    <th>Designation</th>

                    <th>Task</th>

                    <th>Priority</th>

                    <th>Check In</th>

                    <th>Check Out</th>

                    <th>Hours</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if(!empty($attendance))
            {
                $i=1;

                foreach($attendance as $row)
                {
            ?>

                <tr>

                    <td><?= $i++; ?></td>

                    <td><?= $row->employee_name; ?></td>

                    <td><?= $row->designation_name; ?></td>

                    <td><?= $row->task_name; ?></td>

                    <td>
                        <span class="label label-info">
                            <?= $row->priority; ?>
                        </span>
                    </td>

                    <td><?= $row->check_in; ?></td>

                    <td>
                        <?= !empty($row->check_out) ? $row->check_out : '-'; ?>
                    </td>

                    <td>
                        <?= !empty($row->total_hours) ? $row->total_hours : '0'; ?>
                    </td>

                    <td>

                        <?php

                        switch($row->attendance_status)
                        {
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

                            break;
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

                    <td colspan="9" class="text-center text-danger">
                        No Time sheet Records Found
                    </td>

                </tr>

            <?php
            }
            ?>

            </tbody>

        </table>

    </div>

</div></div>