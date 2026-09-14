<style>
    .offer-basic-section {
        width: 100%;
    }

    .offer-row {
        margin-bottom: 18px;
    }

    .offer-field {
        flex: 0 0 20%;
        max-width: 20%;
        padding-left: 12px;
        padding-right: 12px;
    }

    .offer-field .form-label,
    .offer-row .form-label {
        display: block;
        margin-bottom: 6px;
        color: #5f7f9f;
        font-weight: 400;
    }

    .required {
        color: red;
        margin-left: 2px;
    }

    .offer-field .form-control,
    .offer-row .form-control {
        width: 100%;
    }

    /* Select2 should occupy the complete field width */
    .offer-field .select2-container,
    .offer-row .select2-container {
        width: 100% !important;
    }

    .offer-field .select2-selection--single,
    .offer-row .select2-selection--single {
        height: 31px !important;
        min-height: 31px !important;
    }

    .offer-field .select2-selection__rendered,
    .offer-row .select2-selection__rendered {
        line-height: 29px !important;
    }

    .offer-field .select2-selection__arrow,
    .offer-row .select2-selection__arrow {
        height: 29px !important;
    }

    @media (max-width: 991px) {

        .offer-field {
            flex: 0 0 50%;
            max-width: 50%;
            margin-bottom: 15px;
        }

    }

    @media (max-width: 575px) {

        .offer-field {
            flex: 0 0 100%;
            max-width: 100%;
        }

    }
</style>

<div class="card-body">

    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_offer_letter_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <div class="container my-4">

            <!-- ================= OFFER LETTER BASIC DETAILS ================= -->

            <div class="offer-basic-section">

                <!-- ROW 1 -->
                <div class="row offer-row">

                    <!-- Branch -->
                    <div class="offer-field">
                        <label class="form-label">
                            Branch:<span class="required">*</span>
                        </label>

                        <select
                            class="form-control form-control-sm select2"
                            id="branch_id"
                            name="branch_id"
                            required>

                            <option value="">Select Branch</option>

                            <?php foreach ($branch_list as $branch) { ?>
                                <option value="<?php echo $branch->branch_id; ?>">
                                    <?php echo $branch->branch_name; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>


                    <!-- Name -->
                    <div class="offer-field">
                        <label class="form-label">
                            Name:<span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control form-control-sm"
                            name="user_name"
                            id="user_name"
                            value=""
                            required>
                    </div>


                    <!-- Gender -->
                    <div class="offer-field">
                        <label class="form-label">
                            Gender:<span class="required">*</span>
                        </label>

                        <select
                            class="form-control form-control-sm select2"
                            id="gender"
                            name="gender"
                            required>

                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>

                        </select>
                    </div>


                    <!-- Department -->
                    <div class="offer-field">
                        <label class="form-label">
                            Department:<span class="required">*</span>
                        </label>

                        <select
                            class="form-control form-control-sm select2"
                            id="department_id"
                            name="department_id"
                            required>

                            <option value="">Select Department</option>

                            <?php foreach ($department_list as $department) { ?>
                                <option value="<?php echo $department->dept_id; ?>">
                                    <?php echo $department->dept_name; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>


                    <!-- Designation -->
                    <div class="offer-field">
                        <label class="form-label">
                            Designation:<span class="required">*</span>
                        </label>

                        <select
                            class="form-control form-control-sm select2"
                            id="designation_id"
                            name="designation_id"
                            required>

                            <option value="">Select Designation</option>

                            <?php foreach ($desig_list as $desig) { ?>
                                <option value="<?php echo $desig->id; ?>">
                                    <?php echo $desig->designation_name; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>

                </div>


                <!-- ROW 2 -->
                <div class="row offer-row">

                    <!-- Offer Date -->
                    <div class="col-md-3">
                        <label class="form-label">
                            Offer Date:<span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control form-control-sm"
                            name="offer_date"
                            id="offer_date"
                            required>
                    </div>


                    <!-- Reporting Manager -->
                    <div class="col-md-3">
                        <label class="form-label">
                            Reporting Manager:<span class="required">*</span>
                        </label>

                        <select
                            class="form-control form-control-sm select2"
                            id="manager_id"
                            name="manager_id"
                            required>

                            <option value="">Select User</option>

                            <?php foreach ($user_records as $user) { ?>
                                <option value="<?php echo $user->user_id; ?>">
                                    <?php echo $user->user_name; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>


                    <!-- Employee Address -->
                    <div class="col-md-3">
                        <label class="form-label">
                            Employee Address:
                        </label>

                        <textarea
                            class="form-control form-control-sm"
                            name="employee_address"
                            id="employee_address"
                            rows="2"></textarea>
                    </div>


                    <!-- Office Address -->
                    <div class="col-md-3">
                        <label class="form-label">
                            Office Address:<span class="required">*</span>
                        </label>

                        <textarea
                            class="form-control form-control-sm"
                            name="office_address"
                            id="office_address"
                            rows="2"
                            required>Al Quoz Industrial Area 4, Dubai - UAE</textarea>
                    </div>

                </div>

            </div>
        </div>
        <!-- <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Offer Letter Body:</label>
                    <textarea class="form-control form-control-sm" name="offer_body"></textarea>
                </div> 
            </div> -->
        <!-- Dynamic Table -->
        <div class="form-section">
            <div class="section-title">Salary Structure:</div>
            <table class="table table-bordered" id="SalaryTable">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Monthly</th>
                        <th>Annual</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="desc[]" class="form-control form-control-sm" />
                        </td>
                        <td>
                            <input type="text" name="monthly[]" class="form-control form-control-sm" />
                        </td>
                        <td>
                            <input type="text" name="annual[]" class="form-control form-control-sm" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" title="Add Row" onclick="addSalaryRow()"><i class="fa fa-plus"></i></button>

                            <button type="button" class="btn btn-danger" title="Remove Row" onclick="removeSalaryRow(this)"><i class="fa fa-minus"></i></button>

                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="row mb-3">
            <!-- <div class="col-md-12">
                    <label class="form-label">Salary Structure:</label>
                    <textarea class="form-control form-control-sm" name="salary_stucture"></textarea>
                </div>  -->

            <!-- <div class="col-md-12">
                    <label class="form-label">Incentive Structure:</label>
                    <textarea class="form-control form-control-sm" name="incentive_stucture"></textarea>
                </div> -->
        </div>

        <!-- Dynamic Table -->
        <div class="form-section">
            <div class="section-title">Incentive Structure:</div>
            <table class="table table-bordered" id="incentiveTable">
                <thead>
                    <tr>
                        <th>Case</th>
                        <th>Salary</th>
                        <th>Target</th>
                        <th>Incentive 3%</th>
                        <th>Magical Figures</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="case[]" class="form-control form-control-sm" />
                        </td>
                        <td>
                            <input type="number" name="salary[]" class="form-control form-control-sm salary" oninput="calculateIncentive(this)" />
                        </td>
                        <td>
                            <input type="text" name="target_1[]" class="form-control form-control-sm" />
                        </td>
                        <td>
                            <input type="text" name="incentive_3_percent[]" class="form-control form-control-sm" />
                        </td>
                        <td>
                            <input type="text" name="target_2[]" class="form-control form-control-sm" />
                        </td>
                        <!-- <td>
                            <input type="text" name="incentive_5_percent[]" class="form-control form-control-sm"/>
                        </td> -->
                        <td>
                            <button type="button" class="btn btn-danger" title="Remove Row" onclick="removeIncentiveRow(this)"><i class="fa fa-minus"></i></button>

                            <button type="button" class="btn btn-success" title="Add Row" onclick="addIncentiveRow()"><i class="fa fa-plus"></i></button>

                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <!-- <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Other Benefits:</label>
                    <textarea class="form-control form-control-sm" name="other_benefits"></textarea>
                </div> 
            </div> 
            <div class="row mb-3">    
            
                <div class="col-md-12">
                    <label class="form-label">Annexure B:</label>
                    <textarea class="form-control form-control-sm" name="annexure_b"></textarea>
                </div>
            </div>  -->
        <button type="submit" class="btn btn-success">Submit Request</button>

</div>
</form>
</div>
<script>
    let rowCount = 1;

    // --- Add Salary Row ---
    function addSalaryRow() {
        const tableBody = document.getElementById("SalaryTable").getElementsByTagName('tbody')[0];

        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="desc[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="monthly[]" class="form-control form-control-sm monthly" oninput="calculateAnnual(this)"/></td>
            <td><input type="number" name="annual[]" class="form-control form-control-sm annual" readonly/></td>
            <td><button type="button" class="btn btn-danger" title="Remove Row" onclick="removeSalaryRow(this)"><i class="fa fa-minus"></i></button></td>
        `;

        tableBody.appendChild(newRow);
    }

    // --- Remove Salary Row ---
    function removeSalaryRow(button) {
        const row = button.closest("tr");
        const tableBody = document.getElementById("SalaryTable").getElementsByTagName('tbody')[0];

        if (tableBody.rows.length > 1) {
            row.remove();
        } else {
            alert("At least one row is required.");
        }
    }

    // --- Auto Calculate Annual = Monthly × 12 ---
    function calculateAnnual(input) {
        const monthlyValue = parseFloat(input.value) || 0;
        const annualInput = input.closest("tr").querySelector('input[name="annual[]"]');
        annualInput.value = (monthlyValue * 12).toFixed(2);
    }

    // --- Add Incentive Row ---
    function addIncentiveRow() {
        const tableBody = document.getElementById("incentiveTable").getElementsByTagName('tbody')[0];

        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="case[]" class="form-control form-control-sm"/></td>
        <td><input type="number" name="salary[]" class="form-control form-control-sm salary" oninput="calculateIncentive(this)"/></td>
            <td><input type="number" name="target_1[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="incentive_3_percent[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="target_2[]" class="form-control form-control-sm"/></td>
            <td><button type="button" class="btn btn-danger" title="Remove Row" onclick="removeIncentiveRow(this)"><i class="fa fa-minus"></i></button></td>
        `;

        tableBody.appendChild(newRow);
    }

    // --- Remove Incentive Row ---
    function removeIncentiveRow(button) {
        const row = button.closest("tr");
        const tableBody = document.getElementById("incentiveTable").getElementsByTagName('tbody')[0];

        if (tableBody.rows.length > 1) {
            row.remove();
        } else {
            alert("At least one row is required.");
        }
    }


    // Auto-calculate Target & Incentive
    function calculateIncentive(input) {
        const salary = parseFloat(input.value) || 0;
        const row = input.closest("tr");
        const targetField = row.querySelector('input[name="target_1[]"]');
        const incentiveField = row.querySelector('input[name="incentive_3_percent[]"]');
        const magicFigureField = row.querySelector('input[name="target_2[]"]');

        const target = salary * 30;
        const incentive = target * 0.03;
        const magicFigure = salary * 40;

        targetField.value = target.toFixed(2);
        incentiveField.value = incentive.toFixed(2);
        magicFigureField.value = magicFigure.toFixed(2);
    }

    // --- Enable calculation for existing rows on load ---
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('#SalaryTable input[name="monthly[]"]').forEach(input => {
            input.addEventListener('input', function() {
                calculateAnnual(this);
            });
        });
    });

    $(document).ready(function() {

        $('#branch_id').select2({
            width: '100%',
            placeholder: 'Select Branch',
            allowClear: true
        });

        $('#gender').select2({
            width: '100%',
            placeholder: 'Select Gender',
            allowClear: true
        });

        $('#department_id').select2({
            width: '100%',
            placeholder: 'Select Department',
            allowClear: true
        });

        $('#designation_id').select2({
            width: '100%',
            placeholder: 'Select Designation',
            allowClear: true
        });

        $('#manager_id').select2({
            width: '100%',
            placeholder: 'Select Reporting Manager',
            allowClear: true
        });

    });
</script>