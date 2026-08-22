<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Stock Valuation Report
    </title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .branch {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .filter {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {

            background:
                #efefef;

            font-weight:
                bold;

            text-align:
                center;

        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .total {
            font-weight: bold;
        }
    </style>

</head>


<body>


    <!-- =====================================================
         COMPANY
    ====================================================== -->

    <table>
        <tr>
            <td colspan="10" class="company">

                <?= !empty($company_name)
                    ? htmlspecialchars(
                        $company_name
                    )
                    : 'Al Tareeq Kitchen Equipment Industry LLC'; ?>
            </td>

        </tr>


        <tr>

            <td
                colspan="10"
                class="branch">

                Branch :

                <?= !empty($branch_name)
                    ? htmlspecialchars(
                        $branch_name
                    )
                    : '-'; ?>

            </td>

        </tr>


        <tr>

            <td
                colspan="10"
                class="title">

                STOCK VALUATION REPORT

            </td>

        </tr>


        <tr>

            <td
                colspan="10"
                class="filter">

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

            </td>

        </tr>


        <tr>

            <td
                colspan="5">

                Prepared By :

                <strong>

                    <?= !empty($prepared_by)
                        ? htmlspecialchars(
                            $prepared_by
                        )
                        : 'Admin'; ?>

                </strong>

            </td>


            <td
                colspan="5"
                style="text-align:right;">

                Printed On :

                <strong>

                    <?= date(
                        'd-M-Y h:i A'
                    ); ?>

                </strong>

            </td>

        </tr>

    </table>


    <br>


    <!-- =====================================================
         REPORT TABLE
    ====================================================== -->

    <table>

        <thead>

            <tr>

                <th>
                    Sl No
                </th>

                <th>
                    Stock Code
                </th>

                <th>
                    Product Name
                </th>

                <th>
                    Warehouse
                </th>

                <th>
                    Store
                </th>

                <th>
                    Stock Qty
                </th>

                <th>
                    Allocated Qty
                </th>

                <th>
                    Available Qty
                </th>

                <th>
                    Unit Price
                </th>

                <th>
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

                    $value = isset($row->stock_value) ? (float)$row->stock_value : ($stock * $price);

                    $total_stock += $stock;
                    $total_allocated += $allocated;
                    $total_available += $available;
                    $total_value += $value;

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

                <tr class="total">
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
                    <td
                        colspan="10"
                        class="center">

                        No Stock Valuation records
                        found for the selected criteria.
                    </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>

    <br>

    <table>
        <tr>
            <td colspan="10">
                &copy;
                <?= date('Y'); ?>
                Al Tareeq Kitchen Equipment Industry LLC
            </td>
        </tr>
    </table>

</body>

</html>