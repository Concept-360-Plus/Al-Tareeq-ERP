<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Stock Ledger Report
    </title>

</head>


<body>


    <!-- =====================================================
         COMPANY
    ===================================================== -->

    <table
        border="0"
        width="100%">

        <tr>

            <td
                colspan="13"
                align="center">

                <strong>

                    <?= !empty($company_name)
                        ? htmlspecialchars($company_name)
                        : 'Al Tareeq Kitchen Equipment Industry LLC'; ?>

                </strong>

            </td>

        </tr>


        <!-- =================================================
             BRANCH
        ================================================== -->

        <tr>

            <td
                colspan="13"
                align="center">

                <strong>

                    Branch :

                    <?= !empty($branch_name)
                        ? htmlspecialchars($branch_name)
                        : '-'; ?>

                </strong>

            </td>

        </tr>


        <!-- =================================================
             REPORT TITLE
        ================================================== -->

        <tr>

            <td
                colspan="13"
                align="center">

                <strong>

                    STOCK LEDGER REPORT

                </strong>

            </td>

        </tr>


        <tr>

            <td colspan="13">
                &nbsp;
            </td>

        </tr>


        <!-- =================================================
             FILTER INFORMATION
        ================================================== -->

        <tr>

            <td colspan="2">

                <strong>
                    From Date
                </strong>

            </td>

            <td colspan="2">

                <?= !empty($from)
                    ? date(
                        'd-m-Y',
                        strtotime($from)
                    )
                    : '-'; ?>

            </td>


            <td colspan="2">

                <strong>
                    To Date
                </strong>

            </td>

            <td colspan="2">

                <?= !empty($to)
                    ? date(
                        'd-m-Y',
                        strtotime($to)
                    )
                    : '-'; ?>

            </td>


            <td colspan="2">

                <strong>
                    Warehouse
                </strong>

            </td>

            <td colspan="3">

                <?= !empty($warehouse_name)
                    ? htmlspecialchars($warehouse_name)
                    : 'All Warehouses'; ?>

            </td>

        </tr>


        <tr>

            <td colspan="2">

                <strong>
                    Store
                </strong>

            </td>

            <td colspan="4">

                <?= !empty($store_name)
                    ? htmlspecialchars($store_name)
                    : 'All Stores'; ?>

            </td>


            <td colspan="2">

                <strong>
                    Product
                </strong>

            </td>

            <td colspan="5">

                <?= !empty($product_name)
                    ? htmlspecialchars($product_name)
                    : 'All Products'; ?>

            </td>

        </tr>


        <tr>

            <td colspan="13">
                &nbsp;
            </td>

        </tr>

    </table>


    <!-- =====================================================
         REPORT TABLE
    ===================================================== -->

    <table
        border="1"
        cellpadding="5"
        cellspacing="0"
        width="100%">

        <thead>

            <tr>

                <th>
                    Sl No
                </th>

                <th>
                    Date
                </th>

                <th>
                    Reference
                </th>

                <th>
                    Product Code
                </th>

                <th>
                    Product Name
                </th>

                <th>
                    Opening
                </th>

                <th>
                    Stock In
                </th>

                <th>
                    Stock Out
                </th>

                <th>
                    Balance
                </th>

                <th>
                    Price
                </th>

                <th>
                    Warehouse
                </th>

                <th>
                    Store
                </th>

                <th>
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
                    isset(
                        $records[0]->opening_balance
                    )
                    ? (float)
                    $records[0]->opening_balance
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


                    $total_in +=
                        $stock_in;

                    $total_out +=
                        $stock_out;

                    $final_balance =
                        $balance;

                    ?>


                    <tr>

                        <!-- SL -->

                        <td align="center">

                            <?= $sl++; ?>

                        </td>


                        <!-- DATE -->

                        <td>

                            <?= !empty($row->stock_date)
                                ? date(
                                    'd-m-Y',
                                    strtotime(
                                        $row->stock_date
                                    )
                                )
                                : '-'; ?>

                        </td>


                        <!-- REFERENCE -->

                        <td>

                            <?= !empty($row->reference)
                                ? htmlspecialchars(
                                    $row->reference
                                )
                                : '-'; ?>

                        </td>


                        <!-- PRODUCT CODE -->

                        <td>

                            <?= !empty($row->product_code)
                                ? htmlspecialchars(
                                    $row->product_code
                                )
                                : '-'; ?>

                        </td>


                        <!-- PRODUCT NAME -->

                        <td>

                            <?= !empty($row->product_name)
                                ? htmlspecialchars(
                                    $row->product_name
                                )
                                : '-'; ?>

                        </td>


                        <!-- OPENING -->

                        <td align="right">

                            <?= number_format(
                                (float)$row->opening_balance,
                                2
                            ); ?>

                        </td>


                        <!-- IN -->

                        <td align="right">

                            <?= $stock_in > 0
                                ? number_format(
                                    $stock_in,
                                    2
                                )
                                : '-'; ?>

                        </td>


                        <!-- OUT -->

                        <td align="right">

                            <?= $stock_out > 0
                                ? number_format(
                                    $stock_out,
                                    2
                                )
                                : '-'; ?>

                        </td>


                        <!-- BALANCE -->

                        <td align="right">

                            <strong>

                                <?= number_format(
                                    $balance,
                                    2
                                ); ?>

                            </strong>

                        </td>


                        <!-- PRICE -->

                        <td align="right">

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

                <tr>

                    <td
                        colspan="5"
                        align="right">

                        <strong>
                            Opening Balance
                        </strong>

                    </td>

                    <td align="right">

                        <strong>

                            <?= number_format(
                                $first_opening,
                                2
                            ); ?>

                        </strong>

                    </td>

                    <td colspan="7"></td>

                </tr>


                <tr>

                    <td
                        colspan="6"
                        align="right">

                        <strong>
                            Total Stock In
                        </strong>

                    </td>

                    <td align="right">

                        <strong>

                            <?= number_format(
                                $total_in,
                                2
                            ); ?>

                        </strong>

                    </td>

                    <td colspan="6"></td>

                </tr>


                <tr>

                    <td
                        colspan="6"
                        align="right">

                        <strong>
                            Total Stock Out
                        </strong>

                    </td>

                    <td align="right">

                        <strong>

                            <?= number_format(
                                $total_out,
                                2
                            ); ?>

                        </strong>

                    </td>

                    <td colspan="6"></td>

                </tr>


                <tr>

                    <td
                        colspan="8"
                        align="right">

                        <strong>
                            Closing Balance
                        </strong>

                    </td>

                    <td align="right">

                        <strong>

                            <?= number_format(
                                $final_balance,
                                2
                            ); ?>

                        </strong>

                    </td>

                    <td colspan="4"></td>

                </tr>


            <?php } else { ?>


                <tr>

                    <td
                        colspan="13"
                        align="center">

                        No Stock Ledger records found
                        for the selected criteria.

                    </td>

                </tr>


            <?php } ?>

        </tbody>

    </table>


    <br>


    <!-- =====================================================
         FOOTER INFORMATION
    ===================================================== -->

    <table
        border="0"
        width="100%">

        <tr>

            <td>

                Prepared By :

                <strong>

                    <?= !empty($prepared_by)
                        ? htmlspecialchars($prepared_by)
                        : 'Admin'; ?>

                </strong>

            </td>


            <td align="right">

                Printed On :

                <strong>

                    <?= date('d-M-Y h:i A'); ?>

                </strong>

            </td>

        </tr>


        <tr>

            <td colspan="2">
                &nbsp;
            </td>

        </tr>


        <tr>

            <td>

                &copy; <?= date('Y'); ?>

                <?= !empty($company_name)
                    ? htmlspecialchars($company_name)
                    : 'Al Tareeq Kitchen Equipment Industry LLC'; ?>

            </td>


            <td align="right">

                Designed &amp; Developed by
                Concepts 360 Plus

            </td>

        </tr>

    </table>


</body>

</html>