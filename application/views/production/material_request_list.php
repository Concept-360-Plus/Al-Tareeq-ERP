<style>
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

    <div class="col-md-12">

        <div class="x_panel">

            <div class="x_title">

                <!--<h2>
                    Production Material Requests
                </h2>

                <a
                    href="<?= base_url('index.php/Production/material_request') ?>"
                    class="btn btn-primary btn-sm pull-right">

                    <i class="fa fa-plus"></i>
                    New Material Request

                </a>-->

                <div class="clearfix"></div>

            </div>

            <div class="x_content">

                <div class="table-responsive">

                    <table
                        id="materialRequestTable"
                        class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>
                                    Request No
                                </th>

                                <th>
                                    Job Order
                                </th>

                                <th>
                                    Project
                                </th>

                                <th>
                                    Request Date
                                </th>

                                <th>
                                    Materials
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="120">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php foreach (
                            $material_requests
                            as $index => $row
                        ): ?>

                            <tr>

                                <td>
                                    <?= $index + 1 ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars(
                                            $row->material_request_no
                                        ) ?>
                                    </strong>
                                </td>

                                <td>
                                    <span class="label label-info">
                                        <?= htmlspecialchars(
                                            $row->job_order_no
                                        ) ?>
                                    </span>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $row->project_name ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= !empty(
                                        $row->request_date
                                    )
                                        ? date(
                                            'd-m-Y',
                                            strtotime(
                                                $row->request_date
                                            )
                                        )
                                        : '' ?>
                                </td>

                                <td>

                                    <span class="label label-primary">

                                        <?= (int)$row->material_count ?>

                                    </span>

                                </td>

                                <td>
                                    <?php

                                    $class = 'label-warning';
                                    if (
                                        $row->status == 'Issued'
                                    ) {
                                        $class ='label-success';

                                    } elseif ( $row->status == 'Cancelled'
                                    ) {

                                        $class = 'label-danger';
                                    }

                                    ?>

                                    <span
                                        class="label <?= $class ?>">

                                        <?= htmlspecialchars(
                                            $row->status
                                        ) ?>

                                    </span>

                                </td>

                                <td>
                                    <!-- View -->
                                     <nobr>
                                    <!--<a href="<?= base_url('index.php/Production/material_request_view/' .$row->production_material_request_id) ?>" title="View">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>-->
                                    <!-- Edit -->
                                    <a href="<?= base_url('index.php/Production/material_request_edit/' .$row->production_material_request_id) ?>" 
                                    title="Edit"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </a>
                                    <a href="<?= base_url('index.php/Production/print_material_request/' .$row->production_material_request_id) ?>" title="Print">
                                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                    </a>
                                     <!-- Delete -->
                                    <button type="button" style="border:none;"class=" deleteMaterialRequest" data-id="<?= $row->production_material_request_id ?>" title="Delete">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                   </button>
                                    </nobr>
                               </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

$(document).ready(function () {

    var table = $('#materialRequestTable').DataTable({

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

        dom:
            '<"dt-top-row"' +
                '<"dt-length"l>' +
                '<"dt-buttons"B>' +
                '<"dt-search"f>' +
            '>' +
            'rtip',

        buttons: [

            {
                extend: 'excelHtml5',

                title: 'Material Request List',

                className: 'btn-sm',

                messageTop:
                    'TRN: <?= htmlspecialchars($company['company_trn'] ?? '') ?>',

                exportOptions: {
                    // Exclude Action column
                    columns: ':not(:last-child)'
                }
            },

           
            {
                extend: 'print',

                title: '',

                className: 'btn-sm',

                exportOptions: {
                    // Exclude Action column
                    columns: ':not(:last-child)'
                },

                customize: function (win) {

                    var companyLogo =
                        "<?= !empty($company['company_logo']) ? base_url($company['company_logo']) : '' ?>";

                    var qrCode =
                        "<?= base_url('uploads/company/barcode.png') ?>";

                    var companyTRN =
                        "<?= htmlspecialchars($company['company_trn'] ?? '') ?>";


                    /* =========================
                     * PRINT HEADER
                     * ========================= */

                    var headerHtml = `

                        <div class="st-header-print">

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


                            <div class="st-header-right-print">

                                <img
                                    src="${qrCode}"
                                    alt="QR Code"
                                    class="qr-code-print"
                                >

                                <div class="st-trn-print">
                                    <strong>TRN:</strong> ${companyTRN}
                                </div>

                            </div>

                        </div>


                        <h3 class="print-report-title">
                            Material Request List
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


    $(document).on(
        'click',
        '.deleteMaterialRequest',
        function () {

            var requestId = $(this).data('id');


            if (!requestId) {

                alert(
                    'Invalid Material Request.'
                );

                return;

            }


            if (
                !confirm(
                    'Are you sure you want to delete this Material Request?'
                )
            ) {

                return;

            }


            $.ajax({

                url:
                    base_url +
                    'index.php/Production/delete_material_request',

                type: 'POST',

                dataType: 'json',

                data: {
                    request_id: requestId
                },


                success: function (response) {

                    if (response.status) {

                        alert(
                            response.message
                        );

                        location.reload();

                    } else {

                        alert(
                            response.message ||
                            'Unable to delete Material Request.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        xhr.responseText
                    );

                    alert(
                        'Unable to delete Material Request.'
                    );

                }

            });

        }
    );

});

</script>

