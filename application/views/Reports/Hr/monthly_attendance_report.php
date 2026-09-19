<div class="card">
  <div class="card-body">
    <form method="post" action="<?= base_url('index.php/Reports/monthly_attendance_report') ?>">
      <div class="row mb-3">

        <div class="col-md-3">
          <label>From Date</label>
          <input type="date" name="from_date" class="form-control"
                 value="<?= htmlspecialchars($from_date ?? '') ?>" required>
        </div>

        <div class="col-md-3">
          <label>To Date</label>
          <input type="date" name="to_date" class="form-control"
                 value="<?= htmlspecialchars($to_date ?? '') ?>" required>
        </div>

        <div class="col-md-3">
          <label>Department</label>
          <select name="department_id" class="form-control select2">
            <option value="">All</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?= $dept->dept_id ?>" <?= ($selected_dept == $dept->dept_id) ? 'selected' : '' ?>>
                <?= $dept->dept_name ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3 text-end">
          <label>&nbsp;</label><br>
          <button type="submit" class="btn btn-primary btn-sm">Generate</button>
        </div>

      </div>
    </form>
       
    <!-- Right Aligned Buttons -->
<div class="d-flex justify-content-end gap-2 mb-2">

    <!-- Print Button -->
    <form action="<?= base_url('index.php/Reports/print_monthly_attendance_report') ?>" method="post" target="_blank">
        <input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date ?? '') ?>">
        <input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date ?? '') ?>">
        <input type="hidden" name="department_id" value="<?= htmlspecialchars($selected_dept) ?>">
        <button type="submit" class="btn btn-warning btn-sm">Print</button>
    </form>

    <!-- Export Button -->
    <form action="<?= base_url('index.php/Reports/export_monthly_attendance_report') ?>" method="post">
        <input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date ?? '') ?>">
        <input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date ?? '') ?>">
        <input type="hidden" name="department_id" value="<?= htmlspecialchars($selected_dept) ?>">
        <button type="submit" class="btn btn-success btn-sm">Export to Excel</button>
    </form>

</div>

  </div>
</div>



    <div class="card-body">
    <div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap" width="100%">
  <thead class="table-secondary">
    <tr>
      <th>Sr No</th>
      <th>Employee Code</th>
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
      <?php foreach ($records as $row): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $row->user_code ?></td>
          <td><?= $row->user_name ?></td>
          <td><?= $row->dept_name ?></td>
          <td><?= $row->designation_name ?></td>
          <td><?= date('d-M-Y', strtotime($row->Attendance_date)) ?></td>
          <td>
            <?= ($row->attendence == 'P') ? '<span class="text-success fw-bold">Present</span>' : '<span class="text-danger fw-bold">Absent</span>' ?>
          </td>
          <td><?= $row->in_time ?? '-' ?></td>
          <td><?= $row->out_time ?? '-' ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    $('.select2').select2();
});
</script>
