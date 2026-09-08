<style>
 .dataTables_wrapper .dataTables_length select.form-control,
.dataTables_wrapper .dataTables_filter input.form-control {
    display: inline-block !important;
    width: auto !important;
    height: 34px;
    padding: 6px 12px;
    vertical-align: middle;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
}

.dataTables_wrapper .dataTables_length {
    float: left;
}

.dataTables_wrapper .dataTables_filter label,
.dataTables_wrapper .dataTables_length label {
    font-weight: normal;
}
.buttons-excel{
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.dt-buttons{
     padding-left: 18px !important;
}
.buttons-print{
   
    margin-right: auto;
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
    margin-left:10px !important;
}
.left{
    margin-left:14px !important;
}
</style>
<link rel="stylesheet" href="<?= base_url('assets/datatables/buttons.dataTables.min.css');?>">
<script src="<?= base_url('assets/datatables/dataTables.buttons.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/jszip.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/buttons.html5.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/buttons.print.min.js');?>"></script>
<div class="x_panel">
    <div class="row">

    <!-- PROJECT -->
    <div class="col-md-3 left">
        <label>Project</label>

        <select id="project_filter" class="form-control">

            <option value="">All Projects</option>

            <?php foreach($project_list as $project){ ?>

                <option value="<?= htmlspecialchars($project->project_name); ?>">
                    <?= htmlspecialchars(
                        $project->project_code . ' - ' . $project->project_name
                    ); ?>
                </option>

            <?php } ?>

        </select>
    </div>


    <!-- DATE TYPE -->
    <div class="col-md-2">
        <label>Date Type</label>

        <select id="date_type" class="form-control">

            <option value="">Select Date Type</option>

            <option value="created">
                Created Date
            </option>

            <option value="start">
                Project Start Date
            </option>

            <option value="end">
                Project End Date
            </option>

        </select>
    </div>


    <!-- FROM DATE -->
    <div class="col-md-2">
        <label>From Date</label>

        <input
            type="date"
            id="from_date"
            class="form-control"
        >
    </div>


    <!-- TO DATE -->
    <div class="col-md-2">
        <label>To Date</label>

        <input
            type="date"
            id="to_date"
            class="form-control"
        >
    </div>


    <!-- RESET -->
    <div class="col-md-2" style="padding-top:25px;">

        <button
            type="button"
            id="reset_filters"
            class="btn btn-default"
        >
            <i class="fa fa-refresh"></i>
            Reset
        </button>

    </div>

</div>

<br>
    <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead><tr><th>#<th>Code</th><th>Project</th><th>Customer</th><th>Approver</th><th>Start</th><th>End</th><th>Status</th><th>Progress</th><th>Current Status</th><th>Created</th></tr></thead>
        <tbody>
            <?php 
            if(!empty($projects)):
                foreach($projects  as $i =>$p){ ?>
                <tr>
                <td><?= $i+1 ?></td><td><a href="<?= base_url('index.php/Project/project_dashboard/'. $p->project_id) ?>" title="View Project dashboard"><?= $p->project_code ?></a></td><td><?= $p->project_name ?></td><td><?php if($p->customer_name!=''){ echo $p->customer_name; }else{echo $p->cname;} ?></td><td><?= $p->manager ?></td><td><?php echo date('d-m-Y', strtotime($p->start_date)); ?></td><td><?php echo date('d-m-Y',strtotime($p->end_date)) ?></td><td><?= $p->status ?></td>
                <td>
                    <?php $progress_percentage = $this->Project_model->get_project_progress_byid($p->project_id); ?>
                    <div style="background:#ddd;width:100px"><div style="background:green;color:#fff;width:<?= (int)$progress_percentage ?>%"><?= (int)$progress_percentage ?>%</div></div>
                </td>
                <td><?= $p->current_status ?></td><td  data-order="<?php echo strtotime($p->created_on); ?>"><?php echo date('d-m-Y', strtotime($p->created_on)); ?></td>
                </tr><?php 
                } 
            else: 
                echo '<tr><td colspan="10">No records found</td></tr>';
            endif; ?>
       </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>

var base_url = "<?= base_url(); ?>";

$(document).ready(function () {

    /* =========================================================
     * DATATABLE
     * ========================================================= */

    var table = $('#datatable-responsive1').DataTable({

        order: [[10, 'desc']],

        dom:
            '<"dt-top-row"' +
                '<"dt-length"l>' +
                '<"dt-buttons"B>' +
                '<"dt-search"f>' +
            '>' +
            'rtip',

        pageLength: 10,

        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, 'All']
        ],

        buttons: [

            /* =====================================================
             * EXCEL
             * ===================================================== */

            {
                extend: 'excelHtml5',

                title: 'Project Progress Report',

                className: 'btn-sm',

                messageTop:
                    'TRN: <?= htmlspecialchars($company['company_trn'] ?? '') ?>',

                exportOptions: {
                    columns: [
                        0, 1, 2, 3, 4,
                        5, 6, 7, 8, 9, 10
                    ]
                }
            },


            /* =====================================================
             * PRINT
             * ===================================================== */

            {
                extend: 'print',

                title: '',

                className: 'btn-sm',

                exportOptions: {
                    columns: [
                        0, 1, 2, 3, 4,
                        5, 6, 7, 8, 9, 10
                    ]
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
                     * Same header as Project List
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
                            Project Progress Report
                        </h3>

                    `;


                    /* =====================================================
                     * INSERT HEADER
                     * ===================================================== */

                    $(win.document.body).prepend(headerHtml);


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
            padding: 2px 0 10px 0;
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
            padding: 3px !important;
            text-align: left;
        }

        table tbody td {
            border: 1px solid #ccc !important;
            padding: 3px !important;
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


        /* =========================================================
         * INIT COMPLETE
         * ========================================================= */

        initComplete: function () {

            $('.dataTables_filter input')

                .addClass('form-control')

                .attr(
                    'placeholder',
                    'Search...'
                );


            $('.dataTables_length select')

                .addClass('form-control');

        }

    });


    /* =========================================================
     * PROJECT FILTER
     * ========================================================= */

    $('#project_filter').on(
        'change',
        function () {

            var value = $(this).val();

            if (value === '') {

                table
                    .column(2)
                    .search('')
                    .draw();

            } else {

                var escapedValue =
                    $.fn.dataTable.util.escapeRegex(value);

                table
                    .column(2)
                    .search(
                        '^' +
                        escapedValue +
                        '$',
                        true,
                        false
                    )
                    .draw();
            }

        }
    );


    /* =========================================================
     * DATE FILTER
     * ========================================================= */

    $.fn.dataTable.ext.search.push(
        function (
            settings,
            data,
            dataIndex
        ) {

            /* Only apply to this table */

            if (
                settings.nTable.id !==
                'datatable-responsive1'
            ) {
                return true;
            }


            var dateType =
                $('#date_type').val();

            var fromDate =
                $('#from_date').val();

            var toDate =
                $('#to_date').val();


            /* No date filter */

            if (
                dateType === '' ||
                (
                    fromDate === '' &&
                    toDate === ''
                )
            ) {

                return true;
            }


            var tableDate = '';


            /* =================================================
             * CREATED DATE
             * ================================================= */

            if (dateType === 'created') {

                tableDate = data[10];

            }


            /* =================================================
             * START DATE
             * ================================================= */

            else if (dateType === 'start') {

                tableDate = data[5];

            }


            /* =================================================
             * END DATE
             * ================================================= */

            else if (dateType === 'end') {

                tableDate = data[6];

            }


            /* =================================================
             * CONVERT DATE
             * ================================================= */

            function convertDate(dateString) {

                if (!dateString) {

                    return '';
                }


                /* Remove time */

                dateString =
                    dateString
                        .trim()
                        .split(' ')[0];


                var parts =
                    dateString.split('-');


                if (parts.length !== 3) {

                    return '';
                }


                var day =
                    parts[0];

                var month =
                    parts[1];

                var year =
                    parts[2];


                return (
                    year +
                    '-' +
                    month +
                    '-' +
                    day
                );
            }


            var rowDate =
                convertDate(tableDate);


            if (rowDate === '') {

                return false;
            }


            /* =================================================
             * FROM DATE
             * ================================================= */

            if (fromDate !== '') {

                if (rowDate < fromDate) {

                    return false;
                }
            }


            /* =================================================
             * TO DATE
             * ================================================= */

            if (toDate !== '') {

                if (rowDate > toDate) {

                    return false;
                }
            }


            return true;

        }
    );


    /* =========================================================
     * DATE TYPE CHANGE
     * ========================================================= */

    $('#date_type').on(
        'change',
        function () {

            table.draw();

        }
    );


    /* =========================================================
     * FROM DATE
     * ========================================================= */

    $('#from_date').on(
        'change',
        function () {

            table.draw();

        }
    );


    /* =========================================================
     * TO DATE
     * ========================================================= */

    $('#to_date').on(
        'change',
        function () {

            table.draw();

        }
    );


    /* =========================================================
     * RESET FILTERS
     * ========================================================= */

    $('#reset_filters').on(
        'click',
        function (e) {

            e.preventDefault();


            $('#project_filter')
                .val('')
                .trigger('change.select2');


            $('#date_type')
                .val('');


            $('#from_date')
                .val('');


            $('#to_date')
                .val('');


            table
                .column(2)
                .search('');


            table.draw();

        }
    );

});

</script>
</div>