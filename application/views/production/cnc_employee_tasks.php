<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>
                        <i class="fa fa-cogs"></i>
                        CNC Employee Tasks
                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">

                    <!-- EMPLOYEE INFORMATION -->

                    <div class="alert alert-info">

                        <strong>
                            <i class="fa fa-user"></i>
                            My CNC Tasks
                        </strong>

                        <span class="pull-right">
                            Only tasks assigned to you are displayed.
                        </span>

                    </div>


                    <!-- TASK TABLE -->

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped"
                            id="cncEmployeeTaskTable"
                        >

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Job Order</th>

                                    <th>Sales Order</th>

                                    <th>Item</th>

                                    <th>Task / Part</th>

                                    <th>Qty</th>

                                    <th>Priority</th>

                                    <th>Status</th>

                                    <th>Started</th>

                                    <th>Completed</th>

                                    <th>Action</th>

                                </tr>

                            </thead>


                            <tbody>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- STATUS HISTORY MODAL -->

    <div
        class="modal fade"
        id="statusHistoryModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-lg"
            role="document"
        >

            <div class="modal-content">

                <div class="modal-header">

                    
                    <h4 class="modal-title">

                        <i class="fa fa-history"></i>

                        Task Status History

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
                            id="statusHistoryTable"
                        >

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Old Status</th>

                                    <th>New Status</th>

                                    <th>Changed By</th>

                                    <th>Remarks</th>

                                    <th>Date</th>

                                </tr>

                            </thead>


                            <tbody>

                            </tbody>

                        </table>

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
    id="cncEmployeeNoteModal"
    tabindex="-1"
    role="dialog"
>

    <div
        class="modal-dialog"
        role="document"
    >

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
                    <i class="fa fa-comment"></i>
                    Add Work Note
                </h4>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="employee_note_task_id"
                >


                <div class="form-group">

                    <label>
                        Note Type
                    </label>

                    <select
                        id="employee_note_type"
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
                        Work Note <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="employee_work_note"
                        class="form-control"
                        rows="5"
                        placeholder="Enter your work note..."
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
                    onclick="saveEmployeeWorkNote()"
                >

                    <i class="fa fa-save"></i>
                    Save Note

                </button>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     CNC TASK TIMELINE MODAL
========================================================= -->

<div
    class="modal fade"
    id="cncEmployeeTimelineModal"
    tabindex="-1"
    role="dialog"
>

    <div
        class="modal-dialog modal-lg"
        role="document"
    >

        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">

                    <i class="fa fa-history"></i>

                    Work Notes / Task Timeline

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

                <div id="cncEmployeeTimelineContent">

                    <div class="text-center">

                        <i class="fa fa-spinner fa-spin"></i>
                        Loading timeline...

                    </div>

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


</div>


<script>

$(document).ready(function () {

    loadCncEmployeeTasks();

});


/*
|--------------------------------------------------------------------------
| Load employee tasks
|--------------------------------------------------------------------------
*/

function loadCncEmployeeTasks()
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_employee_tasks"); ?>',

        type: 'POST',

        dataType: 'json',

        success: function (response) {

            var tbody =
                $('#cncEmployeeTaskTable tbody');

            tbody.empty();


            if (
                !response.status ||
                !response.data ||
                response.data.length === 0
            ) {

                tbody.append(
                    '<tr>' +
                        '<td colspan="11" class="text-center">' +
                            'No CNC tasks assigned to you.' +
                        '</td>' +
                    '</tr>'
                );

                return;
            }


            $.each(
                response.data,
                function (index, row) {

                    var action =
                        getTaskAction(row);


                    var statusBadge =
                        getStatusBadge(
                            row.status
                        );


                    tbody.append(

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
                                    row.quantity
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.priority || '-'
                                ) +
                            '</td>' +

                            '<td>' +
                                statusBadge +
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
                                action +
                            '</td>' +

                        '</tr>'
                    );

                }
            );

        },

        error: function () {

            alert(
                'Unable to load CNC tasks.'
            );

        }

    });

}

function getTaskAction(row) {

    var taskId = row.task_id;

    if (!taskId) {
        return '-';
    }

    // Normalize status
    var status = $.trim(String(row.status || ''))
        .toLowerCase()
        .replace(/_/g, ' ')
        .replace(/\s+/g, ' ');

    var html = '';

    if (status === 'pending') {

        html +=
            '<button type="button" class="btn btn-success btn-xs" ' +
            'onclick="changeTaskStatus(' + taskId + ', \'In Progress\')">' +
            '<i class="fa fa-play"></i> Start' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-info btn-xs" ' +
            'onclick="openEmployeeWorkNote(' + taskId + ', \'General\')">' +
            '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-default btn-xs" ' +
            'onclick="openEmployeeTimeline(' + taskId + ')">' +
            '<i class="fa fa-history"></i> Timeline' +
            '</button>';
    }

    else if (
        status === 'rework' ||
        status === 'qc rework' ||
        status === 'rejected'
    ) {

        html +=
            '<button type="button" class="btn btn-warning btn-xs" ' +
            'onclick="changeTaskStatus(' + taskId + ', \'In Progress\')">' +
            '<i class="fa fa-refresh"></i> Start Rework' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-info btn-xs" ' +
            'onclick="openEmployeeWorkNote(' + taskId + ', \'Rework\')">' +
            '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-default btn-xs" ' +
            'onclick="openEmployeeTimeline(' + taskId + ')">' +
            '<i class="fa fa-history"></i> Timeline' +
            '</button>';
    }

    else if (
        status === 'in progress' ||
        status === 'started' ||
        status === 'working'
    ) {

        html +=
            '<button type="button" class="btn btn-warning btn-xs" ' +
            'onclick="openStatusNote(' + taskId + ', \'Hold\', \'Hold Reason\')">' +
            '<i class="fa fa-pause"></i> Hold' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-success btn-xs" ' +
            'onclick="openStatusNote(' + taskId + ', \'Completed\', \'Completion\')">' +
            '<i class="fa fa-check"></i> Complete' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-info btn-xs" ' +
            'onclick="openEmployeeWorkNote(' + taskId + ', \'General\')">' +
            '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-default btn-xs" ' +
            'onclick="openEmployeeTimeline(' + taskId + ')">' +
            '<i class="fa fa-history"></i> Timeline' +
            '</button>';
    }

    else if (status === 'hold' || status === 'on hold') {

        html +=
            '<button type="button" class="btn btn-success btn-xs" ' +
            'onclick="changeTaskStatus(' + taskId + ', \'In Progress\')">' +
            '<i class="fa fa-play"></i> Resume' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-info btn-xs" ' +
            'onclick="openEmployeeWorkNote(' + taskId + ', \'General\')">' +
            '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-default btn-xs" ' +
            'onclick="openEmployeeTimeline(' + taskId + ')">' +
            '<i class="fa fa-history"></i> Timeline' +
            '</button>';
    }

    else if (
        status === 'completed' ||
        status === 'production completed'
    ) {

        html +=
            '<button type="button" class="btn btn-info btn-xs" ' +
            'onclick="openEmployeeWorkNote(' + taskId + ', \'General\')">' +
            '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ';

        html +=
            '<button type="button" class="btn btn-default btn-xs" ' +
            'onclick="openEmployeeTimeline(' + taskId + ')">' +
            '<i class="fa fa-history"></i> Timeline' +
            '</button>';
    }

    else {

        // Always keep Timeline available
        html +=
            '<button type="button" class="btn btn-default btn-xs" ' +
            'onclick="openEmployeeTimeline(' + taskId + ')">' +
            '<i class="fa fa-history"></i> Timeline' +
            '</button>';

        console.warn(
            'Unknown CNC employee task status:',
            row.status,
            row
        );
    }

    return html;
}


function changeTaskStatus(
    taskId,
    newStatus
)
{

    var message =
        'Change task status to "' +
        newStatus +
        '"?';


    if (!confirm(message)) {

        return;
    }


    $.ajax({

        url:
            '<?php echo site_url("Production/update_cnc_task_status"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id: taskId,

            status: newStatus,

            remarks:
                'Status changed by CNC employee.'

        },

        success: function (response) {

            if (response.status) {

                alert(
                    response.message
                );

                loadCncEmployeeTasks();

            } else {

                alert(
                    response.message ||
                    'Unable to update task status.'
                );

            }

        },

        error: function () {

            alert(
                'Server error while updating task status.'
            );

        }

    });

}

function viewTaskHistory(taskId)
{

    $.ajax({

        url:
            '<?php echo site_url("Production/get_cnc_task_status_history"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id: taskId

        },

        success: function (response) {

            var tbody =
                $('#statusHistoryTable tbody');

            tbody.empty();


            if (
                !response.status ||
                !response.data ||
                response.data.length === 0
            ) {

                tbody.append(

                    '<tr>' +

                        '<td colspan="6" class="text-center">' +

                            'No status history found.' +

                        '</td>' +

                    '</tr>'

                );

            } else {

                $.each(
                    response.data,
                    function (index, row) {

                        tbody.append(

                            '<tr>' +

                                '<td>' +
                                    (index + 1) +
                                '</td>' +

                                '<td>' +
                                    escapeHtml(
                                        row.old_status || '-'
                                    ) +
                                '</td>' +

                                '<td>' +
                                    escapeHtml(
                                        row.new_status || '-'
                                    ) +
                                '</td>' +

                                '<td>' +
                                    escapeHtml(
                                        row.changed_by_name || '-'
                                    ) +
                                '</td>' +

                                '<td>' +
                                    escapeHtml(
                                        row.remarks || '-'
                                    ) +
                                '</td>' +

                                '<td>' +
                                    escapeHtml(
                                        row.changed_at || '-'
                                    ) +
                                '</td>' +

                            '</tr>'

                        );

                    }
                );

            }

            $('#statusHistoryModal').modal('show');

        },

        error: function () {

            alert(
                'Unable to load task history.'
            );

        }

    });

}

function getStatusBadge(status)
{

    status =
        $.trim(status || '');


    if (status === 'Pending') {

        return (
            '<span class="label label-default">' +
                'Pending' +
            '</span>'
        );

    }


    if (status === 'In Progress') {

        return (
            '<span class="label label-primary">' +
                'In Progress' +
            '</span>'
        );

    }


    if (status === 'Hold') {

        return (
            '<span class="label label-warning">' +
                'Hold' +
            '</span>'
        );

    }


    if (status === 'Completed') {

        return (
            '<span class="label label-success">' +
                'Completed' +
            '</span>'
        );

    }


    return (
        '<span class="label label-default">' +
            escapeHtml(status) +
        '</span>'
    );
}


function escapeHtml(value)
{

    if (value === null ||
        value === undefined) {

        return '';

    }


    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

/*
|--------------------------------------------------------------------------
| Open employee work note
|--------------------------------------------------------------------------
*/

function openEmployeeWorkNote(taskId, noteType)
{
    $('#employee_note_task_id')
        .val(taskId);

    $('#employee_note_type')
        .val(noteType || 'General');

    $('#employee_work_note')
        .val('');

    /*
     * Clear any previous Hold / Complete action
     */
    $('#cncEmployeeNoteModal')
        .removeData('new-status');

    $('#cncEmployeeNoteModal')
        .modal('show');
}
/*
|--------------------------------------------------------------------------
| Save employee work note
|--------------------------------------------------------------------------
*/

function saveEmployeeWorkNote()
{
    var taskId =
        $('#employee_note_task_id').val();

    var noteType =
        $('#employee_note_type').val();

    var note =
        $.trim(
            $('#employee_work_note').val()
        );

    /*
     * Status requested by Hold / Complete button
     */
    var newStatus =
        $('#cncEmployeeNoteModal').data('new-status') || '';


    if (!taskId) {

        alert('Task ID is missing.');

        return;
    }


    if (!note) {

        alert('Please enter a work note.');

        $('#employee_work_note').focus();

        return;
    }


    /*
     * First save the work note
     */
    $.ajax({

        url:
            '<?php echo site_url("Production/save_cnc_task_note"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {

            task_id: taskId,

            note_type: noteType,

            note: note,
            added_by_role:"Employee"

        },

        success: function (response) {

            if (!response.status) {

                alert(
                    response.message ||
                    'Unable to save work note.'
                );

                return;
            }


            /*
             * If this was a normal Note,
             * no status change is required.
             */
            if (!newStatus) {

                alert(
                    response.message ||
                    'Work note saved successfully.'
                );

                $('#cncEmployeeNoteModal')
                    .removeData('new-status')
                    .modal('hide');

                loadCncEmployeeTasks();

                return;
            }


            /*
             * Hold / Complete
             *
             * Now change the task status.
             */
            $.ajax({

                url:
                    '<?php echo site_url("Production/update_cnc_task_status"); ?>',

                type: 'POST',

                dataType: 'json',

                data: {

                    task_id: taskId,

                    status: newStatus,

                    remarks: note

                },

                success: function (statusResponse) {

                    if (statusResponse.status) {

                        alert(
                            statusResponse.message ||
                            'Task status updated successfully.'
                        );

                        $('#cncEmployeeNoteModal')
                            .removeData('new-status')
                            .modal('hide');

                        loadCncEmployeeTasks();

                    } else {

                        alert(
                            statusResponse.message ||
                            'Work note was saved, but status could not be updated.'
                        );

                    }

                },

                error: function () {

                    alert(
                        'Work note was saved, but server error occurred while updating status.'
                    );

                }

            });

        },

        error: function () {

            alert(
                'Server error while saving work note.'
            );

        }

    });
}

/*
|--------------------------------------------------------------------------
| Open status note
|
| Used for:
| Hold
| Complete
|--------------------------------------------------------------------------
*/

function openStatusNote(
    taskId,
    newStatus,
    noteType
)
{
    /*
     * Store the task/status temporarily.
     */
    $('#employee_note_task_id')
        .val(taskId);

    $('#employee_note_type')
        .val(noteType);

    $('#employee_work_note')
        .val('');

    /*
     * Store status on modal.
     */
    $('#cncEmployeeNoteModal')
        .data('new-status', newStatus);


    $('#cncEmployeeNoteModal').modal('show');
}


/*
|--------------------------------------------------------------------------
| When note modal is submitted
|--------------------------------------------------------------------------
*/

$('#cncEmployeeNoteModal').on(
    'click',
    '.btn-primary',
    function () {

        /*
         * This handler is intentionally handled
         * by saveEmployeeWorkNote().
         */

    }
);


/*
|--------------------------------------------------------------------------
| Timeline
|--------------------------------------------------------------------------
*/

function openEmployeeTimeline(taskId)
{
    $('#cncEmployeeTimelineContent').html(

        '<div class="text-center">' +

            '<i class="fa fa-spinner fa-spin"></i> ' +

            'Loading timeline...' +

        '</div>'

    );


    $('#cncEmployeeTimelineModal')
        .modal('show');


    loadEmployeeTimeline(taskId);
}


/*
|--------------------------------------------------------------------------
| Load timeline
|--------------------------------------------------------------------------
*/


function loadEmployeeTimeline(taskId)
{
    console.log('Employee Timeline Task ID:', taskId);

    $('#cncEmployeeTimelineContent').html(
        '<div class="text-center">' +
            '<i class="fa fa-spinner fa-spin"></i> Loading timeline...' +
        '</div>'
    );

    $.ajax({

        url: '<?php echo site_url("Production/get_cnc_task_timeline"); ?>',

        type: 'POST',

        data: {
            task_id: taskId
        },

        dataType: 'json',

        success: function (response) {

            console.log('Employee Timeline Response:', response);

            var container =
                $('#cncEmployeeTimelineContent');

            container.empty();


            /*
             * NO DATA
             */
            if (
                !response ||
                !response.status ||
                !response.data ||
                !response.data.length
            ) {

                container.html(

                    '<div class="alert alert-info">' +

                        '<i class="fa fa-info-circle"></i> ' +

                        'No timeline entries found.' +

                    '</div>'

                );

                return;
            }


            var html = '';


            $.each(
                response.data,
                function (index, row) {

                    console.log(
                        'Timeline Row:',
                        row
                    );


                    var entryType =
                        row.entry_type || 'status';


                    /*
                     * =====================================================
                     * PERSON
                     * =====================================================
                     */
                    var personName =
                        row.employee_name ||
                        row.created_by_name ||
                        row.user_name ||
                        'System';


                    /*
                     * =====================================================
                     * ROLE
                     * =====================================================
                     */
                    var addedByRole =
                        row.added_by_role ||
                        'Employee';


                    /*
                     * =====================================================
                     * STATUS ENTRY
                     * =====================================================
                     */
                    if (entryType === 'status') {

                        var fromStatus =
                            row.from_status || '-';

                        var toStatus =
                            row.to_status || '-';


                        html +=

                            '<div class="panel panel-default">' +

                                '<div class="panel-heading">' +

                                    '<strong>' +

                                        '<i class="fa fa-refresh"></i> ' +

                                        'Status Changed' +

                                    '</strong>' +

                                    '<span class="pull-right text-muted">' +

                                        escapeHtml(
                                            row.created_at || '-'
                                        ) +

                                    '</span>' +

                                '</div>' +


                                '<div class="panel-body">' +

                                    '<div style="margin-bottom:10px;">' +

                                        '<strong>From:</strong> ' +

                                        '<span class="label label-default">' +

                                            escapeHtml(
                                                fromStatus
                                            ) +

                                        '</span>' +

                                        ' &nbsp; ' +

                                        '<i class="fa fa-arrow-right"></i>' +

                                        ' &nbsp; ' +

                                        '<strong>To:</strong> ' +

                                        '<span class="label label-primary">' +

                                            escapeHtml(
                                                toStatus
                                            ) +

                                        '</span>' +

                                    '</div>' +


                                    '<div style="margin-bottom:8px;">' +

                                        '<i class="fa fa-user"></i> ' +

                                        '<strong>' +

                                            escapeHtml(
                                                personName
                                            ) +

                                        '</strong>' +

                                    '</div>' +


                                    (
                                        row.note

                                        ? '<div>' +

                                            '<strong>Note:</strong><br>' +

                                            escapeHtml(
                                                row.note
                                            ) +

                                          '</div>'

                                        : ''

                                    ) +

                                '</div>' +

                            '</div>';

                    }


                    /*
                     * =====================================================
                     * NOTE ENTRY
                     * =====================================================
                     */
                    else {

                        var roleClass =
                            (
                                addedByRole.toLowerCase() ===
                                'supervisor'
                            )
                            ? 'primary'
                            : 'success';


                        html +=

                            '<div class="panel panel-info">' +

                                '<div class="panel-heading">' +

                                    '<strong>' +

                                        '<i class="fa fa-sticky-note-o"></i> ' +

                                        escapeHtml(
                                            row.note_type ||
                                            'Work Note'
                                        ) +

                                    '</strong>' +


                                    '<span class="label label-' +
                                        roleClass +
                                        '" style="margin-left:8px;">' +

                                        escapeHtml(
                                            addedByRole
                                        ) +

                                    '</span>' +


                                    '<span class="pull-right text-muted">' +

                                        escapeHtml(
                                            row.created_at || '-'
                                        ) +

                                    '</span>' +

                                '</div>' +


                                '<div class="panel-body">' +

                                    '<div style="margin-bottom:10px;">' +

                                        '<i class="fa fa-user"></i> ' +

                                        '<strong>' +

                                            escapeHtml(
                                                personName
                                            ) +

                                        '</strong>' +

                                    '</div>' +


                                    '<div style="margin-bottom:10px;">' +

                                        '<strong>Type:</strong> ' +

                                        escapeHtml(
                                            row.note_type ||
                                            'General'
                                        ) +

                                    '</div>' +


                                    '<div>' +

                                        escapeHtml(
                                            row.note || '-'
                                        ) +

                                    '</div>' +

                                '</div>' +

                            '</div>';

                    }

                }
            );


            container.html(html);

        },


        error: function (xhr, status, error) {

            console.log(
                'Timeline AJAX Error:',
                status,
                error
            );

            console.log(
                'Timeline Response:',
                xhr.responseText
            );


            $('#cncEmployeeTimelineContent').html(

                '<div class="alert alert-danger">' +

                    '<i class="fa fa-exclamation-triangle"></i> ' +

                    '<strong>Unable to load timeline.</strong><br>' +

                    '<small>' +

                        escapeHtml(
                            xhr.responseText ||
                            error ||
                            'Unknown error'
                        ) +

                    '</small>' +

                '</div>'

            );

        }

    });
}



</script>