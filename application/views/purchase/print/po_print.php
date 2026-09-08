<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Purchase Order</title>

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

        /* =========================
           HEADER
        ========================== */

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

        /* =========================
           DOCUMENT TITLE
        ========================== */

        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 8px 0 15px 0;
            color: #222;
        }

        /* =========================
           DOCUMENT INFORMATION
        ========================== */

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
            width: 110px;
        }

        .document-info .value {
            font-weight: normal;
        }

        /* =========================
           SUPPLIER / BRANCH
        ========================== */

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

        /* =========================
           BILLING / SHIPPING
        ========================== */

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

        /* =========================
           PRODUCTS
        ========================== */

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

        /* =========================
           TOTALS
        ========================== */

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

        /* =========================
           TERMS
        ========================== */

        .section-heading {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #222;
            border-bottom: 1px solid #999;
            padding-bottom: 5px;
            margin-top: 12px;
            margin-bottom: 6px;
        }

        .terms-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 15px;
        }

        .terms-table td {
            padding: 6px 7px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        .terms-table td:first-child {
            width: 22%;
            font-weight: bold;
            color: #444;
        }

        /* =========================
           APPROVALS
        ========================== */

        .approval-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .approval-table td {
            width: 25%;
            border: none;
            vertical-align: top;
            padding: 5px;
        }

        .approval-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .signature {
            height: 55px;
            max-width: 130px;
            margin-top: 4px;
            display: block;
        }

        .approval-name {
            font-size: 11px;
            margin-top: 3px;
        }

        .stamp {
            max-width: 140px;
            max-height: 100px;
            margin-top: -5px;
        }

        /* =========================
           FOOTER
        ========================== */

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
    /*
|--------------------------------------------------------------------------
| Safe company variable
|--------------------------------------------------------------------------
| The controller should pass:
| $data['company'] = $this->Setup_model->get_company_details();
|--------------------------------------------------------------------------
*/
    $company = !empty($company) ? $company : [];
    ?>

    <div class="page-content">

        <!-- =========================================================
         COMPANY HEADER
    ========================================================== -->

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

                <!-- QR + TRN -->
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


        <!-- =========================================================
         DOCUMENT TITLE
    ========================================================== -->

        <div class="document-title">
            PURCHASE ORDER
        </div>


        <!-- =========================================================
         PO INFORMATION
    ========================================================== -->

        <table class="document-info">

            <tr>

                <td class="label">
                    PO No:
                </td>

                <td class="value">
                    <strong><?= $po->po_code ?></strong>
                </td>

                <td class="label">
                    PO Date:
                </td>

                <td class="value">
                    <?= date('d-m-Y', strtotime($po->po_date)) ?>
                </td>

            </tr>

            <tr>

                <td class="label">
                    Quotation No:
                </td>

                <td class="value">
                    <?= !empty($po->quotation_code)
                        ? $po->quotation_code
                        : '-' ?>
                </td>

                <td class="label">
                    Currency:
                </td>

                <td class="value">
                    <?= !empty($po->currency_abbr)
                        ? $po->currency_abbr
                        : '-' ?>
                </td>

            </tr>

        </table>


        <!-- =========================================================
         SUPPLIER / BRANCH
    ========================================================== -->

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
                                <?= $po->supplier_name ?>
                            </strong>

                            <br>

                            <?php if (!empty($po->contact_number)) { ?>
                                <?= $po->contact_number ?><br>
                            <?php } ?>

                            <?php if (!empty($po->supplier_email)) { ?>
                                <?= $po->supplier_email ?><br>
                            <?php } ?>

                            <?php if (!empty($po->billing_address)) { ?>
                                <?= $po->billing_address ?><br>
                            <?php } ?>

                            <?= $po->billing_city ?>,
                            <?= $po->billing_state ?>,
                            <?= $po->billing_country ?>

                        </div>

                    </div>

                </td>


                <!-- BRANCH -->
                <td>

                    <div class="party-box">

                        <div class="party-title">
                            Branch
                        </div>

                        <div class="party-info">

                            <strong>
                                <?= $branch_name ?>
                            </strong>

                            <br>

                            <?php if (!empty($branch_contact)) { ?>
                                <?= $branch_contact ?><br>
                            <?php } ?>

                            <?php if (!empty($branch_email)) { ?>
                                <?= $branch_email ?><br>
                            <?php } ?>

                            <?php if (!empty($branch_address)) { ?>
                                <?= $branch_address ?><br>
                            <?php } ?>

                            <?php if (!empty($branch_location)) { ?>
                                <?= $branch_location ?><br>
                            <?php } ?>

                            <?php if (!empty($branch_trn)) { ?>
                                TRN: <?= $branch_trn ?><br>
                            <?php } ?>

                            <?php if (!empty($branch_web)) { ?>
                                Web: <?= $branch_web ?>
                            <?php } ?>

                        </div>

                    </div>

                </td>

            </tr>
        </table>


        <!-- =========================================================
         BILLING / SHIPPING
    ========================================================== -->

        <table class="address-wrapper">
            <tr>

                <!-- BILLING -->
                <td>

                    <div class="address-box">

                        <div class="address-title">
                            Billing Address
                        </div>

                        <div class="address-info">

                            <?= $po->billing_address ?><br>

                            <?= $po->billing_city ?>,
                            <?= $po->billing_state ?>,
                            <?= $po->billing_country ?>

                        </div>

                    </div>

                </td>


                <!-- SHIPPING -->
                <td>

                    <div class="address-box">

                        <div class="address-title">
                            Shipping Address
                        </div>

                        <div class="address-info">

                            <?= !empty($po->shipping_address)
                                ? $po->shipping_address
                                : '-' ?>

                            <?php if (
                                !empty($po->shipping_city) ||
                                !empty($po->shipping_state) ||
                                !empty($po->shipping_country)
                            ) { ?>

                                <br>

                                <?= $po->shipping_city ?>,
                                <?= $po->shipping_state ?>,
                                <?= $po->shipping_country ?>

                            <?php } ?>

                        </div>

                    </div>

                </td>

            </tr>
        </table>


        <!-- =========================================================
         PRODUCTS
    ========================================================== -->

        <table class="products">

            <thead>

                <tr>

                    <th width="5%">#</th>

                    <th width="15%">
                        Model
                    </th>

                    <th width="31%">
                        Description
                    </th>

                    <th width="8%">
                        Qty
                    </th>

                    <th width="9%">
                        Unit
                    </th>

                    <th width="11%">
                        Price
                    </th>

                    <th width="9%">
                        Currency
                    </th>

                    <th width="12%">
                        Total
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php

                $sl = 1;

                $total_before_vat = 0;
                $total_discount   = 0;
                $grand_total      = 0;

                if (!empty($po_tr)) {

                    foreach ($po_tr as $item):

                        $total_before_vat +=
                            ((float)$item->price * (float)$item->quantity);

                        $total_discount +=
                            (float)$item->dis_amt;

                        $grand_total +=
                            (float)$item->total;

                ?>

                        <tr>

                            <td class="text-center">
                                <?= $sl++ ?>
                            </td>

                            <td class="text-left">
                                <?= $item->product_name ?>
                            </td>

                            <td class="text-left">
                                <?= $item->description ?>
                            </td>

                            <td class="text-center">
                                <?= $item->quantity ?>
                            </td>

                            <td class="text-center">
                                <?= $item->unit_name ?>
                            </td>

                            <td class="text-right">
                                <?= number_format($item->price, 2) ?>
                            </td>

                            <td class="text-center">
                                <?= $po->currency_abbr ?>
                            </td>

                            <td class="text-right">
                                <?= number_format($item->total, 2) ?>
                            </td>

                        </tr>

                <?php

                    endforeach;
                }

                ?>

            </tbody>

        </table>


        <!-- =========================================================
         SUMMARY / TOTALS
    ========================================================== -->

        <table class="summary-wrapper">

            <tr>

                <!-- AMOUNT IN WORDS -->
                <td class="amount-words">

                    <strong>
                        Amount in Words:
                    </strong>

                    <br>

                    <?= numberToWordsAED((float)$po->grand_total); ?>

                </td>


                <!-- TOTALS -->
                <td class="totals-cell">

                    <table class="totals">

                        <tr>

                            <td class="label">
                                Total Before VAT
                            </td>

                            <td class="amount">
                                <?= number_format($total_before_vat, 2) ?>
                            </td>

                        </tr>


                        <?php if (!empty($total_discount) && $total_discount > 0) { ?>

                            <tr>

                                <td class="label">
                                    Discount Amount
                                </td>

                                <td class="amount">
                                    <?= number_format($total_discount, 2) ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <?php if (!empty($po->vat_amt) && $po->vat_amt > 0) { ?>

                            <tr>

                                <td class="label">
                                    VAT Amount
                                </td>

                                <td class="amount">
                                    <?= number_format($po->vat_amt, 2) ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <tr class="grand-total">

                            <td class="label">
                                Grand Total
                            </td>

                            <td class="amount">
                                <?= number_format($po->grand_total, 2) ?>
                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>


        <!-- =========================================================
         TERMS & CONDITIONS
    ========================================================== -->

        <div class="section-heading">
            Terms & Conditions
        </div>

        <table class="terms-table">

            <tr>

                <td>
                    Validity
                </td>

                <td>
                    <?= !empty($po->validity)
                        ? $po->validity
                        : '-' ?>
                </td>

            </tr>


            <tr>

                <td>
                    Payment Terms
                </td>

                <td>
                    <?= !empty($po->payment_term)
                        ? $po->payment_term
                        : '-' ?>
                </td>

            </tr>


            <tr>

                <td>
                    Delivery Terms
                </td>

                <td>
                    <?= !empty($po->delivery_term)
                        ? $po->delivery_term
                        : '-' ?>
                </td>

            </tr>


            <tr>

                <td>
                    Other Conditions
                </td>

                <td>
                    <?= !empty($po->terms_and_condition)
                        ? $po->terms_and_condition
                        : '-' ?>
                </td>

            </tr>


            <tr>

                <td>
                    Remarks
                </td>

                <td>
                    <?= !empty($po->remarks)
                        ? $po->remarks
                        : '-' ?>
                </td>

            </tr>

        </table>


        <!-- =========================================================
         APPROVAL / SIGNATURES
    ========================================================== -->

        <table class="approval-table">

            <tr>

                <!-- PREPARED BY -->
                <td style="text-align:left;">

                    <div class="approval-title">
                        Prepared By:
                    </div>

                    <?php if (!empty($prepared_signature)) { ?>

                        <img
                            src="<?= base_url('public/employee/' . $prepared_signature) ?>"
                            class="signature">

                    <?php } ?>

                    <div class="approval-name">
                        <?= htmlspecialchars($prepared_by_name ?? '') ?>
                    </div>

                </td>


                <!-- CHECKED BY -->
                <td style="text-align:center;">

                    <div class="approval-title">
                        Checked By:
                    </div>

                    <?php if (!empty($checked_signature)) { ?>

                        <img
                            src="<?= base_url('public/employee/' . $checked_signature) ?>"
                            class="signature"
                            style="margin-left:auto;margin-right:auto;">

                    <?php } ?>

                    <div class="approval-name">
                        <?= htmlspecialchars($checked_by_name ?? '') ?>
                    </div>

                </td>


                <!-- APPROVED BY -->
                <td style="text-align:center;">

                    <div class="approval-title">
                        Approved By:
                    </div>

                    <?php if (!empty($approved_signature)) { ?>

                        <img
                            src="<?= base_url('public/employee/' . $approved_signature) ?>"
                            class="signature"
                            style="margin-left:auto;margin-right:auto;">

                    <?php } ?>

                    <div class="approval-name">
                        <?= htmlspecialchars($approved_by_name ?? '') ?>
                    </div>

                </td>


                <!-- STAMP -->
                <td style="text-align:right;">

                    <?php if (!empty($branch_stamp)) { ?>

                        <?php

                        $path = FCPATH . ltrim($branch_stamp, './');

                        if (file_exists($path)) {

                            $type = pathinfo($path, PATHINFO_EXTENSION);

                            $data = file_get_contents($path);

                            $base64 =
                                'data:image/' .
                                $type .
                                ';base64,' .
                                base64_encode($data);

                        ?>

                            <img
                                src="<?= $base64 ?>"
                                alt="Stamp"
                                class="stamp">

                        <?php } ?>

                    <?php } ?>

                </td>

            </tr>

        </table>

    </div>


    <!-- =============================================================
     COMPANY FOOTER
============================================================== -->

    <div class="page-footer">

        <?php if (!empty($company['company_footer'])) { ?>

            <img
                src="<?= base_url($company['company_footer']) ?>"
                alt="Company Footer">

        <?php } ?>

    </div>


</body>

</html>