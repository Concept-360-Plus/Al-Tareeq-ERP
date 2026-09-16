<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=monthly_leave_report_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="10">
                <strong>Monthly Leave Report - <?= date('F Y', strtotime($selected_month)) ?> (Department: <?= $selected_dept_name ?>)</strong>
            </th>
        </tr>
        <tr>
            <th>Sr No</th>
            <th>Emp Code</th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($records)): $i = 1; ?>
            <?php foreach ($records as $r): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r->user_code ?></td>
                    <td><?= $r->user_name ?></td>
                    <td><?= $r->dept_name ?></td>
                    <td><?= $r->designation_name ?></td>
                    <td><?= $r->leave_type ?></td>
                    <td><?= date('d-M-Y', strtotime($r->start_date)) ?></td>
                    <td><?= date('d-M-Y', strtotime($r->end_date)) ?></td>
                    <td>
                        <?php
                        switch ($r->leave_status) {
                            case '1': echo 'Approved'; break;
                            case '2': echo 'Rejected'; break;
                            default: echo 'Pending'; break;
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
