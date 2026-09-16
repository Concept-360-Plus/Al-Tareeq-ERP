<!DOCTYPE html>
<html>

<head>
  <title>Monthly Payroll Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 6px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .title {
      text-align: center;
      font-size: 20px;
      margin-top: 20px;
    }

    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="no-print" style="text-align:right;">
    <button onclick="window.print()">🖨️ Print</button>
  </div>

  <div class="title">Monthly Payroll Report</div>

  <?php if (!empty($selected_month)): ?>
    <p><strong>Month:</strong> <?= date('F Y', strtotime($selected_month)) ?></p>
  <?php endif; ?>

  <table>
    <thead>
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
    </thead>
    <tbody>
      <?php if ($generate_flag !== true): ?>
        <tr>
          <td colspan="14" style="text-align:center;">Please generate the report first before printing.</td>
        </tr>

      <?php elseif (!empty($records)): ?>
        <?php $i = 1;
        foreach ($records as $r): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($r->user_name) ?></td>
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
        <tr>
          <td colspan="14" style="text-align:center;">No records found for the selected month and filters.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>

</html>