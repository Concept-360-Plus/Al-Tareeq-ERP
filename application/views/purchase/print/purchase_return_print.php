<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Purchase Return</title>

    <style>
        @page {
            margin: 12mm 12mm 22mm 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .page-content {
            width: 100%;
        }


        /* =====================================================
           COMPANY HEADER
        ====================================================== */

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .company-logo {
            width: 300px;
            height: auto;
            max-height: 150px;
            object-fit: contain;
            display: block;
        }

        .barcode-container {
            text-align: right;
        }

        .barcode {
            height: 70px;
            width: 100px;
            display: block;
            margin-left: auto;
        }

        .trn {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin-top: 5px;
            font-weight: bold;
            text-align: right;
        }


        /* =====================================================
           DOCUMENT TITLE
        ====================================================== */

        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 8px 0 15px 0;
            color: #222;
        }


        /* =====================================================
           DOCUMENT INFORMATION
        ====================================================== */

        .document-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .document-info td {
            border: none;
            padding: 4px 8px;
            vertical-align: top;
        }

        .document-info .label {
            font-weight: bold;
            color: #555;
            width: 105px;
        }

        .document-info .value {
            font-weight: normal;
        }


        /* =====================================================
           SUPPLIER / RECEIVING LOCATION
        ====================================================== */

        .party-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .party-wrapper td {
            width: 50%;
            vertical-align: top;
            padding: 0 8px 0 0;
            border: none;
        }

        .party-wrapper td:last-child {
            padding: 0 0 0 8px;
        }

        .party-box {
            border: 1px solid #d8d8d8;
            padding: 9px 10px;
            min-height: 105px;
        }

        .party-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 7px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            color: #222;
        }

        .party-info {
            font-size: 11px;
            line-height: 1.55;
        }


        /* =====================================================
           RETURN REASON / REMARKS
        ====================================================== */

        .remarks-box {
            width: 100%;
            border: 1px solid #d8d8d8;
            padding: 9px 10px;
            margin-bottom: 18px;
            box-sizing: border-box;
        }

        .remarks-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            color: #444;
        }

        .remarks-content {
            font-size: 11px;
            line-height: 1.5;
        }


        /* =====================================================
           ITEMS TABLE
        ====================================================== */

        table.products {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 15px;
            font-size: 11px;
        }

        table.products th {
            background: #f3f3f3;
            color: #222;
            font-weight: bold;
            padding: 8px 6px;
            border-top: 1px solid #999;
            border-bottom: 1px solid #999;
            border-left: none;
            border-right: none;
            text-align: center;
        }

        table.products td {
            padding: 7px 6px;
            border-bottom: 1px solid #ddd;
            border-left: none;
            border-right: none;
            vertical-align: top;
        }

        table.products tbody tr:last-child td {
            border-bottom: 1px solid #999;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }


        /* =====================================================
           TOTAL QUANTITY
        ====================================================== */

        .summary-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        .summary-wrapper td {
            border: none;
            vertical-align: top;
        }

        .summary-note {
            width: 58%;
            padding: 5px 15px 5px 0;
            font-size: 11px;
            line-height: 1.5;
        }

        .total-cell {
            width: 42%;
        }

        table.total-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table.total-table td {
            padding: 7px;
            border-bottom: 1px solid #ddd;
        }

        table.total-table td.label {
            width: 65%;
            text-align: left;
            font-weight: bold;
        }

        table.total-table td.amount {
            width: 35%;
            text-align: right;
        }

        table.total-table tr.grand-total td {
            border-top: 1px solid #777;
            border-bottom: 1px solid #777;
            font-size: 12px;
            font-weight: bold;
            padding-top: 8px;
            padding-bottom: 8px;
        }


        /* =====================================================
           SIGNATURES
        ====================================================== */

        .signature-section {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-section td {
            width: 33.33%;
            border: none;
            text-align: center;
            vertical-align: bottom;
            padding: 5px;
        }

        .signature-space {
            height: 45px;
        }

        .signature-line {
            border-top: 1px solid #777;
            width: 75%;
            margin: 0 auto 5px auto;
        }

        .signature-title {
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .page-footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -12mm;
            text-align: center;
        }

        .page-footer img {
            width: 100%;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }


        .no-break {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    </style>

</head>


<body>


    <?php

    $company = !empty($company) ? $company : [];

    ?>


    <div class="page-content">


        <!-- =====================================================
         COMPANY HEADER
    ====================================================== -->

        <table class="header-table">

            <tr>

                <!-- COMPANY LOGO -->

                <td width="55%">

                    <?php if (!empty($company['company_logo'])) { ?>

                        <img
                            src="<?= base_url($company['company_logo']) ?>"
                            alt="Company Logo"
                            class="company-logo">

                    <?php } ?>

                </td>


                <!-- QR CODE + TRN -->

                <td width="45%" style="text-align:right;">

                    <?php if (file_exists(FCPATH . 'uploads/company/barcode.png')) { ?>

                        <div class="barcode-container">

                            <img
                                src="<?= base_url('uploads/company/barcode.png') ?>"
                                alt="QR Code"
                                class="barcode">

                            <div class="trn">

                                TRN:
                                <?= !empty($company['company_trn'])
                                    ? $company['company_trn']
                                    : '' ?>

                            </div>

                        </div>

                    <?php } ?>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         TITLE
    ====================================================== -->

        <div class="document-title">

            PURCHASE RETURN

        </div>


        <!-- =====================================================
         RETURN INFORMATION
    ====================================================== -->

        <table class="document-info">

            <tr>

                <td class="label">
                    Return No:
                </td>

                <td class="value">

                    <strong>
                        <?= !empty($master->return_code)
                            ? $master->return_code
                            : '-' ?>
                    </strong>

                </td>


                <td class="label">
                    Return Date:
                </td>

                <td class="value">

                    <?= !empty($master->return_date)
                        ? date(
                            'd-m-Y',
                            strtotime($master->return_date)
                        )
                        : '-' ?>

                </td>

            </tr>


            <tr>

                <td class="label">
                    GRN No:
                </td>

                <td class="value">

                    <?= !empty($master->grn_code)
                        ? $master->grn_code
                        : '-' ?>

                </td>


                <td class="label">
                    Warehouse:
                </td>

                <td class="value">

                    <?= !empty($master->warehouse_name)
                        ? $master->warehouse_name
                        : '-' ?>

                </td>

            </tr>


            <tr>

                <td class="label">
                    Store:
                </td>

                <td class="value">

                    <?= !empty($master->store_name)
                        ? $master->store_name
                        : '-' ?>

                </td>


                <td class="label">
                    Document Type:
                </td>

                <td class="value">

                    Purchase Return

                </td>

            </tr>

        </table>


        <!-- =====================================================
         SUPPLIER / RETURN LOCATION
    ====================================================== -->

        <table class="party-wrapper">

            <tr>


                <!-- SUPPLIER -->

                <td>

                    <div class="party-box">

                        <div class="party-title">
                            Supplier
                        </div>

                        <div class="party-info">

                            <strong>
                                <?= !empty($master->supplier_name)
                                    ? $master->supplier_name
                                    : '-' ?>
                            </strong>

                            <br>


                            <?php if (!empty($master->contact_number)) { ?>

                                <?= $master->contact_number ?>

                                <br>

                            <?php } ?>


                            <?php if (!empty($master->supplier_email)) { ?>

                                <?= $master->supplier_email ?>

                                <br>

                            <?php } ?>


                            <?php if (!empty($master->billing_address)) { ?>

                                <?= $master->billing_address ?>

                            <?php } ?>

                        </div>

                    </div>

                </td>


                <!-- RETURN LOCATION -->

                <td>

                    <div class="party-box">

                        <div class="party-title">
                            Return Location
                        </div>

                        <div class="party-info">

                            <strong>
                                <?= !empty($master->warehouse_name)
                                    ? $master->warehouse_name
                                    : '-' ?>
                            </strong>

                            <br>

                            Store:
                            <?= !empty($master->store_name)
                                ? $master->store_name
                                : '-' ?>

                            <?php if (!empty($master->grn_code)) { ?>

                                <br>

                                Original GRN:
                                <?= $master->grn_code ?>

                            <?php } ?>

                        </div>

                    </div>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         REMARKS
    ====================================================== -->

        <div class="remarks-box">

            <div class="remarks-title">
                Remarks
            </div>

            <div class="remarks-content">

                <?= !empty($master->remarks)
                    ? nl2br($master->remarks)
                    : '-' ?>

            </div>

        </div>


        <!-- =====================================================
         RETURN ITEMS
    ====================================================== -->

        <table class="products">

            <thead>

                <tr>

                    <th width="6%">
                        Sl No
                    </th>

                    <th width="14%">
                        Product Code
                    </th>

                    <th width="22%">
                        Product
                    </th>

                    <th width="24%">
                        Description
                    </th>

                    <th width="9%">
                        Unit
                    </th>

                    <th width="11%">
                        Returned Qty
                    </th>

                    <th width="14%">
                        Reason
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php

                $i = 1;
                $total_qty = 0;

                if (!empty($items)) {

                    foreach ($items as $row):

                        $total_qty += (float)$row->return_qty;

                ?>

                        <tr>

                            <td class="text-center">

                                <?= $i++ ?>

                            </td>


                            <td class="text-left">

                                <?= !empty($row->product_code)
                                    ? $row->product_code
                                    : '-' ?>

                            </td>


                            <td class="text-left">

                                <?= !empty($row->product_name)
                                    ? $row->product_name
                                    : '-' ?>

                            </td>


                            <td class="text-left">

                                <?= !empty($row->description)
                                    ? $row->description
                                    : '-' ?>

                            </td>


                            <td class="text-center">

                                <?= !empty($row->unit_name)
                                    ? $row->unit_name
                                    : '-' ?>

                            </td>


                            <td class="text-right">

                                <?= number_format(
                                    (float)$row->return_qty,
                                    2
                                ) ?>

                            </td>


                            <td class="text-left">

                                <?= !empty($row->reason)
                                    ? $row->reason
                                    : '-' ?>

                            </td>

                        </tr>

                    <?php

                    endforeach;
                } else {

                    ?>

                    <tr>

                        <td
                            colspan="7"
                            class="text-center"
                            style="padding:15px;">
                            No items found.
                        </td>

                    </tr>

                <?php

                }

                ?>

            </tbody>

        </table>


        <!-- =====================================================
         TOTAL RETURNED QUANTITY
    ====================================================== -->

        <table class="summary-wrapper">

            <tr>

                <td class="summary-note">

                    <strong>
                        Total Items:
                    </strong>

                    <?= !empty($items)
                        ? count($items)
                        : 0 ?>

                </td>


                <td class="total-cell">

                    <table class="total-table">

                        <tr class="grand-total">

                            <td class="label">
                                Total Returned Qty
                            </td>

                            <td class="amount">

                                <?= number_format(
                                    $total_qty,
                                    2
                                ) ?>

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         SIGNATURES
    ====================================================== -->

        <table class="signature-section">

            <tr>


                <!-- PREPARED BY -->

                <td>

                    <div class="signature-space"></div>

                    <div class="signature-line"></div>

                    <div class="signature-title">
                        Prepared By
                    </div>

                </td>


                <!-- CHECKED BY -->

                <td>

                    <div class="signature-space"></div>

                    <div class="signature-line"></div>

                    <div class="signature-title">
                        Checked By
                    </div>

                </td>


                <!-- APPROVED BY -->

                <td>

                    <div class="signature-space"></div>

                    <div class="signature-line"></div>

                    <div class="signature-title">
                        Approved By
                    </div>

                </td>

            </tr>

        </table>


    </div>


    <!-- =========================================================
     COMPANY FOOTER
========================================================== -->

    <div class="page-footer">

        <?php if (!empty($company['company_footer'])) { ?>

            <img
                src="<?= base_url($company['company_footer']) ?>"
                alt="Company Footer">

        <?php } ?>

    </div>


</body>

</html>