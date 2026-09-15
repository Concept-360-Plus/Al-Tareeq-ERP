<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="x_panel">

                <div class="x_title">

                    <h2>
                        <i class="fa fa-cogs"></i>
                        Bending Employee Tasks
                    </h2>

                    <div class="clearfix"></div>

                </div>


                <div class="x_content">

                    <div class="alert alert-info">

                        <strong>
                            <i class="fa fa-user"></i>
                            My Bending Tasks
                        </strong>

                        <span class="pull-right">
                            Only tasks assigned to you are displayed.
                        </span>

                    </div>


                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped"
                            id="bendingEmployeeTaskTable"
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


    <!-- =====================================================
         STATUS HISTORY
         ===================================================== -->

    <div
        class="modal fade"
        id="bendingStatusHistoryModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-lg"
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

                        <i class="fa fa-history"></i>

                        Task Status History

                    </h4>

                </div>


                <div class="modal-body">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped"
                            id="bendingStatusHistoryTable"
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


    <!-- =====================================================
         WORK NOTE
         ===================================================== -->

    <div
        class="modal fade"
        id="bendingEmployeeNoteModal"
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

                        <i class="fa fa-sticky-note-o"></i>

                        Work Note

                    </h4>

                </div>


                <div class="modal-body">

                    <input
                        type="hidden"
                        id="bending_employee_note_task_id"
                    >


                    <div class="form-group">

                        <label>
                            Note Type
                        </label>

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
                        </label>

                        <textarea
                            id="bending_employee_work_note"
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
         TIMELINE
         ===================================================== -->

    <div
        class="modal fade"
        id="bendingEmployeeTimelineModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-lg"
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

                        <i class="fa fa-clock-o"></i>

                        Task Timeline

                    </h4>

                </div>


                <div class="modal-body">

                    <div
                        id="bendingEmployeeTimelineTaskInfo"
                        class="alert alert-info"
                    >
                    </div>


                    <div
                        id="bendingEmployeeTimelineLoading"
                        class="text-center"
                    >

                        <i class="fa fa-spinner fa-spin"></i>

                        Loading timeline...

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
                    >
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

    loadBendingEmployeeTasks();

});


/* =========================================================
 * LOAD TASKS
 * ========================================================= */
function loadBendingEmployeeTasks()
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_employee_tasks"); ?>',

        type: 'POST',

        dataType: 'json',

        success: function (response) {

            var tbody =
                $('#bendingEmployeeTaskTable tbody');

            tbody.empty();


            if (
                !response.status ||
                !response.data ||
                response.data.length === 0
            ) {

                tbody.append(
                    '<tr>' +
                        '<td colspan="11" class="text-center">' +
                            'No Bending tasks assigned to you.' +
                        '</td>' +
                    '</tr>'
                );

                return;
            }


            $.each(
                response.data,
                function (index, row) {

                    var action =
                        getBendingTaskAction(row);

                    var statusBadge =
                        getBendingStatusBadge(
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
                                    row.quantity || '0'
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

                            '<td style="white-space:nowrap;">' +
                                action +
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
                'Unable to load Bending tasks.'
            );

        }

    });
}


/* =========================================================
 * TASK ACTIONS
 * ========================================================= */
function getBendingTaskAction(row)
{
    var status =
        $.trim(row.status || '');

    var taskId =
        parseInt(row.task_id);


    /*
     * PENDING
     */
    if (status === 'Pending') {

        return (

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-success" ' +
                'onclick="openBendingStatusNote(' +
                    taskId +
                    ', \'In Progress\', \'General\')" ' +
            '>' +
                '<i class="fa fa-play"></i> Start' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-info" ' +
                'onclick="openBendingEmployeeNote(' +
                    taskId +
                ')" ' +
            '>' +
                '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-default" ' +
                'onclick="openBendingEmployeeTimeline(' +
                    taskId +
                    ', \'' +
                    escapeJs(
                        row.task_description || ''
                    ) +
                    '\')" ' +
            '>' +
                '<i class="fa fa-clock-o"></i> Timeline' +
            '</button>'

        );
    }


    /*
     * REWORK
     */
    if (
        status === 'Rework' ||
        status === 'QC Rework' ||
        status === 'Rejected'
    ) {

        return (

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-warning" ' +
                'onclick="openBendingStatusNote(' +
                    taskId +
                    ', \'In Progress\', \'Rework\')" ' +
            '>' +
                '<i class="fa fa-refresh"></i> Start Rework' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-info" ' +
                'onclick="openBendingEmployeeNote(' +
                    taskId +
                ')" ' +
            '>' +
                '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button>'

        );
    }


    /*
     * IN PROGRESS
     */
    if (status === 'In Progress') {

        return (

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-warning" ' +
                'onclick="openBendingStatusNote(' +
                    taskId +
                    ', \'Hold\', \'Hold Reason\')" ' +
            '>' +
                '<i class="fa fa-pause"></i> Hold' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-primary" ' +
                'onclick="openBendingStatusNote(' +
                    taskId +
                    ', \'Completed\', \'Completion\')" ' +
            '>' +
                '<i class="fa fa-check"></i> Complete' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-info" ' +
                'onclick="openBendingEmployeeNote(' +
                    taskId +
                ')" ' +
            '>' +
                '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-default" ' +
                'onclick="openBendingEmployeeTimeline(' +
                    taskId +
                    ', \'' +
                    escapeJs(
                        row.task_description || ''
                    ) +
                    '\')" ' +
            '>' +
                '<i class="fa fa-clock-o"></i> Timeline' +
            '</button>'

        );
    }


    /*
     * HOLD
     */
    if (status === 'Hold') {

        return (

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-success" ' +
                'onclick="openBendingStatusNote(' +
                    taskId +
                    ', \'In Progress\', \'General\')" ' +
            '>' +
                '<i class="fa fa-play"></i> Resume' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-info" ' +
                'onclick="openBendingEmployeeNote(' +
                    taskId +
                ')" ' +
            '>' +
                '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button>'

        );
    }


    /*
     * COMPLETED
     */
    if (status === 'Completed') {

        return (

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-info" ' +
                'onclick="openBendingEmployeeNote(' +
                    taskId +
                ')" ' +
            '>' +
                '<i class="fa fa-sticky-note-o"></i> Note' +
            '</button> ' +

            '<button ' +
                'type="button" ' +
                'class="btn btn-xs btn-default" ' +
                'onclick="openBendingEmployeeTimeline(' +
                    taskId +
                    ', \'' +
                    escapeJs(
                        row.task_description || ''
                    ) +
                    '\')" ' +
            '>' +
                '<i class="fa fa-clock-o"></i> Timeline' +
            '</button>'

        );
    }


    return '-';
}


/* =========================================================
 * STATUS NOTE
 *
 * Hold and Complete MUST have a note.
 * ========================================================= */
function openBendingStatusNote(
    taskId,
    newStatus,
    noteType
)
{
    $('#bendingEmployeeNoteModal')
        .data(
            'new-status',
            newStatus
        );

    $('#bendingEmployeeNoteModal')
        .data(
            'status-note',
            true
        );

    $('#bending_employee_note_task_id')
        .val(taskId);

    $('#bending_employee_note_type')
        .val(noteType);

    $('#bending_employee_work_note')
        .val('');

    $('#bendingEmployeeNoteModal')
        .modal('show');
}


/* =========================================================
 * NORMAL NOTE
 * ========================================================= */
function openBendingEmployeeNote(taskId)
{
    $('#bendingEmployeeNoteModal')
        .data(
            'new-status',
            ''
        );

    $('#bendingEmployeeNoteModal')
        .data(
            'status-note',
            false
        );

    $('#bending_employee_note_task_id')
        .val(taskId);

    $('#bending_employee_note_type')
        .val('General');

    $('#bending_employee_work_note')
        .val('');

    $('#bendingEmployeeNoteModal')
        .modal('show');
}


/* =========================================================
 * SAVE NOTE
 * ========================================================= */
$('#saveBendingEmployeeNote').on(
    'click',
    function ()
    {
        var button = $(this);

        var taskId =
            $('#bending_employee_note_task_id')
                .val();

        var noteType =
            $('#bending_employee_note_type')
                .val();

        var note =
            $.trim(
                $('#bending_employee_work_note')
                    .val()
            );

        var newStatus =
            $('#bendingEmployeeNoteModal')
                .data('new-status');


        if (!taskId) {

            alert(
                'Invalid Bending task.'
            );

            return;
        }


        if (!note) {

            alert(
                'Please enter a note.'
            );

            $('#bending_employee_work_note')
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
                '<?php echo site_url("Production/save_bending_task_note"); ?>',

            type: 'POST',

            data: {
                task_id: taskId,
                note_type: noteType,
                note: note
            },

            dataType: 'json',

            success: function (response) {

                if (!response.status) {

                    alert(
                        response.message ||
                        'Unable to save note.'
                    );

                    return;
                }


                /*
                 * If this note is attached to a status
                 * change, change status AFTER note saves.
                 */
                if (newStatus) {

                    $.ajax({

                        url:
                            '<?php echo site_url("Production/update_bending_task_status"); ?>',

                        type: 'POST',

                        dataType: 'json',

                        data: {

                            task_id: taskId,

                            status: newStatus,

                            remarks: note

                        },

                        success: function (statusResponse) {

                            if (
                                statusResponse.status
                            ) {

                                alert(
                                    statusResponse.message ||
                                    'Task updated successfully.'
                                );

                                $('#bendingEmployeeNoteModal')
                                    .modal('hide');

                                loadBendingEmployeeTasks();

                            } else {

                                alert(
                                    statusResponse.message ||
                                    'Note saved, but status update failed.'
                                );

                            }

                        },

                        error: function () {

                            alert(
                                'Note saved, but status update failed.'
                            );

                        }

                    });

                } else {

                    alert(
                        'Work note saved successfully.'
                    );

                    $('#bendingEmployeeNoteModal')
                        .modal('hide');

                    loadBendingEmployeeTasks();

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
 * STATUS HISTORY
 * ========================================================= */
function viewBendingTaskHistory(taskId)
{
    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_task_status_history"); ?>',

        type: 'POST',

        dataType: 'json',

        data: {
            task_id: taskId
        },

        success: function (response) {

            var tbody =
                $('#bendingStatusHistoryTable tbody');

            tbody.empty();


            if (
                !response.status ||
                !response.data ||
                !response.data.length
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


            $('#bendingStatusHistoryModal')
                .modal('show');

        },

        error: function () {

            alert(
                'Unable to load task history.'
            );

        }

    });
}


/* =========================================================
 * TIMELINE
 * ========================================================= */
function openBendingEmployeeTimeline(
    taskId,
    taskDescription
)
{
    $('#bendingEmployeeTimelineTaskInfo')
        .html(
            '<strong>Task:</strong> ' +
            escapeHtml(
                taskDescription || '-'
            ) +
            ' &nbsp; | &nbsp; ' +
            '<strong>Task ID:</strong> ' +
            escapeHtml(taskId)
        );

    $('#bendingEmployeeTimeline')
        .empty();

    $('#bendingEmployeeTimelineEmpty')
        .hide();

    $('#bendingEmployeeTimelineLoading')
        .show();

    $('#bendingEmployeeTimelineModal')
        .modal('show');

    loadBendingEmployeeTimeline(taskId);
}


function loadBendingEmployeeTimeline(taskId)
{
    $('#bendingEmployeeTimelineLoading')
        .show();

    $('#bendingEmployeeTimelineEmpty')
        .hide();


    $.ajax({

        url:
            '<?php echo site_url("Production/get_bending_task_timeline"); ?>',

        type: 'POST',

        data: {
            task_id: taskId
        },

        dataType: 'json',

        success: function (response) {

            var container =
                $('#bendingEmployeeTimeline');

            container.empty();


            if (
                !response.status ||
                !response.data ||
                !response.data.length
            ) {

                $('#bendingEmployeeTimelineEmpty')
                    .show();

                return;
            }


            $.each(
                response.data,
                function (i, row) {

                    var html =
                        '<div ' +
                            'style="' +
                                'border-left:3px solid #ddd;' +
                                'padding:10px 15px;' +
                                'margin-bottom:10px;' +
                            '"' +
                        '>' +

                            '<div>' +

                                '<strong>' +
                                    escapeHtml(
                                        row.entry_type === 'status'
                                            ? 'Status Changed'
                                            : (
                                                row.note_type ||
                                                'Work Note'
                                            )
                                    ) +
                                '</strong>' +

                            '</div>';


                    if (
                        row.entry_type === 'status'
                    ) {

                        html +=

                            '<div>' +
                                escapeHtml(
                                    row.old_status || '-'
                                ) +
                                ' &rarr; ' +
                                escapeHtml(
                                    row.new_status || '-'
                                ) +
                            '</div>';

                    }


                    if (row.note) {

                        html +=

                            '<div style="margin-top:5px;">' +
                                escapeHtml(
                                    row.note
                                ) +
                            '</div>';

                    }


                    html +=

                        '<small class="text-muted">' +

                            escapeHtml(
                                row.employee_name ||
                                'System'
                            ) +

                            ' | ' +

                            escapeHtml(
                                row.created_at || '-'
                            ) +

                        '</small>' +

                    '</div>';


                    container.append(html);

                }
            );

        },

        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            $('#bendingEmployeeTimelineEmpty')
                .text(
                    'Unable to load timeline.'
                )
                .show();

        },

        complete: function () {

            $('#bendingEmployeeTimelineLoading')
                .hide();

        }

    });
}


/* =========================================================
 * STATUS BADGE
 * ========================================================= */
function getBendingStatusBadge(status)
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


    if (
        status === 'Rework' ||
        status === 'QC Rework' ||
        status === 'Rejected'
    ) {

        return (
            '<span class="label label-danger">' +
                escapeHtml(status) +
            '</span>'
        );

    }


    return (
        '<span class="label label-default">' +
            escapeHtml(status) +
        '</span>'
    );
}


/* =========================================================
 * ESCAPE HTML
 * ========================================================= */
function escapeHtml(value)
{
    if (
        value === null ||
        value === undefined
    ) {
        return '';
    }

    return String(value)

        .replace(
            /&/g,
            '&amp;'
        )

        .replace(
            /</g,
            '&lt;'
        )

        .replace(
            />/g,
            '&gt;'
        )

        .replace(
            /"/g,
            '&quot;'
        )

        .replace(
            /'/g,
            '&#039;'
        );
}


/* =========================================================
 * ESCAPE JS
 * ========================================================= */
function escapeJs(value)
{
    return String(value || '')
        .replace(
            /\\/g,
            '\\\\'
        )
        .replace(
            /'/g,
            "\\'"
        )
        .replace(
            /\r?\n/g,
            ' '
        );
}

</script>