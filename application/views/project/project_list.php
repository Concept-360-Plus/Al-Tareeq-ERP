<link href="<?php echo base_url()."public/assets/pjt.css"; ?>" rel="stylesheet">
<style>
@media print {
    .no-print {
        display: none;
    }
       .st-header {
                width: 100%;
                height: 135px;
                display: flex !important;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 5px;
            }

            .st-header-logo {
                width: 55%;
            }

            .st-header-logo img {
                width: 380px;
                max-width: 100%;
                max-height: 125px;
                height: auto;
                object-fit: cover;
            }

            .st-header-right {
                width: 45%;
                text-align: right;
            }

            .st-header-right img {
                width: 80px;
                height: 80px;
                display: block;
                margin-left: auto;
            }

            .st-trn {
                font-size: 11px;
                font-weight: bold;
                text-align: right;
                margin-top: 3px;
            }
}
</style>
<div class="row">

    <div class="col-md-12">

        <div class="x_panel">

            <div class="x_content">

                <!-- ===================================================== -->
                <!-- FLASH MESSAGES -->
                <!-- ===================================================== -->

                <?php if ($this->session->flashdata('success')): ?>

                    <div class="alert alert-success alert-dismissible fade show">

                        <?= $this->session->flashdata('success') ?>

                        <button type="button"
                                class="close"
                                data-dismiss="alert">
                            &times;
                        </button>

                    </div>

                <?php endif; ?>


                <?php if ($this->session->flashdata('error')): ?>

                    <div class="alert alert-danger alert-dismissible fade show">

                        <?= $this->session->flashdata('error') ?>

                        <button type="button"
                                class="close"
                                data-dismiss="alert">
                            &times;
                        </button>

                    </div>

                <?php endif; ?>


                <!-- ===================================================== -->
                <!-- FILTERS -->
                <!-- ===================================================== -->

                <div class="row mb-3">

                    <!-- PROJECT FILTER -->

                    <div class="col-md-4">

                        <label>
                            Project
                        </label>

                        <select id="project_filter"
                                class="form-control">

                            <option value="">
                                All Projects
                            </option>

                            <?php

                            $project_filter = array();

                            if (!empty($projects)):

                                foreach ($projects as $project):

                                    if (
                                        !isset(
                                            $project_filter[
                                                $project['project_id']
                                            ]
                                        )
                                    ):

                                        $project_filter[
                                            $project['project_id']
                                        ] =
                                            $project['project_name'];

                            ?>

                                        <option value="<?= htmlspecialchars(
                                            $project['project_name']
                                        ) ?>">

                                            <?= htmlspecialchars(
                                                $project['project_code']
                                            ) ?>

                                            -

                                            <?= htmlspecialchars(
                                                $project['project_name']
                                            ) ?>

                                        </option>

                            <?php

                                    endif;

                                endforeach;

                            endif;

                            ?>

                        </select>

                    </div>


                    <!-- STATUS FILTER -->

                    <div class="col-md-3">

                        <label>
                            Status
                        </label>

                        <select id="status_filter"
                                class="form-control">

                            <option value="">
                                All Status
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Approved">
                                Approved
                            </option>

                        </select>

                    </div>


                    <!-- CUSTOMER FILTER -->

                    <div class="col-md-3">

                        <label>
                            Customer
                        </label>

                        <select id="customer_filter"
                                class="form-control">

                            <option value="">
                                All Customers
                            </option>

                            <?php

                            $customer_filter = array();

                            if (!empty($projects)):

                                foreach ($projects as $project):

                                    $customer =
                                        isset(
                                            $project['customer_name']
                                        )
                                        ? $project['customer_name']
                                        : '';

                                    if (
                                        !empty($customer)
                                        &&
                                        !isset(
                                            $customer_filter[$customer]
                                        )
                                    ):

                                        $customer_filter[$customer]
                                            = $customer;

                            ?>

                                        <option value="<?= htmlspecialchars(
                                            $customer
                                        ) ?>">

                                            <?= htmlspecialchars(
                                                $customer
                                            ) ?>

                                        </option>

                            <?php

                                    endif;

                                endforeach;

                            endif;

                            ?>

                        </select>

                    </div>


                    <!-- RESET -->

                    <div class="col-md-2">

                        <label>
                            &nbsp;
                        </label>

                        <button type="button"
                                id="reset_project_filters"
                                class="btn btn-default btn-block">

                            <i class="fa fa-refresh"></i>

                            Reset

                        </button>

                    </div>

                </div>


                <div class="clearfix"></div>


                <!-- ===================================================== -->
                <!-- PROJECT TABLE -->
                <!-- ===================================================== -->

                <table id="datatable-responsive1"
                       class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0"
                       width="100%">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Project Code
                            </th>

                            <th>
                                Project Name
                            </th>

                            <th>
                                Customer
                            </th>

                            <!--<th>
                                Created Date
                            </th>-->

                            <th>
                                Start Date
                            </th>

                            <th>
                                End Date
                            </th>

                            <th>
                                Duration
                            </th>

                            <th>
                                Grand Total
                            </th>

                            <th>
                                Progress
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="15%">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- ============================================================= -->
<!-- AJAX MODAL -->
<!-- ============================================================= -->

<div class="modal"
     id="ajaxModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Loading...
                </h5>

                <button type="button"
                        class="close custom-close"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>


            <div class="modal-body">

                <p class="text-center">
                    Loading content...
                </p>

            </div>

        </div>

    </div>

</div>


<div class="modal-backdrop-custom"
     style="display:none;">
</div>


<!-- ============================================================= -->
<!-- JAVASCRIPT -->
<!-- ============================================================= -->
<script>

var base_url = "<?= base_url(); ?>";

$(document).ready(function () {

    /* =========================================================
     * URL PARAMETERS
     * ========================================================= */

    var urlParams = new URLSearchParams(window.location.search);

    var urlStatus = urlParams.get('status') || '';
    var from_date = urlParams.get('from_date') || '';
    var to_date   = urlParams.get('to_date') || '';

    var project_filter  = $('#project_filter').val() || '';
    var customer_filter = $('#customer_filter').val() || '';
    var status_filter   = urlStatus || '';

    /* Set status from URL */
    if (urlStatus !== '') {
        $('#status_filter').val(urlStatus);
        status_filter = urlStatus;
    }


    /* =========================================================
     * ESCAPE REGEX
     * ========================================================= */

    function escapeRegex(value) {
        return String(value).replace(
            /[.*+?^${}()|[\]\\]/g,
            '\\$&'
        );
    }


    /* =========================================================
     * DESTROY EXISTING DATATABLE
     * ========================================================= */

    if ($.fn.DataTable.isDataTable('#datatable-responsive1')) {

        $('#datatable-responsive1')
            .DataTable()
            .destroy();
    }


    /* =========================================================
     * DATATABLE
     * ========================================================= */

    var table = $('#datatable-responsive1').DataTable({

        processing: true,

        responsive: true,

        pageLength: 10,

        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"]
        ],

        order: [
            [0, 'asc']
        ],


        /* =====================================================
         * DATATABLE TOP CONTROLS
         * ===================================================== */

        dom:
            '<"dt-top-row"' +
                '<"dt-length"l>' +
                '<"dt-buttons"B>' +
                '<"dt-search"f>' +
            '>' +
            'rtip',


        /* =====================================================
         * BUTTONS
         * ===================================================== */

        buttons: [

            /* -------------------------------------------------
             * EXCEL
             * ------------------------------------------------- */

            {
                extend: 'excelHtml5',

                title: 'Project List',

                messageTop:
                    'TRN: <?= htmlspecialchars($company['company_trn'] ?? '') ?>',

                exportOptions: {
                    columns: ':visible:not(:eq(10))'
                }
            },


            /* -------------------------------------------------
             * PRINT
             * ------------------------------------------------- */

            {
                extend: 'print',

                title: '',

                exportOptions: {
                    columns: ':visible:not(:eq(10))'
                },

                customize: function (win) {

                    /* =====================================================
                     * COMPANY INFORMATION
                     * ===================================================== */

                    var companyLogo =
                        "<?= !empty($company['company_logo']) ? base_url($company['company_logo']) : '' ?>";

                    var qrCode =
                        "<?= base_url('uploads/company/barcode.png') ?>";

                    var companyTRN =
                        "<?= htmlspecialchars($company['company_trn'] ?? '') ?>";


                    /* =====================================================
                     * PRINT HEADER
                     * ===================================================== */

                    var headerHtml = `

                        <div class="st-header-print">

                            <!-- LEFT : COMPANY LOGO -->
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


                            <!-- RIGHT : QR + TRN -->
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


                        <h3 class="print-report-title">
                            Project List
                        </h3>

                    `;


                    /* =====================================================
                     * INSERT HEADER
                     * ===================================================== */

                    $(win.document.body).prepend(headerHtml);


                    /* =====================================================
                     * PRINT CSS
                     * ===================================================== */

                   /* =====================================================
 * PRINT CSS
 * ===================================================== */

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
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            padding: 15px 20px 20px 20px;
        }

        /* =================================================
         * PRINT HEADER
         * ================================================= */

        .st-header-print {
            width: 100%;
            min-height: 90px;
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 5px 0 10px 0;
            margin: 0 0 10px 0;
            /* border-bottom: 1px solid #000; */
            page-break-inside: avoid;
        }

        /* =================================================
         * LOGO CONTAINER
         * ================================================= */

        .st-header-logo-print {
            width: 65% !important;
            flex: 0 0 65% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
        }

        /* =================================================
         * COMPANY LOGO (Perfect Dimensioning & Scale)
         * ================================================= */

        .company-logo-print {
            display: block !important;
            width: 350px !important;       
            min-width: 350px !important;   
            max-width: 100% !important;
            height: auto !important;
            max-height: 85px !important;  
            object-fit: contain !important; /* Fixed from cover to prevent cropping */
            object-position: left center !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* =================================================
         * RIGHT SIDE (QR & TRN)
         * ================================================= */

        .st-header-right-print {
            width: 35% !important;
            flex: 0 0 35% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: flex-end !important;
            gap: 4px;
            text-align: right;
        }

        /* =================================================
         * QR CODE & TRN
         * ================================================= */

        .qr-code-print {
            width: 70px !important;
            height: 70px !important;
            min-width: 70px !important;
            min-height: 70px !important;
            object-fit: contain !important;
            display: block !important;
            margin: 0 !important;
        }

        .st-trn-print {
            font-size: 11px;
            line-height: 14px;
            white-space: nowrap;
            text-align: right;
            font-weight: bold;
            margin-top: 2px;
        }

        /* =================================================
         * REPORT TITLE
         * ================================================= */

        .print-report-title {
            width: 100%;
            text-align: left;
            margin: 12px 0 15px 0;
            padding: 0;
            font-size: 22px;
            font-weight: bold;
        }

        /* =================================================
         * TABLE
         * ================================================= */

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 10px;
        }

        table thead th {
            font-weight: bold !important;
            background: #f5f5f5 !important;
            border: 1px solid #999 !important;
            padding: 7px !important;
            text-align: left;
        }

        table tbody td {
            border: 1px solid #ccc !important;
            padding: 6px !important;
            vertical-align: middle;
        }

        table th:nth-child(8),
        table td:nth-child(8) {
            text-align: right !important;
        }

        table th:nth-child(9),
        table td:nth-child(9) {
            text-align: center !important;
        }

        table th:nth-child(10),
        table td:nth-child(10) {
            text-align: center !important;
        }

        /* =================================================
         * PRINT MEDIA OVERRIDES
         * ================================================= */

        @media print {
         @page {
            size: auto;
            margin: 0mm;  /* Setting margin to 0 hides about:blank and date */
        }
            html, body {
                width: 100%;
                margin: 0 !important;
                padding: 10px 15px !important;
            }
            .st-header-print {
                width: 100% !important;
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                margin-bottom: 10px !important;
                page-break-inside: avoid;
            }
            .st-header-logo-print {
                width: 45% !important;
                flex: 0 0 45% !important;
                display: flex !important;
            }
            .company-logo-print {
                width: 275px !important;
                min-width: 275px !important;
                height: auto !important;
                max-height: 85px !important;
                display: block !important;
                object-fit: cover !important;
            }
            .st-header-right-print {
                width: 45% !important;
                flex: 0 0 45% !important;
                display: flex !important;
            }
            table {
                page-break-inside: auto;
            }
            thead {
                display: table-header-group;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            .print-report-title {
                page-break-after: avoid;
            }
        }
    </style>
`);


                }

            }

        ],


        /* =====================================================
         * AJAX
         * ===================================================== */

        ajax: {

            url:
                base_url +
                'index.php/Project/get_project_list_ajax',

            type: 'POST',

            data: function (d) {

                d.project_filter  = project_filter;

                d.customer_filter = customer_filter;

                d.status          = status_filter;

                d.from_date       = from_date;

                d.to_date         = to_date;

            },


            dataSrc: function (json) {

                console.log(
                    'Project AJAX Response:',
                    json
                );

                if (
                    !json ||
                    !Array.isArray(json.data)
                ) {
                    return [];
                }

                return json.data;

            },


            error: function (
                xhr,
                error,
                thrown
            ) {

                console.error(
                    'Project DataTable Error:',
                    error,
                    thrown
                );

                console.error(
                    'Server Response:',
                    xhr.responseText
                );

            }

        },


        /* =====================================================
         * COLUMNS
         * ===================================================== */

        columns: [

            /* -------------------------------------------------
             * 0. SERIAL
             * ------------------------------------------------- */

            {
                data: 'sn',
                defaultContent: ''
            },


            /* -------------------------------------------------
             * 1. PROJECT CODE
             * ------------------------------------------------- */

            {
                data: 'project_code',
                defaultContent: ''
            },


            /* -------------------------------------------------
             * 2. PROJECT NAME
             * ------------------------------------------------- */

            {
                data: 'project_name',
                defaultContent: ''
            },


            /* -------------------------------------------------
             * 3. CUSTOMER
             * ------------------------------------------------- */

            {
                data: 'customer_name',
                defaultContent: ''
            },


            /* -------------------------------------------------
             * 4. START DATE
             * ------------------------------------------------- */

            {
                data: 'start_date',

                defaultContent: '',

                render: function (data, type) {

                    if (
                        !data ||
                        data === '0000-00-00'
                    ) {
                        return '';
                    }

                    if (
                        type === 'sort' ||
                        type === 'type'
                    ) {
                        return data;
                    }

                    var date =
                        new Date(data);

                    if (
                        isNaN(
                            date.getTime()
                        )
                    ) {
                        return data;
                    }

                    var day =
                        String(
                            date.getDate()
                        ).padStart(2, '0');

                    var month =
                        String(
                            date.getMonth() + 1
                        ).padStart(2, '0');

                    var year =
                        date.getFullYear();

                    return (
                        day +
                        '-' +
                        month +
                        '-' +
                        year
                    );

                }

            },


            /* -------------------------------------------------
             * 5. END DATE
             * ------------------------------------------------- */

            {
                data: 'end_date',

                defaultContent: '',

                render: function (data, type) {

                    if (
                        !data ||
                        data === '0000-00-00'
                    ) {
                        return '';
                    }

                    if (
                        type === 'sort' ||
                        type === 'type'
                    ) {
                        return data;
                    }

                    var date =
                        new Date(data);

                    if (
                        isNaN(
                            date.getTime()
                        )
                    ) {
                        return data;
                    }

                    var day =
                        String(
                            date.getDate()
                        ).padStart(2, '0');

                    var month =
                        String(
                            date.getMonth() + 1
                        ).padStart(2, '0');

                    var year =
                        date.getFullYear();

                    return (
                        day +
                        '-' +
                        month +
                        '-' +
                        year
                    );

                }

            },


            /* -------------------------------------------------
             * 6. DURATION
             * ------------------------------------------------- */

            {
                data: null,

                defaultContent: '',

                render: function (
                    data,
                    type,
                    row
                ) {

                    if (
                        !row.start_date ||
                        !row.end_date
                    ) {
                        return '';
                    }

                    var start =
                        new Date(
                            row.start_date
                        );

                    var end =
                        new Date(
                            row.end_date
                        );

                    if (
                        isNaN(
                            start.getTime()
                        ) ||
                        isNaN(
                            end.getTime()
                        )
                    ) {
                        return '';
                    }

                    var diff =
                        Math.ceil(
                            (
                                end - start
                            ) /
                            (
                                1000 *
                                60 *
                                60 *
                                24
                            )
                        ) + 1;

                    return diff + ' Days';

                }

            },


            /* -------------------------------------------------
             * 7. GRAND TOTAL
             * ------------------------------------------------- */

            {
                data: 'grand_total',

                defaultContent: '0.00',

                className: 'text-right',

                render: function (
                    data,
                    type
                ) {

                    var value =
                        parseFloat(data) || 0;

                    if (
                        type === 'sort' ||
                        type === 'type'
                    ) {
                        return value;
                    }

                    return value
                        .toFixed(2)
                        .replace(
                            /\B(?=(\d{3})+(?!\d))/g,
                            ','
                        );

                }

            },


            /* -------------------------------------------------
             * 8. PROGRESS
             * ------------------------------------------------- */

            {
                data: null,

                orderable: false,

                searchable: false,

                defaultContent: '',

                render: function (
                    data,
                    type,
                    row
                ) {

                    var progress =
                        parseFloat(
                            row.progress
                        ) || 0;

                    progress =
                        Math.max(
                            0,
                            Math.min(
                                100,
                                progress
                            )
                        );

                    return (

                        '<div class="progress" ' +
                        'style="height:20px; margin:0;">' +

                            '<div class="progress-bar" ' +
                            'role="progressbar" ' +
                            'style="width:' +
                            progress +
                            '%;">' +

                                progress +
                                '%' +

                            '</div>' +

                        '</div>'

                    );

                }

            },


            /* -------------------------------------------------
             * 9. STATUS
             * ------------------------------------------------- */

            {
                data: 'status',

                defaultContent: 'Open',

                render: function (
                    data,
                    type
                ) {

                    var currentStatus =
                        data || 'Open';

                    var badgeClass =
                        'badge-secondary';

                    switch (
                        String(
                            currentStatus
                        ).toLowerCase()
                    ) {

                        case 'pending':

                            badgeClass =
                                'badge-warning';

                            break;


                        case 'approved':

                            badgeClass =
                                'badge-success';

                            break;


                        case 'rejected':

                            badgeClass =
                                'badge-danger';

                            break;


                        case 'open':

                            badgeClass =
                                'badge-info';

                            break;

                    }

                    var safeStatus =
                        $('<span>')
                            .text(currentStatus)
                            .prop('outerHTML');

                    return (

                        '<span class="badge ' +
                        badgeClass +
                        '">' +

                            safeStatus +

                        '</span>'

                    );

                }

            },


            /* -------------------------------------------------
             * 10. ACTION
             * ------------------------------------------------- */

            {
                data: null,

                orderable: false,

                searchable: false,

                defaultContent: '',

                render: function (
                    data,
                    type,
                    row
                ) {

                    var id =
                        row.project_id;

                    return `

                        <div class="dropdown">

                            <button
                                class="btn btn-light btn-sm border"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">

                                <i class="fa fa-ellipsis-v"></i>

                            </button>


                            <div
                                class="dropdown-menu dropdown-menu-right">

                                <!-- Project Dashboard -->

                                <a
                                    class="dropdown-item"
                                    href="${base_url}index.php/Project/project_dashboard/${id}">

                                    <i
                                        class="fa fa-tachometer text-primary">
                                    </i>

                                    Project Dashboard

                                </a>


                                <!-- Project Overview -->

                                <a
                                    class="dropdown-item"
                                    href="${base_url}index.php/Project/project_full_report/${id}">

                                    <i
                                        class="fa fa-line-chart text-info">
                                    </i>

                                    Project Overview

                                </a>


                                <!-- Edit Project -->

                                <a
                                    class="dropdown-item"
                                    href="${base_url}index.php/Project/edit_project/${id}">

                                    <i
                                        class="fa fa-edit text-warning">
                                    </i>

                                    Edit Project

                                </a>


                                <!-- View Materials -->

                                <a
                                    class="dropdown-item view-item"
                                    href="#"
                                    data-id="${id}">

                                    <i
                                        class="fa fa-eye text-info">
                                    </i>

                                    View Materials

                                </a>


                                <div class="dropdown-divider"></div>


                                <!-- Delete -->

                                <a
                                    class="dropdown-item text-danger"
                                    href="${base_url}index.php/Project/delete/${id}"
                                    onclick="return confirm('Delete this project?')">

                                    <i class="fa fa-trash"></i>

                                    Delete

                                </a>

                            </div>

                        </div>

                    `;

                }

            }

        ]

    });


    /* =========================================================
     * PROJECT FILTER
     * ========================================================= */

    $('#project_filter').on(
        'change',
        function () {

            project_filter =
                $(this).val() || '';

            table
                .column(2)
                .search('');

            if (
                project_filter !== ''
            ) {

                table
                    .column(2)
                    .search(
                        '^' +
                        escapeRegex(
                            project_filter
                        ) +
                        '$',
                        true,
                        false
                    );

            }

            table.draw();

        }
    );


    /* =========================================================
     * CUSTOMER FILTER
     * ========================================================= */

    $('#customer_filter').on(
        'change',
        function () {

            customer_filter =
                $(this).val() || '';

            table
                .column(3)
                .search('');

            if (
                customer_filter !== ''
            ) {

                table
                    .column(3)
                    .search(
                        '^' +
                        escapeRegex(
                            customer_filter
                        ) +
                        '$',
                        true,
                        false
                    );

            }

            table.draw();

        }
    );


    /* =========================================================
     * STATUS FILTER
     * ========================================================= */

    $('#status_filter').on(
        'change',
        function () {

            status_filter =
                $(this).val() || '';

            table
                .column(9)
                .search('');

            if (
                status_filter !== ''
            ) {

                table
                    .column(9)
                    .search(
                        '^' +
                        escapeRegex(
                            status_filter
                        ) +
                        '$',
                        true,
                        false
                    );

            }

            table.draw();

        }
    );


    /* =========================================================
     * RESET FILTERS
     * ========================================================= */

    $('#reset_project_filters').on(
        'click',
        function (e) {

            e.preventDefault();

            project_filter  = '';
            customer_filter = '';
            status_filter   = '';

            from_date = '';
            to_date   = '';


            $('#project_filter')
                .val('')
                .trigger('change.select2');


            $('#customer_filter')
                .val('')
                .trigger('change.select2');


            $('#status_filter')
                .val('')
                .trigger('change.select2');


            table
                .columns()
                .search('');


            table.draw();

        }
    );


    /* =========================================================
     * DEBUG
     * ========================================================= */

    console.log(
        'PROJECT DATATABLE CREATED'
    );


    console.log(
        'Initial Filters:',
        {
            project: project_filter,
            customer: customer_filter,
            status: status_filter,
            from_date: from_date,
            to_date: to_date
        }
    );


    /* =========================================================
     * DATATABLE RESPONSIVE ADJUST
     * ========================================================= */

    setTimeout(function () {

        table.columns.adjust();

        if (
            table.responsive &&
            typeof table.responsive.recalc ===
                'function'
        ) {

            table.responsive.recalc();

        }

    }, 300);

});


/* =============================================================
 * VIEW PROJECT MATERIALS
 * ============================================================= */

$(document).on(
    'click',
    '.view-item',
    function (e) {

        e.preventDefault();
        e.stopPropagation();

        var id =
            $(this).data('id');


        $('.modal-backdrop-custom')
            .show();


        $('#ajaxModal')
            .addClass('modal-show')
            .show();


        $('#ajaxModal .modal-title')
            .text('Loading...');


        $('#ajaxModal .modal-body')
            .html(
                '<p class="text-center">' +
                    '<i class="fa fa-spinner fa-spin"></i> ' +
                    'Loading content...' +
                '</p>'
            );


        $.ajax({

            url:
                base_url +
                'index.php/Project/project_popup_materials',

            type: 'POST',

            data: {
                id: id
            },


            success: function (response) {

                try {

                    var data =
                        typeof response === 'string'
                        ? JSON.parse(response)
                        : response;


                    $('#ajaxModal .modal-title')
                        .text(
                            data.title ||
                            'Project Materials'
                        );


                    $('#ajaxModal .modal-body')
                        .html(
                            data.html ||
                            '<p class="text-center">' +
                                'No materials found.' +
                            '</p>'
                        );

                }
                catch (e) {

                    console.error(
                        'Modal JSON error:',
                        e
                    );


                    $('#ajaxModal .modal-body')
                        .html(
                            '<div class="alert alert-danger">' +
                                'Unable to load materials.' +
                            '</div>'
                        );

                }

            },


            error: function (xhr) {

                console.error(
                    'project_popup_materials error:',
                    xhr.responseText
                );


                $('#ajaxModal .modal-body')
                    .html(
                        '<div class="alert alert-danger">' +
                            'Unable to load materials.' +
                        '</div>'
                    );

            }

        });

    }
);


/* =============================================================
 * VIEW ASSIGNED TEAM
 * ============================================================= */

$(document).on(
    'click',
    '.view-team',
    function (e) {

        e.preventDefault();
        e.stopPropagation();

        var id =
            $(this).data('id');


        $('.modal-backdrop-custom')
            .show();


        $('#ajaxModal')
            .addClass('modal-show')
            .show();


        $('#ajaxModal .modal-title')
            .text('Loading...');


        $('#ajaxModal .modal-body')
            .html(
                '<p class="text-center">' +
                    '<i class="fa fa-spinner fa-spin"></i> ' +
                    'Loading content...' +
                '</p>'
            );


        $.ajax({

            url:
                base_url +
                'index.php/Project/project_task_popup',

            type: 'POST',

            data: {
                id: id
            },


            success: function (response) {

                try {

                    var data =
                        typeof response === 'string'
                        ? JSON.parse(response)
                        : response;


                    $('#ajaxModal .modal-title')
                        .text(
                            data.title ||
                            'Assigned Team'
                        );


                    $('#ajaxModal .modal-body')
                        .html(
                            data.html ||
                            '<p class="text-center">' +
                                'No data found.' +
                            '</p>'
                        );

                }
                catch (e) {

                    console.error(
                        'Team modal JSON error:',
                        e
                    );


                    $('#ajaxModal .modal-body')
                        .html(
                            '<div class="alert alert-danger">' +
                                'Unable to load assigned team.' +
                            '</div>'
                        );

                }

            },


            error: function (xhr) {

                console.error(
                    'project_task_popup error:',
                    xhr.responseText
                );


                $('#ajaxModal .modal-body')
                    .html(
                        '<div class="alert alert-danger">' +
                            'Unable to load assigned team.' +
                        '</div>'
                    );

            }

        });

    }
);


/* =============================================================
 * CLOSE MODAL
 * ============================================================= */

$(document).on(
    'click',
    '.custom-close, .modal-backdrop-custom',
    function () {

        $('#ajaxModal')
            .removeClass('modal-show')
            .hide();


        $('.modal-backdrop-custom')
            .hide();

    }
);


/* =============================================================
 * ACTION DROPDOWN
 * ============================================================= */

$(document).on(
    'click',
    '.action-btn',
    function (e) {

        e.stopPropagation();


        $('.action-dropdown')
            .not($(this).parent())
            .removeClass('active');


        $(this)
            .parent()
            .toggleClass('active');

    }
);


/* =============================================================
 * CLOSE ACTION DROPDOWN WHEN CLICKING OUTSIDE
 * ============================================================= */

$(document).on(
    'click',
    function () {

        $('.action-dropdown')
            .removeClass('active');

    }
);

</script>