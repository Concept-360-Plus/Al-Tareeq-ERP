<!DOCTYPE html>
<html>

<head>
  <title>Monthly Leave Report</title>
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

  <div class="title">Monthly Leave Report</div>
  <p><strong>Month:</strong> <?= date('F Y', strtotime($selected_month)) ?></p>

  <table>
    <thead>
      <tr>
        <th>#</th>
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
      <?php if (!empty($records)):
        $i = 1; ?>
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
              if ($r->leave_status == 0)
                echo 'Pending';
              elseif ($r->leave_status == 1)
                echo 'Approved';
              elseif ($r->leave_status == 2)
                echo 'Rejected';
              else
                echo 'N/A';
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="10">No records found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>

</html>