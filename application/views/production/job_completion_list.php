<style>

/* =========================================================
 * LABEL STYLE
 * ========================================================= */
.dt-buttons{margin-top:-4px;}
.label {
    display: inline-block;
    padding: 4px 8px;
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    border-radius: 3px;
}

.label-success {
    background-color: #28a745;
}

.label-warning {
    background-color: #f0ad4e;
    color: #fff;
}

.label-danger {
    background-color: #dc3545;
}

.label-info {
    background-color: #17a2b8;
}

.label-default {
    background-color: #777;
}

.label-primary {
    background-color: #007bff;
}


/* =========================================================
 * FILTER
 * ========================================================= */

.filter-row {
    margin-top: 15px;
    margin-bottom: 15px;
}

.filter-row .form-group {
    margin-bottom: 10px;
}


/* =========================================================
 * HIDDEN FILTER COLUMN
 * ========================================================= */

.status-filter-column {
    display: none !important;
}
 /* Keep DataTable controls in one row */
.dt-top-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 15px;
}

/* Show entries */
.dt-length {
    display: flex;
    align-items: center;
}

/* Excel + Print */
.dt-buttons {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Search */
.dt-search {
    margin-left: auto;
}

.dt-search .dataTables_filter {
    margin: 0;
}

.dt-search .dataTables_filter label {
    display: flex;
    align-items: center;
    margin: 0;
}

.dt-search input {
    margin-left: 5px;
}

/* Button size */
.dt-buttons .btn {
    padding: 5px 10px;
    font-size: 13px;
}

/* Select size */
.dt-length select {
    display: inline-block;
    width: auto;
    margin: 0 5px;
}


</style>


<div class="row">

    <div class="col-md-12 col-sm-12">

        <div class="x_panel">

            <div class="x_content">

                <?php if ($this->session->flashdata('success')): ?>

                    <div class="alert alert-success">

                        <?= $this->session->flashdata('success'); ?>

                    </div>

                <?php endif; ?>


                <?php if ($this->session->flashdata('error')): ?>

                    <div class="alert alert-danger">

                        <?= $this->session->flashdata('error'); ?>

                    </div>

                <?php endif; ?>
               

                <!--<a href="<?= base_url(
                    'index.php/Production/job_completion'
                ) ?>"
                   class="btn btn-primary pull-right">

                    <i class="fa fa-plus"></i>

                    New Job Completion

                </a>-->


                <div class="row filter-row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Project
                            </label>


                            <select
                                id="projectFilter"
                                class="form-control select2"
                            >

                                <option value="">
                                    All Projects
                                </option>


                                <?php

                                /*
                                 * Build unique project list
                                 */

                                $projects = [];


                                if (!empty($job_completions)) {

                                    foreach (
                                        $job_completions as $row
                                    ) {

                                        $project_id =
                                            $row->fk_project_id
                                            ?? $row->project_id
                                            ?? '';


                                        $project_name =
                                            $row->project_name
                                            ?? '';


                                        if (
                                            $project_id !== '' &&
                                            $project_name !== ''
                                        ) {

                                            $projects[
                                                $project_id
                                            ] = $project_name;

                                        }

                                    }

                                }


                                /*
                                 * Sort by project name
                                 */

                                asort($projects);

                                ?>


                                <?php foreach (
                                    $projects as $project_id => $project_name
                                ): ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $project_id
                                        ) ?>"
                                        data-project-name="<?= htmlspecialchars(
                                            $project_name
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $project_name
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>


                            </select>

                        </div>

                    </div>



                    <!-- ============================================= -->
                    <!-- STATUS FILTER -->
                    <!-- ============================================= -->

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Status
                            </label>


                            <select
                                id="statusFilter"
                                class="form-control"
                            >

                                <option value="">
                                    All Status
                                </option>

                                <option value="Pending">
                                    Pending
                                </option>

                                <option value="Partially Completed">
                                    Partially Completed
                                </option>

                                <option value="Completed">
                                    Completed
                                </option>

                            </select>

                        </div>

                    </div>



                    <!-- ============================================= -->
                    <!-- RESET -->
                    <!-- ============================================= -->

                    <div class="col-md-2">

                        <div class="form-group">

                            <label>
                                &nbsp;
                            </label>


                            <button
                                type="button"
                                id="resetFilters"
                                class="btn btn-default form-control"
                            >

                                <i class="fa fa-refresh"></i>

                                Reset Filters

                            </button>

                        </div>

                    </div>


                </div>



                <!-- ================================================= -->
                <!-- TABLE -->
                <!-- ================================================= -->

                <div class="table-responsive">

                    <table
                        id="jobCompletionTable"
                        class="table table-bordered table-striped"
                    >

                        <thead>

                            <tr>

                                <th width="50">
                                    #
                                </th>

                                <th>
                                    Completion No
                                </th>

                                <th>
                                    Job Order
                                </th>

                                <th>
                                    Project
                                </th>

                                <th>
                                    Completion Date
                                </th>

                                <th>
                                    Completed Items
                                </th>

                                <th>
                                    Status
                                </th>

                                <!-- Hidden searchable column -->
                                <th class="status-filter-column">
                                    Status Filter
                                </th>

                                <th width="130">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                        <?php if (
                            !empty($job_completions)
                        ): ?>


                            <?php foreach (
                                $job_completions as $index => $row
                            ): ?>


                                <?php

                                /* =================================================
                                 * PROJECT ID
                                 * ================================================= */

                                $project_id =
                                    $row->fk_project_id
                                    ?? $row->project_id
                                    ?? '';


                                /* =================================================
                                 * PROJECT NAME
                                 * ================================================= */

                                $project_name =
                                    $row->project_name
                                    ?? '';


                                /* =================================================
                                 * TOTAL ORDERED
                                 * ================================================= */

                                $total_ordered =
                                    (float) (
                                        $row->total_ordered_quantity
                                        ?? 0
                                    );


                                /* =================================================
                                 * TOTAL COMPLETED
                                 * ================================================= */

                                $total_completed =
                                    (float) (
                                        $row->total_completed_quantity
                                        ?? 0
                                    );


                                /* =================================================
                                 * STATUS
                                 * ================================================= */

                                if (
                                    $total_ordered <= 0
                                ) {

                                    $status =
                                        'Pending';

                                    $status_class =
                                        'label-default';

                                } elseif (
                                    $total_completed >=
                                    $total_ordered
                                ) {

                                    $status =
                                        'Completed';

                                    $status_class =
                                        'label-success';

                                } else {

                                    $status =
                                        'Partially Completed';

                                    $status_class =
                                        'label-warning';

                                }

                                ?>


                                <tr>


                                    <!-- ================================= -->
                                    <!-- SERIAL -->
                                    <!-- ================================= -->

                                    <td>

                                        <?= $index + 1 ?>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- COMPLETION NO -->
                                    <!-- ================================= -->

                                    <td>

                                        <strong>

                                            <?= htmlspecialchars(
                                                $row->job_completion_no
                                            ) ?>

                                        </strong>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- JOB ORDER -->
                                    <!-- ================================= -->

                                    <td>

                                        <span
                                            class="label label-info"
                                        >

                                            <?= htmlspecialchars(
                                                $row->job_order_no
                                            ) ?>

                                        </span>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- PROJECT -->
                                    <!-- ================================= -->

                                    <td
                                        data-project-id="<?= htmlspecialchars(
                                            $project_id
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $project_name
                                        ) ?>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- COMPLETION DATE -->
                                    <!-- ================================= -->

                                    <td>

                                        <?php if (
                                            !empty(
                                                $row->completion_date
                                            )
                                        ): ?>

                                            <?= date(
                                                'd-m-Y',
                                                strtotime(
                                                    $row->completion_date
                                                )
                                            ) ?>

                                        <?php endif; ?>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- COMPLETED ITEMS -->
                                    <!-- ================================= -->

                                    <td>

                                        <span
                                            class="label label-primary"
                                        >

                                            <?= (int)
                                                $row->completed_items ?>

                                        </span>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- VISIBLE STATUS -->
                                    <!-- ================================= -->

                                    <td>

                                        <span
                                            class="label <?= $status_class ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $status
                                            ) ?>

                                        </span>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- HIDDEN STATUS FILTER COLUMN -->
                                    <!-- ================================= -->

                                    <td
                                        class="status-filter-column"
                                    >

                                        <?= htmlspecialchars(
                                            $status
                                        ) ?>

                                    </td>



                                    <!-- ================================= -->
                                    <!-- ACTION -->
                                    <!-- ================================= -->

                                    <td>


                                        <!-- EDIT -->

                                        <a
                                            href="<?= base_url(
                                                'index.php/Production/job_completion_edit/' .
                                                $row->job_completion_id
                                            ) ?>"  title="Edit"
                                        >

                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>

                                        </a>



                                        <!-- VIEW -->

                                        <a
                                            href="<?= base_url(
                                                'index.php/Production/job_completion_view/' .
                                                $row->job_completion_id
                                            ) ?>"
                                           
                                            title="View"
                                        >

                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>

                                        </a>



                                        <!-- DELETE -->

                                        <button
                                            type="button"
                                            class="deleteJobCompletion" style="border:none;"
                                            data-id="<?= $row->job_completion_id ?>"
                                            title="Delete"
                                        >

                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>

                                        </button>


                                    </td>


                                </tr>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center"
                                >

                                    No Job Completion records found.

                                </td>

                            </tr>


                        <?php endif; ?>


                        </tbody>

                    </table>

                </div>


            </div>

        </div>

    </div>

</div>



<script>

var base_url = "<?= base_url(); ?>";

$(document).ready(function () {

    /* =========================================================
     * SELECT2
     * ========================================================= */
    if ($.fn.select2) {

        $('#projectFilter').select2({
            width: '100%'
        });

    }


    /* =========================================================
     * JOB COMPLETION DATATABLE
     * ========================================================= */
    var table = $('#jobCompletionTable').DataTable({

        destroy: true,

        responsive: true,

        pageLength: 10,

        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"]
        ],

        order: [
            [0, 'desc']
        ],

        /*
         * Hidden Status Filter column
         */
        columnDefs: [

            {
                targets: 7,
                visible: false,
                searchable: true
            }

        ],

        /*
         * DataTable top controls
         */
        dom:
            '<"dt-top-row"' +
                '<"dt-length"l>' +
                '<"dt-buttons"B>' +
                '<"dt-search"f>' +
            '>' +
            'rtip',

        buttons: [

            /* =================================================
             * EXCEL
             * ================================================= */
            {
                extend: 'excelHtml5',

                title: 'Job Completion List',

                className: 'btn-sm',

                messageTop:
                    'TRN: <?= htmlspecialchars($company['company_trn'] ?? '') ?>',

                /*
                 * Exclude Action column
                 */
                exportOptions: {
                    columns: ':not(:last-child)'
                }

            },


            /* =================================================
             * PRINT
             * ================================================= */
            {
                extend: 'print',

                title: '',

                className: 'btn-sm',

                /*
                 * Exclude Action column
                 */
                exportOptions: {
                    columns: ':not(:last-child)'
                },

                customize: function (win) {

                    var companyLogo =
                        "<?= !empty($company['company_logo']) ? base_url($company['company_logo']) : '' ?>";

                    var qrCode =
                        "<?= base_url('uploads/company/barcode.png') ?>";

                    var companyTRN =
                        "<?= htmlspecialchars($company['company_trn'] ?? '') ?>";


                    /* =================================================
                     * PRINT HEADER
                     * ================================================= */
                    var headerHtml = `

                        <div class="st-header-print">

                            <!-- COMPANY LOGO -->
                            <div class="st-header-logo-print">

                                ${
                                    companyLogo
                                    ?
                                    `<img
                                        src="${companyLogo}"
                                        alt="Company Logo"
                                        class="company-logo-print"
                                    >`
                                    :
                                    ''
                                }

                            </div>


                            <!-- QR + TRN -->
                            <div class="st-header-right-print">

                                <img
                                    src="${qrCode}"
                                    alt="QR Code"
                                    class="qr-code-print"
                                >

                                <div class="st-trn-print">

                                    <strong>TRN:</strong>
                                    ${companyTRN}

                                </div>

                            </div>

                        </div>


                        <!-- REPORT TITLE -->
                        <h3 class="print-report-title">
                            Job Completion List
                        </h3>

                    `;


                    $(win.document.body).prepend(headerHtml);


                    
                    $(win.document.head).append(`

                        <style>

                            /* =================================================
                             * GLOBAL
                             * ================================================= */

                            * {
                                box-sizing: border-box;
                            }


                            html,
                            body {

                                width: 100%;

                                margin: 0;

                                padding: 0;

                            }


                            body {

                                font-family:
                                    Arial,
                                    Helvetica,
                                    sans-serif;

                                font-size: 12px;

                                color: #000;

                                padding:
                                    15px
                                    20px
                                    20px
                                    20px;

                            }


                            /* =================================================
                             * HEADER
                             * ================================================= */

                            .st-header-print {

                                width: 100%;

                                min-height: 90px;

                                display: flex !important;

                                flex-direction: row !important;

                                justify-content:
                                    space-between !important;

                                align-items:
                                    center !important;

                                padding:
                                    5px
                                    0
                                    10px
                                    0;

                                margin:
                                    0
                                    0
                                    10px
                                    0;

                                page-break-inside: avoid;

                            }


                            /* =================================================
                             * LOGO AREA
                             * ================================================= */

                            .st-header-logo-print {

                                width: 65% !important;

                                flex:
                                    0 0 65% !important;

                                display: flex !important;

                                align-items:
                                    center !important;

                                justify-content:
                                    flex-start !important;

                                overflow:
                                    visible !important;

                            }


                            /* =================================================
                             * COMPANY LOGO
                             * ================================================= */

                            .company-logo-print {

                                display:
                                    block !important;

                                width:
                                    350px !important;

                                min-width:
                                    350px !important;

                                max-width:
                                    100% !important;

                                height:
                                    auto !important;

                                max-height:
                                    85px !important;

                                object-fit:
                                    contain !important;

                                object-position:
                                    left center !important;

                                margin:
                                    0 !important;

                                padding:
                                    0 !important;

                            }


                            /* =================================================
                             * RIGHT HEADER
                             * ================================================= */

                            .st-header-right-print {

                                width:
                                    35% !important;

                                flex:
                                    0 0 35% !important;

                                display:
                                    flex !important;

                                flex-direction:
                                    column !important;

                                justify-content:
                                    center !important;

                                align-items:
                                    flex-end !important;

                                gap:
                                    4px !important;

                                text-align:
                                    right !important;

                            }


                            /* =================================================
                             * QR CODE
                             * ================================================= */

                            .qr-code-print {

                                width:
                                    70px !important;

                                height:
                                    70px !important;

                                min-width:
                                    70px !important;

                                min-height:
                                    70px !important;

                                max-width:
                                    70px !important;

                                max-height:
                                    70px !important;

                                object-fit:
                                    contain !important;

                                display:
                                    block !important;

                                margin:
                                    0 !important;

                            }


                            /* =================================================
                             * TRN
                             * ================================================= */

                            .st-trn-print {

                                font-size:
                                    11px;

                                line-height:
                                    14px;

                                white-space:
                                    nowrap;

                                text-align:
                                    right;

                                font-weight:
                                    bold;

                                margin-top:
                                    2px;

                            }


                            /* =================================================
                             * REPORT TITLE
                             * ================================================= */

                            .print-report-title {

                                width:
                                    100%;

                                text-align:
                                    left;

                                margin:
                                    12px
                                    0
                                    15px
                                    0;

                                padding:
                                    0;

                                font-size:
                                    22px;

                                font-weight:
                                    bold;

                                page-break-after:
                                    avoid;

                            }


                            /* =================================================
                             * TABLE
                             * ================================================= */

                            table {

                                width:
                                    100% !important;

                                border-collapse:
                                    collapse !important;

                                margin-top:
                                    10px;

                            }


                            table thead th {

                                font-weight:
                                    bold !important;

                                background:
                                    #f5f5f5 !important;

                                border:
                                    1px solid #999 !important;

                                padding:
                                    7px !important;

                                text-align:
                                    left;

                            }


                            table tbody td {

                                border:
                                    1px solid #ccc !important;

                                padding:
                                    6px !important;

                                vertical-align:
                                    middle;

                            }


                            /* =================================================
                             * PRINT MEDIA
                             * ================================================= */

                            @media print {

                                @page {

                                    size:
                                        auto;

                                    margin:
                                        0mm;

                                }


                                html,
                                body {

                                    width:
                                        100%;

                                    margin:
                                        0 !important;

                                    padding:
                                        10px
                                        15px !important;

                                }


                                /* HEADER */

                                .st-header-print {

                                    width:
                                        100% !important;

                                    min-height:
                                        90px !important;

                                    display:
                                        flex !important;

                                    flex-direction:
                                        row !important;

                                    justify-content:
                                        space-between !important;

                                    align-items:
                                        center !important;

                                    margin-bottom:
                                        10px !important;

                                    page-break-inside:
                                        avoid;

                                }


                                /* LOGO */

                                .st-header-logo-print {

                                    width:
                                        45% !important;

                                    flex:
                                        0 0 45% !important;

                                    display:
                                        flex !important;

                                    align-items:
                                        center !important;

                                    justify-content:
                                        flex-start !important;

                                    overflow:
                                        visible !important;

                                }


                                .company-logo-print {

                                    width:
                                        250px !important;

                                    min-width:
                                        250px !important;

                                    max-width:
                                        100% !important;

                                    height:
                                        auto !important;

                                    max-height:
                                        85px !important;

                                    display:
                                        block !important;

                                    object-fit:
                                        cover !important;

                                    object-position:
                                        left center !important;
                                        align-items:
                                        left !important;

                                }


                                /* RIGHT SIDE */

                                .st-header-right-print {

                                    width:
                                        35% !important;

                                    flex:
                                        0 0 35% !important;

                                    display:
                                        flex !important;

                                    flex-direction:
                                        column !important;

                                    justify-content:
                                        center !important;

                                    align-items:
                                        flex-end !important;

                                    gap:
                                        4px !important;

                                }


                                /* QR */

                                .qr-code-print {

                                    width:
                                        70px !important;

                                    height:
                                        70px !important;

                                    min-width:
                                        70px !important;

                                    min-height:
                                        70px !important;

                                    max-width:
                                        70px !important;

                                    max-height:
                                        70px !important;

                                    object-fit:
                                        contain !important;

                                }


                                /* TABLE */

                                table {

                                    page-break-inside:
                                        auto;

                                }


                                thead {

                                    display:
                                        table-header-group;

                                }


                                tr {

                                    page-break-inside:
                                        avoid;

                                    page-break-after:
                                        auto;

                                }


                                .print-report-title {

                                    page-break-after:
                                        avoid;

                                }

                            }

                        </style>

                    `);

                }

            }

        ]

    });


    /* =========================================================
     * PROJECT FILTER
     * ========================================================= */
    $('#projectFilter').on(
        'change',
        function () {

            var projectId = $(this).val();


            /*
             * All Projects
             */
            if (
                projectId === '' ||
                projectId === null
            ) {

                table
                    .column(3)
                    .search('')
                    .draw();

                return;

            }


            /*
             * Apply custom project filter
             */
            $.fn.dataTable.ext.search.push(

                function (
                    settings,
                    data,
                    dataIndex
                ) {

                    /*
                     * Only this table
                     */
                    if (
                        settings.nTable.id !==
                        'jobCompletionTable'
                    ) {

                        return true;

                    }


                    /*
                     * Get actual row
                     */
                    var row =
                        settings
                            .aoData[dataIndex]
                            .nTr;


                    if (!row) {
                        return false;
                    }


                    /*
                     * Get project ID
                     */
                    var rowProjectId =
                        $(row)
                            .find(
                                'td[data-project-id]'
                            )
                            .attr(
                                'data-project-id'
                            );


                    return String(
                        rowProjectId
                    ) === String(
                        projectId
                    );

                }

            );


            table.draw();

            /*
             * Remove temporary filter
             */
            $.fn.dataTable.ext.search.pop();

        }

    );


    /* =========================================================
     * STATUS FILTER
     * ========================================================= */
    $('#statusFilter').on(
        'change',
        function () {

            var status = $(this).val();


            console.log(
                'Selected status:',
                status
            );


            /*
             * All Status
             */
            if (status === '') {

                table
                    .column(7)
                    .search('')
                    .draw();

            } else {

                var exactStatus =
                    '^' +
                    $.fn.dataTable.util.escapeRegex(
                        status
                    ) +
                    '$';


                table
                    .column(7)
                    .search(
                        exactStatus,
                        true,
                        false
                    )
                    .draw();

            }

        }
    );


    /* =========================================================
     * RESET FILTERS
     * ========================================================= */
    $('#resetFilters').on(
        'click',
        function () {

            /*
             * Reset project
             */
            $('#projectFilter')
                .val('')
                .trigger('change');


            /*
             * Reset status
             */
            $('#statusFilter')
                .val('')
                .trigger('change');


            /*
             * Clear DataTables searches
             */
            table
                .search('')
                .columns()
                .search('')
                .draw();

        }
    );


    /* =========================================================
     * DELETE JOB COMPLETION
     * ========================================================= */
    $(document).on(
        'click',
        '.deleteJobCompletion',
        function () {

            var completionId =
                $(this).data('id');


            if (!completionId) {

                alert(
                    'Invalid Job Completion.'
                );

                return;

            }


            if (
                !confirm(
                    'Are you sure you want to delete this Job Completion?'
                )
            ) {

                return;

            }


            $.ajax({

                url:
                    base_url +
                    'index.php/Production/delete_job_completion',

                type: 'POST',

                dataType: 'json',

                data: {

                    completion_id:
                        completionId

                },


                success: function (
                    response
                ) {

                    if (
                        response.status
                    ) {

                        alert(
                            response.message
                        );

                        location.reload();

                    } else {

                        alert(
                            response.message
                        );

                    }

                },


                error: function (
                    xhr
                ) {

                    console.log(
                        xhr.responseText
                    );

                    alert(
                        'Unable to delete Job Completion.'
                    );

                }

            });

        }

    );


});

</script>

