<link  href="<?php echo base_url(); ?>public/assets/production.css"  rel="stylesheet">
<style>
.jf-status-badge {
    display: inline-block;
    padding: 3px 7px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: bold;
    line-height: 1.4;
    white-space: nowrap;
}

.jf-status-pending {
    background: #f0ad4e;
    color: #fff;
}

.jf-status-progress {
    background: #337ab7;
    color: #fff;
}

.jf-status-hold {
    background: #777;
    color: #fff;
}

.jf-status-completed {
    background: #5cb85c;
    color: #fff;
}

.jf-status-rework {
    background: #d9534f;
    color: #fff;
}

.jf-status-review {
    background: #5bc0de;
    color: #fff;
}

.jf-status-approved {
    background: #5cb85c;
    color: #fff;
}

.jf-status-handover {
    background: #5cb85c;
    color: #fff;
}

.jf-status-default {
    background: #999;
    color: #fff;
}

.jf-timeline-status-transition {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.jf-timeline-status-transition .fa-arrow-right {
    color: #999;
    font-size: 11px;
}

.jf-timeline-item {
    border-left: 3px solid #ddd;
    padding: 10px 12px;
    margin-bottom: 10px;
    background: #f9f9f9;
    border-radius: 3px;
}

.jf-timeline-title {
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: bold;
}

.jf-timeline-content {
    margin-top: 5px;
    padding: 6px 8px;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 3px;
    white-space: pre-wrap;
}

.jf-timeline-date {
    margin-top: 6px;
    color: #999;
    font-size: 11px;
}
</style>
<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>

                        <i class="fa fa-cogs"></i>

                        Joining / Fixing Employee

                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">

                    <?php if (!empty($employee)) { ?>

                        <div class="alert alert-info">

                            <strong>

                                <?php
                                echo htmlspecialchars(
                                    $employee->employee_name
                                );
                                ?>

                            </strong>

                            &nbsp; | &nbsp;

                            Employee ID:

                            <?php
                            echo htmlspecialchars(
                                $employee->uid_number
                            );
                            ?>

                            <span class="pull-right">

                                Joining / Fixing Department

                            </span>

                        </div>

                    <?php } ?>


                    <div class="table-responsive">

                        <table
                            id="joiningFixingEmployeeTaskTable"
                            class="table table-striped table-bordered dt-responsive nowrap"
                            width="100%"
                        >

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Job Order</th>

                                    <th>Sales Order</th>

                                    <th>Product</th>

                                    <th>Task / Part</th>

                                    <th>Qty</th>

                                    <th>Priority</th>

                                    <th>Status</th>

                                    <th>Started</th>

                                    <th>Completed</th>

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

<div
    class="modal fade"
    id="joiningFixingEmployeeTaskDetailsModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-info-circle"></i>

                    Task Details

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

                <div class="row">

                    <div class="col-md-6">

                        <table class="table table-bordered">

                            <tr>

                                <th width="40%">
                                    Job Order
                                </th>

                                <td id="jf_emp_detail_job_order">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Sales Order
                                </th>

                                <td id="jf_emp_detail_sales_order">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Product
                                </th>

                                <td id="jf_emp_detail_product">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Item Code
                                </th>

                                <td id="jf_emp_detail_item_code">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Quantity
                                </th>

                                <td id="jf_emp_detail_quantity">
                                </td>

                            </tr>

                        </table>

                    </div>


                    <div class="col-md-6">

                        <table class="table table-bordered">

                            <tr>

                                <th width="40%">
                                    Task / Part
                                </th>

                                <td id="jf_emp_detail_task">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Priority
                                </th>

                                <td id="jf_emp_detail_priority">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Status
                                </th>

                                <td id="jf_emp_detail_status">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Started
                                </th>

                                <td id="jf_emp_detail_started">
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Completed
                                </th>

                                <td id="jf_emp_detail_completed">
                                </td>

                            </tr>

                        </table>

                    </div>

                </div>


                <div class="panel panel-default">

                    <div class="panel-heading">

                        <strong>
                            Remarks
                        </strong>

                    </div>

                    <div
                        class="panel-body"
                        id="jf_emp_detail_remarks"
                        style="white-space:pre-wrap;"
                    ></div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="joiningFixingEmployeeStatusModal"  tabindex="-1"  role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-edit"></i>

                    Update Task

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
                    id="joining_fixing_employee_status_task_id"
                >

                <input
                    type="hidden"
                    id="joining_fixing_employee_status_value"
                >


                <div class="alert alert-info">

                    <strong>
                        Status:
                    </strong>

                    <span
                        id="joiningFixingEmployeeStatusText"
                    ></span>

                </div>


                <div class="form-group">

                    <label>

                        Note

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <textarea
                        id="joining_fixing_employee_status_note"
                        class="form-control"
                        rows="4"
                        placeholder="Enter note..."
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
                    id="confirmJoiningFixingEmployeeStatus"
                >

                    <i class="fa fa-check"></i>

                    Confirm

                </button>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="joiningFixingEmployeeNoteModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-sticky-note"></i>

                    Work Note

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
                    id="joining_fixing_employee_note_task_id"
                >


                <div class="form-group">

                    <label>
                        Note Type
                    </label>

                    <select
                        id="joining_fixing_employee_note_type"
                        class="form-control"
                    >

                        <option value="General">
                            General
                        </option>

                        <option value="Instruction">
                            Instruction
                        </option>

                        <option value="Follow Up">
                            Follow Up
                        </option>

                        <option value="Hold Reason">
                            Hold Reason
                        </option>

                        <option value="Completion">
                            Completion
                        </option>

                        <option value="Rework">
                            Rework
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>

                        Note

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <textarea
                        id="joining_fixing_employee_work_note"
                        class="form-control"
                        rows="5"
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
                    Close
                </button>


                <button
                    type="button"
                    class="btn btn-primary"
                    id="saveJoiningFixingEmployeeNote"
                >

                    <i class="fa fa-save"></i>

                    Save Note

                </button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade"   id="joiningFixingEmployeeHistoryModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-history"></i>

                    Status History

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

                <div class="table-responsive">

                    <table
                        class="table table-bordered table-striped"
                        id="joiningFixingEmployeeHistoryTable"
                    >

                        <thead>

                            <tr>

                                <th>
                                    Old Status
                                </th>

                                <th>
                                    New Status
                                </th>

                                <th>
                                    Remarks
                                </th>

                                <th>
                                    Date / Time
                                </th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="joiningFixingEmployeeTimelineModal"
    tabindex="-1"
    role="dialog"
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
                    id="joiningFixingEmployeeTimelineLoading"
                    class="text-center"
                    style="display:none;"
                >

                    <i
                        class="fa fa-spinner fa-spin fa-2x"
                    ></i>

                    <p>
                        Loading timeline...
                    </p>

                </div>


                <div
                    id="joiningFixingEmployeeTimelineEmpty"
                    class="alert alert-warning"
                    style="display:none;"
                >
                    No timeline entries found.
                </div>


                <div
                    id="joiningFixingEmployeeTimeline"
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


<script>

var joiningFixingEmployeeTaskTable = null;

$(document).ready(function () {

    if (
        typeof $.fn.DataTable !==
        'undefined'
    ) {

        joiningFixingEmployeeTaskTable =
            $('#joiningFixingEmployeeTaskTable')
                .DataTable({

                    pageLength: 10,

                    responsive: true,

                    order: [],

                    dom:
                        '<"row"<"col-md-6"lB><"col-md-6"f>>' +
                        'rtip',

                    buttons: [

                        {
                            extend: 'excel',

                            text:
                                '<i class="fa fa-file-excel-o"></i>',

                            title:
                                'Joining Fixing Employee Tasks'
                        },

                        {
                            extend: 'print',

                            text:
                                '<i class="fa fa-print"></i>',

                            title:
                                'Joining Fixing Employee Tasks'
                        }

                    ],

                    columnDefs: [

                        {
                            orderable: false,
                            targets: [10]
                        }

                    ]

                });
    }


    loadJoiningFixingEmployeeTasks();

});

function escapeJFEmployeeHtml(value)
{
    return $('<div>')
        .text(value == null ? '' : value)
        .html();
}

function getJFEmployeePriorityBadge(priority)
{
    priority =
        $.trim(
            priority || ''
        ).toLowerCase();

    var badge =
        'label-primary';

    var text =
        priority || 'normal';


    switch (priority) {

        case 'low':
            badge = 'label-success';
            text = 'Low';
            break;

        case 'normal':
            badge = 'label-primary';
            text = 'Normal';
            break;

        case 'high':
            badge = 'label-warning';
            text = 'High';
            break;

        case 'critical':
            badge = 'label-danger';
            text = 'Critical';
            break;

        default:
            text =
                priority
                    ? priority.charAt(0).toUpperCase() +
                      priority.slice(1)
                    : 'Normal';
            break;
    }


    return (
        '<span class="label ' +
        badge +
        '">' +
        escapeJFEmployeeHtml(text) +
        '</span>'
    );
}

function getJFEmployeeStatusClass(status)
{
    var original = $.trim(status || '');
    var normalized = original.toLowerCase();

    var cssClass = 'jf-status-default';
    var text = original || 'Pending';

    switch (normalized) {

        case 'new':
            cssClass = 'jf-status-default';
            text = 'New';
            break;

        case 'pending':
            cssClass = 'jf-status-pending';
            text = 'Pending';
            break;

        case 'in progress':
        case 'started':
        case 'working':
            cssClass = 'jf-status-progress';
            text = 'In Progress';
            break;

        case 'hold':
        case 'on hold':
            cssClass = 'jf-status-hold';
            text = 'On Hold';
            break;

        case 'completed':
            cssClass = 'jf-status-completed';
            text = 'Completed';
            break;

        case 'rework':
        case 'qc rework':
        case 'rejected':
            cssClass = 'jf-status-rework';
            text = 'Rework';
            break;

        case 'supervisor review':
        case 'review':
            cssClass = 'jf-status-review';
            text = 'Supervisor Review';
            break;

        case 'approved':
            cssClass = 'jf-status-approved';
            text = 'Approved';
            break;

        case 'handed over':
        case 'handover':
        case 'handedover':
            cssClass = 'jf-status-handover';
            text = 'Handed Over';
            break;

        default:
            text = original
                ? original.charAt(0).toUpperCase() + original.slice(1)
                : 'Pending';
            break;
    }

    return {
        className: cssClass,
        text: text
    };
}


function getJFEmployeeStatusBadge(status)
{
    var statusInfo = getJFEmployeeStatusClass(status);

    return (
        '<span class="jf-status-badge ' +
        statusInfo.className +
        '">' +
        escapeJFEmployeeHtml(statusInfo.text) +
        '</span>'
    );
}

function getJoiningFixingEmployeeActions(row)
{
    var taskId =
        parseInt(
            row.task_id || 0,
            10
        );

    var status =
        $.trim(
            (row.status || 'Pending')
                .toLowerCase()
        );


    var html = '';


    if (
        status === 'pending'
    ) {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-primary jf-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="In Progress">' +

            '<i class="fa fa-play"></i> Start' +

            '</button> ';
    }


    else if (
        status === 'in progress' ||
        status === 'started' ||
        status === 'working'
    ) {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-warning jf-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="Hold">' +

            '<i class="fa fa-pause"></i> Hold' +

            '</button> ';


        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-success jf-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="Completed">' +

            '<i class="fa fa-check"></i> Complete' +

            '</button> ';
    }


    else if (
        status === 'hold' ||
        status === 'on hold'
    ) {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-primary jf-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="In Progress">' +

            '<i class="fa fa-play"></i> Resume' +

            '</button> ';
    }


    else if (
        status === 'rework' ||
        status === 'qc rework' ||
        status === 'rejected'
    ) {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-danger jf-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="In Progress">' +

            '<i class="fa fa-refresh"></i> Start Rework' +

            '</button> ';
    }


    /*
     * View
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-info jf-employee-view-btn" ' +
        'data-task-id="' + taskId + '">' +

        '<i class="fa fa-eye"></i>' +

        '</button> ';


    /*
     * Note
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-success jf-employee-note-btn" ' +
        'data-task-id="' + taskId + '">' +

        '<i class="fa fa-sticky-note"></i>' +

        '</button> ';


    /*
     * Timeline
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-default jf-employee-timeline-btn" ' +
        'data-task-id="' + taskId + '">' +

        '<i class="fa fa-history"></i>' +

        '</button>';


    return html;
}


/* =========================================================
   LOAD TASKS
========================================================= */

function loadJoiningFixingEmployeeTasks()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_joining_fixing_employee_tasks"); ?>',

        type: 'POST',

        dataType: 'json',

        success: function (response) {

            if (
                !response.status ||
                !response.data
            ) {

                return;
            }


            var rows = [];


            $.each(
                response.data,
                function (index, row) {

                    rows.push([

                        index + 1,

                        escapeJFEmployeeHtml(
                            row.job_order_no || '-'
                        ),

                        escapeJFEmployeeHtml(
                            row.so_code ||
                            row.order_no ||
                            '-'
                        ),

                        escapeJFEmployeeHtml(
                            row.product_name || '-'
                        ),

                        escapeJFEmployeeHtml(
                            row.task_description || '-'
                        ),

                        escapeJFEmployeeHtml(
                            row.quantity || '-'
                        ),

                        getJFEmployeePriorityBadge(
                            row.priority
                        ),

                        getJFEmployeeStatusBadge(
                            row.status
                        ),

                        escapeJFEmployeeHtml(
                            row.started_at || '-'
                        ),

                        escapeJFEmployeeHtml(
                            row.completed_at || '-'
                        ),

                        getJoiningFixingEmployeeActions(
                            row
                        )

                    ]);

                }
            );


            if (
                joiningFixingEmployeeTaskTable
            ) {

                joiningFixingEmployeeTaskTable
                    .clear()
                    .rows.add(rows)
                    .draw();

            } else if (
                $.fn.DataTable &&
                $.fn.DataTable.isDataTable(
                    '#joiningFixingEmployeeTaskTable'
                )
            ) {

                joiningFixingEmployeeTaskTable =
                    $('#joiningFixingEmployeeTaskTable')
                        .DataTable();

                joiningFixingEmployeeTaskTable
                    .clear()
                    .rows.add(rows)
                    .draw();
            }

        },

        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            alert(
                'Unable to load Joining / Fixing tasks.'
            );
        }

    });
}


/* =========================================================
   STATUS BUTTON
========================================================= */

$(document).on(
    'click',
    '.jf-employee-status-btn',
    function () {

        var taskId =
            $(this).data('task-id');

        var status =
            $(this).data('status');


        $('#joining_fixing_employee_status_task_id')
            .val(taskId);

        $('#joining_fixing_employee_status_value')
            .val(status);

        $('#joiningFixingEmployeeStatusText')
            .text(status);

        $('#joining_fixing_employee_status_note')
            .val('');


        $('#joiningFixingEmployeeStatusModal')
            .modal('show');
    }
);


/* =========================================================
   CONFIRM STATUS
========================================================= */

$('#confirmJoiningFixingEmployeeStatus').on(
    'click',
    function () {

        var button =
            $(this);

        var taskId =
            $('#joining_fixing_employee_status_task_id')
                .val();

        var status =
            $('#joining_fixing_employee_status_value')
                .val();

        var note =
            $.trim(
                $('#joining_fixing_employee_status_note')
                    .val()
            );


        if (!taskId || !status) {

            alert(
                'Invalid status request.'
            );

            return;
        }


        /*
         * Hold / Complete require note.
         */
        if (
            (
                status === 'Hold' ||
                status === 'Completed'
            ) &&
            !note
        ) {

            alert(
                'Please enter a note.'
            );

            $('#joining_fixing_employee_status_note')
                .focus();

            return;
        }


        button
            .prop('disabled', true)
            .html(
                '<i class="fa fa-spinner fa-spin"></i> Saving...'
            );


        $.ajax({

            url:
                '<?php echo site_url("Production/update_joining_fixing_employee_task_status"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {

                task_id:
                    taskId,

                status:
                    status,

                remarks:
                    note
            },


            success: function (response) {

                if (response.status) {

                    alert(
                        response.message ||
                        'Task status updated successfully.'
                    );

                    $(
                        '#joiningFixingEmployeeStatusModal'
                    ).modal('hide');

                    loadJoiningFixingEmployeeTasks();

                } else {

                    alert(
                        response.message ||
                        'Unable to update task.'
                    );
                }
            },


            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Server error while updating status.'
                );
            },


            complete: function () {

                button
                    .prop('disabled', false)
                    .html(
                        '<i class="fa fa-check"></i> Confirm'
                    );
            }

        });

    }
);


/* =========================================================
   VIEW
========================================================= */

$(document).on(
    'click',
    '.jf-employee-view-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_employee_task"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {

                task_id:
                    taskId
            },


            success: function (response) {

                if (
                    !response.status ||
                    !response.data
                ) {

                    alert(
                        response.message ||
                        'Unable to load task.'
                    );

                    return;
                }


                var row =
                    response.data;


                $('#jf_emp_detail_job_order')
                    .text(
                        row.job_order_no || '-'
                    );

                $('#jf_emp_detail_sales_order')
                    .text(
                        row.so_code ||
                        row.order_no ||
                        '-'
                    );

                $('#jf_emp_detail_product')
                    .text(
                        row.product_name || '-'
                    );

                $('#jf_emp_detail_item_code')
                    .text(
                        row.item_code || '-'
                    );

                $('#jf_emp_detail_quantity')
                    .text(
                        row.quantity || '-'
                    );

                $('#jf_emp_detail_task')
                    .text(
                        row.task_description || '-'
                    );

                $('#jf_emp_detail_priority')
                    .text(
                        row.priority || '-'
                    );

                $('#jf_emp_detail_status')
                    .text(
                        row.status || '-'
                    );

                $('#jf_emp_detail_started')
                    .text(
                        row.started_at || '-'
                    );

                $('#jf_emp_detail_completed')
                    .text(
                        row.completed_at || '-'
                    );

                $('#jf_emp_detail_remarks')
                    .text(
                        row.remarks || ''
                    );


                $('#joiningFixingEmployeeTaskDetailsModal')
                    .modal('show');
            }

        });

    }
);


/* =========================================================
   NOTE
========================================================= */

$(document).on(
    'click',
    '.jf-employee-note-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $('#joining_fixing_employee_note_task_id')
            .val(taskId);

        $('#joining_fixing_employee_work_note')
            .val('');


        $('#joiningFixingEmployeeNoteModal')
            .modal('show');
    }
);


/* =========================================================
   SAVE NOTE
========================================================= */

$('#saveJoiningFixingEmployeeNote').on(
    'click',
    function () {

        var button =
            $(this);

        var taskId =
            $('#joining_fixing_employee_note_task_id')
                .val();

        var noteType =
            $('#joining_fixing_employee_note_type')
                .val();

        var note =
            $.trim(
                $('#joining_fixing_employee_work_note')
                    .val()
            );


        if (!taskId) {

            alert(
                'Invalid task.'
            );

            return;
        }


        if (!note) {

            alert(
                'Please enter a note.'
            );

            return;
        }


        button
            .prop('disabled', true)
            .html(
                '<i class="fa fa-spinner fa-spin"></i> Saving...'
            );


        $.ajax({

            url:
                '<?php echo site_url("Production/save_joining_fixing_employee_note"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {

                task_id:
                    taskId,

                note_type:
                    noteType,

                note:
                    note
            },


            success: function (response) {

                if (response.status) {

                    alert(
                        response.message ||
                        'Work note saved successfully.'
                    );

                    $(
                        '#joiningFixingEmployeeNoteModal'
                    ).modal('hide');

                    loadJoiningFixingEmployeeTasks();

                } else {

                    alert(
                        response.message ||
                        'Unable to save note.'
                    );
                }
            },


            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Server error while saving note.'
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

    }
);


/* =========================================================
   TIMELINE
========================================================= */

$(document).on(
    'click',
    '.jf-employee-timeline-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $('#joiningFixingEmployeeTimeline')
            .empty();

        $('#joiningFixingEmployeeTimelineEmpty')
            .hide();

        $('#joiningFixingEmployeeTimelineLoading')
            .show();


        $('#joiningFixingEmployeeTimelineModal')
            .modal('show');


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_employee_timeline"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {

                task_id:
                    taskId
            },


            success: function (response) {

                $('#joiningFixingEmployeeTimelineLoading')
                    .hide();


                if (
                    !response.status ||
                    !response.data ||
                    !response.data.length
                ) {

                    $('#joiningFixingEmployeeTimelineEmpty')
                        .show();

                    return;
                }


                var html = '';


                $.each(
                    response.data,
                    function (index, item) {

                    if (item.entry_type === 'status') {

                        var fromStatusHtml = getJFEmployeeStatusBadge(
                            item.from_status || 'New'
                        );

                        var toStatusHtml = getJFEmployeeStatusBadge(
                            item.to_status || '-'
                        );

                        html +=
                            '<div class="jf-timeline-item">' +

                                '<div class="jf-timeline-title">' +

                                    '<i class="fa fa-exchange"></i> ' +

                                    '<span class="jf-timeline-status-transition">' +

                                        fromStatusHtml +

                                        '<i class="fa fa-arrow-right"></i>' +

                                        toStatusHtml +

                                    '</span>' +

                                '</div>' +

                                (
                                    item.note
                                        ? '<div class="jf-timeline-content">' +
                                            escapeJFEmployeeHtml(item.note) +
                                        '</div>'
                                        : ''
                                ) +

                                (
                                    item.employee_name
                                        ? '<div class="jf-timeline-content">' +
                                            '<strong>By:</strong> ' +
                                            escapeJFEmployeeHtml(item.employee_name) +

                                            (
                                                item.added_by_role
                                                    ? ' (' +
                                                        escapeJFEmployeeHtml(
                                                            item.added_by_role
                                                        ) +
                                                    ')'
                                                    : ''
                                            ) +

                                        '</div>'
                                        : ''
                                ) +

                                '<div class="jf-timeline-date">' +
                                    escapeJFEmployeeHtml(
                                        item.created_at || ''
                                    ) +
                                '</div>' +

                            '</div>';
                    }

                    else {

                            html +=
                                '<div class="jf-timeline-item">' +

                                '<strong>' +

                                '<i class="fa fa-sticky-note"></i> ' +

                                escapeJFEmployeeHtml(
                                    item.note_type ||
                                    'Note'
                                ) +

                                '</strong>' +

                                '<div>' +

                                escapeJFEmployeeHtml(
                                    item.note || ''
                                ) +

                                '</div>' +

                                '<div>' +

                                '<strong>By:</strong> ' +

                                escapeJFEmployeeHtml(
                                    item.employee_name ||
                                    '-'
                                ) +

                                ' (' +

                                escapeJFEmployeeHtml(
                                    item.added_by_role ||
                                    '-'
                                ) +

                                ')' +

                                '</div>' +

                                '<small>' +

                                escapeJFEmployeeHtml(
                                    item.created_at || ''
                                ) +

                                '</small>' +

                                '</div>';
                        }

                    }
                );


                $('#joiningFixingEmployeeTimeline')
                    .html(html);
            },


            error: function (xhr) {

                $('#joiningFixingEmployeeTimelineLoading')
                    .hide();

                console.log(
                    xhr.responseText
                );

                alert(
                    'Unable to load timeline.'
                );
            }

        });

    }
);

</script>