<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=monthly_attendance_report_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

function getDepartmentName($departments, $dept_id) {
    foreach ($departments as $d) {
        if ($d->dept_id == $dept_id) return $d->dept_name;
    }
    return 'All';
}
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="9">
                <strong>
                    Attendance Report - 
                    <?= !empty($from_date) && !empty($to_date) ? date('d-M-Y', strtotime($from_date)) . ' to ' . date('d-M-Y', strtotime($to_date)) : '' ?>
                    (Department: <?= getDepartmentName($departments, $selected_dept) ?>)
                </strong>
            </th>
        </tr>
        <tr>
            <th>Sr No</th>
            <th>Emp Code</th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Attendance Date</th>
            <th>Status</th>
            <th>In-Time</th>
            <th>Out-Time</th>
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
                    <td><?= !empty($r->Attendance_date) ? date('d-M-Y', strtotime($r->Attendance_date)) : '-' ?></td>
                    <td><?= ($r->attendence == 'P') ? 'Present' : 'Absent' ?></td>
                    <td><?= $r->in_time ?? '-' ?></td>
                    <td><?= $r->out_time ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align: center;">No records found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
