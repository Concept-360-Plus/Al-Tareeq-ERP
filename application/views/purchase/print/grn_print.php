<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Goods Received Note</title>

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

        /* =========================================
           COMPANY HEADER
        ========================================== */

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
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
            color: #333;
            text-align: right;
        }


        /* =========================================
           DOCUMENT TITLE
        ========================================== */

        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 8px 0 15px 0;
            color: #222;
        }


        /* =========================================
           DOCUMENT INFORMATION
        ========================================== */

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
            width: 100px;
        }

        .document-info .value {
            font-weight: normal;
        }


        /* =========================================
           SUPPLIER / BRANCH
        ========================================== */

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


        /* =========================================
           BILLING ADDRESS
        ========================================== */

        .address-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .address-wrapper td {
            width: 50%;
            vertical-align: top;
            padding: 0 8px 0 0;
            border: none;
        }

        .address-wrapper td:last-child {
            padding: 0 0 0 8px;
        }

        .address-box {
            border: 1px solid #d8d8d8;
            padding: 9px 10px;
            min-height: 65px;
        }

        .address-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            color: #444;
        }

        .address-info {
            font-size: 11px;
            line-height: 1.5;
        }


        /* =========================================
           PRODUCTS
        ========================================== */

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


        /* =========================================
           SUMMARY
        ========================================== */

        .summary-wrapper {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 18px;
        }

        .summary-wrapper>tbody>tr>td {
            vertical-align: top;
            border: none;
        }

        .amount-words {
            width: 58%;
            padding: 5px 15px 5px 0;
            font-size: 11px;
            line-height: 1.5;
        }

        .totals-cell {
            width: 42%;
        }

        table.totals {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table.totals td {
            padding: 6px 7px;
            border-bottom: 1px solid #ddd;
        }

        table.totals td.label {
            text-align: left;
            font-weight: bold;
            width: 65%;
        }

        table.totals td.amount {
            text-align: right;
            width: 35%;
        }

        table.totals tr.grand-total td {
            border-top: 1px solid #777;
            border-bottom: 1px solid #777;
            font-weight: bold;
            font-size: 12px;
            padding-top: 8px;
            padding-bottom: 8px;
        }


        /* =========================================
           PREPARED BY
        ========================================== */

        .approval-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .approval-table td {
            border: none;
            vertical-align: top;
            padding: 5px;
        }

        .approval-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 5px;
        }


        /* =========================================
           FOOTER
        ========================================== */

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

    $grn_data = !empty($grn[0]) ? $grn[0] : null;
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

            GOODS RECEIVED NOTE

        </div>


        <!-- =====================================================
         GRN INFORMATION
    ====================================================== -->

        <table class="document-info">

            <tr>

                <td class="label">
                    GRN No:
                </td>

                <td class="value">

                    <strong>
                        <?= $grn_data->grn_code ?? '-' ?>
                    </strong>

                </td>


                <td class="label">
                    GRN Date:
                </td>

                <td class="value">

                    <?= !empty($grn_data->grn_date)
                        ? date('d-m-Y', strtotime($grn_data->grn_date))
                        : '-' ?>

                </td>

            </tr>


            <tr>

                <td class="label">
                    Warehouse:
                </td>

                <td class="value">

                    <?= $grn_data->warehouse_name ?? '-' ?>

                </td>


                <td class="label">
                    Store:
                </td>

                <td class="value">

                    <?= $grn_data->store_name ?? '-' ?>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         SUPPLIER / BRANCH
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
                                <?= $grn_data->supplier_name ?? '-' ?>
                            </strong>

                            <br>


                            <?php if (!empty($grn_data->contact_number)) { ?>

                                <?= $grn_data->contact_number ?>

                                <br>

                            <?php } ?>


                            <?php if (!empty($grn_data->supplier_email)) { ?>

                                <?= $grn_data->supplier_email ?>

                                <br>

                            <?php } ?>


                            <?php if (!empty($grn_data->billing_address)) { ?>

                                <?= $grn_data->billing_address ?>

                                <br>

                            <?php } ?>

                        </div>

                    </div>

                </td>


                <!-- RECEIVING LOCATION -->

                <td>

                    <div class="party-box">

                        <div class="party-title">
                            Receiving Location
                        </div>

                        <div class="party-info">

                            <strong>
                                <?= $grn_data->warehouse_name ?? '-' ?>
                            </strong>

                            <br>

                            Store:
                            <?= $grn_data->store_name ?? '-' ?>

                        </div>

                    </div>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         BILLING ADDRESS
    ====================================================== -->

        <table class="address-wrapper">

            <tr>

                <td>

                    <div class="address-box">

                        <div class="address-title">
                            Billing Address
                        </div>

                        <div class="address-info">

                            <?= $grn_data->billing_address ?? '-' ?>

                        </div>

                    </div>

                </td>


                <td>

                    <div class="address-box">

                        <div class="address-title">
                            Supplier
                        </div>

                        <div class="address-info">

                            <?= $grn_data->supplier_name ?? '-' ?>

                        </div>

                    </div>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         PRODUCTS
    ====================================================== -->

        <table class="products">

            <thead>

                <tr>

                    <th width="6%">
                        Sl No
                    </th>

                    <th width="16%">
                        Model
                    </th>

                    <th width="32%">
                        Description
                    </th>

                    <th width="9%">
                        Qty
                    </th>

                    <th width="10%">
                        Unit
                    </th>

                    <th width="13%">
                        Price
                    </th>

                    <th width="14%">
                        Total
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php

                $sl_no = 1;

                $total_before_vat = 0;
                $total_discount   = 0;

                $vat_amount = $grn_data->vat_amt ?? 0;
                $discount   = $grn_data->discount ?? 0;
                $grand_total = $grn_data->grand_total ?? 0;


                if (!empty($grn_tr)) {

                    foreach ($grn_tr as $detail):

                        $total_before_vat +=
                            ((float)$detail->price * (float)$detail->rec_quantity);

                        $total_discount +=
                            (float)($detail->discount_amt ?? 0);

                ?>

                        <tr>

                            <td class="text-center">
                                <?= $sl_no++ ?>
                            </td>

                            <td class="text-left">
                                <?= $detail->product_name ?>
                            </td>

                            <td class="text-left">
                                <?= $detail->description ?>
                            </td>

                            <td class="text-center">
                                <?= $detail->rec_quantity ?>
                            </td>

                            <td class="text-center">
                                <?= $detail->unit_name ?>
                            </td>

                            <td class="text-right">
                                <?= number_format((float)$detail->price, 2) ?>
                            </td>

                            <td class="text-right">
                                <?= number_format((float)$detail->total, 2) ?>
                            </td>

                        </tr>

                <?php

                    endforeach;
                }

                ?>

            </tbody>

        </table>


        <!-- =====================================================
         TOTALS
    ====================================================== -->

        <table class="summary-wrapper">

            <tr>


                <!-- AMOUNT IN WORDS -->

                <td class="amount-words">

                    <strong>
                        Amount in Words:
                    </strong>

                    <br>

                    <?php
                    if (function_exists('numberToWordsAED')) {
                        echo numberToWordsAED((float)$grand_total);
                    }
                    ?>

                </td>


                <!-- TOTALS -->

                <td class="totals-cell">

                    <table class="totals">

                        <tr>

                            <td class="label">
                                Total Before VAT
                            </td>

                            <td class="amount">
                                <?= number_format(
                                    (float)$total_before_vat,
                                    2
                                ) ?>
                            </td>

                        </tr>


                        <?php if ((float)$discount > 0) { ?>

                            <tr>

                                <td class="label">
                                    Discount Amount
                                </td>

                                <td class="amount">
                                    <?= number_format(
                                        (float)$discount,
                                        2
                                    ) ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <?php if ((float)$vat_amount > 0) { ?>

                            <tr>

                                <td class="label">
                                    VAT Amount
                                </td>

                                <td class="amount">
                                    <?= number_format(
                                        (float)$vat_amount,
                                        2
                                    ) ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <tr class="grand-total">

                            <td class="label">
                                Grand Total
                            </td>

                            <td class="amount">
                                <?= number_format(
                                    (float)$grand_total,
                                    2
                                ) ?>
                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>


        <!-- =====================================================
         PREPARED BY
    ====================================================== -->

        <table class="approval-table">

            <tr>

                <td width="50%" style="text-align:left;">

                    <div class="approval-title">
                        Prepared By:
                    </div>

                    <div>
                        <?= !empty($grn_data->created_by)
                            ? $grn_data->created_by
                            : '-' ?>
                    </div>

                </td>


                <td width="50%" style="text-align:right;">

                    <div class="approval-title">
                        Goods Received Note
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