<link href="<?php echo base_url()."public/assets/production.css"; ?>" rel="stylesheet"/>

<style>
    .bending-action-buttons .btn {
        margin-bottom: 3px;
    }

    .bending-status-completed {
        background: #5cb85c;
        color: #fff;
    }

    .bending-status-rework {
        background: #d9534f;
        color: #fff;
    }

    .bending-status-pending {
        background: #f0ad4e;
        color: #fff;
    }

    .bending-status-progress {
        background: #337ab7;
        color: #fff;
    }

    .bending-status-hold {
        background: #777;
        color: #fff;
    }

    .bending-status-review {
        background: #5bc0de;
        color: #fff;
    }

    .bending-status-handover {
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
                        Bending Supervisor
                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">

                    <div class="alert alert-info">

                        <strong>
                            Bending Department
                        </strong>

                        <br>

                        Tasks approved by CNC are received here.
                        The Bending Supervisor assigns each task
                        to a Bending employee.

                        <br>

                        Completed Bending tasks can be approved
                        and handed over to the next department.

                    </div>


                    <div class="table-responsive">

                        <table
                            id="bendingSupervisorTaskTable"
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
    id="bendingAssignEmployeeModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-user-plus"></i>

                    <span id="bendingAssignModalTitle">
                        Assign Bending Employee
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
                    id="bending_assign_task_id"
                >


                <div
                    id="bendingAssignTaskInfo"
                    class="alert alert-info"
                ></div>


                <div class="form-group">

                    <label>
                        Bending Employee
                    </label>

                    <select
                        id="bending_employee_id"
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
                    id="assignBendingEmployee"
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
    id="bendingTaskDetailsModal"
    tabindex="-1"
    role="dialog"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <i class="fa fa-info-circle"></i>

                    Bending Task Details

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


<div
    class="modal fade"
    id="bendingHandoverModal"
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
                    id="bending_handover_task_id"
                >


                <div
                    id="bendingHandoverTaskInfo"
                    class="alert alert-info"
                >
                    Loading task...
                </div>


                <div class="handover-info-box">

                    <div>
                        <strong>
                            Current Department:
                        </strong>

                        Bending
                    </div>


                    <div style="margin-top:8px;">

                        <strong>
                            Next Department:
                        </strong>

                        <span class="handover-next-department">
                            Polishing
                        </span>

                    </div>


                    <div style="margin-top:8px;">

                        <strong>
                            Department ID:
                        </strong>

                        11

                    </div>

                </div>


                <div class="alert alert-success">

                    <i class="fa fa-info-circle"></i>

                    The task will be transferred to the
                    <strong>Polishing Department</strong>.

                    No Polishing employee will be selected
                    here. The Polishing Supervisor will assign
                    the employee.

                </div>


                <div class="form-group">

                    <label>
                        Handover Remarks
                    </label>

                    <textarea
                        id="bending_handover_remarks"
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
                    id="approveBendingHandover"
                >

                    <i class="fa fa-check"></i>

                    Approve & Handover

                </button>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="bendingReworkModal"
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
                    id="bending_rework_task_id"
                >


                <div
                    id="bendingReworkTaskInfo"
                    class="alert alert-warning"
                >
                    Loading task...
                </div>


                <div class="alert alert-danger">

                    <i class="fa fa-warning"></i>

                    The task will be returned to the
                    assigned Bending employee for rework.

                </div>


                <div class="form-group">

                    <label>
                        Rework Reason
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="bending_rework_remarks"
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
                    id="confirmBendingRework"
                >

                    <i class="fa fa-refresh"></i>

                    Send for Rework

                </button>

            </div>

        </div>

    </div>

</div>


<div
    class="modal fade"
    id="bendingSupervisorNoteModal"
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
                    id="bending_note_task_id"
                >


                <div class="form-group">

                    <label>
                        Note Type
                    </label>

                    <select
                        id="bending_note_type"
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
                        id="bending_supervisor_note"
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
                    id="saveBendingSupervisorNote"
                >

                    <i class="fa fa-save"></i>

                    Save Note

                </button>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="bendingSupervisorTimelineModal"
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
                    id="bendingTimelineTaskInfo"
                    class="alert alert-info"
                    style="margin-bottom:15px;"
                >
                    Loading task...
                </div>


                <div
                    id="bendingTimelineLoading"
                    class="text-center"
                    style="display:none;"
                >

                    <i class="fa fa-spinner fa-spin fa-2x"></i>

                    <p>
                        Loading timeline...
                    </p>

                </div>


                <div
                    id="bendingTimelineEmpty"
                    class="alert alert-warning"
                    style="display:none;"
                >
                    No timeline entries found.
                </div>


                <div
                    id="bendingTimeline"
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

var bendingSupervisorDataTable = null;

$(document).ready(function () {

    loadBendingEmployees();

    loadBendingSupervisorTasks();


    /*
     * ASSIGN / REASSIGN
     */
    $('#assignBendingEmployee').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#bending_assign_task_id').val();

            var employeeId =
                $('#bending_employee_id').val();


            if (!taskId) {

                alert('Invalid Bending task.');

                return;
            }


            if (!employeeId) {

                alert('Please select Bending employee.');

                return;
            }


            if (
                !confirm(
                    'Assign this task to the selected Bending employee?'
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
                    '<?php echo site_url("Production/assign_bending_employee"); ?>',

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


                        $('#bendingAssignEmployeeModal')
                            .modal('hide');


                        loadBendingSupervisorTasks();

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
    $('#saveBendingSupervisorNote').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#bending_note_task_id').val();

            var noteType =
                $('#bending_note_type').val();

            var note =
                $.trim(
                    $('#bending_supervisor_note').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (!note) {

                alert('Please enter note.');

                $('#bending_supervisor_note')
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
                    '<?php echo site_url("Production/save_bending_supervisor_note"); ?>',

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


                        $('#bending_supervisor_note')
                            .val('');


                        $('#bendingSupervisorNoteModal')
                            .modal('hide');


                        loadBendingSupervisorTasks();

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
    $('#approveBendingHandover').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#bending_handover_task_id').val();

            var remarks =
                $.trim(
                    $('#bending_handover_remarks').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (
                !confirm(
                    'Approve this Bending task and hand it over to Polishing department?'
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
                    '<?php echo site_url("Production/update_bending_supervisor_status_v2"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    status:
                        'Approved',

                    next_department_id:
                        11,

                    remarks:
                        remarks

                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Task approved and handed over to Polishing.'
                        );


                        $('#bendingHandoverModal')
                            .modal('hide');


                        $('#bending_handover_remarks')
                            .val('');


                        loadBendingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to approve and handover task.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        'Bending handover error:',
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
    $('#confirmBendingRework').on(
        'click',
        function () {

            var button = $(this);

            var taskId =
                $('#bending_rework_task_id').val();

            var remarks =
                $.trim(
                    $('#bending_rework_remarks').val()
                );


            if (!taskId) {

                alert('Invalid task.');

                return;
            }


            if (!remarks) {

                alert(
                    'Please enter the rework reason.'
                );

                $('#bending_rework_remarks')
                    .focus();

                return;
            }


            if (
                !confirm(
                    'Send this task back to the Bending employee for rework?'
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
                    '<?php echo site_url("Production/update_bending_supervisor_status_v2"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id:
                        taskId,

                    status:
                        'Rework',

                    next_department_id:
                        10,

                    remarks:
                        remarks

                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message ||
                            'Task sent for rework successfully.'
                        );


                        $('#bendingReworkModal')
                            .modal('hide');


                        $('#bending_rework_remarks')
                            .val('');


                        loadBendingSupervisorTasks();

                    } else {

                        alert(
                            response.message ||
                            'Unable to send task for rework.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        'Bending rework error:',
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


function loadBendingEmployees()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_employees"); ?>',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            var select =
                $('#bending_employee_id');


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


function loadBendingSupervisorTasks()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_supervisor_tasks"); ?>',

        type: 'GET',

        dataType: 'json',


        success: function (response) {

            var table =
                $('#bendingSupervisorTaskTable');


            /*
             * Destroy existing DataTable
             */
            if (
                $.fn.DataTable &&
                $.fn.DataTable.isDataTable(
                    '#bendingSupervisorTaskTable'
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
                                'onclick="openBendingAssignEmployee(' +
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
                                'onclick="openBendingAssignEmployee(' +
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
                            'onclick="viewBendingTask(' +
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
                            'onclick="openBendingSupervisorNote(' +
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
                            'onclick="openBendingSupervisorTimeline(' +
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
                                'onclick="openBendingHandover(' +
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
                                'onclick="openBendingRework(' +
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

                        '<div class="bending-action-buttons">' +

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
                                    getBendingPriorityBadge(
                                        row.priority
                                    ) +
                                '</td>' +

                                '<td>' +
                                    getBendingStatusBadge(
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

                bendingSupervisorDataTable =
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
                                    'Bending Supervisor Tasks'
                            },

                            {
                                extend: 'print',

                                text:
                                    '<i class="fa fa-print"></i>',

                                title:
                                    'Bending Supervisor Tasks'
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
                'Bending task loading error:',
                xhr.responseText
            );

            alert(
                'Unable to load Bending tasks.'
            );

        }

    });
}

function openBendingAssignEmployee(taskId)
{
    $('#bending_assign_task_id')
        .val(taskId);


    $('#bending_employee_id')
        .val('');


    $('#bendingAssignModalTitle')
        .text(
            'Assign Bending Employee'
        );


    $('#bendingAssignTaskInfo')
        .html(
            '<i class="fa fa-spinner fa-spin"></i> Loading task...'
        );


    $('#bendingAssignEmployeeModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_task"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                $('#bendingAssignTaskInfo')
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


            $('#bendingAssignModalTitle')
                .text(
                    task.assigned_employee_id
                        ? 'Reassign Bending Employee'
                        : 'Assign Bending Employee'
                );


            $('#bendingAssignTaskInfo')
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

                $('#bending_employee_id')
                    .val(
                        task.assigned_employee_id
                    );

            }

        },


        error: function (xhr) {

            console.log(
                'Get Bending task error:',
                xhr.responseText
            );

            $('#bendingAssignTaskInfo')
                .html(
                    '<span class="text-danger">' +
                    'Server error while loading task.' +
                    '</span>'
                );

        }

    });
}

function viewBendingTask(taskId)
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_task"); ?>',

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


            $('#bendingTaskDetailsModal')
                .modal('show');

        },


        error: function (xhr) {

            console.log(
                'View Bending task error:',
                xhr.responseText
            );

            alert(
                'Unable to load task details.'
            );

        }

    });
}

function openBendingHandover(taskId)
{
    $('#bending_handover_task_id')
        .val(taskId);


    $('#bending_handover_remarks')
        .val('');


    $('#bendingHandoverTaskInfo')
        .html(
            '<i class="fa fa-spinner fa-spin"></i> Loading task...'
        );


    $('#bendingHandoverModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_task"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                $('#bendingHandoverTaskInfo')
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


            $('#bendingHandoverTaskInfo')
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

            $('#bendingHandoverTaskInfo')
                .html(
                    '<span class="text-danger">' +
                    'Server error while loading task.' +
                    '</span>'
                );

        }

    });
}


function openBendingRework(taskId)
{
    $('#bending_rework_task_id')
        .val(taskId);


    $('#bending_rework_remarks')
        .val('');


    $('#bendingReworkTaskInfo')
        .html(
            '<i class="fa fa-spinner fa-spin"></i> Loading task...'
        );


    $('#bendingReworkModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_task"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            if (!response.status) {

                $('#bendingReworkTaskInfo')
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


            $('#bendingReworkTaskInfo')
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

            $('#bendingReworkTaskInfo')
                .html(
                    '<span class="text-danger">' +
                    'Server error while loading task.' +
                    '</span>'
                );

        }

    });
}

function openBendingSupervisorNote(taskId)
{
    $('#bending_note_task_id')
        .val(taskId);


    $('#bending_note_type')
        .val('General');


    $('#bending_supervisor_note')
        .val('');


    $('#bendingSupervisorNoteModal')
        .modal('show');
}

function openBendingSupervisorTimeline(taskId)
{
    $('#bendingTimelineTaskInfo')
        .html(
            '<strong>Task ID:</strong> ' +
            escapeHtml(taskId)
        );


    $('#bendingTimeline')
        .empty();


    $('#bendingTimelineEmpty')
        .hide();


    $('#bendingTimelineLoading')
        .show();


    $('#bendingSupervisorTimelineModal')
        .modal('show');


    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_supervisor_timeline"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id:
                taskId

        },


        success: function (response) {

            var container =
                $('#bendingTimeline');


            container.empty();


            if (
                !response.status ||
                !response.data ||
                !response.data.length
            ) {

                $('#bendingTimelineEmpty')
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
                                        getBendingStatusClass(
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
                                        getBendingStatusClass(
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


            $('#bendingTimeline')
                .html(

                    '<div class="alert alert-danger">' +

                        '<i class="fa fa-exclamation-triangle"></i> ' +

                        'Unable to load timeline.' +

                    '</div>'

                );

        },


        complete: function () {

            $('#bendingTimelineLoading')
                .hide();

        }

    });
}

function getBendingPriorityBadge(priority)
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


function getBendingStatusBadge(status)
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

function getBendingStatusClass(status)
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