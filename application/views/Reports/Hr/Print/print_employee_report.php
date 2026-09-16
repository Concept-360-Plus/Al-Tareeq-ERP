<html>
<head>
  <title><?= $title ?></title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 8px; }
  </style>
</head>
<body>
<div class="no-print" style="text-align:right;">
    <button onclick="window.print()">🖨️ Print</button>
  </div>

  <div align="center">
    <h3><?= $title ?></h3>
    <p>Date: <?= date('d-M-Y') ?></p>
  </div>

  <table>
    <thead>
      <tr>
        <th>S.No</th>
        <th>Employee Name</th>
        <th>Designation</th>
        <th>Department</th>
        <th style="white-space: nowrap; min-width: 100px;">Date of Join</th>
        <th>Contact Number</th>
        <th>Email ID</th>
        <th>Basic Salary</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($records)): $i = 1; ?>
        <?php foreach ($records as $row): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $row->user_name ?></td>
            <td><?= $row->designation_name ?></td>
            <td><?= $row->dept_name ?></td>
            <td style="white-space: nowrap;"><?= date('d-M-Y', strtotime($row->joining_date)) ?></td>
            <td><?= $row->contact_no ?></td>
            <td><?= $row->email_id ?></td>
            <td><?= $row->basic_salary ?></td>

          </tr>
        <?php endforeach; ?>
      <?php else: ?>
<tr><td colspan="7" style="text-align:center;" >No records found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
