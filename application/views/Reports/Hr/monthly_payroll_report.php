<div class="card">
  <div class="card-body">
    <form method="post" action="<?= base_url('index.php/Reports/monthly_payroll_report') ?>" id="filterForm" class="row g-3 align-items-end w-100">

      <input type="hidden" name="generate" id="generateFlag" value="0">

      <div class="col-md-3">
        <label for="month" class="form-label">Month</label>
        <input type="month" name="month" id="month" class="form-control" value="<?= htmlspecialchars($selected_month) ?>" required>
      </div>

      <div class="col-md-3">
        <label for="department_id" class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-select select2">
          <option value="">All</option>
          <?php foreach ($departments as $dept): ?>
            <option value="<?= $dept->dept_id ?>" <?= ($selected_dept == $dept->dept_id) ? 'selected' : '' ?>>
              <?= htmlspecialchars($dept->dept_name) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label for="user_id" class="form-label">Employee</label>
        <select name="user_id" id="user_id" class="form-select select2">
          <option value="">All</option>
          <?php foreach ($user_records as $employee): ?>
            <option
              value="<?= $employee->employee_id ?>"
              <?= ($user_id == $employee->employee_id)
                ? 'selected'
                : '' ?>>

              <?= htmlspecialchars(
                $employee->employee_name
                  . ' ('
                  . $employee->user_code
                  . ')'
              ) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3 d-flex align-items-end gap-2 flex-wrap">
        <button type="submit" class="btn btn-primary btn-sm" onclick="setGenerateFlag(1)">Generate</button>
        <button type="button" class="btn btn-warning btn-sm" onclick="submitPrint()">Print</button>
        <button type="button" class="btn btn-success btn-sm" onclick="submitExport()">Export Excel</button>
      </div>
    </form>

    <!-- Report Table below -->
    <div class="table-responsive mt-3">
      <table id="datatable" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead class="table-light">
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
          <?php if (isset($generate) && $generate == 1): ?>
            <?php if (!empty($records)): ?>
              <?php $i = 1;
              foreach ($records as $r): ?>
                <tr>
                  <td><?= $i++ ?></td>
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
              <!-- Empty state with 14 TDs -->
              <tr>
                <td colspan="14" class="text-center text-danger">No records found</td>
              </tr>
            <?php endif; ?>
          <?php else: ?>
            <!-- Not generated yet - also 14 TDs -->
            <tr>
              <td colspan="14" class="text-center">Click "Generate" to view report</td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>
</div>

<style>
  .btn-sm {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
    line-height: 1.5;
  }
</style>

<script>
  function setGenerateFlag(value) {
    document.getElementById('generateFlag').value = value;
  }


  $(document).ready(function() {
    <?php if (isset($generate) && $generate == 1 && !empty($records)): ?>
      $('#datatable').DataTable({
        responsive: true,
        destroy: true,
        language: {
          emptyTable: "No payroll data available"
        }
      });
    <?php endif; ?>
  });

  function submitPrint() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    formData.set('generate', '1');

    const printForm = document.createElement('form');
    printForm.method = 'post';
    printForm.action = '<?= base_url('index.php/Reports/print_monthly_payroll_report') ?>';
    printForm.target = '_blank';
    printForm.style.display = 'none';

    for (const [key, value] of formData.entries()) {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = key;
      input.value = value;
      printForm.appendChild(input);
    }

    document.body.appendChild(printForm);
    printForm.submit();
    document.body.removeChild(printForm);
  }

  function submitExport() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    formData.set('generate', '1');

    const exportForm = document.createElement('form');
    exportForm.method = 'post';
    exportForm.action = '<?= base_url('index.php/Reports/export_monthly_payroll_report') ?>';
    exportForm.style.display = 'none';

    for (const [key, value] of formData.entries()) {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = key;
      input.value = value;
      exportForm.appendChild(input);
    }

    document.body.appendChild(exportForm);
    exportForm.submit();
    document.body.removeChild(exportForm);
  }
</script>