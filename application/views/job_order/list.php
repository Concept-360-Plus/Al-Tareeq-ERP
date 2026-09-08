
<style>
    .dt-buttons{margin-top:-4px;}
    .pull-right {
        margin-right: 16px;
    }

    .filter-row {
        margin-bottom: 15px;
    }

    .filter-row .form-group {
        margin-bottom: 10px;
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

/* Mobile */
@media (max-width: 768px) {
    .dt-top-row {
        flex-wrap: wrap;
        gap: 10px;
    }

    .dt-search {
        margin-left: 0;
        width: 100%;
    }
}

</style>


<div class="row">

    <div class="col-md-12 col-sm-12">

        <div class="x_panel">

            <div class="x_content">

                <!--<a href="<?= base_url('index.php/Production/job_create') ?>"
                   class="btn btn-primary pull-right">

                    <i class="fa fa-plus"></i>
                    Create Job Order

                </a>-->

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

                <div class="row filter-row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Project
                            </label>

                            <select id="projectFilter"  class="form-control select2">

                                <option value="">
                                    All Projects
                                </option>


                                <?php

                                /*
                                 * Build unique project list
                                 */

                                $projects = [];

                                if (!empty($job_orders)) {

                                    foreach ($job_orders as $row) {

                                        if (
                                            !empty($row->fk_project_id) &&
                                            !empty($row->project_name)
                                        ) {

                                            $projects[
                                                $row->fk_project_id
                                            ] = $row->project_name;

                                        }

                                    }

                                }

                                /*
                                 * Sort project names
                                 */

                                asort($projects);

                                ?>


                                <?php foreach (
                                    $projects
                                    as $project_id => $project_name
                                ): ?>

                                    <option value="<?= htmlspecialchars(
                                        $project_id
                                    ); ?>">

                                        <?= htmlspecialchars(
                                            $project_name
                                        ); ?>

                                    </option>

                                <?php endforeach; ?>


                            </select>

                        </div>

                    </div>



                    <!-- ================================================= -->
                    <!-- STATUS FILTER -->
                    <!-- ================================================= -->

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Status
                            </label>


                            <select id="statusFilter"
                                    class="form-control">

                                <option value="">
                                    All Status
                                </option>


                                <?php

                                /*
                                 * Get unique statuses
                                 */

                                $statuses = [];

                                if (!empty($job_orders)) {

                                    foreach ($job_orders as $row) {

                                        if (
                                            isset($row->status) &&
                                            trim($row->status) !== ''
                                        ) {

                                            $statuses[] =
                                                trim($row->status);

                                        }

                                    }

                                }


                                $statuses =
                                    array_unique($statuses);


                                sort($statuses);

                                ?>


                                <?php foreach (
                                    $statuses as $status
                                ): ?>

                                    <option value="<?= htmlspecialchars(
                                        $status
                                    ); ?>">

                                        <?= htmlspecialchars(
                                            $status
                                        ); ?>

                                    </option>

                                <?php endforeach; ?>


                            </select>

                        </div>

                    </div>



                    <!-- ================================================= -->
                    <!-- RESET BUTTON -->
                    <!-- ================================================= -->

                    <div class="col-md-2">

                        <div class="form-group">

                            <label>
                                &nbsp;
                            </label>


                            <button type="button"
                                    id="resetFilters"
                                    class="btn btn-default form-control">

                                <i class="fa fa-refresh"></i>

                                Reset Filters

                            </button>

                        </div>

                    </div>


                </div>


                <!-- ===================================================== -->
                <!-- JOB ORDER TABLE -->
                <!-- ===================================================== -->

                <table class="table table-bordered table-striped"
                       id="jobOrderTable">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Job Order No
                            </th>

                            <th>
                                Project
                            </th>

                            <th>
                                Order Date
                            </th>

                            <th>
                                Items
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="150">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php $i = 1; ?>


                    <?php if (!empty($job_orders)): ?>


                        <?php foreach (
                            $job_orders as $row
                        ): ?>


                            <tr>


                                <!-- ===================================== -->
                                <!-- SERIAL NUMBER -->
                                <!-- ===================================== -->

                                <td>

                                    <?= $i++; ?>

                                </td>



                                <!-- ===================================== -->
                                <!-- JOB ORDER NUMBER -->
                                <!-- ===================================== -->

                                <td>

                                    <strong>

                                        JO<?= htmlspecialchars(
                                            $row->job_order_no
                                        ); ?>

                                    </strong>

                                </td>



                                <!-- ===================================== -->
                                <!-- PROJECT -->
                                <!-- ===================================== -->

                                <td
                                    data-project-id="<?= htmlspecialchars(
                                        $row->fk_project_id
                                    ); ?>"
                                >

                                    <?= htmlspecialchars(
                                        $row->project_name ?? ''
                                    ); ?>

                                </td>



                                <!-- ===================================== -->
                                <!-- ORDER DATE -->
                                <!-- ===================================== -->

                                <td>

                                    <?php if (
                                        !empty($row->order_date)
                                    ): ?>

                                        <?= date(
                                            'd-m-Y',
                                            strtotime(
                                                $row->order_date
                                            )
                                        ); ?>

                                    <?php endif; ?>

                                </td>



                                <!-- ===================================== -->
                                <!-- ITEMS -->
                                <!-- ===================================== -->

                                <td>

                                    <?= (int) $row->total_items; ?>

                                </td>



                                <!-- ===================================== -->
                                <!-- STATUS -->
                                <!-- ===================================== -->

                                <td>

                                    <?php

                                    $status =
                                        isset($row->status)
                                            ? trim($row->status)
                                            : '';


                                    /*
                                     * Default status class
                                     */

                                    $status_class =
                                        'label-default';


                                    switch ($status) {

                                        case 'Pending':

                                            $status_class =
                                                'label-warning';

                                            break;


                                        case 'In Progress':

                                            $status_class =
                                                'label-info';

                                            break;


                                        case 'Production Completed':

                                            $status_class =
                                                'label-success';

                                            break;


                                        case 'Completed':

                                            $status_class =
                                                'label-success';

                                            break;


                                        case 'Cancelled':

                                            $status_class =
                                                'label-danger';

                                            break;

                                    }

                                    ?>


                                    <?php if ($status !== ''): ?>

                                        <span
                                            class="label <?= $status_class; ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $status
                                            ); ?>

                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="label label-default"
                                        >

                                            -

                                        </span>

                                    <?php endif; ?>


                                </td>



                                <!-- ===================================== -->
                                <!-- ACTION -->
                                <!-- ===================================== -->

                                <td>


                                    <!-- EDIT -->

                                    <a href="<?= base_url(
                                        'index.php/Production/edit_job_order/' .
                                        $row->job_order_id
                                    ); ?>"
                                       title="Edit"
                                      >

                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>

                                    </a>



                                    <!-- PRINT -->

                                    <a href="<?= base_url(
                                        'index.php/Production/print_job_order/' .
                                        $row->job_order_id
                                    ); ?>"
                                       title="Print"
                                       >

                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>

                                  

                                    </a>



                                    <!-- DELETE -->

                                    <a href="<?= base_url(
                                        'index.php/Production/delete/' .
                                        $row->job_order_id
                                    ); ?>"
                                       
                                       title="Delete"
                                       onclick="return confirm(
                                           'Delete this Job Order?'
                                       );">

                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>

                                  

                                    </a>


                                </td>


                            </tr>


                        <?php endforeach; ?>


                    <?php endif; ?>


                    </tbody>

                </table>


            </div>

        </div>

    </div>

</div>




<script>

$(document).ready(function () {

    /* =========================================================
     * SELECT2
     * ========================================================= */

    $('#projectFilter').select2({
        placeholder: 'Select Project',
        allowClear: true,
        width: '100%'
    });


    /* =========================================================
     * INITIALIZE JOB ORDER DATATABLE
     * ========================================================= */

    var table = $('#jobOrderTable').DataTable({

        destroy: true,

        responsive: true,

        pageLength: 10,

        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"]
        ],

        order: [
            [0, 'asc']
        ],

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

                title: 'Job Order List',

                className: 'btn-sm',

                messageTop:
                    'TRN: <?= htmlspecialchars($company['company_trn'] ?? '') ?>',

                /*
                 * Exclude last column = Action
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

                /*
                 * Remove default DataTables title
                 * because we create our own title
                 */

                title: '',

                className: 'btn-sm',

                /*
                 * Exclude last column = Action
                 */

                exportOptions: {
                    columns: ':not(:last-child)'
                },


                customize: function (win) {

                    /* =================================================
                     * COMPANY DETAILS
                     * ================================================= */

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
                                    ? `
                                        <img
                                            src="${companyLogo}"
                                            alt="Company Logo"
                                            class="company-logo-print"
                                        >
                                      `
                                    : ''
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
                            Job Order List
                        </h3>

                    `;


                    /*
                     * Add header before table
                     */

                    $(win.document.body)
                        .prepend(headerHtml);


                    /* =================================================
                     * PRINT CSS
                     * ================================================= */

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
     * CUSTOM PROJECT FILTER
     * ========================================================= */

    $.fn.dataTable.ext.search.push(function (
        settings,
        data,
        dataIndex
    ) {

        /*
         * Apply only to Job Order table
         */

        if (
            settings.nTable.id !== 'jobOrderTable'
        ) {

            return true;

        }


        /*
         * Selected project ID
         */

        var selectedProject =
            $('#projectFilter').val();


        /*
         * All Projects
         */

        if (
            selectedProject === '' ||
            selectedProject === null ||
            typeof selectedProject === 'undefined'
        ) {

            return true;

        }


        /*
         * Get current DataTable row
         */

        var rowNode =
            settings.aoData[dataIndex].nTr;


        if (!rowNode) {

            return false;

        }


        /*
         * Get project ID from
         *
         * <td data-project-id="123">
         */

        var rowProjectId =
            $(rowNode)
                .find('td[data-project-id]')
                .attr('data-project-id');


        /*
         * Compare project IDs
         */

        return String(rowProjectId) ===
               String(selectedProject);

    });


    /* =========================================================
     * PROJECT FILTER CHANGE
     * ========================================================= */

    $('#projectFilter').on(
        'change',
        function () {

            table.draw();

        }
    );


    /* =========================================================
     * STATUS FILTER
     * ========================================================= */

    $.fn.dataTable.ext.search.push(function (
        settings,
        data,
        dataIndex
    ) {

        /*
         * Apply only to Job Order table
         */

        if (
            settings.nTable.id !== 'jobOrderTable'
        ) {

            return true;

        }


        /*
         * Selected status
         */

        var selectedStatus =
            $('#statusFilter').val();


        /*
         * All Status
         */

        if (
            selectedStatus === '' ||
            selectedStatus === null ||
            typeof selectedStatus === 'undefined'
        ) {

            return true;

        }


        /*
         * Get current DataTable row
         */

        var rowNode =
            settings.aoData[dataIndex].nTr;


        if (!rowNode) {

            return false;

        }


        /*
         * Status is column 5
         */

        var statusText =
            $(rowNode)
                .find('td')
                .eq(5)
                .text()
                .trim();


        /*
         * Compare exact status
         */

        return statusText ===
               selectedStatus;

    });


    /* =========================================================
     * STATUS FILTER CHANGE
     * ========================================================= */

    $('#statusFilter').on(
        'change',
        function () {

            table.draw();

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
             * Clear DataTable search
             */

            table
                .search('')
                .columns()
                .search('')
                .draw();

        }
    );

});

</script>