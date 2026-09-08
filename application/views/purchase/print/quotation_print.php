<!DOCTYPE html>
<html>

<head>

    <title>Supplier Quotation</title>

    <style>
        body {
            margin: 0;
            padding: 0 5px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .no-border,
        .no-border td,
        .no-border th {
            border: none !important;
        }

        .header-table td {
            border: none !important;
            padding: 0;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-bottom: 2px solid #111;
            padding-bottom: 4px;
            display: inline-block;
            width: 100%;
        }

        .info-table td {
            border: none !important;
            padding: 2px 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 13px;
        }

        .items-table th {
            background-color: #f7f7f7;
            border-top: 1px solid #ddd;
            border-bottom: 2px solid #ddd;
            padding: 8px 5px;
            font-weight: bold;
            text-align: center;
        }

        .items-table td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-top: none;
            border-bottom: 1px solid #eee;
            padding: 8px 6px;
            vertical-align: top;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }

        .summary-wrapper {
            width: 100%;
            margin-top: 15px;
        }

        .summary-wrapper>tbody>tr>td {
            border: none !important;
            padding: 0;
        }

        .summary-table {
            width: 280px;
            margin-left: auto;
            border-collapse: collapse;
            font-size: 13px;
        }

        .summary-table td {
            padding: 6px 0;
            border: none;
            border-bottom: 1px solid #eee;
        }

        .summary-label {
            font-weight: bold;
            text-align: left;
        }

        .summary-value {
            text-align: right;
        }

        .grand-total td {
            border-bottom: 2px double #111 !important;
            padding: 8px 0;
            font-size: 15px;
            font-weight: bold;
        }

        .terms-section {
            width: 100%;
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.7;
        }

        .terms-section table td {
            border: none !important;
            padding: 1px 0;
            vertical-align: top;
        }

        .terms-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .signature-table td {
            border: none !important;
            padding: 0;
        }

        .footer {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }

        .footer img {
            max-width: 100%;
            height: auto;
        }

        .barcode-container {
            display: inline-block;
            text-align: right;
        }

        @media print {

            .print-btn {
                display: none;
            }

            @page {
                margin: 8mm;
            }

            body {
                margin: 0;
            }

        }
    </style>

</head>


<body>


    <!-- =========================================================
     HEADER
========================================================= -->

    <table class="header-table" style="width:100%; border-collapse:collapse; border:none;">

        <tr>

            <!-- LEFT : COMPANY LOGO -->
            <td width="55%"
                style="vertical-align:top; border:none; padding:0;">

                <?php if (!empty($company['company_logo'])) { ?>

                    <img
                        src="<?= base_url($company['company_logo']) ?>"
                        alt="Company Logo"
                        style="
                        width:300px;
                        height:auto;
                        max-height:150px;
                        object-fit:contain;
                        display:block;
                    ">

                <?php } ?>

            </td>


            <!-- RIGHT : QR / TRN -->
            <td width="45%"
                style="
                text-align:right;
                vertical-align:top;
                border:none;
                padding:0;
            ">

                <div class="barcode-container">

                    <img
                        src="<?= base_url('uploads/company/barcode.png') ?>"
                        alt="QR Code"
                        style="
                        height:70px;
                        width:100px;
                        max-width:350px;
                        display:block;
                        margin-left:auto;
                    ">

                    <div style="
                    font-family:Arial,sans-serif;
                    font-size:12px;
                    color:#333;
                    margin-top:5px;
                    font-weight:bold;
                    text-align:right;
                ">

                        TRN:
                        <?= !empty($company['company_trn'])
                            ? $company['company_trn']
                            : '' ?>

                    </div>

                </div>

            </td>

        </tr>

    </table>



    <!-- =========================================================
     SUPPLIER + DOCUMENT INFORMATION
========================================================= -->

    <div style="
    width:100%;
    margin-top:20px;
    font-family:Arial,sans-serif;
    font-size:13px;
    line-height:1.6;
    color:#333;
">

        <table style="
        width:100%;
        border-collapse:collapse;
        border:none;
    ">

            <tr>


                <!-- =================================================
                 LEFT : SUPPLIER INFORMATION
            ================================================== -->

                <td style="
                width:55%;
                vertical-align:top;
                border:none;
                padding:0;
            ">

                    <table class="info-table"
                        style="
                           width:100%;
                           border-collapse:collapse;
                           border:none;
                       ">

                        <!-- Supplier Code -->

                        <?php if (!empty($quote[0]->supplier_code)) { ?>

                            <tr>

                                <td style="
                            width:110px;
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                        ">
                                    Supplier ID
                                </td>

                                <td style="
                            padding:2px 0;
                            border:none;
                        ">
                                    : <?= $quote[0]->supplier_code ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <!-- Supplier Name -->

                        <tr>

                            <td style="
                            width:110px;
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                            vertical-align:top;
                        ">
                                Name
                            </td>

                            <td style="
                            padding:2px 0;
                            border:none;
                            vertical-align:top;
                        ">
                                :
                                <?= !empty($quote[0]->supplier_name)
                                    ? $quote[0]->supplier_name
                                    : '' ?>
                            </td>

                        </tr>


                        <!-- Address -->

                        <?php if (!empty($quote[0]->billing_address)) { ?>

                            <tr>

                                <td style="
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                            vertical-align:top;
                        ">
                                    Address
                                </td>

                                <td style="
                            padding:2px 0;
                            border:none;
                            vertical-align:top;
                        ">
                                    :
                                    <?= nl2br($quote[0]->billing_address) ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <!-- Contact -->

                        <?php if (!empty($quote[0]->contact_number)) { ?>

                            <tr>

                                <td style="
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                        ">
                                    Contact No
                                </td>

                                <td style="
                            padding:2px 0;
                            border:none;
                        ">
                                    :
                                    <?= $quote[0]->contact_number ?>
                                </td>

                            </tr>

                        <?php } ?>


                        <!-- Email -->

                        <?php if (!empty($quote[0]->supplier_email)) { ?>

                            <tr>

                                <td style="
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                        ">
                                    Email
                                </td>

                                <td style="
                            padding:2px 0;
                            border:none;
                        ">
                                    :
                                    <?= $quote[0]->supplier_email ?>
                                </td>

                            </tr>

                        <?php } ?>

                    </table>

                </td>



                <!-- =================================================
                 RIGHT : DOCUMENT INFORMATION
            ================================================== -->

                <td style="
                width:45%;
                vertical-align:top;
                border:none;
                padding:0;
            ">

                    <table style="
                    width:280px;
                    margin-left:auto;
                    margin-top:-15px;
                    border-collapse:collapse;
                    border:none;
                ">


                        <!-- TITLE -->

                        <tr>

                            <td colspan="2"
                                style="
                                border:none;
                                padding-bottom:12px;
                            ">

                                <div class="title">
                                    SUPPLIER QUOTATION
                                </div>

                            </td>

                        </tr>


                        <!-- DOCUMENT NUMBER -->

                        <tr>

                            <td style="
                            width:110px;
                            font-size:13px;
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                        ">
                                Reference No
                            </td>

                            <td style="
                            font-size:13px;
                            padding:2px 0;
                            border:none;
                        ">
                                :
                                <?= !empty($quote[0]->quotation_code)
                                    ? $quote[0]->quotation_code
                                    : '' ?>
                            </td>

                        </tr>


                        <!-- DATE -->

                        <tr>

                            <td style="
                            font-size:13px;
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                        ">
                                Date
                            </td>

                            <td style="
                            font-size:13px;
                            padding:2px 0;
                            border:none;
                        ">
                                :

                                <?php
                                if (!empty($quote[0]->quotation_date)) {
                                    echo date(
                                        'd/m/Y',
                                        strtotime($quote[0]->quotation_date)
                                    );
                                }
                                ?>

                            </td>

                        </tr>


                        <!-- SUPPLIER ID -->

                        <tr>

                            <td style="
                            font-size:13px;
                            font-weight:bold;
                            padding:2px 0;
                            border:none;
                        ">
                                Supplier ID
                            </td>

                            <td style="
                            font-size:13px;
                            padding:2px 0;
                            border:none;
                        ">
                                :
                                <?= !empty($quote[0]->supplier_code)
                                    ? $quote[0]->supplier_code
                                    : '' ?>
                            </td>

                        </tr>


                    </table>

                </td>

            </tr>

        </table>

    </div>



    <!-- =========================================================
     ITEM DETAILS
========================================================= -->

    <table class="items-table">

        <thead>

            <tr>

                <th width="5%">
                    #
                </th>

                <th width="13%">
                    Code
                </th>

                <th width="30%"
                    style="text-align:left;">
                    Item Description
                </th>

                <th width="9%">
                    Qty
                </th>

                <th width="9%">
                    Unit
                </th>

                <th width="12%"
                    style="text-align:right;">
                    Rate
                </th>

                <th width="10%"
                    style="text-align:right;">
                    Discount
                </th>

                <th width="12%"
                    style="text-align:right;">
                    Amount
                </th>

            </tr>

        </thead>


        <tbody>

            <?php

            $sl_no = 1;

            $sub_total = 0;

            if (!empty($quote_tr)) {

                foreach ($quote_tr as $detail) {

                    $sub_total += (float)$detail->total;

            ?>

                    <tr>

                        <!-- SL NO -->

                        <td style="text-align:center;">
                            <?= $sl_no++ ?>
                        </td>


                        <!-- PRODUCT CODE -->

                        <td style="text-align:left;">
                            <?= !empty($detail->product_code)
                                ? $detail->product_code
                                : '' ?>
                        </td>


                        <!-- DESCRIPTION -->

                        <td style="text-align:left;">

                            <span style="
                    font-weight:bold;
                    color:#111;
                ">

                                <?= !empty($detail->description)
                                    ? $detail->description
                                    : '' ?>

                            </span>

                        </td>


                        <!-- QTY -->

                        <td style="text-align:center;">

                            <?= number_format(
                                (float)$detail->quantity,
                                2
                            ) ?>

                        </td>


                        <!-- UNIT -->

                        <td style="text-align:center;">

                            <?= !empty($detail->unit_name)
                                ? $detail->unit_name
                                : '' ?>

                        </td>


                        <!-- RATE -->

                        <td style="text-align:right;">

                            <?= number_format(
                                (float)$detail->price,
                                2
                            ) ?>

                        </td>


                        <!-- DISCOUNT -->

                        <td style="text-align:right;">

                            <?= number_format(
                                (float)$detail->dis_amt,
                                2
                            ) ?>

                        </td>


                        <!-- AMOUNT -->

                        <td style="text-align:right;">

                            <?= number_format(
                                (float)$detail->total,
                                2
                            ) ?>

                        </td>

                    </tr>

            <?php

                }
            }

            ?>

        </tbody>

    </table>



    <!-- =========================================================
     TOTAL SUMMARY
========================================================= -->

    <table class="summary-wrapper">

        <tr>

            <!-- LEFT SPACER -->

            <td style="
            width:50%;
            border:none;
        ">
            </td>


            <!-- RIGHT SUMMARY -->

            <td style="
            width:50%;
            vertical-align:top;
            border:none;
            padding:0;
        ">

                <table class="summary-table">


                    <!-- SUB TOTAL -->

                    <tr>

                        <td class="summary-label">
                            Sub Total
                        </td>

                        <td class="summary-value">

                            :
                            <?= number_format(
                                $sub_total,
                                2
                            ) ?>

                        </td>

                    </tr>


                    <!-- VAT -->

                    <tr>

                        <td class="summary-label">

                            VAT
                            (<?= !empty($quote[0]->vat_percent)
                                    ? $quote[0]->vat_percent
                                    : '0' ?>%)

                        </td>

                        <td class="summary-value">

                            :
                            <?= number_format(
                                (float)$quote[0]->vat_amt,
                                2
                            ) ?>

                        </td>

                    </tr>


                    <!-- GRAND TOTAL -->

                    <tr class="grand-total">

                        <td class="summary-label">
                            Grand Total
                        </td>

                        <td class="summary-value">

                            :
                            <?= number_format(
                                (float)$quote[0]->grand_total,
                                2
                            ) ?>

                        </td>

                    </tr>


                </table>

            </td>

        </tr>

    </table>



    <!-- =========================================================
     TERMS & CONDITIONS
========================================================= -->

    <div class="terms-section">

        <div class="terms-title">
            Purchase Terms :-
        </div>


        <table style="
        width:100%;
        border-collapse:collapse;
        border:none;
    ">


            <!-- PAYMENT -->

            <tr>

                <td style="
                width:150px;
                border:none;
                padding:1px 0;
                vertical-align:top;
            ">
                    Payment :-
                </td>

                <td style="
                border:none;
                padding:1px 0;
            ">

                    <?php
                    echo !empty($quote[0]->payment_term)
                        ? nl2br($quote[0]->payment_term)
                        : '---';
                    ?>

                </td>

            </tr>


            <!-- VALIDITY -->

            <tr>

                <td style="
                border:none;
                padding:1px 0;
                vertical-align:top;
            ">
                    Validity :-
                </td>

                <td style="
                border:none;
                padding:1px 0;
            ">

                    <?php
                    echo !empty($quote[0]->validity)
                        ? nl2br($quote[0]->validity)
                        : '---';
                    ?>

                </td>

            </tr>


            <!-- DELIVERY -->

            <tr>

                <td style="
                border:none;
                padding:1px 0;
                vertical-align:top;
            ">
                    Delivery :-
                </td>

                <td style="
                border:none;
                padding:1px 0;
            ">

                    <?php
                    echo !empty($quote[0]->delivery_term)
                        ? nl2br($quote[0]->delivery_term)
                        : '---';
                    ?>

                </td>

            </tr>


            <!-- GENERAL TERMS -->

            <?php if (!empty($quote[0]->general_term)) { ?>

                <tr>

                    <td style="
                border:none;
                padding:1px 0;
                vertical-align:top;
            ">
                        General Terms :-
                    </td>

                    <td style="
                border:none;
                padding:1px 0;
            ">

                        <?= nl2br($quote[0]->general_term) ?>

                    </td>

                </tr>

            <?php } ?>


        </table>

    </div>



    <br><br>



    <!-- =========================================================
     PREPARED / APPROVED
========================================================= -->

    <table class="signature-table"
        style="
           width:100%;
           border-collapse:collapse;
           margin-top:15px;
       ">

        <tr>


            <!-- PREPARED BY -->

            <td width="50%"
                style="
                border:none;
                text-align:left;
                vertical-align:top;
            ">

                Prepared By:

                <br><br><br>

                ____________________

            </td>


            <!-- APPROVED BY -->

            <td width="50%"
                style="
                border:none;
                text-align:right;
                vertical-align:top;
            ">

                Approved By:

                <br><br><br>

                ____________________

            </td>


        </tr>

    </table>



    <!-- =========================================================
     FOOTER
========================================================= -->

    <div class="footer">

        <?php if (!empty($company['company_footer'])) { ?>

            <img
                src="<?= base_url($company['company_footer']) ?>"
                alt="Company Footer">

        <?php } ?>

    </div>



</body>

</html>



<!-- =========================================================
     AUTO PRINT
========================================================= -->

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {

        setTimeout(function() {

            window.print();

        }, 500);

    });
</script>