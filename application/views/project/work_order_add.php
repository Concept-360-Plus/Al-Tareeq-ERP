
<link href="<?php echo base_url(); ?>public/build/css/popup.css" rel="stylesheet">

<style type="text/css">

    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 220px !important;
        min-width: 220px !important;
    }

    label {
        font-weight: bold;
    }

    h4 {
        color: black;
        font-weight: bold;
    }

    table th,
    table td {
        vertical-align: middle !important;
    }

    .btn-sm .fa {
        color: #fff;
    }

    .table {
        width: 65% !important;
    }

    .col-form-label {
        font-weight: normal;
    }

    .min {
        margin-left: -7px;
    }

    .project-info-card {
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #fff;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .project-info-header {
        padding: 10px 15px;
        background: #f5f5f5;
        border-bottom: 1px solid #ddd;
        font-size: 15px;
        font-weight: bold;
    }

    .project-info-header i {
        margin-right: 7px;
    }

    .project-info-body {
        padding: 15px;
    }

    .project-info-item {
        margin-bottom: 5px;
    }

    .project-info-item label {
        display: block;
        font-size: 12px;
        color: #777;
        margin-bottom: 5px;
    }

    .project-info-value {
        min-height: 32px;
        padding: 7px 10px;
        background: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        color: #333;
    }

    .ajax-error {
        color: #d9534f;
        font-size: 12px;
    }

</style>


<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12">

        <div class="x_panel">

            <div class="x_content">

                <form
                    id="main"
                    method="post"
                    action="<?php echo base_url('index.php/Project/add_work_order_details'); ?>"
                    autocomplete="off"
                    enctype="multipart/form-data"
                >

                    <!-- ===================================================== -->
                    <!-- PROJECT / HANDED OVER -->
                    <!-- ===================================================== -->

                    <div class="form-group row">

                        <label class="col-md-1 col-form-label">
                            Project:<span style="color:red;"> *</span>
                        </label>

                        <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">

                            <select
                                tabindex="1"
                                class="form-select form-control select2"
                                id="project_id"
                                name="project_id"
                                required
                            >
                                <option value="">Select</option>

                                <?php foreach ($records as $s) { ?>

                                    <option value="<?php echo $s->project_id; ?>">
                                        <?php
                                        echo $s->project_code . ' ' . $s->project_name;
                                        ?>
                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <label
                            class="col-md-1 col-form-label"
                            style="padding-right:5px;"
                        >
                            <nobr>Handed over to:</nobr>
                        </label>

                        <div class="col-md-3" style="padding-left:15px;">

                            <select
                                tabindex="2"
                                class="form-select form-control"
                                id="handed_over_to"
                                name="handed_over_to"
                            >

                                <option value="">Select</option>

                                <?php foreach ($user_records as $s) { ?>

                                    <option value="<?php echo $s->user_id; ?>">
                                        <?php echo $s->user_name; ?>
                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                    </div>


                    <!-- ===================================================== -->
                    <!-- WORK ORDER DATE / CODE -->
                    <!-- ===================================================== -->

                    <div class="form-group row">

                        <label class="col-md-1 col-form-label">
                            <nobr>Work Order Date:</nobr>
                        </label>

                        <div class="col-md-3 col-lg-3">

                            <div class="input-group date">

                                <input
                                    type="date"
                                    class="form-control datepicker1"
                                    id="work_order_date"
                                    name="work_order_date"
                                    value=""
                                    tabindex="3"
                                >

                            </div>

                        </div>


                        <label class="col-md-1 col-form-label">
                            <nobr>
                                Work Order Code:
                                <span style="color:red;"> *</span>
                            </nobr>
                        </label>

                        <div class="col-md-3" style="padding-left:15px;">

                            <input
                                type="text"
                                name="wo_code"
                                id="wo_code"
                                class="form-control bg-soft-gray"
                                value="<?php echo $code; ?>"
                                required
                            >

                        </div>

                    </div>


                    <!-- ===================================================== -->
                    <!-- PROJECT INFORMATION -->
                    <!-- ===================================================== -->

                    <div class="row">

                        <div class="col-md-8">

                            <div class="project-info-card">

                                <div class="project-info-header">

                                    <i class="fa fa-folder-open"></i>

                                    <span>Project Information</span>

                                </div>


                                <div class="project-info-body">

                                    <div class="row">

                                        <!-- Project Start Date -->

                                        <div class="col-md-3">

                                            <div class="project-info-item">

                                                <label>
                                                    Project Start Date
                                                </label>

                                                <div
                                                    id="sdate"
                                                    class="project-info-value"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>


                                        <!-- Project End Date -->

                                        <div class="col-md-3">

                                            <div class="project-info-item">

                                                <label>
                                                    Project End Date
                                                </label>

                                                <div
                                                    id="edate"
                                                    class="project-info-value"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>


                                        <!-- Project Manager -->

                                        <div class="col-md-3">

                                            <div class="project-info-item">

                                                <label>
                                                    Project Manager
                                                </label>

                                                <div
                                                    id="manager_id"
                                                    class="project-info-value"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>


                                        <!-- Customer -->

                                        <div class="col-md-3">

                                            <div class="project-info-item">

                                                <label>
                                                    Customer
                                                </label>

                                                <div
                                                    id="customer_id"
                                                    class="project-info-value"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="clearfix"></div>


                    <!-- ===================================================== -->
                    <!-- PROJECT ITEMS -->
                    <!-- ===================================================== -->

                    <div class="row">

                        <div class="col-md-12">

                            <div id="item_list_id"></div>

                        </div>

                    </div>


                    <!-- ===================================================== -->
                    <!-- WORK ORDER ATTACHMENTS -->
                    <!-- ===================================================== -->

                    <div class="row">

                        <div class="col-md-12">

                            <h7 class="min">
                                <strong>Work Order Attachments:</strong>
                            </h7>


                            <div class="form-group row">

                                <table
                                    class="table table-bordered table-hover"
                                    id="tab_logic1"
                                >

                                    <thead>

                                        <tr>

                                            <th></th>

                                            <th>
                                                Upload
                                                ("jpeg","jpg","png","doc","pdf")
                                                <span style="color:red;"> *</span>
                                            </th>

                                            <th>
                                                Select Type
                                            </th>

                                            <th style="width:12%;">

                                                <div class="row">

                                                    &nbsp;

                                                    <a
                                                        id="add_row1"
                                                        title="Add"
                                                        class="btn btn-sm bg-red"
                                                        href="javascript:void(0);"
                                                    >
                                                        <span class="fa fa-plus"></span>
                                                    </a>

                                                    &nbsp;

                                                    <a
                                                        id="delete_row1"
                                                        title="Delete"
                                                        class="btn btn-sm btn-primary"
                                                        href="javascript:void(0);"
                                                    >
                                                        <span class="fa fa-trash"></span>
                                                    </a>

                                                </div>

                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody id="mytbbody1">

                                        <tr id="r0">

                                            <td>1</td>


                                            <td>

                                                <div class="col-sm-8">

                                                    <input
                                                        class="form-control"
                                                        id="documents_res0"
                                                        name="documents_res[]"
                                                        tabindex="6"
                                                        type="file"
                                                        required
                                                    >

                                                </div>

                                            </td>


                                            <td>

                                                <div class="form-group row">

                                                    <div class="col-sm-10">

                                                        <select
                                                            class="form-select form-control"
                                                            name="wo_attachments[]"
                                                            id="wo_attachments0"
                                                        >

                                                            <option
                                                                value=""
                                                                selected
                                                                disabled
                                                            >
                                                                Please select type
                                                            </option>

                                                            <option value="Cutting List">
                                                                Cutting List
                                                            </option>

                                                            <option value="Optimization">
                                                                Optimization
                                                            </option>

                                                            <option value="Material Allocation">
                                                                Material Allocation
                                                            </option>

                                                            <option value="Indent To Stores">
                                                                Indent To Stores
                                                            </option>

                                                            <option value="Fabrication Details">
                                                                Fabrication Details
                                                            </option>

                                                            <option value="Templates/Samples">
                                                                Templates/Samples
                                                            </option>

                                                            <option value="Shop Drawing">
                                                                Shop Drawing
                                                            </option>

                                                        </select>

                                                    </div>

                                                </div>

                                            </td>


                                            <td></td>

                                        </tr>


                                        <tr id="r1"></tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                    <!-- ===================================================== -->
                    <!-- PREPARED / CHECKED / APPROVED -->
                    <!-- ===================================================== -->

                    <div class="row">

                        <div class="col-md-10">

                            <div class="form-group row">


                                <!-- Prepared By -->

                                <label
                                    class="col-md-1 col-form-label"
                                    style="padding-right:5px;"
                                >
                                    <nobr>Prepared By:</nobr>
                                </label>

                                <div
                                    class="col-md-2"
                                    style="padding-left:15px;"
                                >

                                    <select
                                        tabindex="10"
                                        class="form-select form-control"
                                        id="prepared_id"
                                        name="prepared_id"
                                        required
                                        style="width:150px;"
                                    >

                                        <option value="">
                                            Select
                                        </option>

                                        <?php foreach ($user_records as $s) { ?>

                                            <option value="<?php echo $s->user_id; ?>">
                                                <?php echo $s->user_name; ?>
                                            </option>

                                        <?php } ?>

                                    </select>

                                </div>


                                <!-- Checked By -->

                                <label
                                    class="col-md-1 col-form-label"
                                    style="padding-right:5px;"
                                >
                                    <nobr>Checked By:</nobr>
                                </label>

                                <div
                                    class="col-md-2"
                                    style="padding-left:15px;"
                                >

                                    <select
                                        tabindex="11"
                                        class="form-select form-control"
                                        id="checked_id"
                                        name="checked_id"
                                        required
                                        style="width:150px;"
                                    >

                                        <option value="">
                                            Select
                                        </option>

                                        <?php foreach ($user_records as $s) { ?>

                                            <option value="<?php echo $s->user_id; ?>">
                                                <?php echo $s->user_name; ?>
                                            </option>

                                        <?php } ?>

                                    </select>

                                </div>


                                <!-- Approved By -->

                                <label
                                    class="col-md-1 col-form-label"
                                    style="padding-right:5px;"
                                >
                                    <nobr>Approved By:</nobr>
                                </label>

                                <div
                                    class="col-md-2"
                                    style="padding-left:15px;"
                                >

                                    <select
                                        tabindex="12"
                                        class="form-select form-control"
                                        id="approved_id"
                                        name="approved_id"
                                        style="width:150px;"
                                    >

                                        <option value="">
                                            Select
                                        </option>

                                        <?php foreach ($user_records as $s) { ?>

                                            <option value="<?php echo $s->user_id; ?>">
                                                <?php echo $s->user_name; ?>
                                            </option>

                                        <?php } ?>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ===================================================== -->
                    <!-- SUBMIT -->
                    <!-- ===================================================== -->

                    <div class="row">

                        <div class="col-md-10 text-end">

                            <button
                                type="submit"
                                tabindex="502"
                                id="add"
                                class="btn btn-success"
                            >
                                Submit
                            </button>

                        </div>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<script>

$(document).ready(function () {

    /* =========================================================
     * SELECT2
     * ========================================================= */

    $('.select2').select2({
        placeholder: '-- Select Project --',
        allowClear: true,
        width: '100%'
    });


    /* =========================================================
     * PROJECT CHANGE
     * ========================================================= */

    $('#project_id').on('change', function () {

        var project_id = $(this).val();

        /*
         * Clear previous information first
         */
        $('#sdate').text('-');
        $('#edate').text('-');
        $('#manager_id').text('-');
        $('#customer_id').text('-');

        $('#item_list_id').html('');

        /*
         * No project selected
         */
        if (project_id === '') {
            return;
        }

        /*
         * Load project information
         */
        get_project_info(project_id);

        /*
         * Load project items
         */
        get_project_items_list(project_id);

    });


    /* =========================================================
     * WORK ORDER ATTACHMENTS
     * ========================================================= */

    var attachmentIndex = 1;


    $('#add_row1').on('click', function (e) {

        e.preventDefault();

        var rowHtml = '';

        rowHtml += '<tr id="r' + attachmentIndex + '">';

        rowHtml += '<td>' + (attachmentIndex + 1) + '</td>';

        rowHtml += '<td>';

        rowHtml += '<div class="col-sm-8">';

        rowHtml += '<input ';
        rowHtml += 'class="form-control" ';
        rowHtml += 'id="documents_res' + attachmentIndex + '" ';
        rowHtml += 'name="documents_res[]" ';
        rowHtml += 'type="file" ';
        rowHtml += '>';

        rowHtml += '</div>';

        rowHtml += '</td>';


        rowHtml += '<td>';

        rowHtml += '<div class="col-sm-10">';

        rowHtml += '<select ';
        rowHtml += 'class="form-select form-control" ';
        rowHtml += 'name="wo_attachments[]" ';
        rowHtml += 'id="wo_attachments' + attachmentIndex + '">';

        rowHtml += '<option value="" selected disabled>';
        rowHtml += 'Please select type';
        rowHtml += '</option>';

        rowHtml += '<option value="Cutting List">Cutting List</option>';
        rowHtml += '<option value="Optimization">Optimization</option>';
        rowHtml += '<option value="Material Allocation">Material Allocation</option>';
        rowHtml += '<option value="Indent To Stores">Indent To Stores</option>';
        rowHtml += '<option value="Fabrication Details">Fabrication Details</option>';
        rowHtml += '<option value="Templates/Samples">Templates/Samples</option>';
        rowHtml += '<option value="Shop Drawing">Shop Drawing</option>';

        rowHtml += '</select>';

        rowHtml += '</div>';

        rowHtml += '</td>';

        rowHtml += '<td></td>';

        rowHtml += '</tr>';


        $('#r' + attachmentIndex).before(rowHtml);

        attachmentIndex++;

    });


    $('#delete_row1').on('click', function (e) {

        e.preventDefault();

        /*
         * Keep first row
         */
        if (attachmentIndex <= 1) {
            return;
        }

        attachmentIndex--;

        $('#r' + attachmentIndex).remove();

    });

});


/* =========================================================
 * GET PROJECT INFORMATION
 * ========================================================= */

function get_project_info(project_id)
{
    if (!project_id) {

        $('#sdate').text('-');
        $('#edate').text('-');
        $('#manager_id').text('-');
        $('#customer_id').text('-');

        return;
    }


    $.ajax({

        type: 'POST',

        url: "<?php echo site_url('Project/get_project_items_details'); ?>",

        data: {
            project_id: project_id
        },

        dataType: 'json',

        beforeSend: function () {

            $('#sdate').text('Loading...');
            $('#edate').text('Loading...');
            $('#manager_id').text('Loading...');
            $('#customer_id').text('Loading...');

        },

        success: function (msg) {

            console.log('Project Information:', msg);


            /*
             * Important:
             *
             * These fields are DIV elements.
             * Therefore use .text() instead of .val().
             */


            $('#customer_id').text(
                msg.customer_name ||
                msg.customer ||
                msg.customer_id ||
                '-'
            );


            $('#manager_id').text(
                msg.manager_name ||
                msg.manager ||
                msg.user_name ||
                msg.user_id ||
                '-'
            );


            $('#sdate').text(
                msg.sdate ||
                msg.start_date ||
                '-'
            );


            $('#edate').text(
                msg.edate ||
                msg.end_date ||
                '-'
            );

        },

        error: function (xhr, status, error) {

            console.error(
                'Project Information AJAX Error:',
                status,
                error
            );

            console.error(
                'Response:',
                xhr.responseText
            );


            $('#sdate').text('-');
            $('#edate').text('-');
            $('#manager_id').text('-');
            $('#customer_id').text('-');


            /*
             * Uncomment this if you want the error
             * visible in the page while debugging.
             */

            // $('#customer_id').html(
            //     '<span class="ajax-error">Unable to load project information</span>'
            // );

        }

    });

}


/* =========================================================
 * GET PROJECT ITEMS
 * ========================================================= */

function get_project_items_list(project_id)
{

    if (!project_id) {

        $('#item_list_id').html('');

        return;
    }


    $.ajax({

        type: 'POST',

        url: "<?php echo site_url('Project/get_project_items_list'); ?>",

        data: {
            project_id: project_id
        },

        beforeSend: function () {

            $('#item_list_id').html(
                '<div class="text-center">Loading project items...</div>'
            );

        },

        success: function (response) {

            $('#item_list_id').html(response);

        },

        error: function (xhr, status, error) {

            console.error(
                'Project Items AJAX Error:',
                status,
                error
            );

            console.error(
                'Response:',
                xhr.responseText
            );

            $('#item_list_id').html(
                '<div class="alert alert-danger">' +
                'Unable to load project items.' +
                '</div>'
            );

        }

    });

}


/* =========================================================
 * OPTIONAL:
 * OLD FUNCTION NAME
 *
 * If another part of your existing page calls
 * get_project_items_details(), keep this wrapper.
 * ========================================================= */

function get_project_items_details()
{
    var project_id = $('#project_id').val();

    if (!project_id) {
        return;
    }

    get_project_info(project_id);
    get_project_items_list(project_id);
}

</script>
