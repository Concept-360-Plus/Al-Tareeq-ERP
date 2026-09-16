<div class="x_panel">


  <div class="x_content">

    <form id="main"
      method="post"
      action="<?php echo base_url('index.php/Hr/add_emp_attendance_data'); ?>"
      autocomplete="off"
      class="form-horizontal form-label-left">

      <!-- Employee -->
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
          Employee Name <span style="color:red">*</span>
        </label>

        <div class="col-md-5 col-sm-6 col-xs-12">
          <select tabindex="1"
            class="form-control select2"
            id="employee_id"
            name="employee_id"
            required>

            <option value="">Select Employee</option>

            <?php foreach ($records as $s) { ?>
              <option value="<?php echo $s->employee_id; ?>">
                <?php echo $s->user_code . ' ' . $s->employee_name; ?>
              </option>
            <?php } ?>

          </select>
        </div>
      </div>


      <!-- Date -->
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
          Date <span style="color:red">*</span>
        </label>

        <div class="col-md-5 col-sm-6 col-xs-12">
          <input type="date"
            class="form-control form-control-sm"
            id="Attendance_date"
            name="Attendance_date"
            value="<?php echo date('Y-m-d'); ?>"
            max="<?php echo date('Y-m-d'); ?>"
            tabindex="2"
            required>
        </div>
      </div>


      <!-- Attendance -->
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
          Attendance <span style="color:red">*</span>
        </label>

        <div class="col-md-5 col-sm-6 col-xs-12">
          <select tabindex="3"
            class="form-control"
            id="attendance"
            name="attendance"
            required
            onchange="showFields()">

            <option value="">Select</option>
            <option value="present">Present</option>
            <option value="absent">Absent</option>
            <option value="half_day">Half Day</option>

          </select>
        </div>
      </div>


      <!-- In / Out Time -->
      <div id="inOutTimeFields" style="display:none;">

        <!-- In Time -->
        <div class="form-group row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            In Time
          </label>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="time"
              id="in_time"
              name="in_time"
              tabindex="4"
              class="form-control">
          </div>
        </div>


        <!-- Out Time -->
        <div class="form-group row">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Out Time
          </label>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="time"
              id="out_time"
              name="out_time"
              tabindex="5"
              class="form-control">
          </div>
        </div>

      </div>


      <!-- Deduction Section -->
      <div id="deductionFields" style="display:none;">

        <div class="form-group row">

          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Is Deductible?
          </label>

          <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="checkbox">
              <label>
                <input type="checkbox"
                  id="is_deductible"
                  name="is_deductible"
                  value="1"
                  onchange="toggleDeductionInputs()">

                Yes, apply salary deduction
              </label>
            </div>
          </div>

        </div>


        <!-- Deductible Days -->
        <div class="form-group row deduction-input">

          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Deductible Days
          </label>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="number"
              id="deductible_days"
              name="deductible_days"
              class="form-control"
              min="0"
              step="0.5"
              value="0"
              disabled>
          </div>

        </div>


        <!-- Deductible Hours -->
        <div class="form-group row deduction-input">

          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Deductible Hours
          </label>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="number"
              id="deductible_hours"
              name="deductible_hours"
              class="form-control"
              min="0"
              value="0"
              disabled>
          </div>

        </div>


        <!-- Deductible Minutes -->
        <div class="form-group row deduction-input">

          <label class="control-label col-md-3 col-sm-3 col-xs-12">
            Deductible Minutes
          </label>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <input type="number"
              id="deductible_minutes"
              name="deductible_minutes"
              class="form-control"
              min="0"
              max="59"
              value="0"
              disabled>
          </div>

        </div>

      </div>


      <!-- Remark -->
      <div class="form-group row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
          Remark
        </label>

        <div class="col-md-5 col-sm-6 col-xs-12">
          <textarea id="remark"
            name="remark"
            rows="2"
            placeholder="Remark"
            tabindex="9"
            class="form-control"></textarea>
        </div>
      </div>


      <!-- Submit -->
      <div class="ln_solid"></div>

      <div class="form-group row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

          <button type="submit"
            id="add"
            tabindex="10"
            class="btn btn-success">
            Submit
          </button>

        </div>
      </div>

    </form>

  </div>
</div>


<script>
  $(document).ready(function() {

    // Initialize Select2
    $('#employee_id').select2({
      placeholder: "Select Employee",
      allowClear: true,
      width: '100%'
    });

    // Initial state
    showFields();

  });


  /**
   * Show fields based on attendance status
   */
  function showFields() {

    var attendance = $('#attendance').val();

    // Reset visibility
    $('#inOutTimeFields').hide();
    $('#deductionFields').hide();

    // Present / Half Day
    if (attendance === 'present' || attendance === 'half_day') {

      $('#inOutTimeFields').show();
    }

    // Absent / Half Day
    if (attendance === 'absent' || attendance === 'half_day') {

      $('#deductionFields').show();
    }

  }


  /**
   * Enable / Disable deduction inputs
   */
  function toggleDeductionInputs() {

    var isChecked = $('#is_deductible').is(':checked');

    $('#deductible_days').prop('disabled', !isChecked);
    $('#deductible_hours').prop('disabled', !isChecked);
    $('#deductible_minutes').prop('disabled', !isChecked);

    if (!isChecked) {

      $('#deductible_days').val(0);
      $('#deductible_hours').val(0);
      $('#deductible_minutes').val(0);
    }

  }


  /**
   * Form validation
   */
  document.getElementById("main").addEventListener("submit", function(e) {

    let valid = true;

    // Remove previous errors
    document.querySelectorAll('.text-danger').forEach(function(el) {
      el.remove();
    });


    // -------------------------
    // Employee
    // -------------------------

    let employee = document.getElementById("employee_id").value;

    if (!employee) {

      showError('employee_id', 'Please select an employee.');
      valid = false;
    }


    // -------------------------
    // Date
    // -------------------------

    let attendanceDate =
      document.getElementById("Attendance_date").value;

    let today = new Date();
    let year = today.getFullYear();
    let month = String(today.getMonth() + 1).padStart(2, '0');
    let day = String(today.getDate()).padStart(2, '0');

    let todayString = year + '-' + month + '-' + day;


    if (!attendanceDate) {

      showError(
        'Attendance_date',
        'Please select a date.'
      );

      valid = false;

    } else if (attendanceDate > todayString) {

      showError(
        'Attendance_date',
        'Future dates are not allowed.'
      );

      valid = false;
    }


    // -------------------------
    // Attendance
    // -------------------------

    let attendance =
      document.getElementById("attendance").value;

    if (!attendance) {

      showError(
        'attendance',
        'Please select attendance.'
      );

      valid = false;
    }


    // -------------------------
    // Present / Half Day
    // -------------------------

    if (attendance === 'present' ||
      attendance === 'half_day') {

      let inTime =
        document.getElementById("in_time").value;

      let outTime =
        document.getElementById("out_time").value;


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

    if (attendance === 'absent' ||
      attendance === 'half_day') {

      let isDeductible =
        document.getElementById("is_deductible").checked;


      if (isDeductible) {

        let days =
          parseFloat(
            document.getElementById("deductible_days").value
          ) || 0;

        let hours =
          parseInt(
            document.getElementById("deductible_hours").value
          ) || 0;

        let minutes =
          parseInt(
            document.getElementById("deductible_minutes").value
          ) || 0;


        // At least one value required
        if (days <= 0 && hours <= 0 && minutes <= 0) {

          showError(
            'deductible_days',
            'Please enter deductible days, hours or minutes.'
          );

          valid = false;
        }


        // Hours cannot be negative
        if (hours < 0) {

          showError(
            'deductible_hours',
            'Hours cannot be negative.'
          );

          valid = false;
        }


        // Minutes must be 0-59
        if (minutes < 0 || minutes > 59) {

          showError(
            'deductible_minutes',
            'Minutes must be between 0 and 59.'
          );

          valid = false;
        }

      }

    }


    // Prevent submission
    if (!valid) {

      e.preventDefault();
      return false;
    }

  });


  /**
   * Display validation error
   */
  function showError(fieldId, message) {

    let field = document.getElementById(fieldId);

    if (!field) {
      return;
    }

    let errorLabel =
      document.createElement('span');

    errorLabel.className =
      'text-danger';

    errorLabel.style.display =
      'block';

    errorLabel.style.marginTop =
      '5px';

    errorLabel.innerText =
      message;


    // For Select2
    if (fieldId === 'employee_id') {

      let select2Container =
        $('#employee_id')
        .next('.select2');

      select2Container.after(errorLabel);

    } else {

      field.parentNode.appendChild(errorLabel);
    }

  }
</script>