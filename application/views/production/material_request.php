<div class="x_panel">

    <!--<div class="x_title">
        <h2>Create Material Request</h2>
        <div class="clearfix"></div>
    </div>-->

    <div class="x_content">

        <div class="row">

            <div class="col-md-4">

                <label>Material Request No.</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $material_request_no ?>"
                    readonly
                    id="material_request_no">

            </div>

            <div class="col-md-4">

                <label>Request Date</label>

                <input
                    type="date"
                    class="form-control"
                    id="request_date"
                    value="<?= date('Y-m-d') ?>">

            </div>

            <div class="col-md-4">

                <label>
                    Job Order
                    <span class="text-danger">*</span>
                </label>

                <select
                    id="job_order_id"
                    class="form-control select2">

                    <option value="">
                        -- Select Job Order --
                    </option>

                    <?php foreach ($job_orders as $jo): ?>

                        <option
                            value="<?= $jo->job_order_id ?>">

                            <?= htmlspecialchars(
                                $jo->job_order_no
                            ) ?>

                            <?php if (!empty($jo->project_name)): ?>

                                -
                                <?= htmlspecialchars(
                                    $jo->project_name
                                ) ?>

                            <?php endif; ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        </div>

        <br>

        <div
            id="materialRequestSection"
            style="display:none;">

            <div class="panel panel-default">

                <div class="panel-heading">

                    <strong>
                        Required Raw Materials
                    </strong>

                </div>

                <div class="panel-body">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped"
                            id="materialRequestTable">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Product</th>

                                    <th>Material</th>

                                    <th>Required</th>

                                    <!--<th>Previously Requested</th>-->

                                    <th>Remaining</th>

                                    <th>Request Qty</th>

                                    <th>Unit</th>

                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">
                                       Select a Job Order.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <div class="form-group">

                <label>Remarks</label>

                <textarea
                    id="remarks"
                    class="form-control"
                    rows="3"></textarea>

            </div>

            <div class="text-right">

                <button
                    type="button"
                    id="saveMaterialRequest"
                    class="btn btn-primary">

                    <i class="fa fa-save"></i>
                    Submit Material Request

                </button>

            </div>

        </div>

    </div>

</div>

<script>

var base_url = "<?= base_url(); ?>";

var materialRequestItems = [];


$(document).ready(function () {

    var materialRequestTable =
        $('#materialRequestTable').DataTable({

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

               
                {
                    extend: 'excelHtml5',

                    title: 'Material Request List',

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


                                <!-- QR CODE + TRN -->
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
                                Material Request List
                            </h3>

                        `;


                        $(win.document.body)
                            .prepend(headerHtml);


                        /* =================================================
                         * PRINT CSS
                         * ================================================= */
                        $(win.document.head).append(`

                            <style>

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
                                        5px 0 10px 0;

                                    margin:
                                        0 0 10px 0;

                                    page-break-inside:
                                        avoid;

                                }


                                /* =================================================
                                 * LOGO
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
                                 * RIGHT SIDE
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
                                 * TITLE
                                 * ================================================= */
                                .print-report-title {

                                    width:
                                        100%;

                                    text-align:
                                        left;

                                    margin:
                                        12px 0 15px 0;

                                    padding:
                                        0;

                                    font-size:
                                        22px;

                                    font-weight:
                                        bold;

                                    page-break-after:
                                        avoid;

                                }


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
                                 * PRINT
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
                                            10px 15px !important;

                                    }


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


                                    .st-header-logo-print {

                                        width:
                                            65% !important;

                                        flex:
                                            0 0 65% !important;

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
                                            350px !important;

                                        min-width:
                                            350px !important;

                                        max-width:
                                            100% !important;

                                        height:
                                            auto !important;

                                        max-height:
                                            85px !important;

                                        display:
                                            block !important;

                                        object-fit:
                                            contain !important;

                                    }


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

                                }

                            </style>

                        `);

                    }

                }

            ]

        });


    $('#job_order_id').on('change', function () {

        var jobOrderId = $(this).val();

        materialRequestItems = [];

        if (!jobOrderId) {

            $('#materialRequestSection').hide();

            return;
        }


        $.ajax({

            url:
                base_url +
                'index.php/Production/get_materials_for_material_request',

            type: 'POST',

            dataType: 'json',

            data: {
                job_order_id: jobOrderId
            },


            success: function (response) {

                if (!response.status) {

                    alert(
                        response.message ||
                        'Unable to load materials.'
                    );

                    return;
                }


                materialRequestItems =
                    response.items;


                renderMaterialRequestItems();


                $('#materialRequestSection')
                    .show();

            },


            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Unable to load Job Order materials.'
                );

            }

        });

    });


});


function renderMaterialRequestItems()
{

    var tbody =
        $('#materialRequestTable tbody');


    tbody.empty();


    if (!materialRequestItems.length) {

        tbody.html(

            '<tr>' +

            '<td colspan="7" class="text-center">' +

            'No raw materials found for this Job Order.' +

            '</td>' +

            '</tr>'

        );

        return;
    }


    $.each(

        materialRequestItems,

        function(index, item) {


            var remaining =
                parseFloat(
                    item.remaining_quantity
                ) || 0;


            if (remaining <= 0) {

                return;

            }


            tbody.append(

                '<tr>' +

                '<td>' +
                (index + 1) +
                '</td>' +


                '<td>' +
                escapeHtml(
                    item.item_description || ''
                ) +
                '</td>' +


                '<td>' +
                escapeHtml(
                    item.material_name || ''
                ) +
                '</td>' +


                '<td>' +
                parseInt(
                    item.quantity_required,
                    10
                ) +
                '</td>' +


                '<td class="remaining-qty">' +
                parseInt(
                    item.remaining_quantity,
                    10
                ) +
                '</td>' +


                '<td>' +

                '<input type="number" ' +

                'class="form-control request-qty" ' +

                'data-index="' +
                index +
                '" ' +

                'data-required="' +
                item.quantity_required +
                '" ' +

                'data-previously-requested="' +
                item.previously_requested +
                '" ' +

                'min="0" ' +

                'max="' +
                item.remaining_quantity +
                '" ' +

                'step="1" ' +

                'value="' +
                item.remaining_quantity +
                '">' +

                '</td>' +


                '<td>' +

                escapeHtml(
                    item.unit_id || ''
                ) +

                '</td>' +


                '</tr>'

            );

        }

    );

}


function escapeHtml(text)
{

    return $('<div>')
        .text(text)
        .html();

}

$('#saveMaterialRequest').on(
    'click',
    function () {


        var jobOrderId =
            $('#job_order_id').val();


        if (!jobOrderId) {

            alert(
                'Please select a Job Order.'
            );

            return;
        }


        var items = [];


        $('.request-qty').each(
            function () {


                var index =
                    $(this).data('index');


                var qty =
                    parseFloat(
                        $(this).val()
                    ) || 0;


                if (qty <= 0) {

                    return;

                }


                var item =
                    materialRequestItems[index];


                var remaining =
                    parseFloat(
                        item.remaining_quantity
                    ) || 0;


                if (qty > remaining) {

                    alert(
                        'Request quantity cannot exceed remaining quantity for ' +
                        item.material_name
                    );


                    items = [];


                    return false;

                }


                items.push({

                    job_order_item_id:
                        item.job_order_item_id,

                    job_order_material_id:
                        item.job_order_material_id,

                    material_id:
                        item.material_id,

                    material_code:
                        item.material_code,

                    material_name:
                        item.material_name,

                    required_quantity:
                        item.quantity_required,

                    previously_requested:
                        item.previously_requested,

                    request_quantity:
                        qty,

                    unit:
                        item.unit

                });

            }
        );


        if (!items.length) {

            alert(
                'Please enter at least one material quantity.'
            );

            return;

        }


        $.ajax({

            url:
                base_url +
                'index.php/Production/save_material_request',

            type: 'POST',

            dataType: 'json',

            data: {

                job_order_id:
                    jobOrderId,

                request_date:
                    $('#request_date').val(),

                remarks:
                    $('#remarks').val(),

                items:
                    JSON.stringify(items)

            },


            beforeSend: function () {

                $('#saveMaterialRequest')
                    .prop('disabled', true)
                    .html(
                        '<i class="fa fa-spinner fa-spin"></i> Saving...'
                    );

            },


            success: function (response) {

                if (response.status) {

                    alert(
                        response.message
                    );


                    window.location.href =
                        base_url +
                        'index.php/Production/material_requests';

                } else {

                    alert(
                        response.message ||
                        'Unable to save Material Request.'
                    );

                }

            },


            error: function (xhr) {

                console.log(
                    xhr.responseText
                );


                alert(
                    'Unable to save Material Request.'
                );

            },


            complete: function () {

                $('#saveMaterialRequest')
                    .prop('disabled', false)
                    .html(
                        '<i class="fa fa-save"></i> Submit Material Request'
                    );

            }

        });

    }
);

$(document).on(
    'input',
    '.request-quantity',
    function () {

        var qty =
            parseFloat(
                $(this).val()
            ) || 0;


        var max =
            parseFloat(
                $(this).attr('max')
            ) || 0;


        if (qty > max) {

            alert(
                'Request quantity cannot exceed ' +
                max
            );


            qty = max;


            $(this).val(qty);

        }


        var required =
            parseFloat(
                $(this).data('required')
            ) || 0;


        var previously =
            parseFloat(
                $(this).data('previously')
            ) || 0;


        var remaining =
            required -
            previously -
            qty;


        if (remaining < 0) {

            remaining = 0;

        }


        $(this)
            .closest('tr')
            .find('.remaining-quantity')
            .text(
                remaining.toFixed(2)
            );

    }
);


/* =========================================================
 * REQUEST QTY
 * ========================================================= */
$(document).on(
    'input',
    '.request-qty',
    function () {


        var input = $(this);


        var required =
            parseFloat(
                input.attr('data-required')
            ) || 0;


        var previouslyRequested =
            parseFloat(
                input.attr(
                    'data-previously-requested'
                )
            ) || 0;


        var requestQty =
            parseFloat(
                input.val()
            ) || 0;


        /*
         * Maximum quantity
         */
        var maxQty =
            required -
            previouslyRequested;


        if (maxQty < 0) {

            maxQty = 0;

        }


        /*
         * Prevent exceeding remaining
         */
        if (requestQty > maxQty) {

            alert(
                'Request quantity cannot exceed ' +
                maxQty.toFixed(2)
            );


            requestQty =
                maxQty;


            input.val(
                requestQty.toFixed(2)
            );

        }


        /*
         * Calculate remaining
         */
        var remaining =
            maxQty -
            requestQty;


        if (remaining < 0) {

            remaining = 0;

        }


        /*
         * Update current row
         */
        input
            .closest('tr')
            .find('.remaining-qty')
            .text(
                remaining.toFixed(2)
            );

    }

);

</script>

