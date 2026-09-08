<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>
        Stock Transfer - <?= htmlspecialchars($master->transfer_code) ?>
    </title>

    <style>
        @page {
            size: A4;
            margin: 15mm 12mm 20mm 12mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .print-button {
            text-align: right;
            margin-bottom: 15px;
        }

        .print-button button {
            padding: 7px 15px;
            border: 1px solid #ccc;
            background: #f5f5f5;
            cursor: pointer;
            font-size: 12px;
        }

        /* =========================
           HEADER
        ========================= */

        .company-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .company-header td {
            border: none;
            vertical-align: top;
        }

        .company-logo {
            width: 55%;
            text-align: left;
        }

        .company-logo img {
            width: 300px;
            height: auto;
            max-height: 150px;
            object-fit: contain;
            display: block;
        }

        .company-qr {
            width: 45%;
            text-align: right;
            vertical-align: top;
        }

        .company-qr img {
            height: 70px;
            width: 100px;
            max-width: 350px;
            display: block;
            margin-left: auto;
        }

        .trn {
            margin-top: 5px;
            font-size: 11px;
            text-align: right;
        }

        /* =========================
           DOCUMENT TITLE
        ========================= */

        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0 18px 0;
            letter-spacing: 0.3px;
        }

        /* =========================
           DOCUMENT INFORMATION
        ========================= */

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .info-table td {
            border: none;
            padding: 5px 3px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 17%;
            white-space: nowrap;
        }

        .info-value {
            width: 33%;
        }

        /* =========================
           LOCATION SECTION
        ========================= */

        .location-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .location-wrapper td {
            width: 50%;
            vertical-align: top;
            border: none;
            padding: 0 5px 0 0;
        }

        .location-wrapper td:last-child {
            padding: 0 0 0 5px;
        }

        .location-box {
            border: 1px solid #d5d5d5;
            padding: 10px;
            min-height: 125px;
        }

        .location-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 9px;
            padding-bottom: 6px;
            border-bottom: 1px solid #ddd;
        }

        .location-row {
            margin-bottom: 7px;
        }

        .location-label {
            font-weight: bold;
            display: inline-block;
            width: 105px;
        }

        /* =========================
           ITEMS TABLE
        ========================= */

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .items th {
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 8px 6px;
            font-size: 11px;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
        }

        .items td {
            border-bottom: 1px solid #ddd;
            padding: 8px 6px;
            vertical-align: top;
        }

        .items .sl {
            width: 7%;
            text-align: center;
        }

        .items .code {
            width: 16%;
        }

        .items .product {
            width: 28%;
        }

        .items .unit {
            width: 11%;
            text-align: center;
        }

        .items .qty {
            width: 15%;
            text-align: right;
        }

        .items .remarks {
            width: 23%;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .total-row td {
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            font-weight: bold;
            padding: 8px 6px;
        }

        /* =========================
           REMARKS
        ========================= */

        .remarks-box {
            margin-top: 18px;
            border: 1px solid #d5d5d5;
            padding: 10px;
            min-height: 50px;
        }

        .remarks-title {
            font-weight: bold;
            margin-bottom: 6px;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .summary-table td {
            border: none;
            padding: 5px 3px;
        }

        .summary-label {
            text-align: right;
            font-weight: bold;
            width: 80%;
        }

        .summary-value {
            text-align: right;
            width: 20%;
            font-weight: bold;
        }

        /* =========================
           SIGNATURES
        ========================= */

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 65px;
            page-break-inside: avoid;
        }

        .signature-table td {
            width: 33.33%;
            text-align: center;
            border: none;
            padding-top: 25px;
            vertical-align: bottom;
        }

        .signature-line {
            width: 150px;
            margin: 0 auto 6px auto;
            border-top: 1px solid #333;
        }

        .signature-label {
            font-size: 11px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            position: fixed;
            bottom: -12mm;
            left: 0;
            width: 100%;
            text-align: center;
        }

        .footer img {
            max-width: 100%;
            height: auto;
            max-height: 70px;
        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            .print-button {
                display: none;
            }

            body {
                margin: 0;
            }

            .items {
                page-break-inside: auto;
            }

            .items tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .location-wrapper,
            .remarks-box,
            .signature-table {
                page-break-inside: avoid;
            }
        }
    </style>

</head>

<body>

    <!-- PRINT BUTTON -->
    <div class="print-button">
        <button type="button" onclick="window.print()">
            Print
        </button>
    </div>


    <!-- =========================
         COMPANY HEADER
    ========================== -->

    <table class="company-header">

        <tr>

            <td class="company-logo">

                <?php if (!empty($company['company_logo'])) { ?>

                    <img src="<?= base_url($company['company_logo']) ?>"
                        alt="Company Logo">

                <?php } ?>

            </td>


            <td class="company-qr">

                <img src="<?= base_url('uploads/company/barcode.png') ?>"
                    alt="QR Code">

                <div class="trn">

                    TRN:
                    <?= !empty($company['company_trn'])
                        ? htmlspecialchars($company['company_trn'])
                        : '' ?>

                </div>

            </td>

        </tr>

    </table>


    <!-- =========================
         TITLE
    ========================== -->

    <div class="document-title">
        STOCK TRANSFER
    </div>


    <!-- =========================
         TRANSFER INFORMATION
    ========================== -->

    <table class="info-table">

        <tr>

            <td class="info-label">
                Transfer No
            </td>

            <td class="info-value">
                <?= htmlspecialchars($master->transfer_code) ?>
            </td>

            <td class="info-label">
                Transfer Date
            </td>

            <td class="info-value">
                <?= !empty($master->transfer_date)
                    ? date('d-m-Y', strtotime($master->transfer_date))
                    : '' ?>
            </td>

        </tr>


        <tr>

            <td class="info-label">
                Status
            </td>

            <td class="info-value">
                <?= htmlspecialchars($master->status) ?>
            </td>

            <td class="info-label">
                Document Type
            </td>

            <td class="info-value">
                Stock Transfer
            </td>

        </tr>

    </table>


    <!-- =========================
         SOURCE / DESTINATION
    ========================== -->

    <table class="location-wrapper">

        <tr>

            <!-- FROM -->

            <td>

                <div class="location-box">

                    <div class="location-title">
                        TRANSFER FROM
                    </div>


                    <div class="location-row">

                        <span class="location-label">
                            Branch:
                        </span>

                        <?= htmlspecialchars($master->from_branch) ?>

                    </div>


                    <div class="location-row">

                        <span class="location-label">
                            Warehouse:
                        </span>

                        <?= htmlspecialchars($master->from_warehouse) ?>

                    </div>


                    <div class="location-row">

                        <span class="location-label">
                            Store:
                        </span>

                        <?= htmlspecialchars($master->from_store) ?>

                    </div>

                </div>

            </td>


            <!-- TO -->

            <td>

                <div class="location-box">

                    <div class="location-title">
                        TRANSFER TO
                    </div>


                    <div class="location-row">

                        <span class="location-label">
                            Branch:
                        </span>

                        <?= htmlspecialchars($master->to_branch) ?>

                    </div>


                    <div class="location-row">

                        <span class="location-label">
                            Warehouse:
                        </span>

                        <?= htmlspecialchars($master->to_warehouse) ?>

                    </div>


                    <div class="location-row">

                        <span class="location-label">
                            Store:
                        </span>

                        <?= htmlspecialchars($master->to_store) ?>

                    </div>

                </div>

            </td>

        </tr>

    </table>


    <!-- =========================
         ITEMS
    ========================== -->

    <table class="items">

        <thead>

            <tr>

                <th class="sl">
                    Sl. No
                </th>

                <th class="code">
                    Product Code
                </th>

                <th class="product">
                    Product
                </th>

                <th class="unit text-center">
                    Unit
                </th>

                <th class="qty text-right">
                    Transfer Qty
                </th>

                <th class="remarks">
                    Remarks
                </th>

            </tr>

        </thead>


        <tbody>

            <?php

            $total_qty = 0;

            if (!empty($items)) {

                foreach ($items as $key => $item):

                    $total_qty += (float)$item->transfer_qty;

            ?>

                    <tr>

                        <td class="sl">
                            <?= $key + 1 ?>
                        </td>

                        <td class="code">
                            <?= htmlspecialchars($item->product_code) ?>
                        </td>

                        <td class="product">
                            <?= htmlspecialchars($item->product_name) ?>
                        </td>

                        <td class="unit text-center">
                            <?= htmlspecialchars($item->unit_name) ?>
                        </td>

                        <td class="qty text-right">
                            <?= number_format((float)$item->transfer_qty, 2) ?>
                        </td>

                        <td class="remarks">
                            <?= !empty($item->remarks)
                                ? nl2br(htmlspecialchars($item->remarks))
                                : '' ?>
                        </td>

                    </tr>

                <?php

                endforeach;
            } else {

                ?>

                <tr>

                    <td colspan="6" class="text-center">
                        No items found.
                    </td>

                </tr>

            <?php } ?>


            <!-- TOTAL -->

            <tr class="total-row">

                <td colspan="4" class="text-right">
                    Total
                </td>

                <td class="text-right">
                    <?= number_format($total_qty, 2) ?>
                </td>

                <td></td>

            </tr>

        </tbody>

    </table>


    <!-- =========================
         SUMMARY
    ========================== -->

    <table class="summary-table">

        <tr>

            <td class="summary-label">
                Total Items:
            </td>

            <td class="summary-value">
                <?= !empty($items) ? count($items) : 0 ?>
            </td>

        </tr>

        <tr>

            <td class="summary-label">
                Total Transfer Quantity:
            </td>

            <td class="summary-value">
                <?= number_format($total_qty, 2) ?>
            </td>

        </tr>

    </table>


    <!-- =========================
         GENERAL REMARKS
    ========================== -->

    <?php if (!empty($master->remarks)) { ?>

        <div class="remarks-box">

            <div class="remarks-title">
                Remarks
            </div>

            <?= nl2br(htmlspecialchars($master->remarks)) ?>

        </div>

    <?php } ?>


    <!-- =========================
         SIGNATURES
    ========================== -->

    <table class="signature-table">

        <tr>

            <td>

                <div class="signature-line"></div>

                <div class="signature-label">
                    Prepared By
                </div>

            </td>


            <td>

                <div class="signature-line"></div>

                <div class="signature-label">
                    Issued By
                </div>

            </td>


            <td>

                <div class="signature-line"></div>

                <div class="signature-label">
                    Received By
                </div>

            </td>

        </tr>

    </table>


    <!-- =========================
         COMPANY FOOTER
    ========================== -->

    <div class="footer">

        <?php if (!empty($company['company_footer'])) { ?>

            <img src="<?= base_url($company['company_footer']) ?>"
                alt="Company Footer">

        <?php } ?>

    </div>

</body>

</html>