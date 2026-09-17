<link  href="<?php echo base_url(); ?>public/assets/production.css" rel="stylesheet">

<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>
                        <i class="fa fa-cogs"></i>
                        Joining / Fixing Supervisor
                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">

                    <div class="alert alert-info">

                        <strong>
                            Joining / Fixing Department
                        </strong>

                        <br>

                        Tasks received from the previous
                        department are shown here.

                        <br>

                        The Supervisor assigns each task
                        to a Joining / Fixing employee.

                        <br>

                        Completed tasks can be approved
                        and handed over to the next department.

                    </div>


                    <div class="table-responsive">

                        <table
                            id="joiningFixingSupervisorTaskTable"
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

                                    <th>Assigned Employee</th>

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

<div class="modal fade"  id="joiningFixingAssignEmployeeModal" tabindex="-1" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-user-plus"></i>

                    <span id="joiningFixingAssignModalTitle">
                        Assign Joining / Fixing Employee
                    </span>

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
                    id="joining_fixing_assign_task_id"
                >


                <div
                    id="joiningFixingAssignTaskInfo"
                    class="alert alert-info"
                ></div>


                <div class="form-group">

                    <label>
                        Joining / Fixing Employee
                    </label>

                    <select
                        id="joining_fixing_employee_id"
                        class="form-control"
                    >

                        <option value="">
                            Select Employee
                        </option>

                    </select>

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
                    class="btn btn-success"
                    id="assignJoiningFixingEmployee"
                >

                    <i class="fa fa-user-plus"></i>

                    Assign Employee

                </button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="joiningFixingTaskDetailsModal"  tabindex="-1"  role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-info-circle"></i>

                    Joining / Fixing Task Details

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

                        <label>Job Order</label>

                        <input
                            type="text"
                            id="jf_detail_job_order"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label>Sales Order</label>

                        <input
                            type="text"
                            id="jf_detail_sales_order"
                            class="form-control"
                            readonly
                        >

                    </div>

                </div>


                <br>


                <div class="row">

                    <div class="col-md-6">

                        <label>Product</label>

                        <input
                            type="text"
                            id="jf_detail_product"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label>Quantity</label>

                        <input
                            type="text"
                            id="jf_detail_quantity"
                            class="form-control"
                            readonly
                        >

                    </div>

                </div>


                <br>


                <div class="form-group">

                    <label>Task / Part</label>

                    <textarea
                        id="jf_detail_task"
                        class="form-control"
                        rows="3"
                        readonly
                    ></textarea>

                </div>


                <div class="row">

                    <div class="col-md-6">

                        <label>Priority</label>

                        <input
                            type="text"
                            id="jf_detail_priority"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label>Status</label>

                        <input
                            type="text"
                            id="jf_detail_status"
                            class="form-control"
                            readonly
                        >

                    </div>

                </div>


                <br>


                <div class="form-group">

                    <label>Remarks</label>

                    <textarea
                        id="jf_detail_remarks"
                        class="form-control"
                        rows="3"
                        readonly
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

            </div>

        </div>

    </div>

</div>

<div  class="modal fade"
    id="joiningFixingHandoverModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-share"></i>

                    Approve & Handover

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

                <input  type="hidden" id="joining_fixing_handover_task_id">


                <div  id="joiningFixingHandoverTaskInfo" class="alert alert-info">
                    Loading task...
                </div>


                <div class="handover-info-box">

                    <div>

                        <strong>
                            Current Department:
                        </strong>

                        Joining / Fixing

                    </div>


                    <div style="margin-top:8px;">

                        <strong>
                            Next Department:
                        </strong>

                        <span
                            class="handover-next-department"
                            id="joiningFixingNextDepartmentText"
                        >
                            Quality Check
                        </span>

                    </div>

                </div>


                <div class="alert alert-success">

                    <i class="fa fa-info-circle"></i>

                    The task will be transferred to
                    the next department.

                    <br>

                    No employee will be selected here.

                </div>


                <div class="form-group">

                    <label>
                        Handover Remarks
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="joining_fixing_handover_remarks"
                        class="form-control"
                        rows="4"
                        placeholder="Enter handover remarks..."
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
                    class="btn btn-success"
                    id="approveJoiningFixingHandover"
                >

                    <i class="fa fa-check"></i>

                    Approve & Handover

                </button>

            </div>

        </div>

    </div>

</div>
<div class="modal fade"  id="joiningFixingReworkModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-refresh"></i>

                    Send for Rework

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
                    id="joining_fixing_rework_task_id"
                >


                <div
                    id="joiningFixingReworkTaskInfo"
                    class="alert alert-warning"
                >
                    Loading task...
                </div>


                <div class="alert alert-danger">

                    <i class="fa fa-warning"></i>

                    The task will be returned to the
                    assigned Joining / Fixing employee
                    for rework.

                </div>


                <div class="form-group">

                    <label>

                        Rework Reason

                        <span class="text-danger">*</span>

                    </label>

                    <textarea
                        id="joining_fixing_rework_remarks"
                        class="form-control"
                        rows="5"
                        placeholder="Enter reason for rework..."
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
                    class="btn btn-danger"
                    id="confirmJoiningFixingRework"
                >

                    <i class="fa fa-refresh"></i>

                    Send for Rework

                </button>

            </div>

        </div>

    </div>

</div>

<div  class="modal fade"  id="joiningFixingSupervisorNoteModal"  tabindex="-1" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-sticky-note-o"></i>

                    Supervisor Note

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
                    id="joining_fixing_note_task_id"
                >


                <div class="form-group">

                    <label>
                        Note Type
                    </label>

                    <select
                        id="joining_fixing_note_type"
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

                        <option value="Rework">
                            Rework
                        </option>

                        <option value="Handover">
                            Handover
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>

                        Note

                        <span class="text-danger">*</span>

                    </label>

                    <textarea
                        id="joining_fixing_supervisor_note"
                        class="form-control"
                        rows="5"
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
                    class="btn btn-success"
                    id="saveJoiningFixingSupervisorNote"
                >

                    <i class="fa fa-save"></i>

                    Save Note

                </button>

            </div>

        </div>

    </div>

</div>

<div  class="modal fade" id="joiningFixingSupervisorTimelineModal" tabindex="-1"  role="dialog">

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

                <!--<div
                    id="joiningFixingTimelineTaskInfo"
                    class="alert alert-info"
                >
                    Loading task...
                </div>-->


                <div
                    id="joiningFixingTimelineLoading"
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
                    id="joiningFixingTimelineEmpty"
                    class="alert alert-warning"
                    style="display:none;"
                >
                    No timeline entries found.
                </div>


                <div
                    id="joiningFixingTimeline"
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

var joiningFixingSupervisorDataTable = null;

var JOINING_FIXING_NEXT_DEPARTMENT_ID = 0;

$(document).ready(function () {

    loadJoiningFixingEmployees();

    loadJoiningFixingSupervisorTasks();


    /*
     * ASSIGN
     */
    $('#assignJoiningFixingEmployee').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#joining_fixing_assign_task_id').val();

            var employeeId =
                $('#joining_fixing_employee_id').val();


            if (!taskId) {

                alert(
                    'Invalid Joining / Fixing task.'
                );

                return;
            }


            if (!employeeId) {

                alert(
                    'Please select Joining / Fixing employee.'
                );

                return;
            }


            if (
                !confirm(
                    'Assign this task to the selected employee?'
                )
            ) {

                return;
            }


            button
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...'
                );


            $.ajax({

                url:
                    '<?php echo site_url("Production/assign_joining_fixing_employee"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    employee_id:
                        employeeId
                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Employee assigned successfully.'
                        );

                        $(
                            '#joiningFixingAssignEmployeeModal'
                        ).modal('hide');

                        loadJoiningFixingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to assign employee.'
                        );
                    }
                },


                error: function (xhr) {

                    console.log(
                        xhr.responseText
                    );

                    alert(
                        'Server error while assigning employee.'
                    );
                },


                complete: function () {

                    button
                        .prop('disabled', false)
                        .html(
                            '<i class="fa fa-user-plus"></i> Assign Employee'
                        );
                }

            });

        }
    );


    /*
     * APPROVE / HANDOVER
     */
    $('#approveJoiningFixingHandover').on(
        'click',
        function () {

            var button =
                $(this);

            var taskId =
                $('#joining_fixing_handover_task_id').val();

            var remarks =
                $.trim(
                    $('#joining_fixing_handover_remarks').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (!remarks) {

                alert(
                    'Handover remarks are required.'
                );

                return;
            }


            if (
                !confirm(
                    'Approve this task and hand it over to the next department?'
                )
            ) {

                return;
            }


            button
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Handover...'
                );


            $.ajax({

                url:
                    '<?php echo site_url("Production/update_joining_fixing_supervisor_status"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    status:
                        'Approved',

                    next_department_id:
                        JOINING_FIXING_NEXT_DEPARTMENT_ID,

                    remarks:
                        remarks
                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Task handed over successfully.'
                        );

                        $(
                            '#joiningFixingHandoverModal'
                        ).modal('hide');

                        loadJoiningFixingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to hand over task.'
                        );
                    }
                },


                error: function (xhr) {

                    console.log(
                        xhr.responseText
                    );

                    alert(
                        'Server error while handing over task.'
                    );
                },


                complete: function () {

                    button
                        .prop('disabled', false)
                        .html(
                            '<i class="fa fa-check"></i> Approve & Handover'
                        );
                }

            });

        }
    );


    /*
     * REWORK
     */
    $('#confirmJoiningFixingRework').on(
        'click',
        function () {

            var button =
                $(this);

            var taskId =
                $('#joining_fixing_rework_task_id').val();

            var remarks =
                $.trim(
                    $('#joining_fixing_rework_remarks').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (!remarks) {

                alert(
                    'Rework reason is required.'
                );

                return;
            }


            button
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Sending...'
                );


            $.ajax({

                url:
                    '<?php echo site_url("Production/update_joining_fixing_supervisor_status"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    status:
                        'Rework',

                    remarks:
                        remarks
                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Task sent for rework.'
                        );

                        $(
                            '#joiningFixingReworkModal'
                        ).modal('hide');

                        loadJoiningFixingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to send task for rework.'
                        );
                    }
                },


                error: function (xhr) {

                    console.log(
                        xhr.responseText
                    );

                    alert(
                        'Server error while sending rework.'
                    );
                },


                complete: function () {

                    button
                        .prop('disabled', false)
                        .html(
                            '<i class="fa fa-refresh"></i> Send for Rework'
                        );
                }

            });

        }
    );


    /*
     * SUPERVISOR NOTE
     */
    $('#saveJoiningFixingSupervisorNote').on(
        'click',
        function () {

            var button =
                $(this);

            var taskId =
                $('#joining_fixing_note_task_id').val();

            var noteType =
                $('#joining_fixing_note_type').val();

            var note =
                $.trim(
                    $('#joining_fixing_supervisor_note').val()
                );


            if (!taskId) {

                alert('Invalid task.');

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
                    '<?php echo site_url("Production/save_joining_fixing_supervisor_note"); ?>',

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
                            'Note saved successfully.'
                        );

                        $(
                            '#joiningFixingSupervisorNoteModal'
                        ).modal('hide');

                        $(
                            '#joining_fixing_supervisor_note'
                        ).val('');

                        loadJoiningFixingSupervisorTasks();

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

});

function escapeJoiningFixingHtml(value)
{
    return $('<div>')
        .text(value == null ? '' : value)
        .html();
}

function getJoiningFixingPriorityBadge(priority)
{
    priority =
        $.trim(
            priority || ''
        ).toLowerCase();

    var badgeClass =
        'label-default';

    var text =
        'Normal';


    switch (priority) {

        case 'low':

            badgeClass =
                'label-success';

            text =
                'Low';

            break;


        case 'normal':

            badgeClass =
                'label-primary';

            text =
                'Normal';

            break;


        case 'high':

            badgeClass =
                'label-warning';

            text =
                'High';

            break;


        case 'critical':

            badgeClass =
                'label-danger';

            text =
                'Critical';

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
        badgeClass +
        '">' +
        escapeJoiningFixingHtml(text) +
        '</span>'
    );
}


function getJoiningFixingStatusClass(status)
{
    if (!status) {
        return '';
    }

    var value =
        String(status)
            .toLowerCase()
            .replace(/\s+/g, '_');

    if (value === 'pending') {
        return 'jf-status-pending';
    }

    if (
        value === 'in_progress' ||
        value === 'in-progress' ||
        value === 'inprogress' ||
        value === 'started' ||
        value === 'working'
    ) {
        return 'jf-status-progress';
    }

    if (
        value === 'hold' ||
        value === 'on_hold'
    ) {
        return 'jf-status-hold';
    }

    if (
        value === 'completed' ||
        value === 'complete'
    ) {
        return 'jf-status-completed';
    }

    if (
        value === 'rework' ||
        value === 'qc_rework' ||
        value === 'rejected'
    ) {
        return 'jf-status-rework';
    }

    if (
        value === 'supervisor_review' ||
        value === 'review'
    ) {
        return 'jf-status-review';
    }

    if (value === 'approved') {
        return 'jf-status-approved';
    }

    if (
        value === 'handed_over' ||
        value === 'handover'
    ) {
        return 'jf-status-handover';
    }

    return '';
}


function getJoiningFixingStatusBadge(status)
{
    var text =
        $.trim(status || '');

    if (!text) {
        text = 'Pending';
    }

    var statusClass =
        getJoiningFixingStatusClass(text);

    return (
        '<span class="jf-status-badge ' +
        statusClass +
        '">' +
        escapeJoiningFixingHtml(text) +
        '</span>'
    );
}


function getJoiningFixingActions(row)
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


    if (!taskId) {

        return (
            '<span class="text-danger">' +
            'Invalid Task' +
            '</span>'
        );
    }


    var html = '';


    /*
     * ASSIGN / REASSIGN
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-primary joining-fixing-assign-btn" ' +
        'data-task-id="' + taskId + '">' +

        '<i class="fa fa-user"></i> ' +

        (
            row.assigned_employee_id
                ? 'Reassign'
                : 'Assign'
        ) +

        '</button> ';


    /*
     * VIEW
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-info joining-fixing-view-btn" ' +
        'data-task-id="' + taskId + '" ' +
        'title="View Task">' +

        '<i class="fa fa-eye"></i>' +

        '</button> ';


    /*
     * SUPERVISOR NOTE
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-success joining-fixing-note-btn" ' +
        'data-task-id="' + taskId + '" ' +
        'title="Supervisor Note">' +

        '<i class="fa fa-sticky-note"></i>' +

        '</button> ';


    /*
     * TIMELINE
     */
    html +=
        '<button type="button" ' +
        'class="btn btn-xs btn-default joining-fixing-timeline-btn" ' +
        'data-task-id="' + taskId + '" ' +
        'title="Timeline">' +

        '<i class="fa fa-history"></i>' +

        '</button> ';


    /*
     * APPROVE
     */
    if (
        status === 'completed' ||
        status === 'supervisor review' ||
        status === 'review'
    ) {

        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-success joining-fixing-approve-btn" ' +
            'data-task-id="' + taskId + '">' +

            '<i class="fa fa-check"></i> Approve' +

            '</button> ';


        html +=
            '<button type="button" ' +
            'class="btn btn-xs btn-danger joining-fixing-rework-btn" ' +
            'data-task-id="' + taskId + '">' +

            '<i class="fa fa-refresh"></i> Rework' +

            '</button>';
    }


    return html;
}

function loadJoiningFixingEmployees()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_joining_fixing_employees"); ?>',

        type: 'POST',

        dataType: 'json',

        success: function (response) {

            var select =
                $('#joining_fixing_employee_id');

            select.empty();

            select.append(
                '<option value="">Select Employee</option>'
            );


            if (
                response.status &&
                response.data
            ) {

                $.each(
                    response.data,
                    function (index, employee) {

                        select.append(
                            '<option value="' +
                            employee.employee_id +
                            '">' +

                            escapeJoiningFixingHtml(
                                employee.employee_name
                            ) +

                            (
                                employee.uid_number
                                    ? ' (' +
                                      escapeJoiningFixingHtml(
                                          employee.uid_number
                                      ) +
                                      ')'
                                    : ''
                            ) +

                            '</option>'
                        );

                    }
                );
            }

        },

        error: function (xhr) {

            console.log(
                xhr.responseText
            );
        }

    });
}

function loadJoiningFixingSupervisorTasks()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_joining_fixing_supervisor_tasks"); ?>',

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

                        escapeJoiningFixingHtml(
                            row.job_order_no || '-'
                        ),

                        escapeJoiningFixingHtml(
                            row.so_code ||
                            row.order_no ||
                            '-'
                        ),

                        escapeJoiningFixingHtml(
                            row.product_name || '-'
                        ),

                        escapeJoiningFixingHtml(
                            row.task_description || '-'
                        ),

                        escapeJoiningFixingHtml(
                            row.quantity || '-'
                        ),

                        getJoiningFixingPriorityBadge(
                            row.priority
                        ),

                        getJoiningFixingStatusBadge(
                            row.status
                        ),

                        row.assigned_employee_name
                            ? escapeJoiningFixingHtml(
                                row.assigned_employee_name
                            ) +
                              (
                                row.assigned_employee_uid
                                    ? '<br><small>' +
                                      escapeJoiningFixingHtml(
                                          row.assigned_employee_uid
                                      ) +
                                      '</small>'
                                    : ''
                              )
                            : '<span class="text-muted">Not Assigned</span>',

                        escapeJoiningFixingHtml(
                            row.created_at || '-'
                        ),

                        getJoiningFixingActions(row)
                    ]);
                }
            );


            if (
                $.fn.DataTable.isDataTable(
                    '#joiningFixingSupervisorTaskTable'
                )
            ) {

                joiningFixingSupervisorDataTable
                    .clear()
                    .rows.add(rows)
                    .draw();

            } else {

                joiningFixingSupervisorDataTable =
                    $('#joiningFixingSupervisorTaskTable')
                        .DataTable({

                            data: rows,

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
                                        'Joining Fixing Supervisor Tasks'
                                },

                                {
                                    extend: 'print',

                                    text:
                                        '<i class="fa fa-print"></i>',

                                    title:
                                        'Joining Fixing Supervisor Tasks'
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

$(document).on(
    'click',
    '.joining-fixing-assign-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $('#joining_fixing_assign_task_id')
            .val(taskId);


        $('#joiningFixingAssignTaskInfo')
            .text(
                'Loading task...'
            );


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_task"); ?>',

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


                $('#joiningFixingAssignTaskInfo')
                    .html(

                        '<strong>Job Order:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.job_order_no || '-'
                        ) +

                        '<br>' +

                        '<strong>Sales Order:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.so_code ||
                            row.order_no ||
                            '-'
                        ) +

                        '<br>' +

                        '<strong>Product:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.product_name || '-'
                        ) +

                        '<br>' +

                        '<strong>Task:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.task_description || '-'
                        )
                    );


                if (row.assigned_employee_id) {

                    $('#joining_fixing_employee_id')
                        .val(
                            row.assigned_employee_id
                        );

                    $('#joiningFixingAssignModalTitle')
                        .text(
                            'Reassign Joining / Fixing Employee'
                        );

                } else {

                    $('#joining_fixing_employee_id')
                        .val('');

                    $('#joiningFixingAssignModalTitle')
                        .text(
                            'Assign Joining / Fixing Employee'
                        );
                }


                $('#joiningFixingAssignEmployeeModal')
                    .modal('show');
            }

        });

    }
);

$(document).on(
    'click',
    '.joining-fixing-view-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_task"); ?>',

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


                $('#jf_detail_job_order')
                    .val(
                        row.job_order_no || '-'
                    );

                $('#jf_detail_sales_order')
                    .val(
                        row.so_code ||
                        row.order_no ||
                        '-'
                    );

                $('#jf_detail_product')
                    .val(
                        row.product_name || '-'
                    );

                $('#jf_detail_quantity')
                    .val(
                        row.quantity || '-'
                    );

                $('#jf_detail_task')
                    .val(
                        row.task_description || '-'
                    );

                $('#jf_detail_priority')
                    .val(
                        row.priority || '-'
                    );

                $('#jf_detail_status')
                    .val(
                        row.status || '-'
                    );

                $('#jf_detail_remarks')
                    .val(
                        row.remarks || ''
                    );


                $('#joiningFixingTaskDetailsModal')
                    .modal('show');
            }

        });

    }
);

$(document).on(
    'click',
    '.joining-fixing-note-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $('#joining_fixing_note_task_id')
            .val(taskId);

        $('#joining_fixing_supervisor_note')
            .val('');

        $('#joiningFixingSupervisorNoteModal')
            .modal('show');
    }
);

$(document).on(
    'click',
    '.joining-fixing-approve-btn',
    function () {

        var taskId =
            $(this).data('task-id');


        $('#joining_fixing_handover_task_id')
            .val(taskId);


        $('#joiningFixingHandoverTaskInfo')
            .text(
                'Loading task...'
            );


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_task"); ?>',

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


                $('#joiningFixingHandoverTaskInfo')
                    .html(

                        '<strong>Job Order:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.job_order_no || '-'
                        ) +

                        '<br>' +

                        '<strong>Product:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.product_name || '-'
                        ) +

                        '<br>' +

                        '<strong>Status:</strong> ' +
                        escapeJoiningFixingHtml(
                            row.status || '-'
                        )
                    );


                $('#joiningFixingHandoverModal')
                    .modal('show');
            }

        });

    }
);


$(document).on( 'click', '.joining-fixing-rework-btn', function () {

        var taskId =
            $(this).data('task-id');


        $('#joining_fixing_rework_task_id')
            .val(taskId);

        $('#joining_fixing_rework_remarks')
            .val('');


        $('#joiningFixingReworkTaskInfo')
            .text(
                'Loading task...'
            );


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_task"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {
                task_id:
                    taskId
            },


            success: function (response) {

                if (
                    response.status &&
                    response.data
                ) {

                    var row =
                        response.data;


                    $('#joiningFixingReworkTaskInfo')
                        .html(

                            '<strong>Job Order:</strong> ' +
                            escapeJoiningFixingHtml(
                                row.job_order_no || '-'
                            ) +

                            '<br>' +

                            '<strong>Product:</strong> ' +
                            escapeJoiningFixingHtml(
                                row.product_name || '-'
                            ) +

                            '<br>' +

                            '<strong>Employee:</strong> ' +
                            escapeJoiningFixingHtml(
                                row.assigned_employee_name ||
                                'Not Assigned'
                            )
                        );
                }


                $('#joiningFixingReworkModal')
                    .modal('show');
            }

        });

    }
);

$(document).on('click', '.joining-fixing-timeline-btn', function () {

        var taskId =  $(this).data('task-id');
        $('#joiningFixingTimeline')
            .empty();

        $('#joiningFixingTimelineEmpty')
            .hide();

        $('#joiningFixingTimelineLoading')
            .show();


        $('#joiningFixingSupervisorTimelineModal')
            .modal('show');


        $.ajax({

            url:
                '<?php echo site_url("Production/get_joining_fixing_supervisor_timeline"); ?>',

            type: 'POST',

            dataType: 'json',

            data: {
                task_id:
                    taskId
            },


            success: function (response) {

                $('#joiningFixingTimelineLoading')
                    .hide();


                if (
                    !response.status ||
                    !response.data ||
                    !response.data.length
                ) {

                    $('#joiningFixingTimelineEmpty')
                        .show();

                    return;
                }


                var html = '';


                $.each(
                    response.data,
                    function (index, item) {
                       
                        if (
                            item.entry_type === 'status'
                        ) {

                            var fromStatusHtml =
                                getJoiningFixingStatusBadge(
                                    item.from_status || 'New'
                                );

                            var toStatusHtml =
                                getJoiningFixingStatusBadge(
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
                                                escapeJoiningFixingHtml(
                                                    item.note
                                                ) +
                                            '</div>'
                                            : ''
                                    ) +


                                    (
                                        item.employee_name
                                            ? '<div class="jf-timeline-content">' +

                                                '<strong>By:</strong> ' +

                                                escapeJoiningFixingHtml(
                                                    item.employee_name
                                                ) +

                                                (
                                                    item.added_by_role
                                                        ? ' (' +
                                                        escapeJoiningFixingHtml(
                                                            item.added_by_role
                                                        ) +
                                                        ')'
                                                        : ''
                                                ) +

                                            '</div>'
                                            : ''
                                    ) +


                                    '<div class="jf-timeline-date">' +

                                        escapeJoiningFixingHtml(
                                            item.created_at || ''
                                        ) +

                                    '</div>' +

                                '</div>';

                        }

                        else {

                            html +=
                                '<div class="jf-timeline-item">' +

                                '<div class="jf-timeline-title">' +

                                '<i class="fa fa-sticky-note"></i> ' +

                                escapeJoiningFixingHtml(
                                    item.note_type ||
                                    'Note'
                                ) +

                                '</div>' +

                                '<div>' +

                                escapeJoiningFixingHtml(
                                    item.note || ''
                                ) +

                                '</div>' +

                                '<div>' +

                                '<strong>By:</strong> ' +

                                escapeJoiningFixingHtml(
                                    item.employee_name ||
                                    '-'
                                ) +

                                ' (' +

                                escapeJoiningFixingHtml(
                                    item.added_by_role ||
                                    '-'
                                ) +

                                ')' +

                                '</div>' +

                                '<div class="jf-timeline-date">' +

                                escapeJoiningFixingHtml(
                                    item.created_at || ''
                                ) +

                                '</div>' +

                                '</div>';
                        }

                    }
                );


                $('#joiningFixingTimeline')
                    .html(html);
            },


            error: function (xhr) {

                $('#joiningFixingTimelineLoading')
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