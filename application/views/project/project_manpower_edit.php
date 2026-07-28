<div class="x_panel">

    <div class="x_title">
        <h2>Edit Manpower</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <form method="post" action="<?= base_url('index.php/Project/update_project_manpower_data'); ?>">

            <input type="hidden" name="manpower_id" value="<?= $resource['manpower_id']; ?>">

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Manpower Code</label>
                <div class="col-md-7">
                    <input type="text" name="manpower_code" class="form-control" value="<?= $resource['manpower_code']; ?>" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Project <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select name="project_id" class="form-control" readonly>
                        <option value="">-- Select Project --</option>
                        <option value="<?= $projects['project_id']; ?>" selected>
                            <?= $projects['project_code'].' - '.$projects['project_name']; ?>
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Remarks</label>
                <div class="col-md-7">
                    <textarea name="remarks" rows="4" class="form-control"><?= htmlspecialchars($resource['remarks'] ?? ''); ?></textarea>
                </div>
            </div>

            <!--<div class="form-group row">
                <label class="col-md-2 col-form-label">Approved By</label>
                <div class="col-md-7">
                    <input type="number" name="approved_by" class="form-control" value="<?= htmlspecialchars($resource['approved_by'] ?? ''); ?>">
                </div>
            </div>-->

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Active</label>
                <div class="col-md-7">
                    <select name="bit_active" class="form-control">
                        <option value="1" <?= (!empty($resource['bit_active']) && $resource['bit_active'] == 1) ? 'selected' : '' ?>>Yes</option>
                        <option value="0" <?= (!empty($resource['bit_active']) && $resource['bit_active'] == 0) ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Manpower Items</label>
                <div class="col-md-10">
                    <table class="table table-bordered" id="manpower-items-table">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Employee</th>
                                <th>Role</th>
                                <th>Allocation %</th>
                                <th>Daily Hours</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($resource['items'])) { foreach ($resource['items'] as $item) { ?>
                                <tr>
                                    <td>
                                        <select name="designation_id[]" class="form-control designation-select" required>
                                            <option value="">-- Select --</option>
                                            <?php foreach($designations as $designation){ ?>
                                                <option value="<?= $designation['id']; ?>" <?= (!empty($item['designation_id']) && $item['designation_id'] == $designation['id']) ? 'selected' : '' ?>><?= htmlspecialchars($designation['designation_name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="employee_id[]" class="form-control employee-select" required>
                                            <option value="">-- Select --</option>
                                            <?php foreach($employees as $employee){ ?>
                                                <option value="<?= $employee['employee_id']; ?>" <?= (!empty($item['employee_id']) && $item['employee_id'] == $employee['employee_id']) ? 'selected' : '' ?>><?= htmlspecialchars($employee['employee_name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="role[]" class="form-control" value="<?= htmlspecialchars($item['role'] ?? ''); ?>"></td>
                                    <td><input type="number" step="0.01" name="allocation_percentage[]" class="form-control" value="<?= htmlspecialchars($item['allocation_percentage'] ?? '100.00'); ?>"></td>
                                    <td><input type="number" step="0.01" name="daily_hours[]" class="form-control" value="<?= htmlspecialchars($item['daily_hours'] ?? ''); ?>"></td>
                                    <td><input type="date" name="from_date[]" class="form-control" value="<?= htmlspecialchars($item['from_date'] ?? ''); ?>"></td>
                                    <td><input type="date" name="to_date[]" class="form-control" value="<?= htmlspecialchars($item['to_date'] ?? ''); ?>"></td>
                                    <td>
                                        <select name="status[]" class="form-control">
                                            <option value="Assigned" <?= (!empty($item['status']) && $item['status'] == 'Assigned') ? 'selected' : '' ?>>Assigned</option>
                                            <option value="Working" <?= (!empty($item['status']) && $item['status'] == 'Working') ? 'selected' : '' ?>>Working</option>
                                            <option value="Completed" <?= (!empty($item['status']) && $item['status'] == 'Completed') ? 'selected' : '' ?>>Completed</option>
                                            <option value="Released" <?= (!empty($item['status']) && $item['status'] == 'Released') ? 'selected' : '' ?>>Released</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="item_remarks[]" class="form-control" value="<?= htmlspecialchars($item['remarks'] ?? ''); ?>"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                                </tr>
                            <?php } } else { ?>
                                <tr>
                                    <td>
                                        <select name="designation_id[]" class="form-control designation-select" required>
                                            <option value="">-- Select --</option>
                                            <?php foreach($designations as $designation){ ?>
                                                <option value="<?= $designation['id']; ?>"><?= htmlspecialchars($designation['designation_name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="employee_id[]" class="form-control employee-select" required>
                                            <option value="">-- Select --</option>
                                            <?php foreach($employees as $employee){ ?>
                                                <option value="<?= $employee['employee_id']; ?>"><?= htmlspecialchars($employee['employee_name']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="role[]" class="form-control"></td>
                                    <td><input type="number" step="0.01" name="allocation_percentage[]" class="form-control" value="100.00"></td>
                                    <td><input type="number" step="0.01" name="daily_hours[]" class="form-control"></td>
                                    <td><input type="date" name="from_date[]" class="form-control"></td>
                                    <td><input type="date" name="to_date[]" class="form-control"></td>
                                    <td>
                                        <select name="status[]" class="form-control">
                                            <option value="Assigned">Assigned</option>
                                            <option value="Working">Working</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Released">Released</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="item_remarks[]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-default" id="add-manpower-item">Add Item</button>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-9 offset-md-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= base_url('index.php/Project/list_project_manpower/'.$project_id) ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>

        </form>

    </div>

</div>

<script>
function loadEmployeesForRow(row, selectedEmployeeId) {
    var designationSelect = row.find('.designation-select');
    var employeeSelect = row.find('.employee-select');
    var designationId = designationSelect.val();

    employeeSelect.empty();
    employeeSelect.append('<option value="">-- Select --</option>');

    if (!designationId) {
        return;
    }

    $.ajax({
        url: '<?= base_url("index.php/Project/get_employees_by_designation") ?>',
        type: 'POST',
        dataType: 'json',
        data: { designation_id: designationId },
        success: function (response) {
            if (response && response.employees) {
                $.each(response.employees, function (index, employee) {
                    var isSelected = selectedEmployeeId && selectedEmployeeId == employee.employee_id;
                    employeeSelect.append(
                        '<option value="' + employee.employee_id + '" ' + (isSelected ? 'selected' : '') + '>' + employee.employee_name + '</option>'
                    );
                });
            }
        }
    });
}

$(function () {
    $('#add-manpower-item').on('click', function () {
        var row = $('#manpower-items-table tbody tr:first').clone();
        row.find('input, select').each(function () {
            if ($(this).is('select')) {
                $(this).prop('selectedIndex', 0);
            } else {
                $(this).val('');
            }
        });
        row.find('input[name="allocation_percentage[]"]').val('100.00');
        row.find('.employee-select').empty().append('<option value="">-- Select --</option>');
        row.find('.remove-row').show();
        $('#manpower-items-table tbody').append(row);
    });

    $(document).on('change', '.designation-select', function () {
        loadEmployeesForRow($(this).closest('tr'));
    });

    $(document).on('click', '.remove-row', function () {
        if ($('#manpower-items-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

    $('.designation-select').each(function () {
        var row = $(this).closest('tr');
        var selectedEmployeeId = row.find('.employee-select').val();
        loadEmployeesForRow(row, selectedEmployeeId);
    });
});
</script>
