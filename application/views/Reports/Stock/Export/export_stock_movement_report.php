<html>

<head>

    <meta charset="utf-8">

    <style>
        table {
            border-collapse: collapse;
        }

        th {
            background-color: #d9eaf7;
            font-weight: bold;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }
    </style>

</head>


<body>


    <!-- =====================================================
         TITLE
    ====================================================== -->

    <table width="100%">

        <tr>

            <td
                colspan="12"
                class="title"
                style="text-align:center;">

                Stock Movement Report

            </td>

        </tr>


        <tr>

            <td>
                <strong>From Date</strong>
            </td>

            <td>

                <?php
                echo !empty($from)
                    ? date(
                        'd-m-Y',
                        strtotime($from)
                    )
                    : '-';
                ?>

            </td>


            <td>
                <strong>To Date</strong>
            </td>

            <td>

                <?php
                echo !empty($to)
                    ? date(
                        'd-m-Y',
                        strtotime($to)
                    )
                    : '-';
                ?>

            </td>


            <td>
                <strong>Movement Type</strong>
            </td>

            <td>

                <?php

                if ($movement_type == 'IN') {

                    echo 'Stock In';
                } elseif (
                    $movement_type == 'OUT'
                ) {

                    echo 'Stock Out';
                } else {

                    echo 'All Movements';
                }

                ?>

            </td>

            <td colspan="6"></td>

        </tr>

    </table>


    <br>


    <!-- =====================================================
         REPORT TABLE
    ====================================================== -->

    <table width="100%">

        <thead>

            <tr>

                <th>Sl No</th>

                <th>Movement Date</th>

                <th>Product Code</th>

                <th>Product Name</th>

                <th>Reference</th>

                <th>Movement Type</th>

                <th>Quantity</th>

                <th>Price</th>

                <th>Warehouse</th>

                <th>Store</th>

                <th>Storage Location</th>

                <th>Remarks</th>

            </tr>

        </thead>


        <tbody>

            <?php

            $i = 1;

            $total_in = 0;

            $total_out = 0;

            ?>


            <?php if (!empty($records)) { ?>


                <?php foreach ($records as $row) { ?>

                    <?php

                    $qty =
                        (float)$row->quantity;


                    if (
                        $row->stock_type == 'IN'
                    ) {

                        $total_in += $qty;
                    } elseif (
                        $row->stock_type == 'OUT'
                    ) {

                        $total_out += $qty;
                    }

                    ?>


                    <tr>

                        <td class="text-center">

                            <?php
                            echo $i++;
                            ?>

                        </td>


                        <td>

                            <?php

                            echo !empty($row->stock_date)
                                ? date(
                                    'd-m-Y',
                                    strtotime(
                                        $row->stock_date
                                    )
                                )
                                : '-';

                            ?>

                        </td>


                        <td>

                            <?php
                            echo !empty($row->product_code)
                                ? html_escape(
                                    $row->product_code
                                )
                                : '-';
                            ?>

                        </td>


                        <td>

                            <?php
                            echo !empty($row->product_name)
                                ? html_escape(
                                    $row->product_name
                                )
                                : '-';
                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                !empty($row->bill_no)
                            ) {

                                echo 'Bill: ' .
                                    html_escape(
                                        $row->bill_no
                                    );
                            } elseif (
                                !empty($row->order_ref_no)
                            ) {

                                echo 'Ref: ' .
                                    html_escape(
                                        $row->order_ref_no
                                    );
                            } elseif (
                                !empty($row->trans_id)
                            ) {

                                echo 'Transaction: ' .
                                    html_escape(
                                        $row->trans_id
                                    );
                            } elseif (
                                !empty($row->adjustment_id)
                            ) {

                                echo 'Adjustment: ' .
                                    html_escape(
                                        $row->adjustment_id
                                    );
                            } else {

                                echo '-';
                            }

                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                $row->stock_type == 'IN'
                            ) {

                                echo 'Stock In';
                            } elseif (
                                $row->stock_type == 'OUT'
                            ) {

                                echo 'Stock Out';
                            } else {

                                echo '-';
                            }

                            ?>

                        </td>


                        <td class="text-right">

                            <?php
                            echo number_format(
                                $qty,
                                2
                            );
                            ?>

                        </td>


                        <td class="text-right">

                            <?php
                            echo number_format(
                                (float)$row->price,
                                2
                            );
                            ?>

                        </td>


                        <td>

                            <?php
                            echo !empty($row->warehouse_name)
                                ? html_escape(
                                    $row->warehouse_name
                                )
                                : '-';
                            ?>

                        </td>


                        <td>

                            <?php
                            echo !empty($row->store_name)
                                ? html_escape(
                                    $row->store_name
                                )
                                : '-';
                            ?>

                        </td>


                        <td>

                            <?php
                            echo !empty($row->storage_location)
                                ? html_escape(
                                    $row->storage_location
                                )
                                : '-';
                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                !empty($row->item_remark)
                            ) {

                                echo html_escape(
                                    $row->item_remark
                                );
                            } elseif (
                                !empty($row->remark)
                            ) {

                                echo html_escape(
                                    $row->remark
                                );
                            } else {

                                echo '-';
                            }

                            ?>

                        </td>

                    </tr>

                <?php } ?>


                <!-- =====================================================
                     TOTAL STOCK IN
                ====================================================== -->

                <tr>

                    <td
                        colspan="6"
                        class="text-right">

                        <strong>
                            Total Stock In
                        </strong>

                    </td>

                    <td class="text-right">

                        <strong>

                            <?php
                            echo number_format(
                                $total_in,
                                2
                            );
                            ?>

                        </strong>

                    </td>

                    <td colspan="5"></td>

                </tr>


                <!-- =====================================================
                     TOTAL STOCK OUT
                ====================================================== -->

                <tr>

                    <td
                        colspan="6"
                        class="text-right">

                        <strong>
                            Total Stock Out
                        </strong>

                    </td>

                    <td class="text-right">

                        <strong>

                            <?php
                            echo number_format(
                                $total_out,
                                2
                            );
                            ?>

                        </strong>

                    </td>

                    <td colspan="5"></td>

                </tr>


                <!-- =====================================================
                     NET MOVEMENT
                ====================================================== -->

                <tr>

                    <td
                        colspan="6"
                        class="text-right">

                        <strong>
                            Net Movement
                        </strong>

                    </td>

                    <td class="text-right">

                        <strong>

                            <?php
                            echo number_format(
                                $total_in -
                                    $total_out,
                                2
                            );
                            ?>

                        </strong>

                    </td>

                    <td colspan="5"></td>

                </tr>


            <?php } else { ?>

                <tr>

                    <td
                        colspan="12"
                        class="text-center">

                        No Stock Movement records found.

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</body>

</html>