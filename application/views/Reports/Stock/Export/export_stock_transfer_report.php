<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        Stock Transfer Report
    </title>


    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }


        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #d9eaf7;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .company {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .total {
            font-weight: bold;
        }
    </style>

</head>


<body>


    <!-- =========================
         COMPANY
    ========================== -->

    <table>


        <tr>

            <th
                colspan="15"
                class="company">

                <?php

                echo html_escape(
                    $company_name
                        ?? ''
                );

                ?>

            </th>

        </tr>


        <?php if (!empty($branch_name)) { ?>

            <tr>

                <th colspan="15">

                    <?php

                    echo html_escape(
                        $branch_name
                    );

                    ?>

                </th>

            </tr>

        <?php } ?>


        <tr>

            <th
                colspan="15"
                class="title">

                Stock Transfer Report

            </th>

        </tr>


        <!-- =========================
             FILTER INFORMATION
        ========================== -->


        <tr>

            <td>

                <strong>
                    From Date
                </strong>

            </td>


            <td>

                <?php

                echo !empty($from)
                    ? date(
                        'd-m-Y',
                        strtotime($from)
                    )
                    : '';

                ?>

            </td>


            <td>

                <strong>
                    To Date
                </strong>

            </td>


            <td>

                <?php

                echo !empty($to)
                    ? date(
                        'd-m-Y',
                        strtotime($to)
                    )
                    : '';

                ?>

            </td>


            <td>

                <strong>
                    Status
                </strong>

            </td>


            <td colspan="2">

                <?php

                echo html_escape(
                    $status_name
                        ?? 'All'
                );

                ?>

            </td>


            <td>

                <strong>
                    Product
                </strong>

            </td>


            <td colspan="7">

                <?php

                echo html_escape(
                    $product_name
                        ?? 'All Products'
                );

                ?>

            </td>

        </tr>


        <tr>

            <td>

                <strong>
                    From Warehouse
                </strong>

            </td>


            <td colspan="3">

                <?php

                echo html_escape(
                    $from_warehouse_name
                        ?? 'All Warehouses'
                );

                ?>

            </td>


            <td>

                <strong>
                    From Store
                </strong>

            </td>


            <td colspan="3">

                <?php

                echo html_escape(
                    $from_store_name
                        ?? 'All Stores'
                );

                ?>

            </td>


            <td>

                <strong>
                    To Warehouse
                </strong>

            </td>


            <td colspan="3">

                <?php

                echo html_escape(
                    $to_warehouse_name
                        ?? 'All Warehouses'
                );

                ?>

            </td>


            <td>

                <strong>
                    To Store
                </strong>

            </td>


            <td>

                <?php

                echo html_escape(
                    $to_store_name
                        ?? 'All Stores'
                );

                ?>

            </td>

        </tr>


        <!-- =========================
             HEADINGS
        ========================== -->


        <tr>

            <th>
                Sl No
            </th>

            <th>
                Transfer No
            </th>

            <th>
                Transfer Date
            </th>

            <th>
                From Warehouse
            </th>

            <th>
                From Store
            </th>

            <th>
                To Warehouse
            </th>

            <th>
                To Store
            </th>

            <th>
                Stock Code
            </th>

            <th>
                Product Name
            </th>

            <th>
                Unit
            </th>

            <th>
                Available Qty
            </th>

            <th>
                Transfer Qty
            </th>

            <th>
                Status
            </th>

            <th>
                Created By
            </th>

            <th>
                Remarks
            </th>

        </tr>


        <?php

        $total_transfer_qty = 0;

        ?>


        <?php if (!empty($records)) { ?>


            <?php $i = 1; ?>


            <?php foreach ($records as $row) { ?>


                <?php

                $available_qty =
                    (float)(
                        $row->available_qty
                        ?? 0
                    );


                $transfer_qty =
                    (float)(
                        $row->transfer_qty
                        ?? 0
                    );


                $total_transfer_qty +=
                    $transfer_qty;


                ?>


                <tr>


                    <!-- SL NO -->

                    <td class="text-center">

                        <?php

                        echo $i++;

                        ?>

                    </td>


                    <!-- TRANSFER NO -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->transfer_code
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- DATE -->

                    <td class="text-center">

                        <?php

                        echo !empty($row->transfer_date)
                            ? date(
                                'd-m-Y',
                                strtotime(
                                    $row->transfer_date
                                )
                            )
                            : '-';

                        ?>

                    </td>


                    <!-- FROM WAREHOUSE -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->from_warehouse
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- FROM STORE -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->from_store
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- TO WAREHOUSE -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->to_warehouse
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- TO STORE -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->to_store
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- STOCK CODE -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->product_code
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- PRODUCT -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->product_name
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- UNIT -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->unit_name
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- AVAILABLE -->

                    <td class="text-right">

                        <?php

                        echo number_format(
                            $available_qty,
                            2
                        );

                        ?>

                    </td>


                    <!-- TRANSFER -->

                    <td class="text-right">

                        <?php

                        echo number_format(
                            $transfer_qty,
                            2
                        );

                        ?>

                    </td>


                    <!-- STATUS -->

                    <td class="text-center">

                        <?php

                        $status_value =
                            isset($row->status)
                            ? (string)$row->status
                            : '';


                        if (
                            $status_value === '1'
                        ) {

                            echo 'Completed';
                        } elseif (
                            $status_value === '0'
                        ) {

                            echo 'Pending';
                        } else {

                            echo html_escape(
                                $row->status
                                    ?? '-'
                            );
                        }

                        ?>

                    </td>


                    <!-- CREATED BY -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->created_user
                                ?? '-'
                        );

                        ?>

                    </td>


                    <!-- REMARKS -->

                    <td>

                        <?php

                        $remarks = '';


                        if (
                            !empty($row->remarks)
                        ) {

                            $remarks =
                                $row->remarks;
                        } elseif (
                            !empty($row->item_remarks)
                        ) {

                            $remarks =
                                $row->item_remarks;
                        }


                        echo !empty($remarks)
                            ? html_escape(
                                $remarks
                            )
                            : '-';

                        ?>

                    </td>


                </tr>


            <?php } ?>


            <!-- =========================
                 TOTAL
            ========================== -->

            <tr class="total">


                <th
                    colspan="11"
                    style="text-align:right;">

                    Total Transfer Quantity

                </th>


                <th
                    class="text-right">

                    <?php

                    echo number_format(
                        $total_transfer_qty,
                        2
                    );

                    ?>

                </th>


                <th colspan="3"></th>


            </tr>


        <?php } else { ?>


            <tr>

                <td
                    colspan="15"
                    class="text-center">

                    No Stock Transfer
                    records found.

                </td>

            </tr>


        <?php } ?>


        <!-- =========================
             PREPARED BY
        ========================== -->

        <tr>

            <td colspan="15">

                Prepared By:

                <?php

                echo html_escape(
                    $prepared_by
                        ?? 'Admin'
                );

                ?>

            </td>

        </tr>


    </table>


</body>

</html>