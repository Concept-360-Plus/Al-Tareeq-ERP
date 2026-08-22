<!DOCTYPE html>
<html>

<head>

    <title>
        Stock Ledger Report
    </title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 10px;
            color: #000;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            width: 100%;
            border-bottom: 2px solid #444;
            margin-bottom: 15px;
            padding-bottom: 10px;
            text-align: center;
        }

        .header img {
            width: 100%;
            max-height: 180px;
            object-fit: contain;
        }

        .report-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #000;
            margin-top: 10px;
        }

        .report-subtitle {
            text-align: center;
            font-size: 12px;
            margin: 8px 0 5px;
        }


        /* =====================================================
           INFORMATION
        ===================================================== */

        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 4px;
            border: none;
        }


        /* =====================================================
           REPORT TABLE
        ===================================================== */

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.report-table th,
        table.report-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.report-table th {
            background: #efefef;
            text-align: center;
            font-weight: bold;
        }


        /* =====================================================
           ALIGNMENT
        ===================================================== */

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }


        /* =====================================================
           TOTAL
        ===================================================== */

        .summary-row {
            font-weight: bold;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;

            border-top: 1px solid #555;

            padding: 7px 15px;

            font-size: 10px;

            background: #fff;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            body {
                margin: 10px;
            }

            .footer {
                position: fixed;
                bottom: 0;
            }

            @page {
                size: landscape;
                margin: 10mm;
            }

        }
    </style>

</head>


<body>


    <!-- =====================================================
         HEADER
    ===================================================== -->

    <div class="header">

        <!-- <?php if (!empty($headerPath)) { ?>

            <img
                src="<?= htmlspecialchars($headerPath); ?>"
                class="company-logo"
                alt="Company Header">

        <?php } else { ?> -->

            <img
                src="<?= base_url('public/assets/images/altariq_logo.jpeg'); ?>"
                class="company-logo"
                alt="Company Logo">

        <!-- <?php } ?> -->


        <div class="report-title">

            STOCK LEDGER REPORT

        </div>


        <div class="report-subtitle">

            From Date :

            <strong>
                <?= !empty($from)
                    ? date('d-m-Y', strtotime($from))
                    : '-'; ?>
            </strong>

            &nbsp;&nbsp;

            To Date :

            <strong>
                <?= !empty($to)
                    ? date('d-m-Y', strtotime($to))
                    : '-'; ?>
            </strong>

            &nbsp;&nbsp;

            Warehouse :

            <strong>
                <?= !empty($warehouse_name)
                    ? htmlspecialchars($warehouse_name)
                    : 'All Warehouses'; ?>
            </strong>

            &nbsp;&nbsp;

            Store :

            <strong>
                <?= !empty($store_name)
                    ? htmlspecialchars($store_name)
                    : 'All Stores'; ?>
            </strong>

            &nbsp;&nbsp;

            Product :

            <strong>
                <?= !empty($product_name)
                    ? htmlspecialchars($product_name)
                    : 'All Products'; ?>
            </strong>

        </div>

    </div>


    <!-- =====================================================
         SEPARATOR
    ===================================================== -->

    <table width="100%" style="border:0;">

        <tbody>

            <tr
                height="5px"
                style="background-color:#525453;">

                <td style="border:0;"></td>

            </tr>

        </tbody>

    </table>


    <!-- =====================================================
         REPORT INFORMATION
    ===================================================== -->

    <table class="info-table">

        <tr>

            <td width="50%">

                <strong>
                    Prepared By :
                </strong>

                <?= !empty($prepared_by)
                    ? htmlspecialchars($prepared_by)
                    : 'Admin'; ?>

            </td>


            <td align="right">

                <strong>
                    Printed On :
                </strong>

                <?= date('d-M-Y h:i A'); ?>

            </td>

        </tr>

    </table>


    <!-- =====================================================
         REPORT TABLE
    ===================================================== -->

    <table class="report-table">

        <thead>

            <tr>

                <th width="4%">
                    Sl No
                </th>

                <th width="8%">
                    Date
                </th>

                <th width="11%">
                    Reference
                </th>

                <th width="8%">
                    Product Code
                </th>

                <th width="12%">
                    Product Name
                </th>

                <th width="7%">
                    Opening
                </th>

                <th width="7%">
                    Stock In
                </th>

                <th width="7%">
                    Stock Out
                </th>

                <th width="7%">
                    Balance
                </th>

                <th width="7%">
                    Price
                </th>

                <th width="8%">
                    Warehouse
                </th>

                <th width="8%">
                    Store
                </th>

                <th width="6%">
                    Remarks
                </th>

            </tr>

        </thead>


        <tbody>

            <?php

            $sl = 1;

            $total_in = 0;

            $total_out = 0;

            $first_opening = 0;

            $final_balance = 0;

            if (!empty($records)) {

                $first_opening =
                    isset($records[0]->opening_balance)
                    ? (float)$records[0]->opening_balance
                    : 0;
            }

            ?>


            <?php if (!empty($records)) { ?>


                <?php foreach ($records as $row) { ?>

                    <?php

                    $stock_in =
                        isset($row->stock_in)
                        ? (float)$row->stock_in
                        : 0;

                    $stock_out =
                        isset($row->stock_out)
                        ? (float)$row->stock_out
                        : 0;

                    $balance =
                        isset($row->closing_balance)
                        ? (float)$row->closing_balance
                        : 0;

                    $price =
                        isset($row->price)
                        ? (float)$row->price
                        : 0;

                    $total_in += $stock_in;

                    $total_out += $stock_out;

                    $final_balance = $balance;

                    ?>


                    <tr>

                        <!-- SL NO -->

                        <td class="center">

                            <?= $sl++; ?>

                        </td>


                        <!-- DATE -->

                        <td class="center">

                            <?= !empty($row->stock_date)
                                ? date(
                                    'd-m-Y',
                                    strtotime($row->stock_date)
                                )
                                : '-'; ?>

                        </td>


                        <!-- REFERENCE -->

                        <td>

                            <?= !empty($row->reference)
                                ? htmlspecialchars($row->reference)
                                : '-'; ?>

                        </td>


                        <!-- PRODUCT CODE -->

                        <td>

                            <?= !empty($row->product_code)
                                ? htmlspecialchars($row->product_code)
                                : '-'; ?>

                        </td>


                        <!-- PRODUCT NAME -->

                        <td>

                            <?= !empty($row->product_name)
                                ? htmlspecialchars($row->product_name)
                                : '-'; ?>

                        </td>


                        <!-- OPENING -->

                        <td class="right">

                            <?= number_format(
                                (float)$row->opening_balance,
                                2
                            ); ?>

                        </td>


                        <!-- STOCK IN -->

                        <td class="right">

                            <?= $stock_in > 0
                                ? number_format(
                                    $stock_in,
                                    2
                                )
                                : '-'; ?>

                        </td>


                        <!-- STOCK OUT -->

                        <td class="right">

                            <?= $stock_out > 0
                                ? number_format(
                                    $stock_out,
                                    2
                                )
                                : '-'; ?>

                        </td>


                        <!-- BALANCE -->

                        <td
                            class="right"
                            style="font-weight:bold;">

                            <?= number_format(
                                $balance,
                                2
                            ); ?>

                        </td>


                        <!-- PRICE -->

                        <td class="right">

                            <?= number_format(
                                $price,
                                2
                            ); ?>

                        </td>


                        <!-- WAREHOUSE -->

                        <td>

                            <?= !empty($row->warehouse_name)
                                ? htmlspecialchars(
                                    $row->warehouse_name
                                )
                                : '-'; ?>

                        </td>


                        <!-- STORE -->

                        <td>

                            <?= !empty($row->store_name)
                                ? htmlspecialchars(
                                    $row->store_name
                                )
                                : '-'; ?>

                        </td>


                        <!-- REMARKS -->

                        <td>

                            <?php

                            if (!empty($row->item_remark)) {

                                echo htmlspecialchars(
                                    $row->item_remark
                                );
                            } elseif (!empty($row->remark)) {

                                echo htmlspecialchars(
                                    $row->remark
                                );
                            } else {

                                echo '-';
                            }

                            ?>

                        </td>

                    </tr>


                <?php } ?>


                <!-- =================================================
                     SUMMARY
                ================================================== -->

                <tr class="summary-row">

                    <td
                        colspan="5"
                        class="right">

                        Opening Balance

                    </td>

                    <td class="right">

                        <?= number_format(
                            $first_opening,
                            2
                        ); ?>

                    </td>

                    <td colspan="7"></td>

                </tr>


                <tr class="summary-row">

                    <td
                        colspan="6"
                        class="right">

                        Total Stock In

                    </td>

                    <td class="right">

                        <?= number_format(
                            $total_in,
                            2
                        ); ?>

                    </td>

                    <td colspan="6"></td>

                </tr>


                <tr class="summary-row">

                    <td
                        colspan="6"
                        class="right">

                        Total Stock Out

                    </td>

                    <td class="right">

                        <?= number_format(
                            $total_out,
                            2
                        ); ?>

                    </td>

                    <td colspan="6"></td>

                </tr>


                <tr class="summary-row">

                    <td
                        colspan="8"
                        class="right">

                        Closing Balance

                    </td>

                    <td class="right">

                        <?= number_format(
                            $final_balance,
                            2
                        ); ?>

                    </td>

                    <td colspan="4"></td>

                </tr>


            <?php } else { ?>


                <tr>

                    <td
                        colspan="13"
                        class="center">

                        No Stock Ledger records found
                        for the selected criteria.

                    </td>

                </tr>


            <?php } ?>

        </tbody>

    </table>


    <br>


    <!-- =====================================================
         FOOTER
    ===================================================== -->

    <div class="footer">

        <div class="footer-left">

            &copy; <?= date('Y'); ?>

            <?= !empty($company_name)
                ? htmlspecialchars($company_name)
                : 'Al Tareeq Kitchen Equipment Industry LLC'; ?>

        </div>


        <div class="footer-right">

            Designed &amp; Developed by

            Concepts 360 Plus

        </div>

    </div>


</body>

</html>