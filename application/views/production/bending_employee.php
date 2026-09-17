 <link href="<?php echo base_url()."public/assets/production.css"; ?>" rel="stylesheet"/>
<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>
                        <i class="fa fa-cogs"></i>
                        Bending Employee
                    </h2>

                    <div class="clearfix"></div>

                </div>

                <div class="x_content">

                    <?php if (!empty($employee)) { ?>

                        <div class="alert alert-info">

                            <strong>
                                <?php echo htmlspecialchars($employee->employee_name); ?>
                            </strong>

                            &nbsp; | &nbsp;

                            Employee ID:
                            <?php echo htmlspecialchars($employee->uid_number); ?>

                            <span class="pull-right">
                                Bending Department
                            </span>

                        </div>

                    <?php } ?>

                    <!-- TASK TABLE -->

                    <div class="table-responsive">

                        <table
                            id="bendingEmployeeTaskTable"
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


<!-- =====================================================
     TASK DETAILS MODAL
===================================================== -->

<div
    class="modal fade"
    id="bendingEmployeeTaskDetailsModal"
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
                                <th width="40%">Job Order</th>
                                <td id="bend_emp_detail_job_order"></td>
                            </tr>

                            <tr>
                                <th>Sales Order</th>
                                <td id="bend_emp_detail_sales_order"></td>
                            </tr>

                            <tr>
                                <th>Product</th>
                                <td id="bend_emp_detail_product"></td>
                            </tr>

                            <tr>
                                <th>Item Code</th>
                                <td id="bend_emp_detail_item_code"></td>
                            </tr>

                            <tr>
                                <th>Quantity</th>
                                <td id="bend_emp_detail_quantity"></td>
                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6">

                        <table class="table table-bordered">

                            <tr>
                                <th width="40%">Task / Part</th>
                                <td id="bend_emp_detail_task"></td>
                            </tr>

                            <tr>
                                <th>Priority</th>
                                <td id="bend_emp_detail_priority"></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td id="bend_emp_detail_status"></td>
                            </tr>

                            <tr>
                                <th>Started</th>
                                <td id="bend_emp_detail_started"></td>
                            </tr>

                            <tr>
                                <th>Completed</th>
                                <td id="bend_emp_detail_completed"></td>
                            </tr>

                        </table>

                    </div>

                </div>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <strong>Remarks</strong>
                    </div>

                    <div
                        class="panel-body"
                        id="bend_emp_detail_remarks"
                        style="white-space:pre-wrap;"
                    ></div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     STATUS NOTE MODAL
===================================================== -->

<div
    class="modal fade"
    id="bendingEmployeeStatusModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-edit"></i>
                    Update Task
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="bending_employee_status_task_id"
                >

                <input
                    type="hidden"
                    id="bending_employee_status_value"
                >

                <div class="alert alert-info">

                    <strong>Status:</strong>

                    <span id="bending_employee_status_text"></span>

                </div>

                <div class="form-group">

                    <label>
                        Note
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="bending_employee_status_note"
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
                    id="confirmBendingEmployeeStatus"
                >
                    <i class="fa fa-check"></i>
                    Confirm
                </button>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     WORK NOTE MODAL
===================================================== -->

<div
    class="modal fade"
    id="bendingEmployeeNoteModal"
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
                <button type="button"  class="close" data-dismiss="modal">
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="bending_employee_note_task_id"
                >

                <div class="form-group">

                    <label>Note Type</label>

                    <select
                        id="bending_employee_note_type"
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
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="bending_employee_work_note"
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
                    id="saveBendingEmployeeNote"
                >
                    <i class="fa fa-save"></i>
                    Save Note
                </button>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     STATUS HISTORY MODAL
===================================================== -->

<div
    class="modal fade"
    id="bendingEmployeeHistoryModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>

                <h4 class="modal-title">
                    <i class="fa fa-history"></i>
                    Status History
                </h4>

            </div>

            <div class="modal-body">

                <div class="table-responsive">

                    <table
                        class="table table-bordered table-striped"
                        id="bendingEmployeeHistoryTable"
                    >

                        <thead>

                            <tr>

                                <th>Old Status</th>

                                <th>New Status</th>

                                <th>Remarks</th>

                                <th>Date / Time</th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     TIMELINE MODAL
===================================================== -->

<div
    class="modal fade"
    id="bendingEmployeeTimelineModal"
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
                    id="bendingEmployeeTimelineTaskInfo"
                    class="alert alert-info"
                    style="margin-bottom:15px;"
                >
                    Loading task...
                </div>

                <div
                    id="bendingEmployeeTimelineLoading"
                    class="text-center"
                    style="display:none;"
                >

                    <i class="fa fa-spinner fa-spin fa-2x"></i>

                    <p>
                        Loading timeline...
                    </p>

                </div>

                <div
                    id="bendingEmployeeTimelineEmpty"
                    class="alert alert-warning"
                    style="display:none;"
                >
                    No timeline entries found.
                </div>

                <div
                    id="bendingEmployeeTimeline"
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


<script>

var bendingEmployeeTaskTable = null;

$(document).ready(function () {

    console.log('Bending Employee JS loaded');

    /*
     * Initialize DataTable only if available.
     * Do NOT stop task loading if DataTables is unavailable.
     */
    if (typeof $.fn.DataTable !== 'undefined') {

        console.log('DataTables loaded');

        bendingEmployeeTaskTable = $('#bendingEmployeeTaskTable').DataTable({

            pageLength: 10,

            responsive: true,

            order: [],

            dom:
                '<"row"<"col-md-6"lB><"col-md-6"f>>' +
                'rtip',

            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    title: 'Bending Employee Tasks'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    title: 'Bending Employee Tasks'
                }
            ],

            columnDefs: [
                {
                    orderable: false,
                    targets: [10]
                }
            ]

        });

    } else {

        console.warn(
            'DataTables JS is not loaded. Tasks will still be loaded.'
        );
    }


    /*
     * IMPORTANT:
     * Load tasks independently of DataTables.
     */
    loadBendingEmployeeTasks();

});

function getPriorityBadge(priority)
{
    priority = $.trim(priority || '').toLowerCase();

    var badgeClass = 'label-default';
    var text = 'Normal';

    switch (priority) {

        case 'low':
            badgeClass = 'label-success';
            text = 'Low';
            break;

        case 'normal':
            badgeClass = 'label-primary';
            text = 'Normal';
            break;

        case 'high':
            badgeClass = 'label-warning';
            text = 'High';
            break;

        case 'critical':
            badgeClass = 'label-danger';
            text = 'Critical';
            break;

        default:
            badgeClass = 'label-primary';
            text = priority
                ? priority.charAt(0).toUpperCase() +
                  priority.slice(1)
                : 'Normal';
            break;
    }

    return '<span class="label ' +
           badgeClass +
           '">' +
           escapeHtml(text) +
           '</span>';
}

function getBendingEmployeeStatusBadge(status)
{
    status = $.trim(status || '').toLowerCase();

    var badgeClass = 'label-default';
    var text = status
        ? status.replace(/\b\w/g, function (letter) {
            return letter.toUpperCase();
        })
        : 'Pending';

    switch (status) {

        case 'pending':
            badgeClass = 'label-warning';
            text = 'Pending';
            break;

        case 'in progress':
        case 'started':
        case 'working':
            badgeClass = 'label-primary';
            text = 'In Progress';
            break;

        case 'hold':
        case 'on hold':
            badgeClass = 'label-default';
            text = 'On Hold';
            break;

        case 'completed':
            badgeClass = 'label-success';
            text = 'Completed';
            break;

        case 'rework':
        case 'qc rework':
        case 'rejected':
            badgeClass = 'label-danger';
            text = 'Rework';
            break;

        case 'supervisor review':
        case 'review':
            badgeClass = 'label-info';
            text = 'Supervisor Review';
            break;

        case 'approved':
            badgeClass = 'label-success';
            text = 'Approved';
            break;

        case 'handed over':
        case 'handover':
            badgeClass = 'label-success';
            text = 'Handed Over';
            break;
    }

    return '<span class="label ' +
           badgeClass +
           '">' +
           escapeHtml(text) +
           '</span>';
}

function getBendingEmployeeActions(row)
{
    var taskId = parseInt(row.task_id || 0, 10);

    var status = $.trim(
        (row.status || 'Pending').toLowerCase()
    );

    if (!taskId) {

        return '<span class="text-danger">' +
               'Invalid Task' +
               '</span>';
    }

    var html = '';

    if (status === 'pending') {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-primary ' +
            'bending-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="In Progress" ' +
            'title="Start Task">' +

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
            'class="btn btn-xs btn-warning ' +
            'bending-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="Hold" ' +
            'title="Hold Task">' +

            '<i class="fa fa-pause"></i> Hold' +

            '</button> ';


        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-success ' +
            'bending-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="Completed" ' +
            'title="Complete Task">' +

            '<i class="fa fa-check"></i> Complete' +

            '</button> ';
    }

    else if (
        status === 'hold' ||
        status === 'on hold'
    ) {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-primary ' +
            'bending-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="In Progress" ' +
            'title="Resume Task">' +

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
            'class="btn btn-xs btn-danger ' +
            'bending-employee-status-btn" ' +
            'data-task-id="' + taskId + '" ' +
            'data-status="In Progress" ' +
            'title="Start Rework">' +

            '<i class="fa fa-refresh"></i> Start Rework' +

            '</button> ';
    }


    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-info ' +
        'bending-employee-view-btn" ' +
        'data-task-id="' + taskId + '" ' +
        'title="View Task">' +

        '<i class="fa fa-eye"></i>' +

        '</button> ';


    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-success ' +
        'bending-employee-note-btn" ' +
        'data-task-id="' + taskId + '" ' +
        'title="Add Work Note">' +

        '<i class="fa fa-sticky-note"></i>' +

        '</button> ';

    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-default ' +
        'bending-employee-timeline-btn" ' +
        'data-task-id="' + taskId + '" ' +
        'title="View Timeline">' +

        '<i class="fa fa-history"></i>' +

        '</button>';


    return html;
}


function loadBendingEmployeeTasks()
{
    console.log(
        'Calling get_bending_employee_tasks...'
    );

    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_employee_tasks"); ?>',

        type: 'POST',

        dataType: 'json',

        cache: false,

        data: {},


        beforeSend: function () {

            console.log(
                'Bending employee task request started'
            );
        },


        success: function (response) {

            console.log(
                'Bending employee task response:',
                response
            );


            /*
             * Make sure response exists
             */

            if (!response) {

                console.error(
                    'Empty response received'
                );

                showBendingTaskError(
                    'Empty response received from server.'
                );

                return;
            }


            /*
             * If PHP returned status=false
             */

            if (
                response.status === false ||
                response.status === 0
            ) {

                console.error(
                    'Server returned status false:',
                    response
                );

                showBendingTaskError(
                    response.message ||
                    'No tasks returned from server.'
                );

                return;
            }


            /*
             * Get task array.
             *
             * Supports:
             * response.data
             * response.tasks
             * direct array response
             */

            var tasks = [];

            if ($.isArray(response)) {

                tasks = response;

            } else if ($.isArray(response.data)) {

                tasks = response.data;

            } else if ($.isArray(response.tasks)) {

                tasks = response.tasks;

            }


            console.log(
                'Number of Bending employee tasks:',
                tasks.length
            );


            /*
             * Clear DataTable if available
             */

            if (bendingEmployeeTaskTable) {

                bendingEmployeeTaskTable.clear();

            } else {

                /*
                 * Fallback if DataTables is unavailable
                 */

                $('#bendingEmployeeTaskTable tbody')
                    .empty();
            }


            /*
             * No tasks
             */

            if (!tasks.length) {

                console.warn(
                    'No tasks returned for this employee.'
                );

                if (bendingEmployeeTaskTable) {

                    bendingEmployeeTaskTable.draw();

                } else {

                    $('#bendingEmployeeTaskTable tbody')
                        .html(
                            '<tr>' +
                            '<td colspan="11" ' +
                            'class="text-center text-muted">' +
                            'No tasks assigned to you.' +
                            '</td>' +
                            '</tr>'
                        );
                }

                return;
            }


            /*
             * Add rows
             */

            $.each(tasks, function (index, row) {

                console.log(
                    'Task row:',
                    row
                );


                var taskId =
                    parseInt(row.task_id || 0, 10);


                var rowData = [

                    index + 1,

                    escapeHtml(
                        row.job_order_no || '-'
                    ),

                    escapeHtml(
                        row.so_code || '-'
                    ),

                    escapeHtml(
                        row.product_name || '-'
                    ),

                    escapeHtml(
                        row.task_description || '-'
                    ),

                    escapeHtml(
                        row.quantity || '0'
                    ),

                    getPriorityBadge(
                        row.priority
                    ),

                    getBendingEmployeeStatusBadge(
                        row.status
                    ),

                    escapeHtml(
                        row.started_at || '-'
                    ),

                    escapeHtml(
                        row.completed_at || '-'
                    ),

                    getBendingEmployeeActions(
                        row
                    )

                ];


                /*
                 * DataTable
                 */

                if (bendingEmployeeTaskTable) {

                    bendingEmployeeTaskTable.row.add(
                        rowData
                    );

                }


                /*
                 * Plain table fallback
                 */

                else {

                    $('#bendingEmployeeTaskTable tbody')
                        .append(
                            '<tr>' +

                            '<td>' +
                            (index + 1) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.job_order_no || '-'
                            ) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.so_code || '-'
                            ) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.product_name || '-'
                            ) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.task_description || '-'
                            ) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.quantity || '0'
                            ) +
                            '</td>' +

                            '<td>' +
                            getPriorityBadge(
                                row.priority
                            ) +
                            '</td>' +

                            '<td>' +
                            getBendingEmployeeStatusBadge(
                                row.status
                            ) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.started_at || '-'
                            ) +
                            '</td>' +

                            '<td>' +
                            escapeHtml(
                                row.completed_at || '-'
                            ) +
                            '</td>' +

                            '<td>' +
                            getBendingEmployeeActions(
                                row
                            ) +
                            '</td>' +

                            '</tr>'
                        );
                }

            });


            /*
             * Draw DataTable
             */

            if (bendingEmployeeTaskTable) {

                bendingEmployeeTaskTable.draw();

            }

        },


        error: function (
            xhr,
            status,
            error
        ) {

            console.error(
                '================================'
            );

            console.error(
                'BENDING EMPLOYEE AJAX ERROR'
            );

            console.error(
                'Status:',
                status
            );

            console.error(
                'Error:',
                error
            );

            console.error(
                'HTTP Status:',
                xhr.status
            );

            console.error(
                'Response:',
                xhr.responseText
            );

            console.error(
                '================================'
            );


            showBendingTaskError(
                'Unable to load tasks. Check browser console.'
            );
        }

    });
}

function showBendingTaskError(message)
{
    if (bendingEmployeeTaskTable) {

        bendingEmployeeTaskTable.clear();

        bendingEmployeeTaskTable.row.add([

            '',
            '',
            '',
            '',
            '<span class="text-danger">' +
            escapeHtml(message) +
            '</span>',
            '',
            '',
            '',
            '',
            '',
            ''

        ]);

        bendingEmployeeTaskTable.draw();

    } else {

        $('#bendingEmployeeTaskTable tbody')
            .html(
                '<tr>' +
                '<td colspan="11" ' +
                'class="text-center text-danger">' +
                escapeHtml(message) +
                '</td>' +
                '</tr>'
            );
    }
}

$(document).on(
    'click',
    '.bending-employee-status-btn',
    function () {

        var taskId =
            $(this).data('task-id');

        var newStatus =
            $(this).data('status');


        if (!taskId || !newStatus) {

            alert('Invalid task.');

            return;
        }


        /*
         * Hold and Completed require note
         */

        if (
            newStatus === 'Hold' ||
            newStatus === 'Completed'
        ) {

            $('#bending_employee_status_task_id')
                .val(taskId);

            $('#bending_employee_status_value')
                .val(newStatus);

            $('#bending_employee_status_text')
                .text(newStatus);

            $('#bending_employee_status_note')
                .val('');

            $('#bendingEmployeeStatusModal')
                .modal('show');

        }


        /*
         * Start / Resume / Rework
         */

        else {

            updateBendingEmployeeTaskStatus(
                taskId,
                newStatus,
                ''
            );
        }

    }
);

$(document).on(
    'click',
    '#confirmBendingEmployeeStatus',
    function () {

        var button = $(this);

        var taskId =
            $.trim(
                $('#bending_employee_status_task_id')
                .val()
            );

        var newStatus =
            $.trim(
                $('#bending_employee_status_value')
                .val()
            );

        var note =
            $.trim(
                $('#bending_employee_status_note')
                .val()
            );


        if (!taskId) {

            alert('Invalid task.');

            return;
        }


        if (!newStatus) {

            alert('Invalid status.');

            return;
        }


        if (
            (
                newStatus === 'Hold' ||
                newStatus === 'Completed'
            ) &&
            !note
        ) {

            alert('Please enter a note.');

            $('#bending_employee_status_note')
                .focus();

            return;
        }


        button.prop(
            'disabled',
            true
        );

        button.html(
            '<i class="fa fa-spinner fa-spin"></i> Saving...'
        );


        updateBendingEmployeeTaskStatus(

            taskId,

            newStatus,

            note,

            function () {

                button.prop(
                    'disabled',
                    false
                );

                button.html(
                    '<i class="fa fa-check"></i> Confirm'
                );

                $('#bendingEmployeeStatusModal')
                    .modal('hide');

            },

            function () {

                button.prop(
                    'disabled',
                    false
                );

                button.html(
                    '<i class="fa fa-check"></i> Confirm'
                );
            }
        );

    }
);

function updateBendingEmployeeTaskStatus(
    taskId,
    newStatus,
    note,
    successCallback,
    errorCallback
) {

    $.ajax({

        url:
            '<?php echo site_url("Production/update_bending_employee_task_status"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id: taskId,

            status: newStatus,

            remarks: note

        },


        success: function (response) {

            console.log(
                'Status update response:',
                response
            );


            if (response.status) {

                if (
                    typeof successCallback ===
                    'function'
                ) {

                    successCallback(response);
                }

                loadBendingEmployeeTasks();

            } else {

                alert(
                    response.message ||
                    'Unable to update task.'
                );


                if (
                    typeof errorCallback ===
                    'function'
                ) {

                    errorCallback(response);
                }
            }

        },


        error: function (
            xhr,
            status,
            error
        ) {

            console.error(
                'Status update error:',
                xhr.responseText
            );

            alert(
                'Unable to update task.'
            );


            if (
                typeof errorCallback ===
                'function'
            ) {

                errorCallback();
            }
        }

    });
}

$(document).on(
    'click',
    '.bending-employee-view-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        if (!taskId) {

            alert('Invalid task.');

            return;
        }


        $.ajax({

            url:
                '<?php echo site_url("Production/get_bending_employee_task"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {
                task_id: taskId
            },


            success: function (response) {

                console.log(
                    'Task detail response:',
                    response
                );


                if (
                    !response.status ||
                    !response.data
                ) {

                    alert(
                        response.message ||
                        'Unable to load task details.'
                    );

                    return;
                }


                var row =
                    response.data;


                $('#bend_emp_detail_job_order')
                    .text(
                        row.job_order_no || '-'
                    );


                $('#bend_emp_detail_sales_order')
                    .text(
                        row.so_code || '-'
                    );


                $('#bend_emp_detail_product')
                    .text(
                        row.product_name || '-'
                    );


                $('#bend_emp_detail_item_code')
                    .text(
                        row.item_code || '-'
                    );


                $('#bend_emp_detail_quantity')
                    .text(
                        row.quantity || '0'
                    );


                $('#bend_emp_detail_task')
                    .text(
                        row.task_description || '-'
                    );


                $('#bend_emp_detail_priority')
                    .html(
                        getPriorityBadge(
                            row.priority
                        )
                    );


                $('#bend_emp_detail_status')
                    .html(
                        getBendingEmployeeStatusBadge(
                            row.status
                        )
                    );


                $('#bend_emp_detail_started')
                    .text(
                        row.started_at || '-'
                    );


                $('#bend_emp_detail_completed')
                    .text(
                        row.completed_at || '-'
                    );


                $('#bend_emp_detail_remarks')
                    .text(
                        row.remarks ||
                        'No remarks.'
                    );


                $('#bendingEmployeeTaskDetailsModal')
                    .modal('show');

            },


            error: function (
                xhr
            ) {

                console.error(
                    'Task detail error:',
                    xhr.responseText
                );

                alert(
                    'Unable to load task details.'
                );
            }

        });

    }
);

$(document).on(
    'click',
    '.bending-employee-note-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        if (!taskId) {

            alert('Invalid task.');

            return;
        }


        $('#bending_employee_note_task_id')
            .val(taskId);


        $('#bending_employee_note_type')
            .val('General');


        $('#bending_employee_work_note')
            .val('');


        $('#bendingEmployeeNoteModal')
            .modal('show');

    }
);

$(document).on(
    'click',
    '#saveBendingEmployeeNote',
    function () {

        var button =
            $(this);


        var taskId =
            $.trim(
                $('#bending_employee_note_task_id')
                .val()
            );


        var noteType =
            $.trim(
                $('#bending_employee_note_type')
                .val()
            );


        var note =
            $.trim(
                $('#bending_employee_work_note')
                .val()
            );


        if (!taskId) {

            alert('Invalid task.');

            return;
        }


        if (!note) {

            alert('Please enter a work note.');

            $('#bending_employee_work_note')
                .focus();

            return;
        }


        button.prop(
            'disabled',
            true
        );


        button.html(
            '<i class="fa fa-spinner fa-spin"></i> Saving...'
        );


        $.ajax({

            url:
                '<?php echo site_url("Production/save_bending_employee_note"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {

                task_id: taskId,

                note_type: noteType,

                note: note

            },


            success: function (response) {

                console.log(
                    'Save note response:',
                    response
                );


                if (response.status) {

                    alert(
                        response.message ||
                        'Work note saved successfully.'
                    );


                    $('#bendingEmployeeNoteModal')
                        .modal('hide');


                    $('#bending_employee_work_note')
                        .val('');


                } else {

                    alert(
                        response.message ||
                        'Unable to save work note.'
                    );
                }


                loadBendingEmployeeTasks();

            },


            error: function (
                xhr,
                status,
                error
            ) {

                console.error(
                    'Save note error:',
                    xhr.responseText
                );

                alert(
                    'Unable to save work note.'
                );
            },


            complete: function () {

                button.prop(
                    'disabled',
                    false
                );

                button.html(
                    '<i class="fa fa-save"></i> Save Note'
                );
            }

        });

    }
);


$(document).on(
    'click',
    '.bending-employee-timeline-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        if (!taskId) {

            alert('Invalid task.');

            return;
        }


        $('#bendingEmployeeTimelineTaskInfo')
            .html(
                '<strong>Task ID:</strong> ' +
                escapeHtml(taskId)
            );


        $('#bendingEmployeeTimelineLoading')
            .show();


        $('#bendingEmployeeTimelineEmpty')
            .hide();


        $('#bendingEmployeeTimeline')
            .html('');


        $('#bendingEmployeeTimelineModal')
            .modal('show');


        loadBendingEmployeeTimeline(
            taskId
        );

    }
);

function loadBendingEmployeeTimeline(taskId)
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_employee_timeline"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {
            task_id: taskId
        },


        success: function (response) {

            console.log(
                'Timeline response:',
                response
            );


            $('#bendingEmployeeTimelineLoading')
                .hide();


            if (!response.status) {

                $('#bendingEmployeeTimelineEmpty')
                    .text(
                        response.message ||
                        'Unable to load timeline.'
                    )
                    .show();

                return;
            }


            var data =
                response.data || [];


            if (!data.length) {

                $('#bendingEmployeeTimelineEmpty')
                    .show();

                return;
            }


            var html = '';


            $.each(
                data,
                function (
                    index,
                    item
                ) {

                    var entryType =
                        $.trim(
                            (
                                item.entry_type ||
                                ''
                            ).toLowerCase()
                        );


                    var note =
                        item.note || '';


                    var employeeName =
                        item.employee_name || '';


                    var role =
                        item.added_by_role || '';


                    var createdAt =
                        item.created_at || '';


                    var noteType =
                        item.note_type || '';


                    var icon =
                        'fa-clock-o';


                    if (
                        entryType ===
                        'status'
                    ) {

                        icon =
                            'fa-exchange';

                    } else if (
                        entryType ===
                        'note'
                    ) {

                        icon =
                            'fa-sticky-note';
                    }


                    var title = '';


                    if (
                        entryType ===
                        'status'
                    ) {

                        title =
                            escapeHtml(
                                item.from_status || ''
                            ) +
                            ' &rarr; ' +
                            escapeHtml(
                                item.to_status || ''
                            );

                    } else {

                        title =
                            escapeHtml(
                                noteType ||
                                'Work Note'
                            );
                    }


                    html +=

                        '<div class="cnc-timeline-item">' +

                            '<div class="cnc-timeline-icon">' +

                                '<i class="fa ' +
                                icon +
                                '"></i>' +

                            '</div>' +

                            '<div class="cnc-timeline-content">' +

                                '<div class="cnc-timeline-title">' +

                                    title +

                                '</div>' +

                                '<div class="cnc-timeline-meta">' +

                                    escapeHtml(
                                        employeeName
                                    ) +

                                    (
                                        role
                                        ? ' (' +
                                          escapeHtml(role) +
                                          ')'
                                        : ''
                                    ) +

                                    (
                                        createdAt
                                        ? ' &nbsp;|&nbsp; ' +
                                          escapeHtml(
                                              createdAt
                                          )
                                        : ''
                                    ) +

                                '</div>' +

                                (
                                    note
                                    ? '<div class="cnc-timeline-note">' +
                                      escapeHtml(note) +
                                      '</div>'
                                    : ''
                                ) +

                            '</div>' +

                        '</div>';
                }
            );


            $('#bendingEmployeeTimeline')
                .html(html);

        },


        error: function (
            xhr,
            status,
            error
        ) {

            $('#bendingEmployeeTimelineLoading')
                .hide();


            $('#bendingEmployeeTimelineEmpty')
                .text(
                    'Unable to load timeline.'
                )
                .show();


            console.error(
                'Timeline error:',
                xhr.responseText
            );
        }

    });
}

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

</script>
