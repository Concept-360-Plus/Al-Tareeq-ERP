<?php if (!isset($is_generated)) $is_generated = false; ?>

<div class="card">
  <div class="card-body">
    <!-- Filter Form -->
    <form id="main" method="post" action="<?= base_url('index.php/Reports/employee_report') ?>">
      <div class="row mb-3 align-items-end">
        <!-- Department -->
        <div class="col-md-3">
          <label>Department</label>
          <select name="department_id" class="form-control select2">
            <option value="">All</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?= $dept->dept_id ?>" <?= ($selected_dept == $dept->dept_id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept->dept_name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Designation -->
        <div class="col-md-3">
          <label>Designation</label>
          <select name="designation_id" class="form-control select2">
            <option value="">All</option>
            <?php foreach ($designations as $desig): ?>
              <option value="<?= $desig->did ?>" <?= ($selected_desig == $desig->did) ? 'selected' : '' ?>>
                <?= htmlspecialchars($desig->designation_name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Employee -->
        <div class="col-md-3">
          <label for="user_id">Employee</label>
          <select id="user_id" name="user_id" class="form-select select2">
            <option value="">All</option>
            <?php foreach ($user_records as $user): ?>
              <option value="<?= $user->user_id ?>" <?= ($user->user_id == $user_id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($user->user_name . ' (' . $user->user_code . ')') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Buttons -->
        <div class="col-md-3 text-end">
          <div class="d-flex gap-2 justify-content-end align-items-center" style="height: 40px;">
            <button type="submit" name="action" value="Go" class="btn btn-primary btn-sm">Go</button>
            <button type="button" id="printBtn" class="btn btn-warning btn-sm">Print</button>
            <button type="button" id="exportBtn" class="btn btn-success btn-sm">Export to Excel</button>
          </div>
        </div>
      </div>

      <input type="hidden" name="is_generated" value="<?= $is_generated ? '1' : '' ?>">
    </form>

    <!-- Data Table -->
    <div class="dt-responsive table-responsive">
      <table id="datatable" class="table table-striped table-bordered nowrap" width="100%">
        <thead class="table-primary">
          <tr>
            <th>Sr. No</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Date of Join</th>
            <th>Contact Number</th>
            <th>Email ID</th>
            <th>Basic Salary</th>

          </tr>
        </thead>
        <tbody>
  <?php if (!empty($records)): ?>
    <?php $i = 1; foreach ($records as $row): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row->user_name ?? '-') ?></td>
        <td><?= htmlspecialchars($row->designation_name ?? '-') ?></td>
        <td><?= htmlspecialchars($row->dept_name ?? '-') ?></td>
        <td><?= htmlspecialchars($row->joining_date ?? '-') ?></td>
        <td><?= htmlspecialchars($row->contact_no ?? '-') ?></td>
        <td><?= htmlspecialchars($row->email_id ?? '-') ?></td>
        <td><?= htmlspecialchars($row->basic_salary ?? '-') ?></td>

      </tr>
    <?php endforeach; ?>
  <?php elseif ($is_generated): ?>
    <tr>
      <td colspan="7" class="text-center text-danger">No records found.</td>
    </tr>
  <?php endif; ?>
</tbody>

      </table>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    // Initialize Select2
    $('.select2').select2();

    // Initialize DataTable safely (prevent duplicate init)
    if (!$.fn.DataTable.isDataTable('#datatable')) {
      $('#datatable').DataTable({
        responsive: true
      });
    }

    // Print Action
    $('#printBtn').on('click', function () {
      const form = document.getElementById('main');
      form.action = '<?= base_url('index.php/Reports/print_employee_report') ?>';
      form.target = '_blank';
      form.submit();
      form.action = '<?= base_url('index.php/Reports/employee_report') ?>'; // revert
      form.target = '';
    });

    // Export Action
    $('#exportBtn').on('click', function () {
      const form = document.getElementById('main');
      form.action = '<?= base_url('index.php/Reports/export_employee_report') ?>';
      form.target = '_blank';
      form.submit();
      form.action = '<?= base_url('index.php/Reports/employee_report') ?>'; // revert
      form.target = '';
    });
  });
</script>
