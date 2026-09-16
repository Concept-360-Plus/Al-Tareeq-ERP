<div class="x_panel">


    <div class="x_content">
        <form id="main" method="post" action="<?= base_url('index.php/Hr/update_emp_attendance') ?>" autocomplete="off">

            <!-- Employee Name -->
            <!-- <div class="form-group row">
                <label class="col-sm-3 col-form-label">Employee Name:</label>
                <div class="col-sm-5">
                    <select name="employee_id" id="employee_id" class="form-control select2" required>
                        <option value="">Select Employee</option>
                        <?php foreach ($records as $emp): ?>
                            <option value="<?= $emp->employee_id ?>"
                                <?= ($emp->employee_id == $record1->employee_id) ? 'selected' : '' ?>>
                                <?= $emp->user_code . ' - ' . $emp->employee_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> -->

            <!-- Employee Name -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Employee Name:
                </label>

                <div class="col-sm-5">

                    <input type="text"
                        class="form-control"
                        value="<?= $record1->user_code . ' - ' . $record1->employee_name ?>"
                        readonly>

                    <input type="hidden"
                        name="employee_id"
                        value="<?= $record1->employee_id ?>">

                </div>
            </div>

            <!-- Date -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Date:</label>
                <div class="col-sm-5">
                    <input type="date" name="attendance_date" id="attendance_date" class="form-control form-control-sm"
                        value="<?= date('Y-m-d', strtotime($record1->Attendance_date)) ?>" required>
                </div>
            </div>

            <!-- Attendance -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Attendance <span class="text-danger">*</span></label>
                <div class="col-sm-5">
                    <select name="attendance" id="attendance" class="form-control" required onchange="showFields()">
                        <option value="">Select</option>
                        <option value="present" <?= ($record1->attendence == 'present') ? 'selected' : '' ?>>Present</option>
                        <option value="absent" <?= ($record1->attendence == 'absent') ? 'selected' : '' ?>>Absent</option>
                        <option value="half_day" <?= ($record1->attendence == 'half_day') ? 'selected' : '' ?>>Half Day</option>

                    </select>
                </div>
            </div>

            <!-- In/Out Time -->
            <div id="inOutTimeFields" style="display: none;">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">In Time:</label>
                    <div class="col-sm-3">
                        <input type="time" name="in_time" id="in_time" class="form-control form-control-sm"
                            value="<?= !empty($record1->in_time) ? date('H:i', strtotime($record1->in_time)) : '' ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Out Time:</label>
                    <div class="col-sm-3">
                        <input type="time" name="out_time" id="out_time" class="form-control form-control-sm"
                            value="<?= !empty($record1->out_time) ? date('H:i', strtotime($record1->out_time)) : '' ?>">
                    </div>
                </div>
            </div>

            <!-- Deduction Section -->
            <div id="deductionFields" style="display:none;">

                <!-- Is Deductible -->
                <div class="form-group row">

                    <label class="col-sm-3 col-form-label">
                        Is Deductible?
                    </label>

                    <div class="col-sm-5">

                        <div class="checkbox">

                            <label>

                                <input type="checkbox"
                                    id="is_deductible"
                                    name="is_deductible"
                                    value="1"
                                    <?= ($record1->is_deductible == 1) ? 'checked' : '' ?>
                                    onchange="toggleDeductionInputs()">

                                Yes, apply salary deduction

                            </label>

                        </div>

                    </div>

                </div>


                <!-- Deductible Days -->
                <div class="form-group row">

                    <label class="col-sm-3 col-form-label">
                        Deductible Days
                    </label>

                    <div class="col-sm-3">

                        <input type="number"
                            id="deductible_days"
                            name="deductible_days"
                            class="form-control"
                            min="0"
                            step="0.5"
                            value="<?= isset($record1->deductible_days) ? $record1->deductible_days : 0 ?>">

                    </div>

                </div>


                <!-- Deductible Hours -->
                <div class="form-group row">

                    <label class="col-sm-3 col-form-label">
                        Deductible Hours
                    </label>

                    <div class="col-sm-3">

                        <input type="number"
                            id="deductible_hours"
                            name="deductible_hours"
                            class="form-control"
                            min="0"
                            value="<?= isset($record1->deductible_hours) ? $record1->deductible_hours : 0 ?>">

                    </div>

                </div>


                <!-- Deductible Minutes -->
                <div class="form-group row">

                    <label class="col-sm-3 col-form-label">
                        Deductible Minutes
                    </label>

                    <div class="col-sm-3">

                        <input type="number"
                            id="deductible_minutes"
                            name="deductible_minutes"
                            class="form-control"
                            min="0"
                            max="59"
                            value="<?= isset($record1->deductible_minutes) ? $record1->deductible_minutes : 0 ?>">

                    </div>

                </div>

            </div>

            <!-- Remark -->
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Remark:</label>
                <div class="col-sm-5">
                    <textarea name="remark" id="remark" rows="2" class="form-control form-control-sm"
                        placeholder="Enter remark"><?= $record1->remark ?></textarea>
                </div>
            </div>

            <input type="hidden" name="emp_aId" value="<?= $record1->emp_aId ?>">
            <!-- <input type="hidden" name="employee_id_hidden" value="<?= $record1->employee_id ?>"> -->
            <input type="hidden" name="employee_id" value="<?= $record1->employee_id ?>">


            <!-- Submit -->
            <div class="form-group row">
                <div class="col-sm-5 offset-sm-3">
                    <button type="submit" id="add" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#employee_id').select2({
            placeholder: "Select Employee",
            width: '100%'
        });

        showFields();

        toggleDeductionInputs();


        $('#main').on('submit', function(e) {

            let valid = true;

            $('.text-danger').remove();


            // -------------------------
            // Date validation
            // -------------------------

            let dateVal = $('#attendance_date').val();

            let today = new Date();
            let year = today.getFullYear();
            let month = String(today.getMonth() + 1).padStart(2, '0');
            let day = String(today.getDate()).padStart(2, '0');

            let todayString = year + '-' + month + '-' + day;


            if (!dateVal) {

                showError(
                    'attendance_date',
                    'Please select a valid date.'
                );

                valid = false;

            } else if (dateVal > todayString) {

                showError(
                    'attendance_date',
                    'Future dates are not allowed.'
                );

                valid = false;
            }


            // -------------------------
            // Attendance
            // -------------------------

            let attendance = $('#attendance').val();

            if (!attendance) {

                showError(
                    'attendance',
                    'Please select attendance.'
                );

                valid = false;
            }


            // -------------------------
            // In / Out
            // -------------------------

            if (
                attendance === 'present' ||
                attendance === 'half_day'
            ) {

                let inTime = $('#in_time').val();
                let outTime = $('#out_time').val();


                if (!inTime) {

                    showError(
                        'in_time',
                        'Please enter In Time.'
                    );

                    valid = false;
                }


                if (!outTime) {

                    showError(
                        'out_time',
                        'Please enter Out Time.'
                    );

                    valid = false;
                }


                if (inTime && outTime && inTime >= outTime) {

                    showError(
                        'out_time',
                        'Out Time must be after In Time.'
                    );

                    valid = false;
                }
            }


            // -------------------------
            // Deduction
            // -------------------------

            if (
                attendance === 'absent' ||
                attendance === 'half_day'
            ) {

                let isDeductible =
                    $('#is_deductible').is(':checked');


                if (isDeductible) {

                    let days =
                        parseFloat($('#deductible_days').val()) || 0;

                    let hours =
                        parseInt($('#deductible_hours').val()) || 0;

                    let minutes =
                        parseInt($('#deductible_minutes').val()) || 0;


                    if (
                        days <= 0 &&
                        hours <= 0 &&
                        minutes <= 0
                    ) {

                        showError(
                            'deductible_days',
                            'Please enter deductible days, hours or minutes.'
                        );

                        valid = false;
                    }


                    if (minutes > 59) {

                        showError(
                            'deductible_minutes',
                            'Minutes must be between 0 and 59.'
                        );

                        valid = false;
                    }
                }
            }


            if (!valid) {

                e.preventDefault();
                return false;
            }

        });

    });


    function showFields() {
        var attendance = $('#attendance').val();

        $('#inOutTimeFields').hide();
        $('#deductionFields').hide();


        // Present / Half Day
        if (
            attendance === 'present' ||
            attendance === 'half_day'
        ) {

            $('#inOutTimeFields').show();
        }


        // Absent / Half Day
        if (
            attendance === 'absent' ||
            attendance === 'half_day'
        ) {

            $('#deductionFields').show();
        }
    }


    function toggleDeductionInputs() {
        var isChecked =
            $('#is_deductible').is(':checked');

        $('#deductible_days')
            .prop('disabled', !isChecked);

        $('#deductible_hours')
            .prop('disabled', !isChecked);

        $('#deductible_minutes')
            .prop('disabled', !isChecked);


        if (!isChecked) {

            $('#deductible_days').val(0);
            $('#deductible_hours').val(0);
            $('#deductible_minutes').val(0);
        }
    }


    function showError(fieldId, message) {
        let field = $('#' + fieldId);

        let errorLabel =
            $('<span class="text-danger"></span>');

        errorLabel.text(message);

        errorLabel.css({
            display: 'block',
            marginTop: '5px'
        });

        field.after(errorLabel);
    }
</script>