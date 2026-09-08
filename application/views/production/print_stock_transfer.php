
<!DOCTYPE html>
<html>
<head>
    <title>Stock Transfer</title>
<style>
 @media print {
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;    /* this affects the margin in the printer settings */
    }
    body {
        margin: 1.6cm;  /* adds margin back to content so text isn't cut off */
    }}
.h2, h2
 {
    font-size: 2rem;
}
.job-order-header {
    width: 100%;
    height: 140px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 5px;
}
.header-logo {
    width: 55%;
}

.header-logo img {
    width: 380px;
    max-width: 100%;
    max-height: 130px;
    height: auto;
    object-fit: cover;
    display: block;
}

.header-qr {
    width: 45%;
    text-align: right;
}

.header-qr img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    display: block;
    margin-left: auto;
}

.header-qr .trn {
    font-size: 11px;
    font-weight: bold;
    margin-top: 3px;
}

@media print {

    .print-btn{
        display:none;
    }

}

</style>
    <style>

        /* =========================================================
         * STOCK TRANSFER PRINT STYLE
         * ========================================================= */

        .st-print-area {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #222;
            background: #fff;
        }

        .st-print-area h2 {
            font-size: 24px;
            margin: 10px 0 15px;
            font-weight: 700;
        }

        .st-print-area h3 {
            font-size: 17px;
            margin: 18px 0 8px;
            font-weight: 700;
        }

        .st-print-area h4 {
            font-size: 15px;
            margin: 12px 0 7px;
            font-weight: 700;
        }

        /* =========================================================
         * HEADER
         * ========================================================= */

        .st-header {
            width: 100%;
            height: 140px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .st-header-logo {
            width: 55%;
        }

        .st-header-logo img {
            width: 380px;
            max-width: 100%;
            max-height: 130px;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .st-header-right {
            width: 45%;
            text-align: right;
        }

        .st-header-right img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            display: block;
            margin-left: auto;
        }

        .st-trn {
            font-size: 11px;
            font-weight: bold;
            margin-top: 3px;
        }

        /* =========================================================
         * TITLE
         * ========================================================= */

        .st-title {
            border-bottom: 2px solid #222;
            padding-bottom: 7px;
            margin-bottom: 15px !important;
            letter-spacing: .3px;
        }

        .st-title small {
            font-size: 12px;
            font-weight: normal;
            color: #666;
        }

        /* =========================================================
         * INFORMATION TABLE
         * ========================================================= */

        .st-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .st-info-table th,
        .st-info-table td {
            border: 1px solid #000;
            padding: 7px 8px;
            vertical-align: middle;
            font-size: 12px;
        }

        .st-info-table th {
            background: #f2f2f2;
            font-weight: 700;
            width: 16%;
        }

        .st-info-table td {
            width: 34%;
        }

        /* =========================================================
         * SECTION HEADER
         * ========================================================= */

        .st-section {
            margin-top: 18px;
            margin-bottom: 8px;
            padding: 7px 10px;
            border-left: 5px solid #222;
            border-bottom: 1px solid #222;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        /* =========================================================
         * LOCATION BOX
         * ========================================================= */

        .st-location-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .st-location-table td {
            width: 50%;
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }

        .st-location-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .st-location-value {
            font-size: 12px;
            line-height: 1.7;
        }

        /* =========================================================
         * ITEM TABLE
         * ========================================================= */

        .st-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .st-table th,
        .st-table td {
            border: 1px solid #000;
            padding: 6px 7px;
            font-size: 12px;
        }

        .st-table th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .st-table td {
            vertical-align: middle;
        }

        .st-center {
            text-align: center !important;
        }

        .st-right {
            text-align: right !important;
        }

        .st-item-name {
            font-weight: 600;
        }

        /* =========================================================
         * STATUS
         * ========================================================= */

        .st-status {
            display: inline-block;
            padding: 4px 10px;
            border: 1px solid #555;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* =========================================================
         * JOB ORDER / JOB COMPLETION
         * ========================================================= */

        .st-sub-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .st-sub-table th,
        .st-sub-table td {
            border: 1px solid #000;
            padding: 6px 7px;
            font-size: 12px;
        }

        .st-sub-table th {
            background: #f2f2f2;
            font-weight: bold;
        }

        /* =========================================================
         * MATERIAL REQUEST
         * ========================================================= */

        .st-material-request {
            border: 1px solid #000;
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .st-material-request-header {
            padding: 8px 10px;
            background: #f2f2f2;
            border-bottom: 1px solid #000;
            font-weight: bold;
            font-size: 13px;
        }

        .st-material-request-header span {
            margin-right: 25px;
        }

        .st-material-table {
            width: 100%;
            border-collapse: collapse;
        }

        .st-material-table th,
        .st-material-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        .st-material-table th {
            background: #fafafa;
            font-weight: bold;
            text-align: center;
        }

        /* =========================================================
         * REMARKS
         * ========================================================= */

        .st-remarks-box {
            border: 1px solid #000;
            padding: 10px;
            min-height: 45px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .st-remarks-title {
            font-weight: bold;
            font-size: 12px;
            margin: 8px 0 4px;
            text-decoration: underline;
        }

        /* =========================================================
         * SIGNATURE
         * ========================================================= */

        .st-signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 45px;
        }

        .st-signature-table td {
            text-align: center;
            padding: 8px;
            font-size: 12px;
        }

        .st-signature-space {
            height: 65px;
            vertical-align: bottom;
        }

        /* =========================================================
         * FOOTER
         * ========================================================= */

        .st-footer {
            margin-top: 30px;
            width: 100%;
            text-align: center;
        }

        .st-footer img {
            width: 100%;
            max-height: 80px;
            object-fit: contain;
        }

        /* =========================================================
         * SCREEN
         * ========================================================= */

        @media screen {

            .st-print-area {
                background: #fff;
                padding: 10px;
            }

            .st-header {
                display: none;
            }

            .st-remarks-box {
                width: 80%;
            }
        }

        /* =========================================================
         * PRINT
         * ========================================================= */

        @media print {

           .st-print-area{
            padding:10px;
           }

           
            #stockTransferPrintArea,
            #stockTransferPrintArea * {
                visibility: visible;
            }

            #stockTransferPrintArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
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

            .st-table,
            .st-info-table,
            .st-location-table,
            .st-sub-table,
            .st-material-table,
            .st-signature-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .st-table th,
            .st-table td,
            .st-info-table th,
            .st-info-table td,
            .st-location-table td,
            .st-sub-table th,
            .st-sub-table td,
            .st-material-table th,
            .st-material-table td {
                border: 1px solid #000 !important;
            }

            .st-section {
                page-break-after: avoid;
            }

            .st-location-table,
            .st-table,
            .st-info-table,
            .st-sub-table,
            .st-material-table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }

            .st-material-request {
                page-break-inside: avoid;
            }

            .st-signature-table {
                margin-top: 45px !important;
                page-break-inside: avoid;
            }

            .st-signature-table td {
                height: 65px !important;
            }

            .st-footer {
                page-break-inside: avoid;
            }
            
        }

    </style>
</head>

<body>

<div id="stockTransferPrintArea" class="st-print-area" style="padding: 10px;">

    <!-- =========================================================
         COMPANY HEADER
         ========================================================= -->

    <div class="st-header">

        <div class="st-header-logo">

            <?php if (!empty($company['company_logo'])) { ?>

                <img
                    src="<?= base_url($company['company_logo']) ?>"
                    alt="Company Logo"
                >

            <?php } ?>

        </div>

        <div class="st-header-right">

            <img
                src="<?= base_url('uploads/company/barcode.png') ?>"
                alt="QR Code"
            >

            <div class="st-trn">
                TRN:
                <?= htmlspecialchars($company['company_trn'] ?? '') ?>
            </div>

        </div>

    </div>


    <!-- =========================================================
         PRINT BUTTON
         ========================================================= -->

    <button
        type="button"
        class="btn btn-default no-print"
        id="printStockTransfer"
    >
        <i class="fa fa-print"></i>
        Print
    </button>


    <!-- =========================================================
         STOCK TRANSFER TITLE
         ========================================================= -->

    <h2 class="st-title">

        Stock Transfer -
        <?= htmlspecialchars(
            $stock_transfer->stock_transfer_no ?? ''
        ) ?>

    </h2>


    <!-- =========================================================
         STOCK TRANSFER INFORMATION
         ========================================================= -->

    <div class="st-section">
        Stock Transfer Information
    </div>

    <table class="st-info-table">

        <tr>

            <th>Transfer No</th>

            <td>
                <?= htmlspecialchars(
                    $stock_transfer->stock_transfer_no ?? ''
                ) ?>
            </td>

            <th>Transfer Date</th>

            <td>
                <?php
                if (!empty($stock_transfer->ref_date)) {
                    echo htmlspecialchars(
                        date(
                            'd-m-Y',
                            strtotime($stock_transfer->ref_date)
                        )
                    );
                }
                ?>
            </td>

        </tr>

        <tr>

            <th>Reference No</th>

            <td>
                <?= htmlspecialchars(
                    $stock_transfer->ref_number ?? ''
                ) ?>
            </td>

            <th>Status</th>

            <td>
                <span class="st-status">
                    <?= htmlspecialchars(
                        $stock_transfer->status ?? ''
                    ) ?>
                </span>
            </td>

        </tr>

        <tr>

            <th>Job Completion No</th>

            <td>
                <?= htmlspecialchars(
                    $stock_transfer->job_completion_no ?? ''
                ) ?>
            </td>

            <th>Job Order No</th>

            <td>
                <?= htmlspecialchars(
                    $stock_transfer->job_order_no ?? ''
                ) ?>
            </td>

        </tr>

        <tr>

            <th>Sales Order</th>

            <td>
                <?= htmlspecialchars(
                    $stock_transfer->so_id ?? ''
                ) ?>
            </td>

            <th>Project</th>

            <td>
                <?= htmlspecialchars(
                    $job_order->project_name ?? ''
                ) ?>
            </td>

        </tr>

    </table>


    <!-- =========================================================
         LOCATION
         ========================================================= -->

    <div class="st-section">
        Transfer Location
    </div>

    <table class="st-location-table">

        <tr>

            <td>

                <div class="st-location-title">
                    Location From
                </div>

                <div class="st-location-value">

                    <strong>Branch:</strong>
                    <?= htmlspecialchars(
                        $stock_transfer->from_branch_name  ?? ''
                    ) ?>

                    <br>

                    <strong>Warehouse:</strong>
                    <?= htmlspecialchars(
                        $stock_transfer->from_warehouse_name  ?? ''
                    ) ?>

                    <br>

                    <strong>Store:</strong>
                    <?= htmlspecialchars(
                        $stock_transfer->from_store_name ?? ''
                    ) ?>

                </div>

            </td>


            <td>

                <div class="st-location-title">
                    Location To
                </div>

                <div class="st-location-value">

                    <strong>Branch:</strong>
                    <?= htmlspecialchars(
                        $stock_transfer->to_branch_name  ?? ''
                    ) ?>

                    <br>

                    <strong>Warehouse:</strong>
                    <?= htmlspecialchars(
                        $stock_transfer->to_warehouse_name  ?? ''
                    ) ?>

                    <br>

                    <strong>Store:</strong>
                    <?= htmlspecialchars(
                        $stock_transfer->to_store_name ?? ''
                    ) ?>

                </div>

            </td>

        </tr>

    </table>


    <!-- =========================================================
         STOCK TRANSFER ITEMS
         ========================================================= -->

    <div class="st-section">
        Stock Transfer Items
    </div>

    <table class="st-table">

        <thead>

            <tr>

                <th width="40">#</th>

                <th width="110">Item Code</th>

                <th>Item Description</th>

                <th width="85">Completed</th>

                <th width="95">Previously Transferred</th>

                <th width="85">Transfer Qty</th>

                <th width="85">Remaining</th>

                <th width="60">Unit</th>

            </tr>

        </thead>

        <tbody>

        <?php if (!empty($stock_transfer_items)) { ?>

            <?php foreach (
                $stock_transfer_items
                as $index => $item
            ) { ?>

                <tr>

                    <td class="st-center">
                        <?= $index + 1 ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $item->item_code
                            ?? $item->product_code
                            ?? ''
                        ) ?>
                    </td>

                    <td class="st-item-name">

                        <?= htmlspecialchars(
                            $item->product_name
                            ?? $item->item_description
                            ?? ''
                        ) ?>

                    </td>

                    <td class="st-right">
                        <?= number_format(
                            (float)(
                                $item->completed_quantity
                                ?? 0
                            ),
                            2
                        ) ?>
                    </td>

                    <td class="st-right">
                        <?= number_format(
                            (float)(
                                $item->previously_transferred
                                ?? 0
                            ),
                            2
                        ) ?>
                    </td>

                    <td class="st-right">
                        <?= number_format(
                            (float)(
                                $item->transfer_quantity
                                ?? 0
                            ),
                            2
                        ) ?>
                    </td>

                    <td class="st-right">
                        <?= number_format(
                            (float)(
                                $item->remaining_quantity
                                ?? 0
                            ),
                            2
                        ) ?>
                    </td>

                    <td class="st-center">
                        <?= htmlspecialchars(
                            $item->unit ?? ''
                        ) ?>
                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>

                <td
                    colspan="8"
                    class="st-center"
                >
                    No stock transfer items found.
                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>


    <!-- =========================================================
         JOB COMPLETION
         ========================================================= -->

    <div class="st-section">
        Job Completion
    </div>

    <?php if (!empty($job_completion)) { ?>

        <table class="st-info-table">

            <tr>

                <th>Completion No</th>

                <td>
                    <?= htmlspecialchars(
                        $job_completion->job_completion_no
                        ?? ''
                    ) ?>
                </td>

                <th>Completion Date</th>

                <td>

                    <?php
                    if (!empty(
                        $job_completion->completion_date
                    )) {

                        echo htmlspecialchars(
                            date(
                                'd-m-Y',
                                strtotime(
                                    $job_completion
                                        ->completion_date
                                )
                            )
                        );

                    }
                    ?>

                </td>

            </tr>

        </table>


        <?php if (!empty($job_completion_items)) { ?>

            <table class="st-sub-table">

                <thead>

                    <tr>

                        <th width="40">#</th>

                        <th>Item</th>

                        <th width="80">Ordered</th>

                        <th width="90">Previously Completed</th>

                        <th width="80">Completed</th>

                        <th width="80">Remaining</th>

                        <th width="60">Unit</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach (
                    $job_completion_items
                    as $index => $item
                ) { ?>

                    <tr>

                        <td class="st-center">
                            <?= $index + 1 ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $item->product_name
                                ?? $item->item_description
                                ?? ''
                            ) ?>
                        </td>

                        <td class="st-right">
                            <?= number_format(
                                (float)(
                                    $item->ordered_quantity
                                    ?? 0
                                ),
                                2
                            ) ?>
                        </td>

                        <td class="st-right">
                            <?= number_format(
                                (float)(
                                    $item->previously_completed
                                    ?? 0
                                ),
                                2
                            ) ?>
                        </td>

                        <td class="st-right">
                            <?= number_format(
                                (float)(
                                    $item->completed_quantity
                                    ?? 0
                                ),
                                2
                            ) ?>
                        </td>

                        <td class="st-right">
                            <?= number_format(
                                (float)(
                                    $item->remaining_quantity
                                    ?? 0
                                ),
                                2
                            ) ?>
                        </td>

                        <td class="st-center">
                            <?= htmlspecialchars(
                                $item->unit ?? ''
                            ) ?>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        <?php } ?>

    <?php } ?>


    <!-- =========================================================
         JOB COMPLETION REMARKS
         ========================================================= -->

    <?php if (
        !empty($job_completion)
        && !empty($job_completion->remarks)
    ) { ?>

        <div class="st-remarks-title">
            Job Completion Remarks
        </div>

        <div class="st-remarks-box">

            <?= nl2br(
                htmlspecialchars(
                    $job_completion->remarks
                )
            ) ?>

        </div>

    <?php } ?>


    <!-- =========================================================
         JOB ORDER
         ========================================================= -->

    <div class="st-section">
        Job Order
    </div>

    <?php if (!empty($job_order)) { ?>

        <table class="st-info-table">

            <tr>

                <th>Job Order No</th>

                <td>
                    <?= htmlspecialchars(
                        $job_order->job_order_no ?? ''
                    ) ?>
                </td>

                <th>Order Date</th>

                <td>

                    <?php
                    if (!empty($job_order->order_date)) {

                        echo htmlspecialchars(
                            date(
                                'd-m-Y',
                                strtotime(
                                    $job_order->order_date
                                )
                            )
                        );

                    }
                    ?>

                </td>

            </tr>

            <tr>

                <th>Order No</th>

                <td>
                    <?= htmlspecialchars(
                        $job_order->order_no ?? ''
                    ) ?>
                </td>

                <th>Representative</th>

                <td>
                    <?= htmlspecialchars(
                        $job_order->rep_name ?? ''
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>Contact Person</th>

                <td>
                    <?= htmlspecialchars(
                        $job_order->contact_person ?? ''
                    ) ?>
                </td>

                <th>Project</th>

                <td>
                    <?= htmlspecialchars(
                        $job_order->project_name ?? ''
                    ) ?>
                </td>

            </tr>

            <tr>

                <th>Start Date</th>

                <td>

                    <?php
                    if (!empty($job_order->start_date)) {

                        echo htmlspecialchars(
                            date(
                                'd-m-Y',
                                strtotime(
                                    $job_order->start_date
                                )
                            )
                        );

                    }
                    ?>

                </td>

                <th>Finish Date</th>

                <td>

                    <?php
                    if (!empty($job_order->finish_date)) {

                        echo htmlspecialchars(
                            date(
                                'd-m-Y',
                                strtotime(
                                    $job_order->finish_date
                                )
                            )
                        );

                    }
                    ?>

                </td>

            </tr>

        </table>


        <!-- JOB ORDER ITEMS -->

        <?php if (!empty($job_order_items)) { ?>

            <h4>
                Job Order Items
            </h4>

            <?php foreach (
                $job_order_items
                as $index => $item
            ) { ?>

                <table class="st-table">

                    <thead>

                        <tr>

                            <th
                                colspan="5"
                                style="text-align:left;"
                            >

                                Item <?= $index + 1 ?> :
                                <?= htmlspecialchars(
                                    $item->product_name
                                    ?? $item->item_description
                                    ?? ''
                                ) ?>

                            </th>

                        </tr>

                        <tr>

                            <th width="45">#</th>

                            <th>Item</th>

                            <th width="80">Unit</th>

                            <th width="90">Quantity</th>

                            <th width="110">Item Code</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td class="st-center">
                                <?= $index + 1 ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $item->product_name
                                    ?? $item->item_description
                                    ?? ''
                                ) ?>
                            </td>

                            <td class="st-center">
                                <?= htmlspecialchars(
                                    $item->unit ?? ''
                                ) ?>
                            </td>

                            <td class="st-right">
                                <?= number_format(
                                    (float)(
                                        $item->quantity
                                        ?? 0
                                    ),
                                    2
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $item->item_code
                                    ?? $item->product_code
                                    ?? ''
                                ) ?>
                            </td>

                        </tr>

                    </tbody>

                </table>


                <!-- BOM / RAW MATERIALS -->

                <?php if (!empty($item->materials)) { ?>

                    <h4>
                        Raw Materials
                    </h4>

                    <table class="st-material-table">

                        <thead>

                            <tr>

                                <th width="40">#</th>

                                <th>Material Code</th>

                                <th>Material</th>

                                <th width="90">
                                    Required Qty
                                </th>

                                <th width="70">
                                    Unit
                                </th>

                                <th width="80">
                                    Source
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php foreach (
                            $item->materials
                            as $materialIndex => $material
                        ) { ?>

                            <tr>

                                <td class="st-center">
                                    <?= $materialIndex + 1 ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $material->material_code
                                        ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $material->material_name
                                        ?? ''
                                    ) ?>
                                </td>

                                <td class="st-right">
                                    <?= number_format(
                                        (float)(
                                            $material
                                                ->quantity_required
                                            ?? 0
                                        ),
                                        2
                                    ) ?>
                                </td>

                                <td class="st-center">
                                    <?= htmlspecialchars(
                                        $material->unit
                                        ?? ''
                                    ) ?>
                                </td>

                                <td class="st-center">
                                    <?= htmlspecialchars(
                                        $material->source
                                        ?? 'BOM'
                                    ) ?>
                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                <?php } ?>

            <?php } ?>

        <?php } ?>

    <?php } ?>


    <!-- =========================================================
         PRODUCTION MATERIAL REQUESTS
         ========================================================= -->

    <?php if (!empty($material_requests)) { ?>

        <div class="st-section">
            Material Requests
        </div>

        <?php foreach (
            $material_requests
            as $request
        ) { ?>

            <div class="st-material-request">

                <div class="st-material-request-header">

                    <span>
                        Request No:
                        <?= htmlspecialchars(
                            $request->material_request_no
                            ?? ''
                        ) ?>
                    </span>

                    <span>
                        Date:

                        <?php
                        if (!empty($request->request_date)) {

                            echo htmlspecialchars(
                                date(
                                    'd-m-Y',
                                    strtotime(
                                        $request->request_date
                                    )
                                )
                            );

                        }
                        ?>

                    </span>

                    <span>
                        Status:
                        <?= htmlspecialchars(
                            $request->status ?? ''
                        ) ?>
                    </span>

                </div>


                <?php

                $request_items = $request->items ?? array();

                ?>

                <?php if (!empty($request_items)) { ?>

                    <table class="st-material-table">

                        <thead>

                            <tr>

                                <th width="40">#</th>

                                <th>Material Code</th>

                                <th>Material</th>

                                <th width="80">
                                    Required
                                </th>

                                <th width="90">
                                    Previously Requested
                                </th>

                                <th width="80">
                                    Requested
                                </th>

                                <th width="80">
                                    Unit
                                </th>

                                <th width="90">
                                    Unit Cost
                                </th>

                                <th width="90">
                                    Total Cost
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php foreach (
                            $request_items
                            as $index => $material
                        ) { ?>

                            <tr>

                                <td class="st-center">
                                    <?= $index + 1 ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $material->material_code
                                        ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $material->material_name
                                        ?? ''
                                    ) ?>
                                </td>

                                <td class="st-right">
                                    <?= number_format(
                                        (float)(
                                            $material
                                                ->required_quantity
                                            ?? 0
                                        ),
                                        2
                                    ) ?>
                                </td>

                                <td class="st-right">
                                    <?= number_format(
                                        (float)(
                                            $material
                                                ->previously_requested
                                            ?? 0
                                        ),
                                        2
                                    ) ?>
                                </td>

                                <td class="st-right">
                                    <?= number_format(
                                        (float)(
                                            $material
                                                ->request_quantity
                                            ?? 0
                                        ),
                                        2
                                    ) ?>
                                </td>

                                <td class="st-center">
                                    <?= htmlspecialchars(
                                        $material->unit ?? ''
                                    ) ?>
                                </td>

                                <td class="st-right">
                                    <?= number_format(
                                        (float)(
                                            $material->unit_cost
                                            ?? 0
                                        ),
                                        2
                                    ) ?>
                                </td>

                                <td class="st-right">
                                    <?= number_format(
                                        (float)(
                                            $material->total_cost
                                            ?? 0
                                        ),
                                        2
                                    ) ?>
                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                <?php } ?>


                <?php if (!empty($request->remarks)) { ?>

                    <div
                        style="
                            padding:8px 10px;
                            font-size:11px;
                        "
                    >

                        <strong>Remarks:</strong>

                        <?= nl2br(
                            htmlspecialchars(
                                $request->remarks
                            )
                        ) ?>

                    </div>

                <?php } ?>

            </div>

        <?php } ?>

    <?php } ?>


    <!-- =========================================================
         STOCK TRANSFER REMARKS
         ========================================================= -->

    <?php if (!empty($stock_transfer->remarks)) { ?>

        <div class="st-section">
            Remarks
        </div>

        <div class="st-remarks-title">
            Stock Transfer
        </div>

        <div class="st-remarks-box">

            <?= nl2br(
                htmlspecialchars(
                    $stock_transfer->remarks
                )
            ) ?>

        </div>

    <?php } ?>


    <!-- =========================================================
         JOB ORDER REMARKS
         ========================================================= -->

    <?php if (
        !empty($job_order)
        && !empty($job_order->job_order_remarks)
    ) { ?>

        <div class="st-remarks-title">
            Job Order
        </div>

        <div class="st-remarks-box">

            <?= nl2br(
                htmlspecialchars(
                    $job_order->job_order_remarks
                )
            ) ?>

        </div>

    <?php } ?>


    <!-- =========================================================
         SIGNATURES
         ========================================================= -->

    <table
        class="st-signature-table"
        border="0"
    >

        <tr>

            <td>
                Prepared By
            </td>

            <td>
                Checked By
            </td>

            <td>
                Approved By
            </td>

        </tr>

        <tr>

            <td class="st-signature-space"></td>

            <td class="st-signature-space"></td>

            <td class="st-signature-space"></td>

        </tr>

    </table>


</div>


<!-- =========================================================
     PRINT SCRIPT
     ========================================================= -->

<script>

$(document).on(
    'click',
    '#printStockTransfer',
    function () {

        window.print();

    }
);

</script>

</body>
</html>

