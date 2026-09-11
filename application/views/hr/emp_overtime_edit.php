<style>
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 240px !important;
        min-width: 240px !important;
    }

    .form-control-sm,
    .form-select {
        font-size: 13px !important;
    }

    label {
        font-weight: 500;
        font-size: 13px;
    }

    .x_panel {
        padding: 20px;
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .x_title {
        border-bottom: 1px solid #d9dee4;
        margin-bottom: 15px;
    }

    .x_title h2 {
        font-size: 16px;
        margin: 0;
        font-weight: 600;
        color: #34495e;
    }

    .input-group-addon {
        background: #f7f7f7;
        border: 1px solid #ced4da;
        border-left: 0;
        display: flex;
        align-items: center;
        padding: 0 10px;
    }

    textarea.form-control-sm {
        resize: vertical;
    }
</style>

<div class="x_panel">
    <div class="x_title">
        <h2>Edit Employee Overtime</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <form id="main" method="post"
            action="<?= base_url('index.php/Hr/update_emp_overtime'); ?>"
            autocomplete="off" enctype="multipart/form-data">

            <!-- Employee Name -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Employee Name:</label>
                <div class="col-sm-5">
                    <select name="employee_id" id="employee_id" class="form-control select2" required>
                        <option value="">Select Employee</option>
                        <?php foreach ($records as $emp): ?>
                            <option value="<?= $emp->employee_id ?>"
                                <?= ($emp->employee_id == $row->employee_id) ? 'selected' : '' ?>>
                                <?= $emp->user_code . ' - ' . $emp->employee_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Date -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label">Date:</label>
                <div class="col-md-5">
                    <div class="input-group date datepicker1">
                        <input type="date"
                            class="form-control form-control-sm"
                            id="date_ot" name="date_ot"
                            value="<?= !empty($row->date_ot) ? date('Y-m-d', strtotime($row->date_ot)) : '' ?>"
                            required>
                    </div>
                </div>
            </div>

            <!-- Overtime -->
            <div class="form-group row">

                <label class="col-md-3 col-sm-3 col-xs-12 col-form-label">
                    Overtime <span class="text-danger">*</span>
                </label>


                <!-- Hours -->
                <div class="col-md-2 col-sm-4 col-xs-6">

                    <input type="number"
                        class="form-control form-control-sm"
                        id="ot_hours"
                        name="ot_hours"
                        min="0"
                        step="1"
                        value="0"
                        required>

                    <small class="text-muted">Hours</small>

                </div>


                <!-- Minutes -->
                <div class="col-md-2 col-sm-4 col-xs-6">

                    <input type="number"
                        class="form-control form-control-sm"
                        id="ot_minutes"
                        name="ot_minutes"
                        min="0"
                        max="59"
                        step="1"
                        value="0"
                        required>

                    <small class="text-muted">Minutes</small>

                </div>


                <!-- Display -->
                <div class="col-md-5 col-sm-12">

                    <div id="overtime_display"
                        class="text-primary"
                        style="margin-top:7px; font-weight:500;">

                        Total: 0 Hours 0 Minutes

                    </div>

                </div>

            </div>

            <!-- Remark -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label">Remark:</label>
                <div class="col-md-5">
                    <textarea id="remark" name="remark" rows="2"
                        class="form-control form-control-sm"
                        placeholder="Enter remark"><?= $row->rem; ?></textarea>
                </div>
            </div>

            <!-- Submit -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label"></label>
                <div class="col-md-5">
                    <input type="hidden" name="id" value="<?= $row->emp_oid; ?>">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-save"></i> Update
                    </button>
                    <a href="<?= base_url('index.php/Hr/view_emp_overtime_list'); ?>" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#employee_id').select2({
            placeholder: "Select Employee",
            allowClear: true,
            width: '100%'
        });

        /*
         * Existing overtime is stored as TOTAL MINUTES.
         *
         * Example:
         * 150 minutes = 2 Hours 30 Minutes
         */

        let totalMinutes = parseInt('<?= (int)($row->overtime_minutes ?? 0) ?>') || 0;
        let existingHours = Math.floor(totalMinutes / 60);
        let existingMinutes = totalMinutes % 60;

        // Load existing values
        $('#ot_hours').val(existingHours);
        $('#ot_minutes').val(existingMinutes);

        function calculateOvertime() {

            let hours = parseInt($('#ot_hours').val()) || 0;
            let minutes = parseInt($('#ot_minutes').val()) || 0;

            // Prevent negative values
            if (hours < 0) {
                hours = 0;
                $('#ot_hours').val(0);
            }

            if (minutes < 0) {
                minutes = 0;
                $('#ot_minutes').val(0);
            }

            // Prevent minutes above 59
            if (minutes > 59) {
                minutes = 59;
                $('#ot_minutes').val(59);
            }

            $('#overtime_display').text(
                'Total: ' + hours + ' Hours ' + minutes + ' Minutes'
            );
        }
        $('#ot_hours, #ot_minutes').on('input', calculateOvertime);
        // Initial display
        calculateOvertime();
    });
</script>