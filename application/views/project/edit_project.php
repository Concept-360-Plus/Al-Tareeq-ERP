<style>
    /*

    */
</style>
<link href="<?php echo base_url()."public/assets/task.css"; ?>" rel="stylesheet">
<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_content">

<!--        <form id="project_form" action="<?= base_url('index.php/Project/update_task') ?>" method="post">-->
<form id="project_form" action="<?= base_url('index.php/Project/update_project') ?>" method="post">


<input type="hidden" name="project_id" value="<?= $project['project_id']; ?>">
<input type="hidden" name="project_task_id" value="<?= !empty($project_task) ? $project_task['id'] : ''; ?>">
<!-- ================= PROJECT BASIC INFO ================= -->
<h5>Project Details</h5>
<div class="row">

    <!-- Enquiry 
        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enquiry</label>
                                <select name="e_id" id="se_select" class="form-control" required>
                                    <option value="">-- Select Enquiry --</option>
                                    <?php foreach ($enquires as $eq): ?>
                                        <option value="<?= $eq['enquiry_id']; ?>" <?php if($eq['enquiry_id']==$project['fk_enq_id']):?> selected="selected"<?php endif;?>>
                                            <?= $eq['enquiry_code']; ?> - <?= $eq['customer_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>-->

                        <!-- Quotation -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quotation</label>
                                <select name="quotation_id" id="quotation_select" class="form-control" required readonly>
                                    <option value="">-- Select Quotation --</option>
                                    <?php foreach ($quotation as $qo): ?>
                                        <option value="<?= $qo['qtn_id']; ?>" <?php if($qo['qtn_id']==$project['fk_quot_id']):?> selected="selected"<?php endif;?>>
                                            <?= $qo['quotation_code']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>
<table class="table table-bordered">
<tr>
    <!--<th width="20%">Sales Order</th>
    <td width="30%">
        <input type="text" class="form-control" value="<?= $project['so_code'] ?? '' ?>" readonly>
        <input type="hidden" name="so_id" value="<?= $project['so_id'] ?>">
    </td>-->
    <!-- <th width="20%">Customer</th>
    <td width="30%">
       <input type="text" class="form-control" value="<?= $project['customer_name'] ?>" readonly>
        <input type="hidden" name="customer_name" value="<?= $project['customer_name'] ?>">
        <input type="hidden" name="branch_name" value="<?= $project['branch_name'] ?>">
    </td> -->
</tr>

<tr>
    <th width="20%">Customer</th>
    <td width="25%">
       <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?= $project['customer_name'] ?>" <?= !empty($project['customer_name']) ? 'readonly' : '' ?>>
    </td>
    <th width="20%">Branch</th>
    <td width="25%">
       <input type="text" name="branch_name" id="branch_name" class="form-control" value="<?= $project['branch_name'] ?>" <?= !empty($project['branch_name']) ? 'readonly' : '' ?>>
    </td>
</tr>


<tr>
    <th>Project Name</th>
    <td>
        <input type="text" name="project_name" class="form-control" value="<?= $project['project_name'] ?>" required>
    </td>
    <th>Location</th>
    <td>
        <input type="text" name="project_location" class="form-control" value="<?= $project['project_location'] ?>">
    </td>
</tr>

<tr>
    <th>Start Date</th>
    <td>
        <input type="date" name="start_date1" id="start_date" class="form-control"
               value="<?= $project['start_date'] ?>">
    </td>
    <th>End Date</th>
    <td>
        <input type="date" name="end_date1" id="end_date" class="form-control"
               value="<?= $project['end_date'] ?>">
    </td>
</tr>

<tr>
    <th>Duration (Days)</th>
    <td colspan="1">
        <input type="text" name="duration" id="duration" class="form-control"
               value="<?= $project['duration'] ?>" readonly>
    </td>
</tr>
</table>
<div class="row">
                        <!-- Enquiry -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" value="<?= $project['subject'] ?? '' ?>" class="form-control qty_input text-end">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Client Po Number</label>
                                <input type="text" name="po_number" id="po_number" class="form-control">
                            </div>
                        </div>
                        <!-- Enquiry -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>LOA Received</label>
                                <select name="loa_received" id="loa_received" class="form-control" >
                                    <option value="">-- Select --</option>
                                    <?php $project['loa_received'] = $project['loa_received']??'';?>
                                    <option value="Yes"<?php if($project['loa_received']=='Yes'):?> selected="selected"<?php endif;?>>Yes</option>
                                    <option value="No"<?php if($project['loa_received']=='No'):?> selected="selected"<?php endif;?>>No</option>>
                                </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>LOA Received Date</label>
                                <input type="date" name="loa_date" id="loa_date" value="<?= $project['loa_date'] ?? '' ?>" class="form-control">
                            </div>
                        </div>
                        
                    </div>

<!-- ================= PROJECT ITEMS ================= -->

<h5>Project Items</h5>
<table class="table table-bordered col-md-6" id="project_items_table">
<thead>
<tr>
    <th>#</th>
    <th>Item</th>
    <th class="text-end">Qty</th>
    <!--<th class="text-end">Unit Price</th>
    <th class="text-end">Total</th>-->
</tr>
</thead>
<tbody>

<?php foreach ($project_items as $i => $item): ?>
<tr>
    <td><?= $i+1 ?></td>
    <td>
        <?= $item['product_name'] ?>
        <input type="hidden" name="product_id[]" value="<?= $item['product_id'] ?>">
    </td>
    <td>
        <input type="number" name="quantity[]" class="form-control qty_input text-end"
               value="<?= $item['quantity'] ?>" readonly>
    </td>
    <!--<td>
        <input type="number" name="unit_price[]" class="form-control price_input text-end"
               value="<?= $item['unit_price'] ?>" readonly>
    </td>
    <td class="text-end total"><?= number_format($item['total'],2) ?></td>-->
</tr>
<?php endforeach; ?>

</tbody>
</table>

<!-- Task assignment-->
<!-- ================= PROJECT TASKS ================= -->

<div class="card mt-3 col-md-12">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Project Tasks
        </h4>

        <button type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#taskModal">

            <i class="fa fa-plus"></i>

            Assign Task

        </button>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped" id="taskTable">

            <thead>

            <tr>

                <th width="5%">#</th>

                <th>Task</th>
                <th>Category</th>
                <th>Milestone</th>

                <th>Employee</th>

                <th>Priority</th>

                <th>Start</th>

                <th>End</th>

                <th>Status</th>

                <th width="12%">Action</th>

            </tr>

            </thead>

            <tbody>

            <?php
            if(!empty($project_tasks))
            {
                $i=1;

                foreach($project_tasks as $row)
                {
            ?>

            <tr>

                <td><?= $i++ ?></td>

               

                <td><?= $row['task_name']; ?></td>
                <td><?= $row['project_task_name']; ?></td>

                <td><?= $row['milestone_name']; ?></td>

                <td><?= $row['employee_name']; ?></td>

                <td><?= $row['priority']; ?></td>

                <td><?= date('d-m-Y',strtotime($row['start_date'])); ?></td>

                <td><?= date('d-m-Y',strtotime($row['end_date'])); ?></td>

                <td><?= ucfirst(str_replace('_',' ',$row['status'])); ?></td>

                <td>

                    <button
                        type="button"
                        class="btn btn-warning btn-xs editTask">

                        <i class="fa fa-pencil"></i>

                    </button>

                    <button
                        type="button"
                        class="btn btn-danger btn-xs removeTask">

                        <i class="fa fa-trash"></i>

                    </button>

                    <!-- Hidden Values -->

                    <input type="hidden" class="task_id"
                           value="<?= $row['id']; ?>">

                    <input type="hidden" class="category_id"
                           value="<?= $row['task_category_id']; ?>">

                    <input type="hidden" class="milestone_id"
                           value="<?= $row['milestone_id']; ?>">

                    <input type="hidden" class="designation_id"
                           value="<?= $row['designation_id']; ?>">

                    <input type="hidden" class="employee_id"
                           value="<?= $row['employee_id']; ?>">

                    <input type="hidden" class="task_description"
                           value="<?= htmlspecialchars($row['task_description']); ?>">

                </td>
                <td style="display:none" class="hiddenTaskData">

                    <!-- Hidden inputs for this task -->

                </td>

            </tr>

            <?php

                }

            }

            ?>

            </tbody>

        </table>

    </div>

</div>



<div id="hiddenTaskInputs">

<?php

if(!empty($project_tasks))
{

    foreach($project_tasks as $row)
    {

?>

<input type="hidden" name="task_id[]" value="<?= $row['id']; ?>">
<input type="hidden" name="task_name[]" value="<?= htmlspecialchars($row['task_name']); ?>">
<input type="hidden" name="milestone[]" value="<?= $row['milestone_id']; ?>">
<input type="hidden" name="designation_id[]" value="<?= $row['designation_id']; ?>">
<input type="hidden" name="employee_id[]" value="<?= $row['employee_id']; ?>">
<input type="hidden" name="priority[]" value="<?= $row['priority']; ?>">
<input type="hidden" name="task_category[]" value="<?= $row['task_category_id']; ?>">
<input type="hidden" name="start_date[]" value="<?= $row['start_date']; ?>">
<input type="hidden" name="end_date[]" value="<?= $row['end_date']; ?>">

<input type="hidden" name="status[]" value="<?= $row['status']; ?>">

<input type="hidden" name="task_description[]" value="<?= htmlspecialchars($row['task_description']); ?>">

<?php

    }

}

?>

</div>



<!-- ================= TASK MODAL ================= -->

<div class="modal fade"
     id="taskModal"
     tabindex="-1">

<div class="modal-dialog modal-xl task-modal-dialog">

<div class="modal-content">

<div class="modal-header bg-primary text-white">

<h4 class="modal-title">

Assign Project Tasks

</h4>

<button type="button"
        class="close"
        data-dismiss="modal">

&times;

</button>

</div>

<div class="modal-body task-modal-body">

<button
type="button"
class="btn btn-success btn-sm mb-3"
id="addTaskRow">

<i class="fa fa-plus"></i>

Add Task

</button>

<div class="task-table-responsive">

<table
class="table table-bordered"
id="popupTaskTable">

<thead>

<tr>

<th>Category</th>

<th>Task</th>

<th>Milestone</th>

<th>Designation</th>

<th>Employee</th>

<th>Priority</th>

<th>Start</th>

<th>End</th>

<th>Status</th>

<th>Description</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<!-- Filled by JavaScript -->

</tbody>

</table>

</div>

</div>

<div class="modal-footer">

<button
type="button"
class="btn btn-success"
id="saveTask">

Save Tasks

</button>

<button
type="button"
class="btn btn-secondary"
data-dismiss="modal">

Close

</button>

</div>

</div>

</div>

</div>

<!-- Task assignment -->

<!-- ================= FINANCIAL SUMMARY ================= -->
<!--
<h5>Financial Summary</h5>
<table class="table table-bordered" style="width:50%">
<tr>
    <th>Subtotal</th>
    <td>
        <input type="text" name="subtotal" id="subtotal" class="form-control"
               value="<?= $project['subtotal'] ?>" readonly>
    </td>
</tr>
<tr>
    <th>VAT (%)</th>
    <td>
        <input type="number" name="vat_percentage" id="vat_percentage" class="form-control"
               value="<?= $project['vat_percentage'] ?>" readonly>
    </td>
</tr>
<tr>
    <th>VAT Amount</th>
    <td>
        <input type="text" name="vat_amount" id="vat_amount" class="form-control"
               value="<?= $project['vat_amount'] ?>" readonly>
    </td>
</tr>
<tr>
    <th>Grand Total</th>
    <td>
        <input type="text" name="grand_total" id="grand_total" class="form-control"
               value="<?= $project['grand_total'] ?>" readonly>
    </td>
</tr>
</table> -->

<!-- ================= TECHNICIAN ASSIGNMENT ================= -->

<!--<h5 style="clear:both;">Technician & Resource Assignment</h5>

<table class="table table-bordered" id="technician_table">
<thead>
<tr>
    <th>#</th>
    <th>Technician</th>
    <th>Role</th>
    <th>Start</th>
    <th>End</th>
   
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php if (!empty($project_technicians)): ?>
<?php foreach ($project_technicians as $i => $tech): ?>
<tr>
    <td><?= $i+1 ?></td>
    <td>
    <select name="technician_id[]" class="form-control technician_select">
        <?php foreach ($employees as $emp): ?>
        <option value="<?= $emp['employee_id'] ?>"
            <?= $emp['employee_id'] == $tech['employee_id'] ? 'selected' : '' ?>>
            <?= $emp['employee_name'] ?>
        </option>
        <?php endforeach; ?>
    </select>
</td>
<td>
    <select name="designation_id[]" class="form-control designation_select">
        <?php foreach ($designations as $des): ?>
        <option value="<?= $des['id'] ?>"
            <?= $des['id'] == $tech['designation_id'] ? 'selected' : '' ?>>
            <?= $des['designation_name'] ?>
        </option>
        <?php endforeach; ?>
    </select>
</td>
<td><input type="date" name="assignment_start[]" class="form-control assignment_start"
           value="<?= $tech['assignment_start'] ?>"></td>
<td><input type="date" name="assignment_end[]" class="form-control assignment_end"
           value="<?= $tech['assignment_end'] ?>"></td>


    <td>
        <button type="button" class="btn btn-danger btn-sm remove_row">Remove</button>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>

</tbody>
</table>

<button type="button" class="btn btn-primary btn-sm" id="add_technician">Add Technician</button>
        -->
<!-- ================= REMARKS ================= -->
        </div>
<div class="form-group mt-3 col-md-12">
<label>Remarks</label>
<textarea name="remarks" class="form-control" style="width:50%;"><?= $project['remarks']; ?></textarea>
</div>

<div class="form-group mt-3 col-md-12">
   <label>Approver</label>
    
       <select name="approver" class="form-control" style="width:50%;">
        <?php foreach($users as $user){ ?>
            <option value="<?= $user['user_id']; ?>"
                <?= ($project['approver_id']==$user['user_id'])?'selected':''; ?>>
                <?= $user['user_name']; ?>
            </option>
        <?php } ?>
</select>
</div>

<div class="text-end col-md-12">
    <button type="submit" class="btn btn-success">Update Project</button>
    <a href="<?= base_url('index.php/Project/get_project_list') ?>" class="btn btn-secondary">Cancel</a>

    <?php if ($project['approver_id'] == $logged_in_user_id && $project['status'] != 'Approved'): ?>
        <button type="button" id="approve_project" class="btn btn-primary">
            Approve
        </button>

        <?php if ($project['status'] != 'Rejected'): ?>
            <button type="button" id="reject_project" class="btn btn-danger">
                Reject
            </button>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($project['status'] === 'Approved'): ?>
<a href="<?= base_url('index.php/Project/create_material_request/'.$project['project_id']) ?>"
   class="btn btn-primary btn-sm">
   Create MR
</a>
<?php endif; ?>


</div>



</form>

</div>
</div>
</div>
</div>

<!-- ================= JS ================= -->

<script>
var editingRow = null;
var employees = <?= json_encode($employees); ?>;
var designations = <?= json_encode($designations); ?>;
var rowCount = $('#technician_table tbody tr').length;

// Generate dropdown options
function getTechnicianOptions() {
    var options = '<option value="">-- Select Technician --</option>';
    employees.forEach(function(emp){
        options += `<option value="${emp.employee_id}">${emp.employee_name}</option>`;
    });
    return options;
}

function getDesignationOptions() {
    var options = '<option value="">-- Select Role --</option>';
    designations.forEach(function(des){
        options += `<option value="${des.id}">${des.designation_name}</option>`;
    });
    return options;
}

// Add new technician row
$('#add_technician').click(function(){
    rowCount++;
    var newRow = `<tr>
        <td>${rowCount}</td>
        <td>
            <select name="technician_id[]" class="form-control technician_select">
                ${getTechnicianOptions()}
            </select>
        </td>
        <td>
            <select name="designation_id[]" class="form-control designation_select">
                ${getDesignationOptions()}
            </select>
        </td>
        <td><input type="date" name="assignment_start[]" class="form-control assignment_start"></td>
        <td><input type="date" name="assignment_end[]" class="form-control assignment_end"></td>
        <td class="availability_status"><span class="badge bg-secondary">Checking...</span></td>
        <td><button type="button" class="btn btn-danger btn-sm remove_row">Remove</button></td>
    </tr>`;
    $('#technician_table tbody').append(newRow);
});

// Remove row and re-number
$(document).on('click', '.remove_row', function () {
    $(this).closest('tr').remove();
    $('#technician_table tbody tr').each(function (i) {
        $(this).find('td:first').text(i + 1);
    });
    rowCount = $('#technician_table tbody tr').length;
});

// Check availability function
function checkAvailability(row) {
    var technician_id = row.find('.technician_select').val();
    var start_date = row.find('.assignment_start').val();
    var end_date = row.find('.assignment_end').val();
    var project_id = $('input[name="project_id"]').val();

    if (!technician_id || !start_date || !end_date) return;

    $.ajax({
        url: '<?= base_url("index.php/Project/check_technician_availability") ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            technician_id: technician_id,
            start_date: start_date,
            end_date: end_date,
            project_id: project_id
        },
        success: function(res) {
            var badge = row.find('.availability_status span');
            if (res.status === 'Available') {
                badge.removeClass().addClass('badge bg-success').text('Available');
            } else {
                badge.removeClass().addClass('badge bg-danger').text('Not Available');
            }
        }
    });
}

// Trigger availability check
$(document).on('change', '.technician_select, .assignment_start, .assignment_end', function() {
    var row = $(this).closest('tr');
    checkAvailability(row);
});

// Initial check on page load for existing rows
$('#technician_table tbody tr').each(function(){
    checkAvailability($(this));
});

$('#project_form').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res){
            if(res.status === 'error'){
                alert(res.message); // Show pop-up alert
            } else {
                alert(res.message); // Success message
                window.location.href = '<?= base_url("index.php/Project/get_project_list") ?>';
            }
        },
        error: function(){
            alert('Something went wrong. Please try again.');
        }
    });
});


$('#approve_project').click(function(){
    if(confirm('Are you sure you want to approve this project?')){
        $.ajax({
            url: '<?= base_url("index.php/Project/approve_project") ?>',
            type: 'POST',
            data: { project_id: $('input[name="project_id"]').val() },
            dataType: 'json',
            success: function(res){
                if(res.status === 'success'){
                    alert(res.message);
                    window.location.href = '<?= base_url("index.php/Project/get_project_list") ?>';
                } else {
                    alert(res.message);
                }
            },
            error: function(){
                alert('Something went wrong while approving the project.');
            }
        });
    }
});
$('#reject_project').click(function(){
    if(confirm('Are you sure you want to reject this project?')){
        $.ajax({
            url: '<?= base_url("index.php/Project/reject_project") ?>',
            type: 'POST',
            data: { project_id: $('input[name="project_id"]').val() },
            dataType: 'json',
            success: function(res){
                if(res.status === 'success'){
                    alert(res.message);
                    window.location.href = '<?= base_url("index.php/Project/get_project_list") ?>';
                } else {
                    alert(res.message);
                }
            },
            error: function(){
                alert('Something went wrong while rejecting the project.');
            }
        });
    }
});

</script>
<script>
$(document).ready(function(){

    $('#se_select').change(function(){
        var enquiry_id = $(this).val();

        if(enquiry_id != ''){

            $.ajax({
                url: "<?php echo base_url()?>index.php/Project/getQuotationByEnquiry",
                type: "POST",
                data: {enquiry_id: enquiry_id},
                dataType: "json",
                success: function(response){

                    $('#quotation_select').html('<option value="">-- Select Quotation --</option>');

                    $.each(response, function(index, row){

                        $('#quotation_select').append(
                            '<option value="'+row.qtn_id+'">'+row.quotation_code+'</option>'
                        );

                    });

                }
            });

        }else{

            $('#quotation_select').html('<option value="">-- Select Quotation --</option>');

        }

    });

});
$(document).ready(function () {

    $('#se_select').change(function () {
        var enquiry_id = $(this).val();
        if (enquiry_id != '') {

            $.ajax({
                url: "<?php echo base_url()?>index.php/Project/getProjectDetailsByEnquiry",
                type: "POST",
                data: { enquiry_id: enquiry_id },
                dataType: "json",
                success: function (response) {

                    // Auto fill project details
                    $('#project_name').val(response.project_name);
                    $('#project_location').val(response.project_location);

                }
            });

        } else {

            $('#project_name').val('');
            $('#project_location').val('');
            $('#quotation_select').html('<option value="">-- Select Quotation --</option>');

        }

    });

});

$(document).ready(function () {

    $('#quotation_select').change(function () {

        var quotation_id = $(this).val();

        if (quotation_id != '') {

            $.ajax({
                url: "<?php echo base_url()?>index.php/Project/getcustomerDetails",
                type: "POST",
                data: {
                    quotation_id: quotation_id
                },
                dataType: "json",
                success: function (response) {

                    $('#customer_name').val(response.customer);
                    $('#branch_name').val(response.branch);
                     $('#project_name').val(response.project_name);
                    $('#project_location').val(response.project_location);
                    $('#customer_name').prop('readonly', !!$.trim(response.customer || ''));
                    $('#branch_name').prop('readonly', !!$.trim(response.branch || ''));

                }
            });

        } else {

            $('#customer_name').val('');
            $('#branch_name').val('');
            $('#customer_name, #branch_name').prop('readonly', false);

        }

    });

});


function fetchQuotation(q_id){
        if(!q_id) return;
        $.ajax({
            url: '<?= base_url("index.php/Project/fetch_quotation_details") ?>',
            type: 'POST',
            data: {q_id: q_id},
            dataType: 'json',
            success: function(data){
                var html = '';
                $.each(data.q_products, function(i, prod){
                    html += '<tr>'+
                        '<td>'+(i+1)+'</td>'+
                        '<td><input type="hidden" name="product_id[]" value="'+prod.prd_id+'">'+prod.product_name+'</td>'+
                        '<td class="text-end"><input type="text" name="quantity[]" value="'+prod.qty+'" class="form-control qty_input text-end" readonly></td>'+
                        //'<td class="text-end"><input type="text" name="unit_price[]" value="'+prod.unit_price+'" class="form-control price_input text-end" readonly></td>'+
                        //'<td class="text-end total">'+(prod.qty * prod.unit_price).toFixed(2)+'</td>'+
                    '</tr>';
                });
                $('#project_items_table tbody').html(html);

                calculateTotals();
            }
        });
    }

    // Trigger when user manually selects quotation
    $('#quotation_select').change(function(){
        var q_id = $(this).val();
        fetchQuotation(q_id);
    });

    // ✅ Auto-fetch if SO is preselected via URL
    var preselected_so_id = '<?= $selected_so_id ?? '' ?>';
    if(preselected_so_id){
        fetchSO(preselected_so_id);
    }

    // Recalculate totals on quantity or price change
    $(document).on('keyup change', '.qty_input, .price_input', function(){
        calculateTotals();
    });

    function calculateTotals(){
        var subtotal = 0;
        $('#project_items_table tbody tr').each(function(){
            var qty = parseFloat($(this).find('.qty_input').val()) || 0;
            var price = parseFloat($(this).find('.price_input').val()) || 0;
            var total = qty * price;
            $(this).find('.total').text(total.toFixed(2));
            subtotal += total;
        });
        $('#subtotal').val(subtotal.toFixed(2));

        var vat_percentage = parseFloat($('#vat_percentage').val()) || 0;
        var vat_amount = subtotal * vat_percentage / 100;
        $('#vat_amount').val(vat_amount.toFixed(2));

        $('#grand_total').val((subtotal + vat_amount).toFixed(2));
    }

    // Recalculate VAT & grand total if VAT percentage changes
    $('#vat_percentage').on('keyup change', function(){
        calculateTotals();
    });

    // Initial calculation
    calculateTotals();


</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const startDate = document.getElementById("start_date");
    const endDate = document.getElementById("end_date");
    const duration = document.getElementById("duration");

    function calculateDuration() {
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);

            // Difference in milliseconds
            const diff = end - start;

            if (diff >= 0) {
                // +1 to include both start and end dates
                const days = Math.floor(diff / (1000 * 60 * 60 * 24)) + 1;
                duration.value = days;
            } else {
                duration.value = "";
                alert("End Date cannot be earlier than Start Date.");
            }
        }
    }

    // Calculate on page load (for existing values)
    calculateDuration();

    // Recalculate when dates change
    startDate.addEventListener("change", calculateDuration);
    endDate.addEventListener("change", calculateDuration);
});
</script>

<script>

var taskIndex = 0;
var editingRow = null;
/*------------------------------------------
Create New Task Row
-------------------------------------------*/

function newTaskRow(data = {})
{
    taskIndex++;

    var employeeSelectId = 'task_employee_' + taskIndex;

    var row = '';

    row += '<tr data-task-index="'+taskIndex+'">';

    /* Category */

    row += '<td>';

    row += '<input type="hidden" name="task_id[]" value="'+(data.task_id || '')+'">';

    row += '<select name="task_category[]" class="form-control task-category select2">';

    row += '<option value="">Select</option>';

<?php foreach($task_categories as $cat){ ?>

    row += '<option value="<?= $cat["project_task_id"] ?>">'+
            '<?= addslashes($cat["project_task_name"]) ?>'+
            '</option>';

<?php } ?>

    row += '</select>';

    row += '</td>';

    /* Task */

    row += '<td>';

    row += '<input type="text" class="form-control" name="task_name[]" value="'+(data.task_name || '')+'">';

    row += '</td>';

    /* Milestone */

    row += '<td>';

    row += '<select name="milestone[]" class="form-control select2">';

    row += '<option value="">Select</option>';

<?php foreach($milestones as $m){ ?>

    row += '<option value="<?= $m["milestone_id"] ?>">'+
            '<?= addslashes($m["milestone_name"]) ?>'+
            '</option>';

<?php } ?>

    row += '</select>';

    row += '</td>';

    /* Designation */

    row += '<td>';

    row += '<select name="designation_id[]" class="form-control task-designation-select select2" data-employee-select="#'+employeeSelectId+'">';

    row += '<option value="">Select</option>';

<?php foreach($designations as $d){ ?>

    row += '<option value="<?= $d["id"] ?>">'+
            '<?= addslashes($d["designation_name"]) ?>'+
            '</option>';

<?php } ?>

    row += '</select>';

    row += '</td>';

    /* Employee */

    row += '<td>';

    row += '<select id="'+employeeSelectId+'" name="employee_id[]" class="form-control task-employee-select select2">';

    row += '<option value="">Select Employee</option>';

    row += '</select>';

    row += '</td>';

    /* Priority */

    row += '<td>';

    row += '<select name="priority[]" class="form-control">';

    row += '<option value="Low">Low</option>';

    row += '<option value="Medium">Medium</option>';

    row += '<option value="High">High</option>';

    row += '<option value="Critical">Critical</option>';

    row += '</select>';

    row += '</td>';

    /* Dates */

    row += '<td>';

    row += '<input type="date" class="form-control" name="start_date[]" value="'+(data.start_date || '')+'">';

    row += '</td>';

    row += '<td>';

    row += '<input type="date" class="form-control" name="end_date[]" value="'+(data.end_date || '')+'">';

    row += '</td>';

    /* Status */

    row += '<td>';

    row += '<select name="status[]" class="form-control">';

    row += '<option value="not_started">Not Started</option>';

    row += '<option value="in_progress">In Progress</option>';

    row += '<option value="completed">Completed</option>';

    row += '<option value="hold">Hold</option>';

    row += '</select>';

    row += '</td>';

    /* Description */

    row += '<td>';

    row += '<textarea class="form-control" name="task_description[]">'+
            (data.task_description || '')+
            '</textarea>';

    row += '</td>';

    /* Remove */

    row += '<td>';

    row += '<button type="button" class="btn btn-danger btn-sm removeRow">';

    row += '<i class="fa fa-trash"></i>';

    row += '</button>';

    row += '</td>';

    row += '</tr>';

    $('#popupTaskTable tbody').append(row);

    var currentRow = $('#popupTaskTable tbody tr:last');

    /* Select selected values */

    currentRow.find('[name="task_category[]"]').val(data.task_category_id);

    currentRow.find('[name="milestone[]"]').val(data.milestone_id);

    currentRow.find('[name="designation_id[]"]').val(data.designation_id);

    currentRow.find('[name="priority[]"]').val(data.priority);

    currentRow.find('[name="status[]"]').val(data.status);

    /* Select2 */

    currentRow.find('.select2').select2({

        width:'100%',

        dropdownParent:$('#taskModal')

    });

    currentRow.find('.task-designation-select').on('change', function () {
        loadEmployees(
            $(this).closest('tr').find('.task-employee-select'),
            $(this).val()
        );
    });

    /* Load employee if designation exists */

    if(data.designation_id)
    {
        loadEmployees(currentRow.find('.task-employee-select'), data.designation_id, data.employee_id);
    }

}

/*------------------------------------------
Add Row
-------------------------------------------*/

$('#addTaskRow').on('click',function(){

    newTaskRow();

});

/*------------------------------------------
Remove Row
-------------------------------------------*/

$(document).on('click','.removeRow',function(){

    $(this).closest('tr').remove();

});

/*------------------------------------------
Load Employees
-------------------------------------------*/

function loadEmployees(employeeSelect,designation_id,selected='')
{

    employeeSelect.empty().append('<option value="">Select Employee</option>').val('').trigger('change.select2');

    if (!designation_id) {
        return;
    }

    $.ajax({

        url:"<?= base_url('index.php/Project/get_employee_by_designation'); ?>",

        type:"POST",

        data:{designation_id:designation_id},

        dataType:"json",

        success:function(res){

            var html='<option value="">Select Employee</option>';

            $.each(res,function(i,r){

                html+='<option value="'+r.employee_id+'">'+
                        r.employee_name+
                        '</option>';

            });

            employeeSelect.html(html);

            employeeSelect.val(selected);
            employeeSelect.trigger('change.select2');

        }

    });

}

//task 
/*=========================================================
LOAD EXISTING TASKS INTO POPUP
=========================================================*/

$('button[data-target="#taskModal"]').on('click', function () {

    $('#popupTaskTable tbody').empty();

    var hasTask = false;

    $('#hiddenTaskInputs').find('input[name="task_id[]"]').each(function (i) {

        hasTask = true;

        var data = {

            task_id: $(this).val(),

            task_category_id: $('#hiddenTaskInputs input[name="task_category[]"]').eq(i).val(),

            task_name: $('#hiddenTaskInputs input[name="task_name[]"]').eq(i).val(),

            milestone_id: $('#hiddenTaskInputs input[name="milestone[]"]').eq(i).val(),

            designation_id: $('#hiddenTaskInputs input[name="designation_id[]"]').eq(i).val(),

            employee_id: $('#hiddenTaskInputs input[name="employee_id[]"]').eq(i).val(),

            priority: $('#hiddenTaskInputs input[name="priority[]"]').eq(i).val(),

            start_date: $('#hiddenTaskInputs input[name="start_date[]"]').eq(i).val(),

            end_date: $('#hiddenTaskInputs input[name="end_date[]"]').eq(i).val(),

            status: $('#hiddenTaskInputs input[name="status[]"]').eq(i).val(),

            task_description: $('#hiddenTaskInputs input[name="task_description[]"]').eq(i).val()

        };

        newTaskRow(data);

    });

    /* If project has no task yet */

    if (!hasTask) {

        newTaskRow();

    }

});

/*==========================================
EDIT TASK
==========================================*/

$(document).on('click', '.editTask', function () {

    editingRow = $(this).closest('tr');

    var data = {
        task_id: editingRow.find('.task_id').val(),
        task_category_id: editingRow.find('.category_id').val(),
        task_name: editingRow.children('td:eq(2)').text().trim(),
        milestone_id: editingRow.find('.milestone_id').val(),
        designation_id: editingRow.find('.designation_id').val(),
        employee_id: editingRow.find('.employee_id').val(),
        priority: editingRow.children('td:eq(5)').text().trim(),
        start_date: formatDate(editingRow.children('td:eq(6)').text().trim()),
        end_date: formatDate(editingRow.children('td:eq(7)').text().trim()),
        status: editingRow.children('td:eq(8)').text().trim().toLowerCase().replace(/ /g,'_'),
        task_description: editingRow.find('.task_description').val()
    };

    $('#popupTaskTable tbody').html('');

    newTaskRow(data);

    $('#taskModal').modal('show');

});    /*==========================================
    DELETE TASK
    ==========================================*/

    $(document).on('click','.removeTask',function(){

        if(!confirm('Delete this task?'))
            return;

        $(this).closest('tr').remove();

        rebuildHiddenInputs();

        refreshSerialNo();

    });

    function refreshSerialNo()
    {
        $('#taskTable tbody tr').each(function(i){

            $(this).find('td:first').text(i+1);

        });
    }
    function formatDate(date)
    {
        if(date=='')
            return '';

        var arr=date.split('-');

        if(arr.length!=3)
            return '';

        return arr[2]+'-'+arr[1]+'-'+arr[0];
    }
    function rebuildHiddenInputs()
    {
        $('#hiddenTaskInputs').empty();

        $('#taskTable tbody tr').each(function(){

            $('#hiddenTaskInputs').append($(this).find('.hiddenTaskData').html());

        });
    }

    /*=========================================================
    SAVE TASKS
    =========================================================*/
$('#saveTask').on('click', function () {
    if (editingRow != null) {
    }else{
        $('#taskTable tbody').html('');
    }
    
    $('#popupTaskTable tbody tr').each(function () {

        var task_id = $(this).find('[name="task_id[]"]').val();

        var category_id = $(this).find('[name="task_category[]"]').val();
        var category = $(this).find('[name="task_category[]"] option:selected').text();

        var task = $(this).find('[name="task_name[]"]').val();

        var milestone_id = $(this).find('[name="milestone[]"]').val();
        var milestone = $(this).find('[name="milestone[]"] option:selected').text();

        var designation_id = $(this).find('[name="designation_id[]"]').val();

        var employee_id = $(this).find('[name="employee_id[]"]').val();
        var employee = $(this).find('[name="employee_id[]"] option:selected').text();

        var priority = $(this).find('[name="priority[]"]').val();

        var start = $(this).find('[name="start_date[]"]').val();

        var end = $(this).find('[name="end_date[]"]').val();

        var status = $(this).find('[name="status[]"]').val();

        var description = $(this).find('[name="task_description[]"]').val();

        if (task == '')
            return true;

        var html = '';

        html += '<td></td>';

        html += '<td>' + category + '</td>';

        html += '<td>' + task + '</td>';

        html += '<td>' + milestone + '</td>';

        html += '<td>' + employee + '</td>';

        html += '<td>' + priority + '</td>';

        html += '<td>' + start + '</td>';

        html += '<td>' + end + '</td>';

        html += '<td>' + status + '</td>';

        html += '<td>';

        html += '<button type="button" class="btn btn-warning btn-xs editTask"><i class="fa fa-pencil"></i></button> ';

        html += '<button type="button" class="btn btn-danger btn-xs removeTask"><i class="fa fa-trash"></i></button>';

        html += '<input type="hidden" class="task_id" value="' + task_id + '">';

        html += '<input type="hidden" class="category_id" value="' + category_id + '">';

        html += '<input type="hidden" class="milestone_id" value="' + milestone_id + '">';

        html += '<input type="hidden" class="designation_id" value="' + designation_id + '">';

        html += '<input type="hidden" class="employee_id" value="' + employee_id + '">';

        html += '<input type="hidden" class="task_description" value="' + $('<div>').text(description).html() + '">';

        html += '</td>';

        if (editingRow != null) {

            editingRow.html(html);

            editingRow = null;

        } else {
           
            $('#taskTable tbody').append('<tr>' + html + '</tr>');

        }

    });

    $('#popupTaskTable tbody').empty();

    rebuildTaskSlNo();

    rebuildHiddenInputs();

    $('#taskModal').modal('hide');

});
function rebuildTaskSlNo() {

    $('#taskTable tbody tr').each(function (i) {

        $(this).find('td:first').text(i + 1);

    });

}
function rebuildHiddenInputs() {

    $('#hiddenTaskInputs').empty();

    $('#taskTable tbody tr').each(function () {

        $('#hiddenTaskInputs').append(

            '<input type="hidden" name="task_id[]" value="' + $(this).find('.task_id').val() + '">' +

            '<input type="hidden" name="task_category[]" value="' + $(this).find('.category_id').val() + '">' +

            '<input type="hidden" name="task_name[]" value="' + $('<div>').text($(this).children('td:eq(2)').text().trim()).html() + '">' +

            '<input type="hidden" name="milestone[]" value="' + $(this).find('.milestone_id').val() + '">' +

            '<input type="hidden" name="designation_id[]" value="' + $(this).find('.designation_id').val() + '">' +

            '<input type="hidden" name="employee_id[]" value="' + $(this).find('.employee_id').val() + '">' +

            '<input type="hidden" name="priority[]" value="' + $(this).children('td:eq(5)').text().trim() + '">' +

            '<input type="hidden" name="start_date[]" value="' + $(this).children('td:eq(6)').text().trim() + '">' +

            '<input type="hidden" name="end_date[]" value="' + $(this).children('td:eq(7)').text().trim() + '">' +

            '<input type="hidden" name="status[]" value="' + $(this).children('td:eq(8)').text().trim() + '">' +

            '<input type="hidden" name="task_description[]" value="' + $('<div>').text($(this).find('.task_description').val()).html() + '">'

        );

    });

}
//task
</script>

