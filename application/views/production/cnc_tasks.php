
<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>
                        CNC Production Tasks
                        <small>Supervisor Task Assignment</small>
                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">


                    <!-- ===================================================== -->
                    <!-- CREATE / EDIT CNC TASK -->
                    <!-- ===================================================== -->

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <strong id="cncFormTitle">
                                Create CNC Task
                            </strong>

                        </div>


                        <div class="panel-body">

                            <form id="cncTaskForm">

                                <input
                                    type="hidden"
                                    id="task_id"
                                    name="task_id"
                                    value=""
                                >


                                <div class="row">


                                    <!-- JOB ORDER -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Job Order
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                id="job_order_id"
                                                name="job_order_id"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select Job Order
                                                </option>

                                            </select>

                                        </div>

                                    </div>



                                    <!-- SALES ORDER -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Sales Order
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                id="sales_order_id"
                                                name="sales_order_id"
                                                class="form-control"
                                                disabled
                                            >

                                                <option value="">
                                                    Select Sales Order
                                                </option>

                                            </select>

                                        </div>

                                    </div>



                                    <!-- SALES ORDER ITEM -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Sales Order Item
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                id="sales_order_product_id"
                                                name="sales_order_product_id"
                                                class="form-control"
                                                disabled
                                            >

                                                <option value="">
                                                    Select Item
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>



                                <div class="row">


                                    <!-- TASK DESCRIPTION -->

                                    <div class="col-md-5">

                                        <div class="form-group">

                                            <label>
                                                CNC Task / Part Description
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="text"
                                                id="task_description"
                                                name="task_description"
                                                class="form-control"
                                                placeholder="Example: Side Panel"
                                                maxlength="255"
                                            >

                                        </div>

                                    </div>



                                    <!-- QUANTITY -->

                                    <div class="col-md-2">

                                        <div class="form-group">

                                            <label>
                                                Quantity
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="number"
                                                id="quantity"
                                                name="quantity"
                                                class="form-control"
                                                min="0.01"
                                                step="0.01"
                                                value=""
                                            >

                                        </div>

                                    </div>



                                    <!-- EMPLOYEE -->

                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>
                                                CNC Employee
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                id="assigned_employee_id"
                                                name="assigned_employee_id"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select Employee
                                                </option>

                                            </select>

                                        </div>

                                    </div>



                                    <!-- PRIORITY -->

                                    <div class="col-md-2">

                                        <div class="form-group">

                                            <label>
                                                Priority
                                            </label>

                                            <select
                                                id="priority"
                                                name="priority"
                                                class="form-control"
                                            >

                                                <option value="Low">
                                                    Low
                                                </option>

                                                <option
                                                    value="Normal"
                                                    selected
                                                >
                                                    Normal
                                                </option>

                                                <option value="High">
                                                    High
                                                </option>

                                                <option value="Critical">
                                                    Critical
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>



                                <div class="row">


                                    <!-- REMARKS -->

                                    <div class="col-md-10">

                                        <div class="form-group">

                                            <label>
                                                Remarks
                                            </label>

                                            <textarea
                                                id="remarks"
                                                name="remarks"
                                                class="form-control"
                                                rows="2"
                                            ></textarea>

                                        </div>

                                    </div>



                                    <!-- BUTTONS -->

                                    <div class="col-md-2">

                                        <div class="form-group">

                                            <label>&nbsp;</label>

                                            <button
                                                type="submit"
                                                id="saveCncTask"
                                                class="btn btn-primary btn-block"
                                            >

                                                <i class="fa fa-plus"></i>
                                                Assign Task

                                            </button>


                                            <button
                                                type="button"
                                                id="cancelCncEdit"
                                                class="btn btn-default btn-block"
                                                style="display:none;"
                                            >

                                                <i class="fa fa-times"></i>
                                                Cancel Edit

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>



                    <!-- ===================================================== -->
                    <!-- CNC TASK LIST -->
                    <!-- ===================================================== -->

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <strong>
                                CNC Tasks
                            </strong>

                        </div>


                        <div class="panel-body">

                            <div class="table-responsive">

                                <table
                                    id="cncTaskTable"
                                    class="table table-striped table-bordered"
                                    style="width:100%;"
                                >

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>Job Order</th>

                                            <th>Sales Order</th>

                                            <th>Item Name</th>

                                            <th>Task / Part</th>

                                            <th>Qty</th>

                                            <th>Employee</th>

                                            <th>Priority</th>

                                            <th>Status</th>

                                            <th>Created</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>


                                    <tbody></tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>



<!-- ========================================================= -->
<!-- ADD WORK NOTE MODAL -->
<!-- ========================================================= -->

<div
    class="modal fade"
    id="cncWorkNoteModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-header">

               

                <h4 class="modal-title">

                    <i class="fa fa-sticky-note-o"></i>
                    Add Work Note

                </h4>
                 <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="note_task_id"
                    value=""
                >


                <div class="form-group">

                    <label>
                        Note Type
                    </label>

                    <select
                        id="note_type"
                        class="form-control"
                    >

                        <option value="General">
                            General
                        </option>

                        <option value="Supervisor">
                            Supervisor
                        </option>

                        <option value="Instruction">
                            Instruction
                        </option>

                        <option value="Follow Up">
                            Follow Up
                        </option>

                        <option value="Rework">
                            Rework
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Work Note
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="work_note"
                        class="form-control"
                        rows="5"
                        maxlength="2000"
                        placeholder="Enter work note..."
                    ></textarea>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >
                    Cancel
                </button>


                <button
                    type="button"
                    class="btn btn-primary"
                    id="saveCncWorkNote"
                >

                    <i class="fa fa-save"></i>
                    Save Note

                </button>

            </div>

        </div>

    </div>

</div>



<!-- ========================================================= -->
<!-- CNC WORK NOTES / TIMELINE MODAL -->
<!-- ========================================================= -->

<div
    class="modal fade"
    id="cncTimelineModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                
                <h4 class="modal-title">

                    <i class="fa fa-history"></i>
                    Work Notes / Timeline

                </h4>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>


            </div>


            <div class="modal-body">

                <div
                    id="cncTimelineTaskInfo"
                    class="alert alert-info"
                    style="margin-bottom:15px;"
                >
                    Loading task...
                </div>


                <div
                    id="cncTimelineLoading"
                    class="text-center"
                    style="display:none;"
                >

                    <i class="fa fa-spinner fa-spin fa-2x"></i>

                    <p>
                        Loading timeline...
                    </p>

                </div>


                <div
                    id="cncTimelineEmpty"
                    class="alert alert-warning"
                    style="display:none;"
                >

                    No timeline entries found.

                </div>


                <div
                    id="cncTimeline"
                    class="cnc-timeline"
                ></div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >
                    Close
                </button>

            </div>

        </div>

    </div>

</div>



<style>

/* ========================================================= */
/* CNC TIMELINE */
/* ========================================================= */

.cnc-timeline {
    position: relative;
    padding: 5px 0 5px 35px;
}

.cnc-timeline:before {
    content: '';
    position: absolute;
    left: 12px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #ddd;
}

.cnc-timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.cnc-timeline-icon {
    position: absolute;
    left: -31px;
    top: 0;
    width: 25px;
    height: 25px;
    line-height: 25px;
    text-align: center;
    border-radius: 50%;
    background: #337ab7;
    color: #fff;
    font-size: 12px;
}

.cnc-timeline-content {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px 12px;
    background: #fff;
}

.cnc-timeline-title {
    font-weight: bold;
    margin-bottom: 4px;
}

.cnc-timeline-meta {
    font-size: 11px;
    color: #777;
    margin-bottom: 7px;
}

.cnc-timeline-note {
    white-space: pre-wrap;
    word-break: break-word;
}

.cnc-status-badge {
    display: inline-block;
    padding: 3px 7px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: bold;
}

.cnc-status-pending {
    background: #f0ad4e;
    color: #fff;
}

.cnc-status-progress {
    background: #337ab7;
    color: #fff;
}

.cnc-status-hold {
    background: #777;
    color: #fff;
}

.cnc-status-completed {
    background: #5cb85c;
    color: #fff;
}

.cnc-status-rework {
    background: #d9534f;
    color: #fff;
}

</style>

<!-- ========================================================= -->
<!-- CNC APPROVAL & HANDOVER MODAL -->
<!-- ========================================================= -->

<div
    class="modal fade"
    id="cncApprovalModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

               <h4 class="modal-title">
                    <i class="fa fa-check-circle"></i>
                    CNC Approval & Handover
                </h4>
                 <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>


            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="approval_task_id"
                    value=""
                >


                <div
                    id="approvalLoading"
                    class="text-center"
                    style="display:none;"
                >
                    <i class="fa fa-spinner fa-spin fa-2x"></i>

                    <p>
                        Loading task...
                    </p>
                </div>


                <div id="approvalTaskContent">

                    <div class="row">

                        <!-- JOB ORDER -->
                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Job Order
                                </label>

                                <input
                                    type="text"
                                    id="approval_job_order"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- SALES ORDER -->
                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Sales Order
                                </label>

                                <input
                                    type="text"
                                    id="approval_sales_order"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <!-- PRODUCT -->
                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Item Name
                                </label>

                                <input
                                    type="text"
                                    id="approval_product"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- TASK -->
                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    CNC Task / Part
                                </label>

                                <input
                                    type="text"
                                    id="approval_task"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <!-- QUANTITY -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Quantity
                                </label>

                                <input
                                    type="text"
                                    id="approval_quantity"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- EMPLOYEE -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    CNC Employee
                                </label>

                                <input
                                    type="text"
                                    id="approval_employee"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- STATUS -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Current Status
                                </label>

                                <input
                                    type="text"
                                    id="approval_status"
                                    class="form-control"
                                    readonly
                                >

                            </div>

                        </div>

                    </div>


                    <hr>


                    <div class="alert alert-info">

                        <i class="fa fa-info-circle"></i>

                        <strong>Next Department:</strong>

                        Bending

                    </div>


                    <div class="form-group">

                        <label>
                            Supervisor Remarks
                            <span
                                id="approvalRemarksRequired"
                                class="text-danger"
                            >
                                *
                            </span>
                        </label>

                        <textarea
                            id="approval_remarks"
                            class="form-control"
                            rows="4"
                            maxlength="2000"
                            placeholder="Enter approval or rework remarks..."
                        ></textarea>

                    </div>


                    <div
                        id="approvalError"
                        class="alert alert-danger"
                        style="display:none;"
                    ></div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >
                    Cancel
                </button>


                <button
                    type="button"
                    class="btn btn-danger"
                    id="sendCncRework"
                >
                    <i class="fa fa-refresh"></i>
                    Send for Rework
                </button>


                <button
                    type="button"
                    class="btn btn-success"
                    id="approveCncHandover"
                >
                    <i class="fa fa-check"></i>
                    Approve & Handover to Bending
                </button>

            </div>

        </div>

    </div>
</div>


<script>

/* =========================================================
 * OPEN CNC APPROVAL MODAL
 * ========================================================= */

function openCncApproval(taskId)
{
    $('#approval_task_id').val(taskId);

    $('#approval_job_order').val('');
    $('#approval_sales_order').val('');
    $('#approval_product').val('');
    $('#approval_task').val('');
    $('#approval_quantity').val('');
    $('#approval_employee').val('');
    $('#approval_status').val('');
    $('#approval_remarks').val('');

    $('#approvalError').hide().html('');

    $('#approvalTaskContent').hide();

    $('#approvalLoading').show();

    $('#cncApprovalModal').modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_task_for_approval"); ?>',

        type: 'POST',

        data: {
            task_id: taskId
        },

        dataType: 'json',

        success: function(response)
        {
            if (!response.status) {

                $('#approvalError')
                    .html(
                        escapeHtml(
                            response.message ||
                            'Unable to load CNC task.'
                        )
                    )
                    .show();

                return;
            }


            var task = response.data;


            $('#approval_job_order')
                .val(task.job_order_no || '-');


            $('#approval_sales_order')
                .val(task.so_code || '-');


            $('#approval_product')
                .val(task.product_name || '-');


            $('#approval_task')
                .val(task.task_description || '-');


            $('#approval_quantity')
                .val(task.quantity || '0');


            $('#approval_employee')
                .val(
                    task.employee_name  || '-'
                );


            $('#approval_status')
                .val(task.status || '-');


            $('#approvalTaskContent')
                .show();

        },

        error: function(xhr)
        {
            console.log(xhr.responseText);

            $('#approvalError')
                .html(
                    'Server error while loading CNC task.'
                )
                .show();
        },

        complete: function()
        {
            $('#approvalLoading').hide();
        }

    });
}


/* =========================================================
 * APPROVE & HANDOVER TO BENDING
 * ========================================================= */

$('#approveCncHandover').on('click', function()
{
    processCncApproval('approve');
});


/* =========================================================
 * SEND FOR REWORK
 * ========================================================= */

$('#sendCncRework').on('click', function()
{
    processCncApproval('rework');
});


/* =========================================================
 * PROCESS CNC APPROVAL
 * ========================================================= */

function processCncApproval(decision)
{
    var taskId =
        $('#approval_task_id').val();

    var remarks =
        $.trim(
            $('#approval_remarks').val()
        );


    if (!taskId) {

        alert('Invalid CNC task.');

        return;
    }


    /*
     * Rework must have remarks.
     */
    if (
        decision === 'rework' &&
        !remarks
    ) {

        alert(
            'Please enter the rework reason / remarks.'
        );

        $('#approval_remarks').focus();

        return;
    }


    var message =
        decision === 'approve'
            ? 'Approve this CNC task and hand it over to Bending?'
            : 'Send this CNC task back for rework?';


    if (!confirm(message)) {
        return;
    }


    var approveButton =
        $('#approveCncHandover');

    var reworkButton =
        $('#sendCncRework');


    approveButton.prop(
        'disabled',
        true
    );

    reworkButton.prop(
        'disabled',
        true
    );


    if (decision === 'approve') {

        approveButton.html(
            '<i class="fa fa-spinner fa-spin"></i> Processing...'
        );

    } else {

        reworkButton.html(
            '<i class="fa fa-spinner fa-spin"></i> Processing...'
        );
    }


    $.ajax({

        url:
            '<?php echo site_url("Production/approve_cnc_handover"); ?>',

        type: 'POST',

        data: {

            task_id: taskId,

            decision: decision,

            remarks: remarks

        },

        dataType: 'json',

        success: function(response)
        {
            if (response.status) {

                alert(
                    response.message ||
                    'CNC approval processed successfully.'
                );


                $('#cncApprovalModal')
                    .modal('hide');


                /*
                 * Refresh CNC supervisor task list.
                 */
                loadCncTasks();

            } else {

                alert(
                    response.message ||
                    'Unable to process CNC approval.'
                );
            }
        },

        error: function(xhr)
        {
            console.log(
                xhr.responseText
            );

            alert(
                'Server error while processing CNC approval.'
            );
        },

        complete: function()
        {
            approveButton
                .prop('disabled', false)
                .html(
                    '<i class="fa fa-check"></i> ' +
                    'Approve & Handover to Bending'
                );


            reworkButton
                .prop('disabled', false)
                .html(
                    '<i class="fa fa-refresh"></i> ' +
                    'Send for Rework'
                );
        }

    });
}


/* =========================================================
 * CLEAR APPROVAL MODAL
 * ========================================================= */

$('#cncApprovalModal').on(
    'hidden.bs.modal',
    function()
    {
        $('#approval_task_id').val('');

        $('#approval_job_order').val('');

        $('#approval_sales_order').val('');

        $('#approval_product').val('');

        $('#approval_task').val('');

        $('#approval_quantity').val('');

        $('#approval_employee').val('');

        $('#approval_status').val('');

        $('#approval_remarks').val('');

        $('#approvalError')
            .hide()
            .html('');

        $('#approvalTaskContent')
            .show();
    }
);

</script>


<script>

$(document).ready(function () {


    loadCncJobOrders();

    loadCncEmployees();

    loadCncTasks();



    /* ===================================================== */
    /* JOB ORDER CHANGE */
    /* ===================================================== */

    $('#job_order_id').on('change', function () {

        var jobOrderId = $(this).val();

        resetSalesOrders();

        resetSalesOrderProducts();


        if (!jobOrderId) {
            return;
        }


        loadJobOrderSalesOrders(jobOrderId);

    });



    /* ===================================================== */
    /* SALES ORDER CHANGE */
    /* ===================================================== */

    $('#sales_order_id').on('change', function () {

        var jobOrderId =
            $('#job_order_id').val();

        var salesOrderId =
            $(this).val();


        resetSalesOrderProducts();


        if (!jobOrderId || !salesOrderId) {
            return;
        }


        loadSalesOrderProducts(
            jobOrderId,
            salesOrderId
        );

    });



    /* ===================================================== */
    /* SAVE / UPDATE CNC TASK */
    /* ===================================================== */

    $('#cncTaskForm').on('submit', function (e) {

        e.preventDefault();


        var form = $(this);

        var button = $('#saveCncTask');

        var taskId =
            $('#task_id').val();

        var jobOrderId =
            $('#job_order_id').val();

        var salesOrderId =
            $('#sales_order_id').val();

        var productId =
            $('#sales_order_product_id').val();

        var description =
            $.trim($('#task_description').val());

        var quantity =
            parseFloat($('#quantity').val());

        var employeeId =
            $('#assigned_employee_id').val();


        /* VALIDATION */

        if (!jobOrderId) {

            alert('Please select Job Order.');

            return;
        }


        if (!salesOrderId) {

            alert('Please select Sales Order.');

            return;
        }


        if (!productId) {

            alert('Please select Sales Order Item.');

            return;
        }


        if (!description) {

            alert(
                'Please enter task / part description.'
            );

            return;
        }


        if (!quantity || quantity <= 0) {

            alert('Please enter valid quantity.');

            return;
        }


        if (!employeeId) {

            alert('Please select CNC employee.');

            return;
        }


        var isEdit =
            taskId !== '';


        button
            .prop('disabled', true)
            .html(
                '<i class="fa fa-spinner fa-spin"></i> ' +
                (
                    isEdit
                        ? 'Updating...'
                        : 'Saving...'
                )
            );


        var url =
            isEdit

                ? '<?php echo site_url("Production/update_cnc_task"); ?>'

                : '<?php echo site_url("Production/save_cnc_task"); ?>';


        $.ajax({

            url: url,

            type: 'POST',

            data: form.serialize(),

            dataType: 'json',

            success: function (response) {

                if (response.status) {

                    alert(response.message);

                    resetCncForm();

                    loadCncTasks();

                } else {

                    alert(
                        response.message ||
                        (
                            isEdit
                                ? 'Unable to update CNC task.'
                                : 'Unable to save CNC task.'
                        )
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Server error while processing CNC task.'
                );

            },

            complete: function () {

                button
                    .prop('disabled', false);


                if ($('#task_id').val()) {

                    button.html(
                        '<i class="fa fa-save"></i> Update Task'
                    );

                } else {

                    button.html(
                        '<i class="fa fa-plus"></i> Assign Task'
                    );

                }

            }

        });

    });



    /* ===================================================== */
    /* CANCEL EDIT */
    /* ===================================================== */

    $('#cancelCncEdit').on('click', function () {

        resetCncForm();

    });



    /* ===================================================== */
    /* SAVE WORK NOTE */
    /* ===================================================== */

    $('#saveCncWorkNote').on('click', function () {

        var button =
            $(this);

        var taskId =
            $('#note_task_id').val();

        var noteType =
            $('#note_type').val();

        var note =
            $.trim($('#work_note').val());


        if (!taskId) {

            alert(
                'Invalid CNC task.'
            );

            return;
        }


        if (!note) {

            alert(
                'Please enter work note.'
            );

            $('#work_note').focus();

            return;
        }


        button
            .prop('disabled', true)
            .html(
                '<i class="fa fa-spinner fa-spin"></i> Saving...'
            );


        $.ajax({

            url:
                '<?php echo site_url("Production/save_cnc_task_note"); ?>',

            type: 'POST',

            data: {

                task_id: taskId,
                note_type: noteType,
                note: note,
                added_by_role:"Supervisor"

            },

            dataType: 'json',

            success: function (response) {

                if (response.status) {

                    alert(
                        response.message ||
                        'Work note saved successfully.'
                    );


                    $('#work_note')
                        .val('');


                    $('#note_type')
                        .val('General');


                    $('#cncWorkNoteModal')
                        .modal('hide');


                    /* Refresh task list */

                    loadCncTasks();


                    /*
                     * If timeline is already open,
                     * refresh it.
                     */

                    if (
                        $('#cncTimelineModal').hasClass('in')
                    ) {

                        loadCncTaskTimeline(
                            taskId
                        );

                    }

                } else {

                    alert(
                        response.message ||
                        'Unable to save work note.'
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Server error while saving work note.'
                );

            },

            complete: function () {

                button
                    .prop('disabled', false)
                    .html(
                        '<i class="fa fa-save"></i> Save Note'
                    );

            }

        });

    });



    /* ===================================================== */
    /* CLEAR NOTE MODAL */
    /* ===================================================== */

    $('#cncWorkNoteModal').on(
        'hidden.bs.modal',
        function () {

            $('#note_task_id')
                .val('');

            $('#work_note')
                .val('');

            $('#note_type')
                .val('General');

        }
    );

});



/* ========================================================= */
/* LOAD JOB ORDERS */
/* ========================================================= */

function loadCncJobOrders()
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_job_orders"); ?>',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            var select =
                $('#job_order_id');


            select
                .empty()
                .append(
                    '<option value="">Select Job Order</option>'
                );


            if (
                response.status &&
                response.data
            ) {

                $.each(
                    response.data,
                    function (i, row) {

                        var type =
                            parseInt(
                                row.job_order_type
                            ) === 1

                                ? 'Project'

                                : 'Normal SO';


                        select.append(

                            $('<option>', {

                                value:
                                    row.job_order_id,

                                text:
                                    row.job_order_no +
                                    ' - ' +
                                    type

                            })

                        );

                    }
                );

            }

        }

    });

}



/* ========================================================= */
/* LOAD SALES ORDERS */
/* ========================================================= */

function loadJobOrderSalesOrders(jobOrderId)
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_job_order_sales_orders"); ?>',

        type: 'POST',

        data: {

            job_order_id:
                jobOrderId

        },

        dataType: 'json',

        success: function (response) {

            var select =
                $('#sales_order_id');


            select
                .empty()
                .append(
                    '<option value="">Select Sales Order</option>'
                );


            if (
                response.status &&
                response.data &&
                response.data.length
            ) {

                $.each(
                    response.data,
                    function (i, row) {

                        select.append(

                            $('<option>', {

                                value:
                                    row.so_id,

                                text:
                                    row.so_code

                            })

                        );

                    }
                );


                select.prop(
                    'disabled',
                    false
                );

            }

        }

    });

}



/* ========================================================= */
/* LOAD SO PRODUCTS */
/* ========================================================= */

function loadSalesOrderProducts(
    jobOrderId,
    salesOrderId
)
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_sales_order_products"); ?>',

        type: 'POST',

        data: {

            job_order_id:
                jobOrderId,

            sales_order_id:
                salesOrderId

        },

        dataType: 'json',

        success: function (response) {

            var select =
                $('#sales_order_product_id');


            select
                .empty()
                .append(
                    '<option value="">Select Item</option>'
                );


            if (
                response.status &&
                response.data
            ) {

                $.each(
                    response.data,
                    function (i, row) {

                        /*
                         * IMPORTANT:
                         * Existing product_name field
                         * remains unchanged.
                         */

                        select.append(

                            $('<option>', {

                                value:
                                    row.product_table_id,

                                text:
                                    (
                                        row.product_name
                                            ? row.product_name
                                            : 'Product ' +
                                              row.product_id
                                    ) +
                                    ' - Qty ' +
                                    row.quantity

                            })

                        );

                    }
                );


                select.prop(
                    'disabled',
                    false
                );

            }

        }

    });

}



/* ========================================================= */
/* LOAD EMPLOYEES */
/* ========================================================= */

function loadCncEmployees()
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_employees"); ?>',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            var select =
                $('#assigned_employee_id');


            select
                .empty()
                .append(
                    '<option value="">Select Employee</option>'
                );


            if (
                response.status &&
                response.data
            ) {

                $.each(
                    response.data,
                    function (i, row) {

                        select.append(

                            $('<option>', {

                                value:
                                    row.id,

                                text:
                                    row.name

                            })

                        );

                    }
                );

            }

        }

    });

}



/* ========================================================= */
/* LOAD CNC TASKS */
/* ========================================================= */

function loadCncTasks()
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_task_list"); ?>',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            var tbody =
                $('#cncTaskTable tbody');


            tbody.empty();


            if (
                !response.status ||
                !response.data ||
                !response.data.length
            ) {

                return;

            }


            $.each(
                response.data,
                function (i, row) {


                    /* ========================================= */
                    /* EDIT BUTTON */
                    /* ========================================= */

                    var editButton =

                        '<button ' +
                            'type="button" ' +
                            'class="btn btn-xs btn-primary" ' +
                            'onclick="editCncTask(' +
                                row.task_id +
                            ')">' +

                            '<i class="fa fa-edit"></i> Edit' +

                        '</button> ';



                    /* ========================================= */
                    /* ADD NOTE BUTTON */
                    /* ========================================= */

                    var noteButton =

                        '<button ' +
                            'type="button" ' +
                            'class="btn btn-xs btn-info" ' +
                            'onclick="openCncWorkNote(' +
                                row.task_id +
                            ')">' +

                            '<i class="fa fa-sticky-note-o"></i> Note' +

                        '</button> ';



                    /* ========================================= */
                    /* TIMELINE BUTTON */
                    /* ========================================= */

                    var timelineButton =

                        '<button ' +
                            'type="button" ' +
                            'class="btn btn-xs btn-default" ' +
                            'onclick="openCncTimeline(' +
                                row.task_id +
                            ',' +
                                '\'' +
                                escapeJs(
                                    row.task_description
                                ) +
                                '\'' +
                            ')">' +

                            '<i class="fa fa-history"></i> Timeline' +

                        '</button>';

                        /* =========================================
                        * APPROVAL & HANDOVER BUTTON
                        * Show only when CNC task is Completed
                        * ========================================= */
                        var approvalButton = '';

                        var currentStatus = $.trim(
                            String(row.status || '')
                        ).toLowerCase();

                        if (
                            currentStatus === 'completed' ||
                            currentStatus === 'complete' ||
                            currentStatus === 'production completed'
                        ) {
                            approvalButton =
                                '<button ' +
                                    'type="button" ' +
                                    'class="btn btn-success btn-xs" ' +
                                    'onclick="openCncApproval(' + row.task_id + ')" ' +
                                    'style="margin-left:4px;">' +
                                    '<i class="fa fa-check-circle"></i> Approve & Handover' +
                                '</button> ';
                        }



                    tbody.append(

                        '<tr>' +

                        '<td>' +
                            (i + 1) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.job_order_no
                            ) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.so_code
                            ) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.product_name
                            ) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.task_description
                            ) +
                        '</td>' +

                        '<td>' +
                            row.quantity +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.assigned_employee_name || '-'
                            ) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.priority
                            ) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.status
                            ) +
                        '</td>' +

                        '<td>' +
                            escapeHtml(
                                row.created_at
                            ) +
                        '</td>' +

                        '<td class="text-center" style="white-space:nowrap;">' +

                            editButton +
                            noteButton +
                            timelineButton +
                            approvalButton+

                        '</td>' +

                        '</tr>'

                    );

                }
            );

        },

        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            alert(
                'Unable to load CNC tasks.'
            );

        }

    });

}



/* ========================================================= */
/* EDIT CNC TASK */
/* ========================================================= */

function editCncTask(taskId)
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_task_list"); ?>',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            if (
                !response.status ||
                !response.data
            ) {

                alert(
                    'Unable to load CNC task.'
                );

                return;

            }


            var task = null;


            $.each(
                response.data,
                function (i, row) {

                    if (
                        parseInt(row.task_id) ===
                        parseInt(taskId)
                    ) {

                        task = row;

                        return false;

                    }

                }
            );


            if (!task) {

                alert(
                    'CNC task not found.'
                );

                return;

            }


            $('#task_id')
                .val(task.task_id);


            $('#job_order_id')
                .val(task.job_order_id)
                .trigger('change');


            loadJobOrderSalesOrders(
                task.job_order_id
            );


            setTimeout(function () {

                $('#sales_order_id')
                    .val(task.sales_order_id);


                loadSalesOrderProducts(
                    task.job_order_id,
                    task.sales_order_id
                );


                setTimeout(function () {

                    $('#sales_order_product_id')
                        .val(
                            task.sales_order_product_id
                        );

                }, 500);


            }, 500);


            $('#task_description')
                .val(
                    task.task_description
                );


            $('#quantity')
                .val(
                    task.quantity
                );


            $('#assigned_employee_id')
                .val(
                    task.assigned_employee_id
                );


            $('#priority')
                .val(
                    task.priority
                );


            $('#remarks')
                .val(
                    task.remarks || ''
                );


            $('#cncFormTitle')
                .html(
                    '<i class="fa fa-edit"></i> Edit CNC Task'
                );


            $('#saveCncTask')
                .removeClass('btn-primary')
                .addClass('btn-success')
                .html(
                    '<i class="fa fa-save"></i> Update Task'
                );


            $('#cancelCncEdit')
                .show();


            $('html, body').animate({

                scrollTop:
                    $('#cncTaskForm').offset().top - 100

            }, 500);

        },

        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            alert(
                'Server error while loading task.'
            );

        }

    });

}



/* ========================================================= */
/* OPEN WORK NOTE */
/* ========================================================= */

function openCncWorkNote(taskId)
{

    $('#note_task_id')
        .val(taskId);


    $('#note_type')
        .val('General');


    $('#work_note')
        .val('');


    $('#cncWorkNoteModal')
        .modal('show');

}



/* ========================================================= */
/* OPEN TIMELINE */
/* ========================================================= */

function openCncTimeline(
    taskId,
    taskDescription
)
{

    $('#cncTimelineTaskInfo')
        .html(
            '<strong>Task:</strong> ' +
            escapeHtml(taskDescription || '-') +
            ' &nbsp; | &nbsp; ' +
            '<strong>Task ID:</strong> ' +
            escapeHtml(taskId)
        );


    $('#cncTimeline')
        .empty();


    $('#cncTimelineEmpty')
        .hide();


    $('#cncTimelineLoading')
        .show();


    $('#cncTimelineModal')
        .modal('show');


    loadCncTaskTimeline(
        taskId
    );

}



function loadCncTaskTimeline(taskId)
{
    $('#cncTimelineLoading').show();
    $('#cncTimelineEmpty').hide();

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_task_timeline"); ?>',

        type: 'POST',

        data: {
            task_id: taskId
        },

        dataType: 'json',

        success: function (response) {

            var container = $('#cncTimeline');

            container.empty();

            if (
                !response.status ||
                !response.data ||
                !response.data.length
            ) {

                $('#cncTimelineEmpty').show();
                return;
            }


            $.each(
                response.data,
                function (i, row) {

                    var icon = 'fa-comment';

                    var title = 'Work Note';

                    var note = row.note || '';

                    var type =
                        row.note_type || 'General';


                    /*
                     * =====================================================
                     * ENTRY TYPE
                     * =====================================================
                     */

                    if (
                        row.entry_type === 'status'
                    ) {

                        icon = 'fa-refresh';

                        title = 'Status Changed';

                    }


                    if (
                        row.entry_type === 'note'
                    ) {

                        icon = 'fa-sticky-note-o';

                        title = type;

                    }

                    var addedByRole = '';

                    if (
                        row.entry_type === 'note'
                    ) {

                        addedByRole =
                            row.added_by_role ||
                            'Employee';

                    }

                    var personName =
                        row.employee_name ||
                        row.created_by_name ||
                        'System';

                    var statusHtml = '';

                    if (
                        row.status
                    ) {

                        var statusClass =
                            getCncStatusClass(
                                row.status
                            );

                        statusHtml =

                            '<span class="cnc-status-badge ' +
                            statusClass +
                            '">' +

                            escapeHtml(
                                row.status
                            ) +

                            '</span>';

                    }

                    var fromStatusHtml = '';

                    if (
                        row.from_status
                    ) {

                        fromStatusHtml =

                            '<span class="cnc-status-badge ' +
                            getCncStatusClass(
                                row.from_status
                            ) +
                            '">' +

                            escapeHtml(
                                row.from_status
                            ) +

                            '</span>';

                    }
                    var toStatusHtml = '';

                    if (
                        row.to_status
                    ) {

                        toStatusHtml =

                            '<span class="cnc-status-badge ' +
                            getCncStatusClass(
                                row.to_status
                            ) +
                            '">' +

                            escapeHtml(
                                row.to_status
                            ) +

                            '</span>';

                    }

                    var statusChangeText = '';

                    if (
                        row.from_status ||
                        row.to_status
                    ) {

                        statusChangeText =

                            '<div style="margin-bottom:7px;">' +

                            fromStatusHtml +

                            ' <i class="fa fa-arrow-right"></i> ' +

                            toStatusHtml +

                            '</div>';

                    }

                    var addedByHtml = '';

                    if (
                        row.entry_type === 'note'
                    ) {

                        addedByHtml =

                            '<span class="label label-' +

                            (
                                addedByRole === 'Supervisor'
                                    ? 'primary'
                                    : 'success'
                            ) +

                            '" style="margin-left:5px;">' +

                            escapeHtml(
                                addedByRole
                            ) +

                            '</span>';

                    }


                    container.append(

                        '<div class="cnc-timeline-item">' +

                            '<div class="cnc-timeline-icon">' +

                                '<i class="fa ' +
                                    icon +
                                '"></i>' +

                            '</div>' +


                            '<div class="cnc-timeline-content">' +


                                /*
                                 * TITLE
                                 */
                                '<div class="cnc-timeline-title">' +

                                    escapeHtml(
                                        title
                                    ) +

                                    addedByHtml +

                                '</div>' +


                                /*
                                 * USER + DATE
                                 */
                                '<div class="cnc-timeline-meta">' +

                                    '<i class="fa fa-user"></i> ' +

                                    escapeHtml(
                                        personName
                                    ) +

                                    ' &nbsp; | &nbsp; ' +

                                    '<i class="fa fa-clock-o"></i> ' +

                                    escapeHtml(
                                        row.created_at || ''
                                    ) +

                                '</div>' +


                                /*
                                 * STATUS CHANGE
                                 */
                                statusChangeText +


                                /*
                                 * NOTE
                                 */
                                (
                                    note

                                        ? '<div class="cnc-timeline-note">' +

                                            escapeHtml(
                                                note
                                            ) +

                                          '</div>'

                                        : ''
                                ) +


                            '</div>' +

                        '</div>'

                    );

                }
            );

        },


        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            $('#cncTimeline')
                .html(
                    '<div class="alert alert-danger">' +
                    'Unable to load task timeline.' +
                    '</div>'
                );

        },


        complete: function () {

            $('#cncTimelineLoading')
                .hide();

        }

    });
}
/* ========================================================= */
/* STATUS CLASS */
/* ========================================================= */

function getCncStatusClass(status)
{

    if (!status) {

        return '';

    }


    var value =
        String(status)
            .toLowerCase()
            .replace(/\s+/g, '_');


    if (
        value === 'pending'
    ) {

        return 'cnc-status-pending';

    }


    if (
        value === 'in_progress' ||
        value === 'in-progress' ||
        value === 'inprogress'
    ) {

        return 'cnc-status-progress';

    }


    if (
        value === 'hold' ||
        value === 'on_hold'
    ) {

        return 'cnc-status-hold';

    }


    if (
        value === 'completed' ||
        value === 'complete'
    ) {

        return 'cnc-status-completed';

    }


    if (
        value === 'rework'
    ) {

        return 'cnc-status-rework';

    }


    return '';

}



/* ========================================================= */
/* RESET CNC FORM */
/* ========================================================= */

function resetCncForm()
{

    $('#task_id')
        .val('');


    $('#cncTaskForm')[0]
        .reset();


    resetSalesOrders();

    resetSalesOrderProducts();


    $('#cncFormTitle')
        .html(
            'Create CNC Task'
        );


    $('#saveCncTask')
        .removeClass('btn-success')
        .addClass('btn-primary')
        .html(
            '<i class="fa fa-plus"></i> Assign Task'
        );


    $('#cancelCncEdit')
        .hide();

}



/* ========================================================= */
/* RESET SALES ORDERS */
/* ========================================================= */

function resetSalesOrders()
{

    $('#sales_order_id')
        .empty()
        .append(
            '<option value="">Select Sales Order</option>'
        )
        .prop(
            'disabled',
            true
        );

}



/* ========================================================= */
/* RESET SO PRODUCTS */
/* ========================================================= */

function resetSalesOrderProducts()
{

    $('#sales_order_product_id')
        .empty()
        .append(
            '<option value="">Select Item</option>'
        )
        .prop(
            'disabled',
            true
        );

}



/* ========================================================= */
/* HTML ESCAPE */
/* ========================================================= */

function escapeHtml(value)
{

    if (
        value === null ||
        value === undefined
    ) {

        return '';

    }


    return $('<div>')
        .text(value)
        .html();

}



/* ========================================================= */
/* JAVASCRIPT STRING ESCAPE */
/* ========================================================= */

function escapeJs(value)
{

    if (
        value === null ||
        value === undefined
    ) {

        return '';

    }


    return String(value)
        .replace(/\\/g, '\\\\')
        .replace(/'/g, "\\'")
        .replace(/"/g, '\\"')
        .replace(/\r/g, '\\r')
        .replace(/\n/g, '\\n');

}

</script>

