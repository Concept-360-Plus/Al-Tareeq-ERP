<!DOCTYPE html>
<html>

<head>
  <title>Attendance Report</title>
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

    .right {
      text-align: right;
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

  <div class="title">Attendance Report</div>
  <p><strong>Date Range:</strong> <?= !empty($from_date) ? date('d-M-Y', strtotime($from_date)) : '-' ?> 
      to <?= !empty($to_date) ? date('d-M-Y', strtotime($to_date)) : '-' ?></p>

  <table>
    <thead>
      <tr>
        <th>#</th>
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
            <td>
              <?= ($r->attendence == 'P') 
                    ? '<span class="text-success fw-bold">Present</span>' 
                    : '<span class="text-danger fw-bold">Absent</span>' ?>
            </td>
            <td><?= $r->in_time ?? '-' ?></td>
            <td><?= $r->out_time ?? '-' ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="9" style="text-align:center;">No records found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>

</html>
