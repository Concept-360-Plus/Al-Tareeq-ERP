<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background: #eeeeee;
            font-weight: bold;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

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

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            background: #eeeeee;
        }
    </style>

</head>


<body>


    <table>

        <tr>

            <td
                colspan="12"
                class="title">
                <?php
                echo html_escape(
                    $company_name
                );
                ?>
            </td>

        </tr>


        <tr>

            <td colspan="12">

                <?php
                echo html_escape(
                    $branch_name
                );
                ?>

            </td>

        </tr>


        <tr>

            <td
                colspan="12"
                class="title">
                Stock Reservation Report
            </td>

        </tr>


        <tr>

            <td>
                From Date
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
                To Date
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
                Product
            </td>

            <td colspan="2">
                <?php
                echo html_escape(
                    $product_name
                );
                ?>
            </td>


            <td>
                Customer
            </td>

            <td colspan="3">
                <?php
                echo html_escape(
                    $customer_name
                );
                ?>
            </td>

        </tr>


        <tr>

            <td>
                Sales Order
            </td>

            <td colspan="3">
                <?php
                echo html_escape(
                    $sales_order_name
                );
                ?>
            </td>


            <td>
                Status
            </td>

            <td colspan="7">

                <?php

                if ($status == 'FULL') {

                    echo 'Fully Reserved';
                } elseif ($status == 'PARTIAL') {

                    echo 'Partially Reserved';
                } else {

                    echo 'All';
                }

                ?>

            </td>

        </tr>

    </table>


    <br>


    <?php

    $total_requested = 0;
    $total_reserved  = 0;
    $total_pending   = 0;

    ?>


    <table>

        <thead>

            <tr>

                <th>
                    #
                </th>

                <th>
                    Priority
                </th>

                <th>
                    Reservation Date
                </th>

                <th>
                    Sales Order
                </th>

                <th>
                    Product Code
                </th>

                <th>
                    Product Name
                </th>

                <th>
                    Customer
                </th>

                <th>
                    Branch
                </th>

                <th>
                    Requested Qty
                </th>

                <th>
                    Reserved Qty
                </th>

                <th>
                    Pending Qty
                </th>

                <th>
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            <?php

            $sr = 1;

            if (!empty($records)) {

                foreach ($records as $row) {

                    $requested =
                        (float)$row->requested_qty;

                    $reserved =
                        (float)$row->reserved_quantity;

                    $pending =
                        (float)$row->pending_quantity;

                    $total_requested += $requested;
                    $total_reserved  += $reserved;
                    $total_pending   += $pending;

            ?>

                    <tr>

                        <td class="center">
                            <?php echo $sr++; ?>
                        </td>

                        <td class="center">
                            <?php
                            echo !empty($row->reserve_priority)
                                ? $row->reserve_priority
                                : '-';
                            ?>
                        </td>

                        <td>
                            <?php
                            echo !empty($row->reserved_date)
                                ? date(
                                    'd-m-Y',
                                    strtotime(
                                        $row->reserved_date
                                    )
                                )
                                : '-';
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->so_code
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->product_code
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->product_name
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo !empty($row->customer_name)
                                ? html_escape(
                                    $row->customer_name
                                )
                                : '-';
                            ?>
                        </td>

                        <td>
                            <?php
                            echo !empty($row->branch_name)
                                ? html_escape(
                                    $row->branch_name
                                )
                                : '-';
                            ?>
                        </td>

                        <td class="right">
                            <?php
                            echo number_format(
                                $requested,
                                2
                            );
                            ?>
                        </td>

                        <td class="right">
                            <?php
                            echo number_format(
                                $reserved,
                                2
                            );
                            ?>
                        </td>

                        <td class="right">
                            <?php
                            echo number_format(
                                $pending,
                                2
                            );
                            ?>
                        </td>

                        <td>

                            <?php

                            if ($row->stock_status == 'FULL') {

                                echo 'Fully Reserved';
                            } elseif (
                                $row->stock_status == 'PARTIAL'
                            ) {

                                echo 'Partially Reserved';
                            } else {

                                echo $row->stock_status;
                            }

                            ?>

                        </td>

                    </tr>

            <?php

                }
            }

            ?>

        </tbody>


        <tfoot>

            <tr class="total">

                <td
                    colspan="8"
                    class="right">
                    Total
                </td>

                <td class="right">
                    <?php
                    echo number_format(
                        $total_requested,
                        2
                    );
                    ?>
                </td>

                <td class="right">
                    <?php
                    echo number_format(
                        $total_reserved,
                        2
                    );
                    ?>
                </td>

                <td class="right">
                    <?php
                    echo number_format(
                        $total_pending,
                        2
                    );
                    ?>
                </td>

                <td></td>

            </tr>

        </tfoot>

    </table>


    <br>


    <table>

        <tr>

            <td>
                Prepared By
            </td>

            <td>
                <?php
                echo html_escape(
                    $prepared_by
                );
                ?>
            </td>

            <td>
                Generated On
            </td>

            <td>
                <?php
                echo date(
                    'd-m-Y H:i:s'
                );
                ?>
            </td>

        </tr>

    </table>


</body>

</html>