<!DOCTYPE html>
<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=monthly_payroll_report_" . date('Ymd_His') . ".xls");
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
            <th colspan="10">
<strong>
                    Monthly Attendance Report - <?= !empty($selected_month) ? date('F Y', strtotime($selected_month)) : '' ?>
                    (Department: <?= getDepartmentName($departments, $selected_dept) ?>)
                </strong></th>
<tr>
              <th>Sr No</th>
            <th>Employee Name</th>
            <th>Working Days</th>
            <th>Total Leave</th>
            <th>Present Days</th>
            <th>Paid Leave</th>
            <th>Payment Days</th>
            <th>Total Overtime(hour)</th>
            <th>Overtime Amt</th>
            <th>Basic Salary</th>
            <th>Total Allowances</th>
            <th>Total Deduction</th>
            <th>Gross pay</th>
            <th>Net pay</th>
            </tr>
             </tr>
    </thead>
    <tbody>
        <?php if (!empty($records)): $i = 1; ?>
        <?php foreach ($records as $r): ?>
              <tr>
                <td><?= $i ?></td>
                <td class="text-start"><?= htmlspecialchars($r->user_name) ?></td>
                <td><?= $r->working_days ?? 0 ?></td>
          <td><?= $r->leave_days ?? 0 ?></td>
          <td><?= $r->present_days ?? 0 ?></td>
          <td><?= $r->paid_leave ?? 0 ?></td>
          <td><?= $r->payment_days ?? 0 ?></td>
          <td><?= $r->overtime; ?></td>
          <td><?= $r->overtime_amt; ?></td>
          <td><?= number_format($r->basic_salary ?? 0, 2) ?></td>
          <td><?= number_format($r->total_allowance ?? 0, 2) ?></td>
          <td><?= number_format($r->total_deduction ?? 0, 2) ?></td>
          <td><?= number_format($r->gross_salary ?? 0, 2) ?></td>
          <td><strong><?= number_format($r->net_salary ?? 0, 2) ?></strong></td>
              </tr>
           <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="10">No records found.</td></tr>
      <?php endif; ?>
   </tbody>
  </table>
</body>
</html>

