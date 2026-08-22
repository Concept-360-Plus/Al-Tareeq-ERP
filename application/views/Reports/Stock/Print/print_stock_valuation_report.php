<!DOCTYPE html>

<html>

<head>

    <title>
        Stock Valuation Report
    </title>


    <style>
        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            font-size: 12px;

            margin: 10px;

            color: #000;

        }


        /* =========================
           HEADER
        ========================== */

        .header {

            width: 100%;

            border-bottom:
                2px solid #444;

            margin-bottom: 15px;

            padding-bottom: 10px;

        }


        .header img {

            width: 100%;

            max-height: 220px;

            object-fit: contain;

        }


        .report-title {

            text-align: center;

            font-size: 22px;

            font-weight: bold;

            color: #070707;

            margin-top: 10px;

        }


        .report-subtitle {

            text-align: center;

            font-size: 13px;

            margin:
                8px 0 15px;

        }


        /* =========================
           INFORMATION
        ========================== */

        .info-table {

            width: 100%;

            margin-bottom: 15px;

        }


        .info-table td {

            padding: 4px;

            border: none;

        }


        /* =========================
           REPORT TABLE
        ========================== */

        table.report-table {

            width: 100%;

            border-collapse:
                collapse;

            margin-top: 10px;

        }


        table.report-table th,
        table.report-table td {

            border:
                1px solid #000;

            padding: 8px;

        }


        table.report-table th {

            background:
                #efefef;

            text-align:
                center;

        }


        /* =========================
           ALIGNMENT
        ========================== */

        .center {

            text-align:
                center;

        }


        .right {

            text-align:
                right;

        }


        /* =========================
           TOTAL
        ========================== */

        .total-row {

            font-weight:
                bold;

        }


        /* =========================
           FOOTER
        ========================== */

        .footer {

            position:
                fixed;

            bottom:
                0;

            left:
                0;

            right:
                0;

            border-top:
                1px solid #555;

            padding:
                8px 15px;

            font-size:
                11px;

        }


        .footer-left {

            float:
                left;

        }


        .footer-right {

            float:
                right;

        }


        @media print {

            .footer {

                position:
                    fixed;

                bottom:
                    0;

            }

        }
    </style>

</head>


<body>


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="header">

        <img
            src="<?= base_url(
                        'public/assets/images/altariq_logo.jpeg'
                    ); ?>"
            class="company-logo"
            alt="Company Logo">


        <div class="report-title">

            STOCK VALUATION REPORT

        </div>


        <div class="report-subtitle">

            Warehouse :

            <strong>

                <?= !empty($warehouse_name)
                    ? htmlspecialchars(
                        $warehouse_name
                    )
                    : 'All Warehouses'; ?>

            </strong>


            &nbsp;&nbsp;


            Store :

            <strong>

                <?= !empty($store_name)
                    ? htmlspecialchars(
                        $store_name
                    )
                    : 'All Stores'; ?>

            </strong>


            &nbsp;&nbsp;


            Product :

            <strong>

                <?= !empty($product_name)
                    ? htmlspecialchars(
                        $product_name
                    )
                    : 'All Products'; ?>

            </strong>

        </div>

    </div>


    <!-- =====================================================
         SEPARATOR
    ====================================================== -->

    <table
        width="100%"
        style="border:0;">

        <tbody>

            <tr
                height="5px"
                style="
                    background-color:#525453;
                ">

                <td
                    style="border:0;">
                </td>

            </tr>

        </tbody>

    </table>


    <!-- =====================================================
         REPORT INFORMATION
    ====================================================== -->

    <table class="info-table">

        <tr>

            <td width="50%">

                <strong>
                    Prepared By :
                </strong>

                <?= !empty($prepared_by)
                    ? htmlspecialchars(
                        $prepared_by
                    )
                    : 'Admin'; ?>

            </td>


            <td align="right">

                <strong>
                    Printed On :
                </strong>

                <?= date(
                    'd-M-Y h:i A'
                ); ?>

            </td>

        </tr>

    </table>


    <!-- =====================================================
         REPORT TABLE
    ====================================================== -->

    <table class="report-table">

        <thead>

            <tr>

                <th width="6%">
                    Sl No
                </th>

                <th width="13%">
                    Stock Code
                </th>

                <th width="22%">
                    Product Name
                </th>

                <th width="13%">
                    Warehouse
                </th>

                <th width="15%">
                    Store
                </th>

                <th width="9%">
                    Stock Qty
                </th>

                <th width="9%">
                    Allocated Qty
                </th>

                <th width="9%">
                    Available Qty
                </th>

                <th width="10%">
                    Unit Price
                </th>

                <th width="12%">
                    Stock Value
                </th>

            </tr>

        </thead>


        <tbody>

            <?php

            $sl = 1;

            $total_stock = 0;

            $total_allocated = 0;

            $total_available = 0;

            $total_value = 0;

            ?>


            <?php if (!empty($records)) { ?>


                <?php foreach ($records as $row) { ?>

                    <?php

                    $stock =
                        isset($row->stock_qty)
                        ? (float)$row->stock_qty
                        : 0;

                    $allocated =
                        isset($row->allocated_qty)
                        ? (float)$row->allocated_qty
                        : 0;

                    $available =
                        isset($row->available_qty)
                        ? (float)$row->available_qty
                        : (
                            $stock -
                            $allocated
                        );

                    $price =
                        isset($row->unit_price)
                        ? (float)$row->unit_price
                        : 0;

                    $value =
                        isset($row->stock_value)
                        ? (float)$row->stock_value
                        : (
                            $stock *
                            $price
                        );


                    $total_stock +=
                        $stock;

                    $total_allocated +=
                        $allocated;

                    $total_available +=
                        $available;

                    $total_value +=
                        $value;

                    ?>


                    <tr>

                        <td class="center">
                            <?= $sl++; ?>
                        </td>

                        <td>
                            <?= !empty($row->product_code)
                                ? htmlspecialchars(
                                    $row->product_code
                                )
                                : '-'; ?>
                        </td>

                        <td>
                            <?= !empty($row->product_name)
                                ? htmlspecialchars(
                                    $row->product_name
                                )
                                : '-'; ?>
                        </td>

                        <td>
                            <?= !empty($row->warehouse_name)
                                ? htmlspecialchars(
                                    $row->warehouse_name
                                )
                                : '-'; ?>
                        </td>

                        <td>
                            <?= !empty($row->store_name)
                                ? htmlspecialchars(
                                    $row->store_name
                                )
                                : '-'; ?>
                        </td>

                        <td class="right">
                            <?= number_format(
                                $stock,
                                2
                            ); ?>
                        </td>

                        <td class="right">
                            <?= number_format(
                                $allocated,
                                2
                            ); ?>
                        </td>

                        <td class="right">
                            <?= number_format(
                                $available,
                                2
                            ); ?>
                        </td>

                        <td class="right">
                            <?= number_format(
                                $price,
                                2
                            ); ?>
                        </td>

                        <td class="right">
                            <?= number_format(
                                $value,
                                2
                            ); ?>
                        </td>
                    </tr>
                <?php } ?>


                <tr class="total-row">

                    <td
                        colspan="5"
                        class="right">

                        Total

                    </td>


                    <td class="right">
                        <?= number_format(
                            $total_stock,
                            2
                        ); ?>
                    </td>

                    <td class="right">
                        <?= number_format(
                            $total_allocated,
                            2
                        ); ?>
                    </td>

                    <td class="right">
                        <?= number_format(
                            $total_available,
                            2
                        ); ?>
                    </td>

                    <td>
                    </td>

                    <td class="right">
                        <?= number_format(
                            $total_value,
                            2
                        ); ?>

                    </td>
                </tr>

            <?php } else { ?>

                <tr>
                    <td colspan="10" class="center">
                        No Stock Valuation records
                        found for the selected criteria.
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>

    <br>

    <div class="footer">
        <div class="footer-left">
            &copy;
            <?= date('Y'); ?>
            Al Tareeq Kitchen Equipment Industry LLC
        </div>

        <div class="footer-right">
            Designed &amp; Developed by
            Concepts 360 Plus
        </div>
    </div>
</body>

</html>