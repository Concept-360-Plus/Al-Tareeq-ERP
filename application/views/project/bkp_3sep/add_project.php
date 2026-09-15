<style>
    label,
    h4 {
        color: black;
        font-weight: normal;
    }

    .modal-title {
        color: #fff;
    }

    table th,
    table td {
        vertical-align: middle !important;
    }

    .so {
        margin-right: -10px;
    }

    .product-add-btn {
        margin-top: 25px;
    }

    #itemMasterTable input[type="number"] {
        min-width: 80px;
    }
</style>

<link href="<?= base_url('public/assets/task.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/select2.min.css'); ?>">

<script src="<?= base_url('assets/select2.min.js'); ?>"></script>


<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12">

        <div class="x_panel">

            <div class="clearfix"></div>

            <!-- ===================================================== -->
            <!-- FLASH MESSAGES -->
            <!-- ===================================================== -->

            <?php if ($this->session->flashdata('success')): ?>

                <div class="alert alert-success alert-dismissible fade show">

                    <?= $this->session->flashdata('success'); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            <?php endif; ?>


            <?php if ($this->session->flashdata('error')): ?>

                <div class="alert alert-danger alert-dismissible fade show">

                    <?= $this->session->flashdata('error'); ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            <?php endif; ?>


            <div class="x_content">

                <!-- ===================================================== -->
                <!-- PROJECT FORM -->
                <!-- ===================================================== -->

                <form action="<?= base_url('index.php/Project/save_project'); ?>"
                      method="post"
                      id="projectForm">

                    <input type="hidden"
                           name="project_id"
                           value="<?= $project['project_id'] ?? ''; ?>">


                    <!-- ================================================= -->
                    <!-- SALES ORDER -->
                    <!-- ================================================= -->

                    <div class="form-group"
                         style="width:35%;">

                        <label>
                            Sales Order
                        </label>

                        <select name="so_id"
                                id="so_select123"
                                class="form-control select2"
                                style="width:100%;">

                            <option value="">
                                -- Select --
                            </option>

                            <?php foreach ($sales_orders as $so): ?>

                                <option value="<?= $so['so_id']; ?>~<?= $so['qtn_id']; ?>"
                                    <?= (
                                        !empty($selected_so_id)
                                        &&
                                        $selected_so_id == $so['so_id']
                                    )
                                    ? 'selected'
                                    : ''; ?>>

                                    <?= htmlspecialchars($so['so_code']); ?>

                                    (SO ID: <?= $so['so_id']; ?>)

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <input type="hidden"
                           name="bit_quo"
                           id="bit_quo"
                           value="0">


                    <!-- ================================================= -->
                    <!-- PROJECT DETAILS -->
                    <!-- ================================================= -->

                    <table class="table table-bordered"
                           style="width:66%; font-size:13px; margin-bottom:20px;">

                        <tr>

                            <th>
                                Project Name
                            </th>

                            <td>

                                <input type="text"
                                       name="project_name"
                                       id="project_name"
                                       class="form-control"
                                       value="<?= htmlspecialchars($project['project_name'] ?? ''); ?>"
                                       required>

                            </td>


                            <th>
                                Project Location
                            </th>

                            <td>

                                <input type="text"
                                       name="project_location"
                                       id="project_location"
                                       class="form-control"
                                       value="<?= htmlspecialchars($project['project_location'] ?? ''); ?>">

                            </td>

                        </tr>


                        <tr>

                            <th>
                                Customer
                            </th>

                            <td>

                                <input type="text"
                                       name="customer_name"
                                       id="customer_name"
                                       class="form-control"
                                       value="<?= htmlspecialchars($project['customer_name'] ?? ''); ?>"
                                       readonly>

                                <input type="hidden"
                                       name="customer_id"
                                       id="customer_id"
                                       value="<?= $project['customer_id'] ?? ''; ?>">

                            </td>


                            <th>
                                Branch
                            </th>

                            <td>

                                <input type="text"
                                       name="branch_name"
                                       id="branch_name"
                                       class="form-control"
                                       value="<?= htmlspecialchars($project['branch_name'] ?? ''); ?>"
                                       readonly>

                            </td>

                        </tr>


                        <tr>

                            <th>
                                Start Date
                            </th>

                            <td>

                                <input type="date"
                                       name="start_date1"
                                       id="start_date"
                                       class="form-control"
                                       value="<?= $project['start_date'] ?? ''; ?>">

                            </td>


                            <th>
                                End Date
                            </th>

                            <td>

                                <input type="date"
                                       name="end_date1"
                                       id="end_date"
                                       class="form-control"
                                       value="<?= $project['end_date'] ?? ''; ?>">

                            </td>

                        </tr>


                        <tr>

                            <th>
                                Project Duration (Days)
                            </th>

                            <td colspan="2">

                                <input type="text"
                                       name="duration"
                                       id="duration"
                                       class="form-control"
                                       value="<?= $project['duration'] ?? ''; ?>"
                                       readonly>

                            </td>

                        </tr>

                    </table>


                    <!-- ================================================= -->
                    <!-- SUBJECT / PO -->
                    <!-- ================================================= -->

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Subject
                                </label>

                                <input type="text"
                                       name="subject"
                                       value="<?= htmlspecialchars($project['subject'] ?? ''); ?>"
                                       class="form-control">

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Client PO Number
                                </label>

                                <input type="text"
                                       name="po_number"
                                       id="po_number"
                                       value="<?= htmlspecialchars($project['po_number'] ?? ''); ?>"
                                       class="form-control">

                            </div>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- LOA -->
                    <!-- ================================================= -->

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    LOA Received
                                </label>

                                <?php
                                $loa_received =
                                    $project['loa_received'] ?? '';
                                ?>

                                <select name="loa_received"
                                        id="loa_received"
                                        class="form-control">

                                    <option value="">
                                        -- Select --
                                    </option>

                                    <option value="Yes"
                                        <?= $loa_received == 'Yes'
                                            ? 'selected'
                                            : ''; ?>>
                                        Yes
                                    </option>

                                    <option value="No"
                                        <?= $loa_received == 'No'
                                            ? 'selected'
                                            : ''; ?>>
                                        No
                                    </option>

                                </select>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    LOA Received Date
                                </label>

                                <input type="date"
                                       name="loa_date"
                                       id="loa_date"
                                       value="<?= $project['loa_date'] ?? ''; ?>"
                                       class="form-control">

                            </div>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- PROJECT ITEMS TITLE -->
                    <!-- ================================================= -->

                    <div class="d-flex justify-content-between align-items-center mb-2"
                         style="width:66%;">

                        <h5 class="mb-0">
                            Project Items
                        </h5>


                        <button type="button"
                                class="btn btn-primary btn-sm"
                                id="addItemBtn">

                            <i class="fa fa-plus"></i>
                            Add Item

                        </button>

                    </div>


                    <!-- ================================================= -->
                    <!-- PROJECT ITEMS TABLE -->
                    <!-- ================================================= -->

                    <div class="table-responsive">

                        <table class="table table-bordered"
                               id="project_items_table"
                               style="width:66%;">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        #
                                    </th>

                                    <th>
                                        Product
                                    </th>

                                    <th class="text-end">
                                        Qty
                                    </th>

                                    <th class="text-end">
                                        Unit
                                    </th>

                                   <!-- <th class="text-end">
                                        Total
                                    </th>-->

                                </tr>

                            </thead>


                            <tbody>

                                <?php if (!empty($project_items)): ?>

                                    <?php foreach ($project_items as $i => $item): ?>

                                        <tr>

                                            <td>
                                                <?= $i + 1; ?>
                                            </td>


                                            <td>

                                                <input type="hidden"
                                                       name="product_id[]"
                                                       value="<?= $item['product_id']; ?>">

                                                <?= htmlspecialchars(
                                                    $item['product_name']
                                                ); ?>

                                            </td>


                                            <td class="text-end">

                                                <input type="text"
                                                       name="quantity[]"
                                                       value="<?= $item['quantity']; ?>"
                                                       class="form-control qty_input text-end"
                                                       readonly>

                                            </td>


                                            <td class="text-end">

                                                <input type="text"
                                                       name="unit[]"
                                                       value="<?= htmlspecialchars($item['unit_abbr']); ?>"
                                                       class="form-control text-end"
                                                       readonly>

                                            </td>


                                            <td class="text-end">

                                                <?= number_format(
                                                    $item['total'] ?? 0,
                                                    2
                                                ); ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr class="no-project-item">

                                        <td colspan="5"
                                            class="text-center">

                                            Select a Sales Order or click
                                            Add Item to select products

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>


                    <!-- ================================================= -->
                    <!-- TASKS -->
                    <!-- ================================================= -->

                    <div class="card mt-3">

                        <div class="card-header d-flex justify-content-between">

                            <h5 class="mb-0">
                                Project Tasks
                            </h5>


                            <button type="button"
                                    class="btn btn-primary btn-sm"
                                    data-toggle="modal"
                                    data-target="#taskModal">

                                <i class="fa fa-plus"></i>
                                Assign Task

                            </button>

                        </div>


                        <div class="card-body">

                            <table class="table table-bordered table-striped"
                                   id="taskTable">

                                <thead>

                                    <tr>

                                        <th width="5%">
                                            #
                                        </th>

                                        <th>
                                            Task
                                        </th>

                                        <th>
                                            Employee
                                        </th>

                                        <th>
                                            Priority
                                        </th>

                                        <th>
                                            Start
                                        </th>

                                        <th>
                                            End
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th width="10%">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>
                                </tbody>

                            </table>

                        </div>

                    </div>


                    <div id="hiddenTaskInputs"></div>


                    <!-- ================================================= -->
                    <!-- APPROVER -->
                    <!-- ================================================= -->

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group mt-3">

                                <label>
                                    Assign Approver
                                </label>


                                <?php
                                $approver_id =
                                    $project['approver_id'] ?? '';
                                ?>


                                <select name="approver_id"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        -- Select Approver --
                                    </option>

                                    <?php foreach ($users as $user): ?>

                                        <option value="<?= $user['user_id']; ?>"
                                            <?= $approver_id == $user['user_id']
                                                ? 'selected'
                                                : ''; ?>>

                                            <?= htmlspecialchars(
                                                $user['user_name']
                                            ); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="form-group mt-3">

                                <label>
                                    Remarks
                                </label>

                                <textarea name="remarks"
                                          class="form-control"
                                          rows="3"><?= htmlspecialchars(
                                              $project['remarks'] ?? ''
                                          ); ?></textarea>

                            </div>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- FORM BUTTONS -->
                    <!-- ================================================= -->

                    <div class="col-md-12">

                        <div class="text-end mt-3">

                            <button type="submit"
                                    class="btn btn-success">

                                <?= !empty($project)
                                    ? 'Update Project'
                                    : 'Save Project'; ?>

                            </button>


                            <a href="<?= base_url('index.php/Project/add_project'); ?>"
                               class="btn btn-secondary">

                                Cancel

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<!-- ============================================================= -->
<!-- TASK MODAL -->
<!-- ============================================================= -->

<div class="modal fade"
     id="taskModal">

    <div class="modal-dialog modal-lg task-modal-dialog">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h4 class="modal-title">
                    Assign Task
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>


            <div class="modal-body task-modal-body">

                <button type="button"
                        class="btn btn-success btn-sm mb-3"
                        id="addTaskRow">

                    <i class="fa fa-plus"></i>
                    Add Task

                </button>


                <div class="task-table-responsive">

                    <table class="table table-bordered"
                           id="popupTaskTable">

                        <thead>

                            <tr>

                                <th>
                                    Task
                                </th>

                                <th>
                                    Designation
                                </th>

                                <th>
                                    Employee
                                </th>

                                <th>
                                    Priority
                                </th>

                                <th>
                                    Start
                                </th>

                                <th>
                                    End
                                </th>

                                <th>
                                    Status
                                </th>

                                <th></th>

                            </tr>

                        </thead>


                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>


            <div class="modal-footer">

                <button class="btn btn-success"
                        id="saveTask">

                    Save Tasks

                </button>


                <button class="btn btn-secondary"
                        data-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>


<!-- ============================================================= -->
<!-- ADD ITEM MODAL -->
<!-- ============================================================= -->

<div class="modal fade"
     id="addItemModal"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-lg"
         role="document">

        <div class="modal-content">


            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    Add Project Items
                </h5>


                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>


            <div class="modal-body">


                <!-- SEARCH + ADD PRODUCT -->

                <div class="row mb-3">

                    <div class="col-md-8">

                        <input type="text"
                               id="itemSearch"
                               class="form-control"
                               placeholder="Search product by name or code...">

                    </div>


                    <div class="col-md-4 text-right">

                        <button type="button"
                                class="btn btn-primary btn-sm"
                                id="addProductBtn">

                            <i class="fa fa-plus"></i>
                            Add Product

                        </button>

                    </div>

                </div>


                <!-- ITEM MASTER TABLE -->

                <div class="table-responsive">

                    <table class="table table-bordered table-striped"
                           id="itemMasterTable">

                        <thead>

                            <tr>

                                <th width="5%">
                                    #
                                </th>

                                <th>
                                    Item
                                </th>

                                <th>
                                    Code
                                </th>

                                <th>
                                    Unit
                                </th>

                                <th width="15%">
                                    Qty
                                </th>

                                <th width="10%">
                                    Select
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <tr>

                                <td colspan="6"
                                    class="text-center">

                                    Click Add Item to load products

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-success"
                        id="addSelectedItems">

                    <i class="fa fa-plus"></i>
                    Add Selected Items

                </button>


                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>


<!-- ============================================================= -->
<!-- ADD PRODUCT MODAL -->
<!-- ============================================================= -->

<div class="modal fade"
     id="addProductModal"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog"
         role="document">

        <div class="modal-content">


            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    Add Product
                </h5>


                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>


            <form id="addProductForm">

                <div class="modal-body">


                    <!-- PRODUCT CODE -->

                    <div class="form-group">

                        <label>
                            Product Code
                        </label>

                        <input type="text"
                               name="product_code"
                               id="new_product_code"
                               class="form-control"
                               required>

                    </div>


                    <!-- PRODUCT NAME -->

                    <div class="form-group">

                        <label>
                            Product Name
                        </label>

                        <input type="text"
                               name="product_name"
                               id="new_product_name"
                               class="form-control"
                               required>

                    </div>


                    <!-- UNIT -->

                    <div class="form-group">

                        <label>
                            Unit
                        </label>

                        <select name="unit_id"
                                id="new_unit_id"
                                class="form-control"
                                required>

                            <option value="">
                                -- Select Unit --
                            </option>

                            <?php if (!empty($units)): ?>

                                <?php foreach ($units as $unit): ?>

                                    <option value="<?= $unit['unit_id']; ?>">

                                        <?= htmlspecialchars(
                                            $unit['unit_name']
                                        ); ?>

                                    </option>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </select>

                    </div>


                    <!-- PRICE -->

                    <div class="form-group">

                        <label>
                            Price
                        </label>

                        <input type="number"
                               name="retail_price"
                               id="new_retail_price"
                               class="form-control"
                               min="0"
                               step="0.01"
                               value="0.00"
                               required>

                    </div>


                </div>


                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-success"
                            id="saveProductBtn">

                        <i class="fa fa-save"></i>
                        Save Product

                    </button>


                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Close

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- ============================================================= -->
<!-- JAVASCRIPT -->
<!-- ============================================================= -->

<script>

var taskNo = 0;


/* ============================================================= */
/* TASK ROW */
/* ============================================================= */

function newTaskRow()
{
    taskNo++;

    var row = '';

    row += '<tr>';

    row += '<td>';

    row += '<input type="text" ';
    row += 'class="form-control" ';
    row += 'name="task_name[]">';

    row += '</td>';


    row += '<td>';

    row += '<select name="designation_id[]" ';
    row += 'class="designation form-control designation_select">';

    row += '<option value="">Select</option>';

    <?php foreach ($designations as $d): ?>

    row += '<option value="<?= $d['id']; ?>">';
    row += '<?= htmlspecialchars($d['designation_name']); ?>';
    row += '</option>';

    <?php endforeach; ?>

    row += '</select>';

    row += '</td>';


    row += '<td>';

    row += '<select name="employee_id[]" ';
    row += 'class="employee_select form-control">';

    row += '<option value="">Select</option>';

    row += '</select>';

    row += '</td>';


    row += '<td>';

    row += '<select name="priority[]" class="form-control">';

    row += '<option value="Low">Low</option>';
    row += '<option value="Medium">Medium</option>';
    row += '<option value="High">High</option>';
    row += '<option value="Critical">Critical</option>';

    row += '</select>';

    row += '</td>';


    row += '<td>';

    row += '<input type="date" ';
    row += 'name="start_date[]" ';
    row += 'class="form-control">';

    row += '</td>';


    row += '<td>';

    row += '<input type="date" ';
    row += 'name="end_date[]" ';
    row += 'class="form-control">';

    row += '</td>';


    row += '<td>';

    row += '<select name="status[]" class="form-control">';

    row += '<option value="not_started">Not Started</option>';
    row += '<option value="in_progress">In Progress</option>';
    row += '<option value="completed">Completed</option>';
    row += '<option value="hold">Hold</option>';

    row += '</select>';

    row += '</td>';


    row += '<td>';

    row += '<button class="btn btn-danger removeRow" type="button">';

    row += '<i class="fa fa-trash"></i>';

    row += '</button>';

    row += '</td>';

    row += '</tr>';


    $('#popupTaskTable tbody').append(row);
}


$('#addTaskRow').click(function()
{
    newTaskRow();
});


newTaskRow();


$(document).on('click', '.removeRow', function()
{
    $(this).closest('tr').remove();
});


/* ============================================================= */
/* SAVE TASKS */
/* ============================================================= */

/* ============================================================= */
/* SAVE TASKS */
/* ============================================================= */

$('#saveTask').click(function()
{
    $('#taskTable tbody').empty();
    $('#hiddenTaskInputs').empty();

    var i = 1;

    $('#popupTaskTable tbody tr').each(function()
    {
        var row = $(this);

        var task = $.trim(
            row.find('[name="task_name[]"]').val()
        );

        var designation_id =
            row.find('[name="designation_id[]"]').val();

        var employee_id =
            row.find('[name="employee_id[]"]').val();

        var employee =
            row.find('[name="employee_id[]"] option:selected').text();

        var priority =
            row.find('[name="priority[]"]').val();

        var start =
            row.find('[name="start_date[]"]').val();

        var end =
            row.find('[name="end_date[]"]').val();

        var status =
            row.find('[name="status[]"]').val();


        /* ----------------------------------------------------- */
        /* IGNORE EMPTY TASK ROWS */
        /* ----------------------------------------------------- */

        if (!task) {
            return;
        }


        /* ----------------------------------------------------- */
        /* DISPLAY TASK IN MAIN TABLE */
        /* ----------------------------------------------------- */

        var displayRow = $('<tr>');

        displayRow.append(
            $('<td>').text(i)
        );

        displayRow.append(
            $('<td>').text(task)
        );

        displayRow.append(
            $('<td>').text(
                employee_id ? employee : ''
            )
        );

        displayRow.append(
            $('<td>').text(priority)
        );

        displayRow.append(
            $('<td>').text(start)
        );

        displayRow.append(
            $('<td>').text(end)
        );

        displayRow.append(
            $('<td>').text(status)
        );

        var actionTd = $('<td>');

        actionTd.append(
            $('<button>', {
                type: 'button',
                class: 'btn btn-danger btn-sm removeSavedTask',
                text: 'Delete'
            })
        );

        displayRow.append(actionTd);

        $('#taskTable tbody').append(displayRow);


        /* ----------------------------------------------------- */
        /* CREATE HIDDEN INPUTS PROPERLY */
        /* ----------------------------------------------------- */

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'task_name[]',
                value: task
            })
        );

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'designation_id[]',
                value: designation_id
            })
        );

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'employee_id[]',
                value: employee_id
            })
        );

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'priority[]',
                value: priority
            })
        );

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'start_date[]',
                value: start
            })
        );

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'end_date[]',
                value: end
            })
        );

        $('#hiddenTaskInputs').append(
            $('<input>', {
                type: 'hidden',
                name: 'status[]',
                value: status
            })
        );


        i++;
    });


    /* --------------------------------------------------------- */
    /* CLOSE MODAL */
    /* --------------------------------------------------------- */

    $('#taskModal').modal('hide');
});

/* ============================================================= */
/* DELETE SAVED TASK */
/* ============================================================= */

$(document).on('click', '.removeSavedTask', function()
{

    var index =
        $(this).closest('tr').index();


    $(this).closest('tr').remove();

});


/* ============================================================= */
/* DOCUMENT READY */
/* ============================================================= */

$(document).ready(function()
{


    /* ========================================================= */
    /* SELECT2 */
    /* ========================================================= */

    $('.select2').select2({
        placeholder: '-- Select Sales Order --',
        allowClear: true,
        width: '100%'
    });


    /* ========================================================= */
    /* SALES ORDER */
    /* ========================================================= */

    function fetchSO(so_id)
    {

        if (!so_id) {
            return;
        }


        $.ajax({

            url:
                '<?= base_url("index.php/Project/fetch_so_details"); ?>',

            type: 'POST',

            data: {
                so_id: so_id
            },

            dataType: 'json',


            success: function(data)
            {

                if (!data) {
                    return;
                }


                if (data.so_master)
                {

                    $('#project_name')
                        .val(data.so_master.project_name);

                    $('#branch_name')
                        .val(data.so_master.branch_name);

                    $('#customer_name')
                        .val(data.so_master.customer_name);

                    $('#project_location')
                        .val(data.so_master.project_location);

                }


                var html = '';


                $.each(
                    data.so_products || [],
                    function(i, prod)
                    {

                        html += '<tr>';


                        html +=
                            '<td>' +
                            (i + 1) +
                            '</td>';


                        html +=
                            '<td>' +

                            '<input type="hidden" ' +
                            'name="product_id[]" ' +
                            'value="' +
                            prod.product_id +
                            '">' +

                            $('<span>')
                                .text(prod.product_name)
                                .prop('outerHTML') +

                            '</td>';


                        html +=
                            '<td class="text-end">' +

                            '<input type="number" ' +
                            'name="quantity[]" ' +
                            'value="' +
                            prod.quantity +
                            '" ' +
                            'class="form-control qty_input text-end" ' +
                            'readonly>' +

                            '</td>';


                        html +=
                            '<td class="text-end">' +

                            '<input type="text" ' +
                            'name="unit[]" ' +
                            'value="' +
                            prod.unit_abbr +
                            '" ' +
                            'class="form-control text-end" ' +
                            'readonly>' +

                            '</td>';

                        /*
                        html +=
                            '<td class="text-end">' +

                            (
                                parseFloat(prod.quantity || 0) *
                                parseFloat(prod.unit_price || 0)
                            ).toFixed(2) +

                            '</td>';
                        */

                        html += '</tr>';

                    }
                );


                if (html !== '')
                {
                    $('#project_items_table tbody')
                        .html(html);
                }


               // calculateTotals();

            }

        });

    }


    $('#so_select123').change(function()
    {

        var value = $(this).val();


        if (!value) {
            return;
        }


        var pieces =
            value.split('~');


        var so_id =
            pieces[0];


        var quotation_id =
            pieces[1] || '';


        fetchSO(so_id);


        if (quotation_id)
        {

            $('#bit_quo').val('1');

            fetchQuotation(quotation_id);

        }
        else
        {

            $('#bit_quo').val('0');

        }

    });


    var preselected_so_id =
        '<?= $selected_so_id ?? ''; ?>';


    if (preselected_so_id)
    {
        fetchSO(preselected_so_id);
    }


    /* ========================================================= */
    /* DURATION */
    /* ========================================================= */

    function calculateDuration()
    {

        var start =
            $('#start_date').val();


        var end =
            $('#end_date').val();


        if (start && end)
        {

            var startDate =
                new Date(start);


            var endDate =
                new Date(end);


            var diffTime =
                endDate - startDate;


            var diffDays =
                Math.ceil(
                    diffTime /
                    (1000 * 60 * 60 * 24)
                ) + 1;


            $('#duration')
                .val(diffDays >= 0 ? diffDays : 0);

        }
        else
        {

            $('#duration').val('');

        }

    }


    $('#start_date, #end_date')
        .on('change', calculateDuration);


    calculateDuration();


    /* ========================================================= */
    /* ITEM MASTER - OPEN MODAL */
    /* ========================================================= */

    $('#addItemBtn').on('click', function()
    {

        $('#itemSearch').val('');


        $('#itemMasterTable tbody').html(

            '<tr>' +

            '<td colspan="6" class="text-center">' +

            '<i class="fa fa-spinner fa-spin"></i> ' +
            'Loading items...' +

            '</td>' +

            '</tr>'

        );


        $('#addItemModal').modal('show');


        loadItemMaster();

    });


    /* ========================================================= */
    /* LOAD ITEM MASTER */
    /* ========================================================= */

    function loadItemMaster(search = '')
    {

        $.ajax({

            url:
                "<?= base_url('index.php/Project/get_item_master'); ?>",

            type: "POST",

            data: {
                search: search
            },

            dataType: "json",


            beforeSend: function()
            {

                $('#itemMasterTable tbody').html(

                    '<tr>' +

                    '<td colspan="6" class="text-center">' +

                    '<i class="fa fa-spinner fa-spin"></i> ' +
                    'Loading...' +

                    '</td>' +

                    '</tr>'

                );

            },


            success: function(response)
            {

                var html = '';


                if (!response || response.length === 0)
                {

                    html =

                        '<tr>' +

                        '<td colspan="6" ' +
                        'class="text-center">' +

                        'No products found. ' +

                        'Click "Add Product" to create one.' +

                        '</td>' +

                        '</tr>';

                }
                else
                {

                    $.each(
                        response,
                        function(i, item)
                        {

                            html += '<tr>';


                            html +=
                                '<td>' +
                                (i + 1) +
                                '</td>';


                            html += '<td>';


                            html +=
                                '<input type="hidden" ' +
                                'class="item_id" ' +
                                'value="' +
                                item.product_id +
                                '">';


                            html +=
                                '<input type="hidden" ' +
                                'class="unit_price" ' +
                                'value="' +
                                (item.retail_price || 0) +
                                '">';


                            html +=

                                $('<span>')
                                    .text(
                                        item.product_name
                                    )
                                    .prop('outerHTML');


                            html += '</td>';


                            html += '<td>';


                            html +=

                                $('<span>')
                                    .text(
                                        item.product_code || ''
                                    )
                                    .prop('outerHTML');


                            html += '</td>';


                            html +=
                                '<td class="item_unit">';


                            html +=

                                $('<span>')
                                    .text(
                                        item.unit_abbr || ''
                                    )
                                    .prop('outerHTML');


                            html += '</td>';


                            html += '<td>';


                            html +=
                                '<input type="number" ' +
                                'class="form-control item_qty" ' +
                                'value="1" ' +
                                'min="0.01" ' +
                                'step="0.01">';


                            html += '</td>';


                            html +=
                                '<td class="text-center">';


                            html +=
                                '<input type="checkbox" ' +
                                'class="item_select" ' +
                                'value="' +
                                item.product_id +
                                '">';


                            html += '</td>';


                            html += '</tr>';

                        }
                    );

                }


                $('#itemMasterTable tbody')
                    .html(html);

            },


            error: function(xhr)
            {

                console.log(
                    'get_item_master error:',
                    xhr.responseText
                );


                $('#itemMasterTable tbody').html(

                    '<tr>' +

                    '<td colspan="6" ' +
                    'class="text-center text-danger">' +

                    'Unable to load products.' +

                    '</td>' +

                    '</tr>'

                );

            }

        });

    }


    /* ========================================================= */
    /* SEARCH ITEM */
    /* ========================================================= */

    var itemSearchTimer;


    $('#itemSearch').on('keyup', function()
    {

        var search =
            $(this).val();


        clearTimeout(itemSearchTimer);


        itemSearchTimer =
            setTimeout(
                function()
                {

                    loadItemMaster(search);

                },
                300
            );

    });


    /* ========================================================= */
    /* ADD PRODUCT POPUP */
    /* ========================================================= */

    $('#addProductBtn').on('click', function()
    {

        $('#addProductForm')[0].reset();


        $('#new_retail_price')
            .val('0.00');


        $('#addProductModal')
            .modal('show');

    });


    /* ========================================================= */
    /* SAVE PRODUCT */
    /* ========================================================= */

    $('#addProductForm').on('submit', function(e)
    {

        e.preventDefault();


        var form =
            $(this);


        var button =
            $('#saveProductBtn');


        $.ajax({

            url:
                "<?= base_url('index.php/Project/add_product'); ?>",

            type: "POST",

            data:
                form.serialize(),

            dataType: "json",


            beforeSend: function()
            {

                button
                    .prop('disabled', true)
                    .html(
                        '<i class="fa fa-spinner fa-spin"></i> ' +
                        'Saving...'
                    );

            },


            success: function(response)
            {

                if (response.status)
                {

                    alert(
                        response.message ||
                        'Product added successfully.'
                    );


                    $('#addProductModal')
                        .modal('hide');


                    form[0].reset();


                    /*
                     * Reload Item Master.
                     *
                     * The newly inserted product will now
                     * appear in the Add Item popup.
                     */

                    loadItemMaster(
                        $('#itemSearch').val()
                    );


                    /*
                     * Keep Add Item popup open.
                     */

                    $('#addItemModal')
                        .modal('show');

                }
                else
                {

                    alert(
                        response.message ||
                        'Unable to add product.'
                    );

                }

            },


            error: function(xhr)
            {

                console.log(
                    'add_product error:',
                    xhr.responseText
                );


                alert(
                    'Unable to save product.'
                );

            },


            complete: function()
            {

                button
                    .prop('disabled', false)
                    .html(
                        '<i class="fa fa-save"></i> ' +
                        'Save Product'
                    );

            }

        });

    });


    /* ========================================================= */
    /* ADD SELECTED ITEMS */
    /* ========================================================= */

    $('#addSelectedItems').on('click', function()
    {

        var selectedCount = 0;

        var duplicateCount = 0;


        $('#itemMasterTable tbody tr')
            .each(function()
            {

                var row =
                    $(this);


                var checkbox =
                    row.find('.item_select');


                if (
                    !checkbox.length ||
                    !checkbox.is(':checked')
                )
                {
                    return;
                }


                selectedCount++;


                var productId =
                    row.find('.item_id').val();


                var productName =
                    row.find('td:eq(1)')
                       .text()
                       .trim();


                var productCode =
                    row.find('td:eq(2)')
                       .text()
                       .trim();


                var unit =
                    row.find('.item_unit')
                       .text()
                       .trim();


                var quantity =
                    parseFloat(
                        row.find('.item_qty').val()
                    );


                var unit_price =
                    row.find('.unit_price').val();


                if (!quantity || quantity <= 0)
                {

                    alert(
                        'Please enter a valid quantity for "' +
                        productName +
                        '".'
                    );


                    row.find('.item_qty')
                       .focus();


                    return false;

                }


                /* ============================================= */
                /* CHECK DUPLICATE */
                /* ============================================= */

                var duplicate = false;


                $('#project_items_table tbody tr')
                    .each(function()
                    {

                        var existingProductId =
                            $(this)
                                .find(
                                    'input[name="product_id[]"]'
                                )
                                .val();


                        if (
                            existingProductId ==
                            productId
                        )
                        {

                            duplicate = true;

                            return false;

                        }

                    });


                if (duplicate)
                {

                    duplicateCount++;

                    return;

                }


                /* ============================================= */
                /* REMOVE EMPTY ROW */
                /* ============================================= */

                $('#project_items_table tbody')
                    .find('.no-project-item')
                    .remove();


                /* ============================================= */
                /* ROW NUMBER */
                /* ============================================= */

                var rowNo =
                    $('#project_items_table tbody tr')
                    .length + 1;


                /* ============================================= */
                /* CREATE ROW */
                /* ============================================= */

                var newRow = '';


                newRow += '<tr>';


                newRow +=
                    '<td>' +
                    rowNo +
                    '</td>';


                newRow += '<td>';


                newRow +=
                    '<input type="hidden" ' +
                    'name="product_id[]" ' +
                    'value="' +
                    productId +
                    '">';


                newRow +=
                    '<input type="hidden" ' +
                    'name="unit_price[]" ' +
                    'value="' +
                    unit_price +
                    '">';


                newRow +=

                    $('<span>')
                        .text(productName)
                        .prop('outerHTML');


                newRow += '</td>';


                newRow +=
                    '<td class="text-end">';


                newRow +=
                    '<input type="number" ' +
                    'name="quantity[]" ' +
                    'value="' +
                    quantity +
                    '" ' +
                    'class="form-control qty_input text-end" ' +
                    'min="0.01" ' +
                    'step="0.01">';


                newRow += '</td>';


                newRow +=
                    '<td class="text-end">';


                newRow +=

                    $('<span>')
                        .text(unit)
                        .prop('outerHTML');


                newRow += '</td>';


                newRow +=
                    '<td class="text-center">';


                newRow +=
                    '<button type="button" ' +
                    'class="btn btn-danger btn-sm removeProjectItem">' +

                    '<i class="fa fa-trash"></i>' +

                    '</button>';


                newRow += '</td>';


                newRow += '</tr>';


                $('#project_items_table tbody')
                    .append(newRow);

            });


        if (selectedCount === 0)
        {

            alert(
                'Please select at least one product.'
            );

            return;

        }


        if (duplicateCount > 0)
        {

            alert(
                duplicateCount +
                ' product(s) already exist in the project.'
            );

        }


        $('#addItemModal')
            .modal('hide');


        renumberProjectItems();


        calculateTotals();

    });


    /* ========================================================= */
    /* REMOVE PROJECT ITEM */
    /* ========================================================= */

    $(document).on(
        'click',
        '.removeProjectItem',
        function()
        {

            $(this)
                .closest('tr')
                .remove();


            renumberProjectItems();


            calculateTotals();

        }
    );


    /* ========================================================= */
    /* RENUMBER PROJECT ITEMS */
    /* ========================================================= */

    function renumberProjectItems()
    {

        $('#project_items_table tbody tr')
            .each(function(index)
            {

                $(this)
                    .find('td:first')
                    .text(index + 1);

            });

    }


    /* ========================================================= */
    /* EMPLOYEE BY DESIGNATION */
    /* ========================================================= */

    $(document).on(
        'change',
        '.designation_select',
        function()
        {

            var designation_id =
                $(this).val();


            var employeeSelect =
                $(this)
                    .closest('tr')
                    .find('.employee_select');


            employeeSelect.html(
                '<option value="">Loading...</option>'
            );


            if (designation_id)
            {

                $.ajax({

                    url:
                        "<?= base_url('index.php/Project/get_employee_by_designation'); ?>",

                    type: "POST",

                    data: {
                        designation_id:
                            designation_id
                    },

                    dataType: "json",


                    success: function(response)
                    {

                        var html =
                            '<option value="">-- Select Employee --</option>';


                        $.each(
                            response,
                            function(i, row)
                            {

                                html +=
                                    '<option value="' +
                                    row.employee_id +
                                    '">' +

                                    $('<span>')
                                        .text(
                                            row.employee_name
                                        )
                                        .text() +

                                    '</option>';

                            }
                        );


                        employeeSelect.html(html);

                    },


                    error: function()
                    {

                        employeeSelect.html(
                            '<option value="">Unable to load</option>'
                        );

                    }

                });

            }
            else
            {

                employeeSelect.html(
                    '<option value="">-- Select Employee --</option>'
                );

            }

        }
    );

});


/* ============================================================= */
/* QUOTATION DETAILS */
/* ============================================================= */

function fetchQuotation(q_id)
{

    if (!q_id) {
        return;
    }
    var so_id = $('#so_select123').val();

    $.ajax({

        url:
            '<?= base_url("index.php/Project/fetch_quotation_details"); ?>',

        type: 'POST',

        data: {
            q_id: q_id,so_id
        },

        dataType: 'json',


        success: function(data)
        {

            var html = '';


            $.each(
                data.q_products || [],
                function(i, prod)
                {

                    html += '<tr>';


                    html +=
                        '<td>' +
                        (i + 1) +
                        '</td>';


                    html +=
                        '<td>' +

                        '<input type="hidden" ' +
                        'name="product_id[]" ' +
                        'value="' +
                        prod.prd_id +
                        '">' +

                        $('<span>')
                            .text(prod.product_name)
                            .prop('outerHTML') +

                        '</td>';


                    html +=
                        '<td class="text-end">' +

                        '<input type="number" ' +
                        'name="quantity[]" ' +
                        'value="' +
                        prod.qty +
                        '" ' +
                        'class="form-control qty_input text-end" ' +
                        'readonly>' +

                        '</td>';


                    html +=
                        '<td class="text-end">' +

                        '<input type="text" ' +
                        'name="unit[]" ' +
                        'value="' +
                        prod.unit_abbr +
                        '" ' +
                        'class="form-control text-end" ' +
                        'readonly>' +

                        '<input type="hidden" ' +
                        'name="unit_price[]" ' +
                        'value="' +
                        prod.unit_price +
                        '">' +

                        '</td>';


                    /*html +=
                        '<td class="text-end">' +

                        (
                            parseFloat(prod.qty || 0) *
                            parseFloat(prod.unit_price || 0)
                        ).toFixed(2) +

                        '</td>';
                        */


                    html += '</tr>';

                }
            );


            $('#project_items_table tbody')
                .html(html);


            calculateTotals();

        }

    });

}


/* ============================================================= */
/* TOTAL CALCULATION */
/* ============================================================= */

function calculateTotals()
{

    var subtotal = 0;


    $('#project_items_table tbody tr')
        .each(function()
        {

            var qty =
                parseFloat(
                    $(this)
                        .find('.qty_input')
                        .val()
                ) || 0;


            var price =
                parseFloat(
                    $(this)
                        .find('.price_input')
                        .val()
                ) || 0;


            var total =
                qty * price;


            $(this)
                .find('.total')
                .text(
                    total.toFixed(2)
                );


            subtotal += total;

        });


    $('#subtotal')
        .val(subtotal.toFixed(2));


    var vat_percentage =
        parseFloat(
            $('#vat_percentage').val()
        ) || 0;


    var vat_amount =
        subtotal *
        vat_percentage /
        100;


    $('#vat_amount')
        .val(vat_amount.toFixed(2));


    $('#grand_total')
        .val(
            (
                subtotal +
                vat_amount
            ).toFixed(2)
        );

}


/* ============================================================= */
/* TECHNICIAN AVAILABILITY - EXISTING FUNCTIONALITY */
/* ============================================================= */

function checkAvailability(row)
{

    var technician_id =
        row.find('.technician_select').val();


    var start_date =
        row.find('.assignment_start').val();


    var end_date =
        row.find('.assignment_end').val();


    var project_id =
        $('input[name="project_id"]').val();


    if (
        !technician_id ||
        !start_date ||
        !end_date
    )
    {
        return;
    }


    $.ajax({

        url:
            '<?= base_url("index.php/Project/check_technician_availability"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            technician_id:
                technician_id,

            start_date:
                start_date,

            end_date:
                end_date,

            project_id:
                project_id

        }

    });

}


/* ============================================================= */
/* TECHNICIAN DUPLICATE CHECK */
/* ============================================================= */

function isTechnicianDuplicate(
    newTechId,
    newStart,
    newEnd,
    excludeRow = null
)
{

    var duplicate = false;


    $('#technician_table tbody tr')
        .each(function()
        {

            if (
                excludeRow &&
                $(this).is(excludeRow)
            )
            {
                return;
            }


            var techId =
                $(this)
                    .find('.technician_select')
                    .val();


            var start =
                $(this)
                    .find('.assignment_start')
                    .val();


            var end =
                $(this)
                    .find('.assignment_end')
                    .val();


            if (
                !techId ||
                !start ||
                !end
            )
            {
                return;
            }


            if (techId == newTechId)
            {

                var s1 =
                    new Date(newStart);


                var e1 =
                    new Date(newEnd);


                var s2 =
                    new Date(start);


                var e2 =
                    new Date(end);


                if (
                    s1 <= e2 &&
                    s2 <= e1
                )
                {

                    duplicate = true;

                    return false;

                }

            }

        });


    return duplicate;

}

</script>