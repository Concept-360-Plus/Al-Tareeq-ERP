<?php if (!isset($is_generated)) $is_generated = false; ?>

<?php
$status_labels = [
  0 => 'Pending',
  1 => 'Approved',
  2 => 'Rejected'
];
?>

<div class="card">
  <div class="card-body">
    <!-- Filter Form -->
    <form id="main" method="post" action="<?= base_url('index.php/Reports/monthly_leave_report') ?>">
      <div class="row mb-3 align-items-end">

        <!-- Month -->
        <div class="col-md-3">
          <label>Month</label>
          <input type="month" name="month" class="form-control" required value="<?= isset($selected_month) ? $selected_month : '' ?>">
        </div>

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

        <!-- Buttons -->
        <div class="col-md-6 text-end">
          <div class="d-flex gap-2 justify-content-end align-items-center" style="height: 40px;">
            <button type="submit" name="action" value="Go" class="btn btn-primary btn-sm">Generate</button>
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
          <?php if (!empty($records)): ?>
            <?php $i = 1; foreach ($records as $r): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($r->user_code ?? '-') ?></td>
                <td><?= htmlspecialchars($r->user_name ?? '-') ?></td>
                <td><?= htmlspecialchars($r->dept_name ?? '-') ?></td>
                <td><?= htmlspecialchars($r->designation_name ?? '-') ?></td>
                <td><?= htmlspecialchars($r->leave_type ?? '-') ?></td>
                <td><?= !empty($r->start_date) ? date('d-M-Y', strtotime($r->start_date)) : '-' ?></td>
                <td><?= !empty($r->end_date) ? date('d-M-Y', strtotime($r->end_date)) : '-' ?></td>
                <td><?= $status_labels[$r->leave_status] ?? 'Pending' ?></td>
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

    const table = $('#datatable');

    // Always initialize DataTable
    if (!$.fn.DataTable.isDataTable('#datatable')) {
      table.DataTable({
        responsive: true,
        language: {
          emptyTable: "No leave records found."
        }
      });
    }

    $('#printBtn').on('click', function () {
      const form = document.getElementById('main');
      form.action = '<?= base_url('index.php/Reports/print_monthly_leave_report') ?>';
      form.target = '_blank';
      form.submit();
      form.action = '<?= base_url('index.php/Reports/monthly_leave_report') ?>';
      form.target = '';
    });

    $('#exportBtn').on('click', function () {
      const form = document.getElementById('main');
      form.action = '<?= base_url('index.php/Reports/export_monthly_leave_report') ?>';
      form.target = '_blank';
      form.submit();
      form.action = '<?= base_url('index.php/Reports/monthly_leave_report') ?>';
      form.target = '';
    });
  });
</script>
