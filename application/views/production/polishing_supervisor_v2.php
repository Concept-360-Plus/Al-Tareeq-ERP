<link href="<?php echo base_url()."public/assets/production.css"; ?>" rel="stylesheet"/>

<style>
    .polishing-action-buttons .btn {
        margin-bottom: 3px;
    }

    .polishing-status-completed {
        background: #5cb85c;
        color: #fff;
    }

    .polishing-status-rework {
        background: #d9534f;
        color: #fff;
    }

    .polishing-status-pending {
        background: #f0ad4e;
        color: #fff;
    }

    .polishing-status-progress {
        background: #337ab7;
        color: #fff;
    }

    .polishing-status-hold {
        background: #777;
        color: #fff;
    }

    .polishing-status-review {
        background: #5bc0de;
        color: #fff;
    }

    .polishing-status-handover {
        background: #5cb85c;
        color: #fff;
    }

    .handover-info-box {
        padding: 12px;
        border: 1px solid #ddd;
        background: #f8f8f8;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .handover-next-department {
        font-size: 16px;
        font-weight: bold;
    }
</style>


<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>
                        <i class="fa fa-cogs"></i>
                        Polishing Supervisor
                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">

                    <div class="alert alert-info">

                        <strong>
                            Polishing Department
                        </strong>

                        <br>

                        Tasks approved by Bending are received here.
                        The Polishing Supervisor assigns each task
                        to a Polishing employee.

                        <br>

                        Completed Polishing tasks can be approved
                        and handed over to the next department.

                    </div>


                    <div class="table-responsive">

                        <table
                            id="polishingSupervisorTaskTable"
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


<!-- =========================================================
     ASSIGN / REASSIGN EMPLOYEE MODAL
========================================================= -->

<div
    class="modal fade"
    id="polishingAssignEmployeeModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-user-plus"></i>

                    <span id="polishingAssignModalTitle">
                        Assign Polishing Employee
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
                    id="polishing_assign_task_id"
                >


                <div
                    id="polishingAssignTaskInfo"
                    class="alert alert-info"
                ></div>


                <div class="form-group">

                    <label>
                        Polishing Employee
                    </label>

                    <select
                        id="polishing_employee_id"
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
                    id="assignPolishingEmployee"
                >

                    <i class="fa fa-user-plus"></i>

                    Assign Employee

                </button>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     TASK DETAILS MODAL
========================================================= -->

<div
    class="modal fade"
    id="polishingTaskDetailsModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-info-circle"></i>

                    Polishing Task Details

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
                            id="detail_job_order"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label>Sales Order</label>

                        <input
                            type="text"
                            id="detail_sales_order"
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
                            id="detail_product"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label>Quantity</label>

                        <input
                            type="text"
                            id="detail_quantity"
                            class="form-control"
                            readonly
                        >

                    </div>

                </div>


                <br>


                <div class="form-group">

                    <label>Task / Part</label>

                    <textarea
                        id="detail_task"
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
                            id="detail_priority"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label>Status</label>

                        <input
                            type="text"
                            id="detail_status"
                            class="form-control"
                            readonly
                        >

                    </div>

                </div>


                <br>


                <div class="form-group">

                    <label>Remarks</label>

                    <textarea
                        id="detail_remarks"
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


<!-- =========================================================
     APPROVE & HANDOVER MODAL
========================================================= -->

<div
    class="modal fade"
    id="polishingHandoverModal"
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

                <input
                    type="hidden"
                    id="polishing_handover_task_id"
                >


                <div
                    id="polishingHandoverTaskInfo"
                    class="alert alert-info"
                >
                    Loading task...
                </div>


                <div class="handover-info-box">

                    <div>
                        <strong>
                            Current Department:
                        </strong>

                        Polishing
                    </div>


                    <div style="margin-top:8px;">

                        <strong>
                            Next Department:
                        </strong>

                        <span class="handover-next-department">
                            Joining / Fixing
                        </span>

                    </div>


                    <div style="margin-top:8px;">

                        <strong>
                            Department ID:
                        </strong>

                        12

                    </div>

                </div>


                <div class="alert alert-success">

                    <i class="fa fa-info-circle"></i>

                    The task will be transferred to the
                    <strong>Joining/Fixing Department</strong>.

                    No Joining/Fixing employee will be selected
                    here. The Joining/Fixing Supervisor will assign
                    the employee.

                </div>


                <div class="form-group">

                    <label>
                        Handover Remarks
                    </label>

                    <textarea
                        id="polishing_handover_remarks"
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
                    id="approvePolishingHandover"
                >

                    <i class="fa fa-check"></i>

                    Approve & Handover

                </button>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     REWORK MODAL
========================================================= -->

<div
    class="modal fade"
    id="polishingReworkModal"
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
                    id="polishing_rework_task_id"
                >


                <div
                    id="polishingReworkTaskInfo"
                    class="alert alert-warning"
                >
                    Loading task...
                </div>


                <div class="alert alert-danger">

                    <i class="fa fa-warning"></i>

                    The task will be returned to the
                    assigned Polishing employee for rework.

                </div>


                <div class="form-group">

                    <label>
                        Rework Reason
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="polishing_rework_remarks"
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
                    id="confirmPolishingRework"
                >

                    <i class="fa fa-refresh"></i>

                    Send for Rework

                </button>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     SUPERVISOR NOTE MODAL
========================================================= -->

<div
    class="modal fade"
    id="polishingSupervisorNoteModal"
    tabindex="-1"
    role="dialog"
>

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
                    id="polishing_note_task_id"
                >


                <div class="form-group">

                    <label>
                        Note Type
                    </label>

                    <select
                        id="polishing_note_type"
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

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Note
                    </label>

                    <textarea
                        id="polishing_supervisor_note"
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
                    id="savePolishingSupervisorNote"
                >

                    <i class="fa fa-save"></i>

                    Save Note

                </button>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     TIMELINE MODAL
========================================================= -->

<div
    class="modal fade"
    id="polishingSupervisorTimelineModal"
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
                    id="polishingTimelineTaskInfo"
                    class="alert alert-info"
                    style="margin-bottom:15px;"
                >
                    Loading task...
                </div>


                <div
                    id="polishingTimelineLoading"
                    class="text-center"
                    style="display:none;"
                >

                    <i class="fa fa-spinner fa-spin fa-2x"></i>

                    <p>
                        Loading timeline...
                    </p>

                </div>


                <div
                    id="polishingTimelineEmpty"
                    class="alert alert-warning"
                    style="display:none;"
                >
                    No timeline entries found.
                </div>


                <div
                    id="polishingTimeline"
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

var polishingSupervisorDataTable = null;


/* =========================================================
   DOCUMENT READY
========================================================= */

$(document).ready(function () {

    loadPolishingEmployees();

    loadPolishingSupervisorTasks();


    /*
     * ASSIGN / REASSIGN
     */
    $('#assignPolishingEmployee').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#polishing_assign_task_id').val();

            var employeeId =
                $('#polishing_employee_id').val();


            if (!taskId) {

                alert('Invalid Polishing task.');

                return;
            }


            if (!employeeId) {

                alert('Please select Polishing employee.');

                return;
            }


            if (
                !confirm(
                    'Assign this task to the selected Polishing employee?'
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
                    '<?php echo site_url("Production/assign_polishing_employee_v2"); ?>',

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


                        $('#polishingAssignEmployeeModal')
                            .modal('hide');


                        loadPolishingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to assign employee.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        'Assign/Reassign error:',
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
     * SUPERVISOR NOTE
     */
    $('#savePolishingSupervisorNote').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#polishing_note_task_id').val();

            var noteType =
                $('#polishing_note_type').val();

            var note =
                $.trim(
                    $('#polishing_supervisor_note').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (!note) {

                alert('Please enter note.');

                $('#polishing_supervisor_note')
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
                    '<?php echo site_url("Production/save_polishing_supervisor_note_v2"); ?>',

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


                        $('#polishing_supervisor_note')
                            .val('');


                        $('#polishingSupervisorNoteModal')
                            .modal('hide');


                        loadPolishingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to save note.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        'Note error:',
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


    /*
     * APPROVE & HANDOVER
     */
    $('#approvePolishingHandover').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#polishing_handover_task_id').val();

            var remarks =
                $.trim(
                    $('#polishing_handover_remarks').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (
                !confirm(
                    'Approve this Polishing task and hand it over to Joining/Fixing department?'
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
                    '<?php echo site_url("Production/update_polishing_supervisor_status_v2"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    status:
                        'Approved',

                    next_department_id:
                        12,

                    remarks:
                        remarks

                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Task approved and handed over to Joining/Fixing.'
                        );


                        $('#polishingHandoverModal')
                            .modal('hide');


                        $('#polishing_handover_remarks')
                            .val('');


                        loadPolishingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to approve and handover task.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        'Polishing handover error:',
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
     * CONFIRM REWORK
     */
    $('#confirmPolishingRework').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#polishing_rework_task_id').val();

            var remarks =
                $.trim(
                    $('#polishing_rework_remarks').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (!remarks) {

                alert(
                    'Please enter the rework reason.'
                );

                $('#polishing_rework_remarks')
                    .focus();

                return;
            }


            if (
                !confirm(
                    'Send this task back to the Polishing employee for rework?'
                )
            ) {

                return;
            }


            button
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Sending...'
                );


            $.ajax({

                url:
                    '<?php echo site_url("Production/update_polishing_supervisor_status_v2"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    status:
                        'Rework',

                    next_department_id:
                        11,

                    remarks:
                        remarks

                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Task sent for rework successfully.'
                        );


                        $('#polishingReworkModal')
                            .modal('hide');


                        $('#polishing_rework_remarks')
                            .val('');


                        loadPolishingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to send task for rework.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        'Polishing rework error:',
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

});


/* =========================================================
   LOAD BENDING EMPLOYEES
========================================================= */

function loadPolishingEmployees()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_employees_v2"); ?>',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            var select =
                $('#polishing_employee_id');


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
                                    row.employee_id,

                                text:
                                    row.employee_name +
                                    (
                                        row.uid_number
                                            ? ' (' +
                                              row.uid_number +
                                              ')'
                                            : ''
                                    )

                            })
                        );

                    }
                );

            }

        },

        error: function (xhr) {

            console.log(
                'Employee loading error:',
                xhr.responseText
            );

        }

    });
}


/* =========================================================
   LOAD BENDING SUPERVISOR TASKS
========================================================= */

function loadPolishingSupervisorTasks()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_supervisor_tasks_v2"); ?>',

        type: 'GET',

        dataType: 'json',


        success: function (response) {

            var table =
                $('#polishingSupervisorTaskTable');


            /*
             * Destroy existing DataTable
             */
            if (
                $.fn.DataTable &&
                $.fn.DataTable.isDataTable(
                    '#polishingSupervisorTaskTable'
                )
            ) {

                table
                    .DataTable()
                    .clear()
                    .destroy();

            }


            table.find('tbody').empty();


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

                    var status =
                        $.trim(
                            String(
                                row.status || ''
                            )
                        ).toLowerCase();


                    var employee =
                        row.assigned_employee_name
                            ? escapeHtml(
                                row.assigned_employee_name
                            )
                            : '<span class="text-danger">' +
                              'Not Assigned' +
                              '</span>';


                    /*
                     * -------------------------------------------------
                     * ASSIGN / REASSIGN
                     * -------------------------------------------------
                     */

                    var assignButton = '';


                    if (
                        !row.assigned_employee_id
                    ) {

                        assignButton =

                            '<button ' +
                                'type="button" ' +
                                'class="btn btn-xs btn-success" ' +
                                'onclick="openPolishingAssignEmployee(' +
                                    row.task_id +
                                ')">' +

                                '<i class="fa fa-user-plus"></i> ' +
                                'Assign' +

                            '</button> ';

                    }
                    else {

                        assignButton =

                            '<button ' +
                                'type="button" ' +
                                'class="btn btn-xs btn-warning" ' +
                                'onclick="openPolishingAssignEmployee(' +
                                    row.task_id +
                                ')">' +

                                '<i class="fa fa-user"></i> ' +
                                'Reassign' +

                            '</button> ';

                    }


                    /*
                     * -------------------------------------------------
                     * VIEW
                     * -------------------------------------------------
                     */

                    var detailButton =

                        '<button ' +
                            'type="button" ' +
                            'class="btn btn-xs btn-primary" ' +
                            'onclick="viewPolishingTask(' +
                                row.task_id +
                            ')">' +

                            '<i class="fa fa-eye"></i> ' +
                            'View' +

                        '</button> ';


                    /*
                     * -------------------------------------------------
                     * NOTE
                     * -------------------------------------------------
                     */

                    var noteButton =

                        '<button ' +
                            'type="button" ' +
                            'class="btn btn-xs btn-info" ' +
                            'onclick="openPolishingSupervisorNote(' +
                                row.task_id +
                            ')">' +

                            '<i class="fa fa-sticky-note-o"></i> ' +
                            'Note' +

                        '</button> ';


                    /*
                     * -------------------------------------------------
                     * TIMELINE
                     * -------------------------------------------------
                     */

                    var timelineButton =

                        '<button ' +
                            'type="button" ' +
                            'class="btn btn-xs btn-default" ' +
                            'onclick="openPolishingSupervisorTimeline(' +
                                row.task_id +
                            ')">' +

                            '<i class="fa fa-history"></i> ' +
                            'Timeline' +

                        '</button> ';


                    /*
                     * -------------------------------------------------
                     * APPROVE & HANDOVER
                     * -------------------------------------------------
                     */

                    var handoverButton = '';


                    if (
                        status === 'completed' ||
                        status === 'supervisor review' ||
                        status === 'review'
                    ) {

                        handoverButton =

                            '<button ' +
                                'type="button" ' +
                                'class="btn btn-xs btn-success" ' +
                                'onclick="openPolishingHandover(' +
                                    row.task_id +
                                ')">' +

                                '<i class="fa fa-share"></i> ' +
                                'Approve & Handover' +

                            '</button> ';

                    }


                    /*
                     * -------------------------------------------------
                     * REWORK
                     * -------------------------------------------------
                     */

                    var reworkButton = '';


                    if (
                        status === 'completed' ||
                        status === 'supervisor review' ||
                        status === 'review'
                    ) {

                        reworkButton =

                            '<button ' +
                                'type="button" ' +
                                'class="btn btn-xs btn-danger" ' +
                                'onclick="openPolishingRework(' +
                                    row.task_id +
                                ')">' +

                                '<i class="fa fa-refresh"></i> ' +
                                'Rework' +

                            '</button> ';

                    }


                    /*
                     * -------------------------------------------------
                     * ACTIONS
                     * -------------------------------------------------
                     */

                    var actions =

                        '<div class="polishing-action-buttons">' +

                            assignButton +

                            handoverButton +

                            reworkButton +

                            detailButton +

                            noteButton +

                            timelineButton +

                        '</div>';


                    /*
                     * -------------------------------------------------
                     * TABLE ROW
                     * -------------------------------------------------
                     */

                    table
                        .find('tbody')
                        .append(

                            '<tr>' +

                                '<td>' +
                                    (i + 1) +
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
                                    getPolishingPriorityBadge(
                                        row.priority
                                    ) +
                                '</td>' +

                                '<td>' +
                                    getPolishingStatusBadge(
                                        row.status
                                    ) +
                                '</td>' +

                                '<td>' +
                                    employee +
                                '</td>' +

                                '<td>' +
                                    escapeHtml(
                                        row.created_at || '-'
                                    ) +
                                '</td>' +

                                '<td ' +
                                    'class="text-center" ' +
                                    'style="white-space:nowrap;">' +

                                    actions +

                                '</td>' +

                            '</tr>'

                        );

                }
            );


            /*
             * Reinitialize DataTable
             */
            if (
                $.fn.DataTable
            ) {

                polishingSupervisorDataTable =
                    table.DataTable({

                        responsive: true,

                        pageLength: 10,

                        lengthMenu: [
                            [10, 25, 50, 100],
                            [10, 25, 50, 100]
                        ],

                        dom:
                            '<"row"<"col-sm-6"lB><"col-sm-6"f>>' +
                            'rtip',

                        buttons: [

                            {
                                extend: 'excel',

                                text:
                                    '<i class="fa fa-file-excel-o"></i>',

                                title:
                                    'Polishing Supervisor Tasks'
                            },

                            {
                                extend: 'print',

                                text:
                                    '<i class="fa fa-print"></i>',

                                title:
                                    'Polishing Supervisor Tasks'
                            }

                        ],

                        order: [
                            [0, 'asc']
                        ]

                    });

            }

        },


        error: function (xhr) {

            console.log(
                'Polishing task loading error:',
                xhr.responseText
            );

            alert(
                'Unable to load Polishing tasks.'
            );

        }

    });
}


/* =========================================================
   OPEN ASSIGN / REASSIGN
========================================================= */

function openPolishingAssignEmployee(taskId)
{
    $('#polishing_assign_task_id')
        .val(taskId);


    $('#polishing_employee_id')
        .val('');


    $('#polishingAssignModalTitle')
        .text(
            'Assign Polishing Employee'
        );


    $('#polishingAssignTaskInfo')
        .html(
            '<i class="fa fa-spinner fa-spin"></i> Loading task...'
        );


    $('#polishingAssignEmployeeModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_task_v2"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                $('#polishingAssignTaskInfo')
                    .html(
                        '<span class="text-danger">' +
                        escapeHtml(
                            response.message ||
                            'Unable to load task.'
                        ) +
                        '</span>'
                    );

                return;
            }


            var task =
                response.data;


            $('#polishingAssignModalTitle')
                .text(
                    task.assigned_employee_id
                        ? 'Reassign Polishing Employee'
                        : 'Assign Polishing Employee'
                );


            $('#polishingAssignTaskInfo')
                .html(

                    '<strong>Job Order:</strong> ' +

                    escapeHtml(
                        task.job_order_no || '-'
                    ) +

                    ' &nbsp; | &nbsp; ' +

                    '<strong>Product:</strong> ' +

                    escapeHtml(
                        task.product_name || '-'
                    ) +

                    '<br>' +

                    '<strong>Task:</strong> ' +

                    escapeHtml(
                        task.task_description || '-'
                    ) +

                    '<br>' +

                    '<strong>Qty:</strong> ' +

                    escapeHtml(
                        task.quantity || '0'
                    )

                );


            if (
                task.assigned_employee_id
            ) {

                $('#polishing_employee_id')
                    .val(
                        task.assigned_employee_id
                    );

            }

        },


        error: function (xhr) {

            console.log(
                'Get Polishing task error:',
                xhr.responseText
            );

            $('#polishingAssignTaskInfo')
                .html(
                    '<span class="text-danger">' +
                    'Server error while loading task.' +
                    '</span>'
                );

        }

    });
}


/* =========================================================
   VIEW TASK
========================================================= */

function viewPolishingTask(taskId)
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_task_v2"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                alert(
                    response.message ||
                    'Unable to load task.'
                );

                return;
            }


            var task =
                response.data;


            $('#detail_job_order')
                .val(
                    task.job_order_no || '-'
                );


            $('#detail_sales_order')
                .val(
                    task.so_code || '-'
                );


            $('#detail_product')
                .val(
                    task.product_name || '-'
                );


            $('#detail_quantity')
                .val(
                    task.quantity || '0'
                );


            $('#detail_task')
                .val(
                    task.task_description || '-'
                );


            $('#detail_priority')
                .val(
                    task.priority || '-'
                );


            $('#detail_status')
                .val(
                    task.status || '-'
                );


            $('#detail_remarks')
                .val(
                    task.remarks || '-'
                );


            $('#polishingTaskDetailsModal')
                .modal('show');

        },


        error: function (xhr) {

            console.log(
                'View Polishing task error:',
                xhr.responseText
            );

            alert(
                'Unable to load task details.'
            );

        }

    });
}


/* =========================================================
   OPEN APPROVE & HANDOVER
========================================================= */

function openPolishingHandover(taskId)
{
    $('#polishing_handover_task_id')
        .val(taskId);


    $('#polishing_handover_remarks')
        .val('');


    $('#polishingHandoverTaskInfo')
        .html(
            '<i class="fa fa-spinner fa-spin"></i> Loading task...'
        );


    $('#polishingHandoverModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_task_v2"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                $('#polishingHandoverTaskInfo')
                    .html(
                        '<span class="text-danger">' +
                        escapeHtml(
                            response.message ||
                            'Unable to load task.'
                        ) +
                        '</span>'
                    );

                return;
            }


            var task =
                response.data;


            $('#polishingHandoverTaskInfo')
                .html(

                    '<strong>Job Order:</strong> ' +
                    escapeHtml(
                        task.job_order_no || '-'
                    ) +

                    ' &nbsp; | &nbsp; ' +

                    '<strong>Sales Order:</strong> ' +
                    escapeHtml(
                        task.so_code || '-'
                    ) +

                    '<br>' +

                    '<strong>Product:</strong> ' +
                    escapeHtml(
                        task.product_name || '-'
                    ) +

                    '<br>' +

                    '<strong>Task:</strong> ' +
                    escapeHtml(
                        task.task_description || '-'
                    ) +

                    '<br>' +

                    '<strong>Employee:</strong> ' +
                    escapeHtml(
                        task.employee_name ||
                        task.assigned_employee_name ||
                        '-'
                    )

                );

        },


        error: function (xhr) {

            console.log(
                'Handover task error:',
                xhr.responseText
            );

            $('#polishingHandoverTaskInfo')
                .html(
                    '<span class="text-danger">' +
                    'Server error while loading task.' +
                    '</span>'
                );

        }

    });
}


/* =========================================================
   OPEN REWORK
========================================================= */

function openPolishingRework(taskId)
{
    $('#polishing_rework_task_id')
        .val(taskId);


    $('#polishing_rework_remarks')
        .val('');


    $('#polishingReworkTaskInfo')
        .html(
            '<i class="fa fa-spinner fa-spin"></i> Loading task...'
        );


    $('#polishingReworkModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_task_v2"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                $('#polishingReworkTaskInfo')
                    .html(
                        '<span class="text-danger">' +
                        escapeHtml(
                            response.message ||
                            'Unable to load task.'
                        ) +
                        '</span>'
                    );

                return;
            }


            var task =
                response.data;


            $('#polishingReworkTaskInfo')
                .html(

                    '<strong>Job Order:</strong> ' +
                    escapeHtml(
                        task.job_order_no || '-'
                    ) +

                    ' &nbsp; | &nbsp; ' +

                    '<strong>Product:</strong> ' +
                    escapeHtml(
                        task.product_name || '-'
                    ) +

                    '<br>' +

                    '<strong>Task:</strong> ' +
                    escapeHtml(
                        task.task_description || '-'
                    ) +

                    '<br>' +

                    '<strong>Assigned Employee:</strong> ' +
                    escapeHtml(
                        task.employee_name ||
                        task.assigned_employee_name ||
                        'Not Assigned'
                    )

                );

        },


        error: function (xhr) {

            console.log(
                'Rework task error:',
                xhr.responseText
            );

            $('#polishingReworkTaskInfo')
                .html(
                    '<span class="text-danger">' +
                    'Server error while loading task.' +
                    '</span>'
                );

        }

    });
}


/* =========================================================
   OPEN NOTE
========================================================= */

function openPolishingSupervisorNote(taskId)
{
    $('#polishing_note_task_id')
        .val(taskId);


    $('#polishing_note_type')
        .val('General');


    $('#polishing_supervisor_note')
        .val('');


    $('#polishingSupervisorNoteModal')
        .modal('show');
}


/* =========================================================
   OPEN TIMELINE
========================================================= */

function openPolishingSupervisorTimeline(taskId)
{
    $('#polishingTimelineTaskInfo')
        .html(
            '<strong>Task ID:</strong> ' +
            escapeHtml(taskId)
        );


    $('#polishingTimeline')
        .empty();


    $('#polishingTimelineEmpty')
        .hide();


    $('#polishingTimelineLoading')
        .show();


    $('#polishingSupervisorTimelineModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_polishing_supervisor_timeline_v2"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            var container =
                $('#polishingTimeline');


            container.empty();


            if (
                !response.status ||
                !response.data ||
                !response.data.length
            ) {

                $('#polishingTimelineEmpty')
                    .show();

                return;
            }


            $.each(
                response.data,
                function (i, row) {

                    var icon =
                        row.entry_type === 'status'
                            ? 'fa-refresh'
                            : 'fa-sticky-note-o';


                    var title =
                        row.entry_type === 'status'
                            ? 'Status Changed'
                            : (
                                row.note_type ||
                                'Work Note'
                            );


                    var role =
                        row.added_by_role ||
                        'Employee';


                    var person =
                        row.employee_name ||
                        row.created_by_name ||
                        'System';


                    var html =

                        '<div class="cnc-timeline-item">' +

                            '<div class="cnc-timeline-icon">' +

                                '<i class="fa ' +
                                    icon +
                                '"></i>' +

                            '</div>' +


                            '<div class="cnc-timeline-content">' +

                                '<div class="cnc-timeline-title">' +

                                    escapeHtml(
                                        title
                                    ) +

                                    ' ' +

                                    '<span ' +
                                        'class="label label-info" ' +
                                        'style="font-size:10px;"' +
                                    '>' +

                                        escapeHtml(
                                            role
                                        ) +

                                    '</span>' +

                                '</div>' +


                                '<div class="cnc-timeline-meta">' +

                                    '<strong>' +

                                        escapeHtml(
                                            person
                                        ) +

                                    '</strong>' +

                                    ' &nbsp; | &nbsp; ' +

                                    escapeHtml(
                                        row.created_at || ''
                                    ) +

                                '</div>';
                    if (row.entry_type === 'status') {
                            html +=

                                '<div class="cnc-timeline-note">' +

                                    '<strong>From:</strong> ' +

                                    '<span class="cnc-status-badge ' +
                                        getPolishingStatusClass(
                                            row.old_status
                                        ) +
                                    '">' +

                                        escapeHtml(
                                            row.old_status || '-'
                                        ) +

                                    '</span>' +

                                    ' &nbsp; → &nbsp; ' +

                                    '<strong>To:</strong> ' +

                                    '<span class="cnc-status-badge ' +
                                        getPolishingStatusClass(
                                            row.new_status
                                        ) +
                                    '">' +

                                        escapeHtml(
                                            row.new_status || '-'
                                        ) +

                                    '</span>' +

                                '</div>';

                        }
                    if (
                        row.note
                    ) {

                        html +=

                            '<div ' +
                                'class="cnc-timeline-note" ' +
                                'style="margin-top:8px;"' +
                            '>' +

                                escapeHtml(
                                    row.note
                                ) +

                            '</div>';

                    }


                    html +=

                            '</div>' +

                        '</div>';


                    container.append(
                        html
                    );

                }
            );

        },


        error: function (xhr) {

            console.log(
                'Timeline error:',
                xhr.responseText
            );


            $('#polishingTimeline')
                .html(

                    '<div class="alert alert-danger">' +

                        '<i class="fa fa-exclamation-triangle"></i> ' +

                        'Unable to load timeline.' +

                    '</div>'

                );

        },


        complete: function () {

            $('#polishingTimelineLoading')
                .hide();

        }

    });
}


/* =========================================================
   PRIORITY BADGE
========================================================= */

function getPolishingPriorityBadge(priority)
{
    priority =
        $.trim(
            String(
                priority || ''
            )
        ).toLowerCase();


    var className =
        'label-default';

    var text =
        priority
            ? priority.charAt(0).toUpperCase() +
              priority.slice(1)
            : 'Normal';


    switch (priority) {

        case 'low':

            className =
                'label-success';

            text =
                'Low';

            break;


        case 'normal':

            className =
                'label-primary';

            text =
                'Normal';

            break;


        case 'high':

            className =
                'label-warning';

            text =
                'High';

            break;


        case 'critical':

            className =
                'label-danger';

            text =
                'Critical';

            break;

    }


    return (

        '<span class="label ' +
            className +
        '">' +

            escapeHtml(
                text
            ) +

        '</span>'

    );
}


/* =========================================================
   STATUS BADGE
========================================================= */

function getPolishingStatusBadge(status)
{
    status =
        $.trim(
            String(
                status || ''
            )
        ).toLowerCase();


    var className =
        'label-default';

    var text =
        status
            ? status.replace(
                /\b\w/g,
                function (letter) {
                    return letter.toUpperCase();
                }
            )
            : 'Pending';


    switch (status) {

        case 'pending':

            className =
                'label-warning';

            text =
                'Pending';

            break;


        case 'in progress':

        case 'started':

        case 'working':

            className =
                'label-primary';

            text =
                'In Progress';

            break;


        case 'hold':

        case 'on hold':

            className =
                'label-default';

            text =
                'On Hold';

            break;


        case 'completed':

            className =
                'label-success';

            text =
                'Completed';

            break;


        case 'supervisor review':

        case 'review':

            className =
                'label-info';

            text =
                'Supervisor Review';

            break;


        case 'rework':

        case 'qc rework':

        case 'rejected':

            className =
                'label-danger';

            text =
                'Rework';

            break;


        case 'approved':

            className =
                'label-success';

            text =
                'Approved';

            break;


        case 'handed over':

        case 'handover':

            className =
                'label-success';

            text =
                'Handed Over';

            break;

    }


    return (

        '<span class="label ' +
            className +
        '">' +

            escapeHtml(
                text
            ) +

        '</span>'

    );
}


/* =========================================================
   STATUS CLASS FOR TIMELINE
========================================================= */

function getPolishingStatusClass(status)
{
    status =
        $.trim(
            String(
                status || ''
            )
        ).toLowerCase();


    switch (status) {

        case 'pending':

            return 'cnc-status-pending';


        case 'in progress':

        case 'started':

        case 'working':

            return 'cnc-status-progress';


        case 'hold':

        case 'on hold':

            return 'cnc-status-hold';


        case 'completed':

        case 'approved':

            return 'cnc-status-completed';


        case 'rework':

        case 'qc rework':

        case 'rejected':

            return 'cnc-status-rework';


        default:

            return 'cnc-status-pending';

    }
}


/* =========================================================
   HTML ESCAPE
========================================================= */

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