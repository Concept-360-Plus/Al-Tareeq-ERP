<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        <?php echo $title; ?>
    </title>

    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            max-width: 100%;
            max-height: 70px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        .branch-name {
            font-size: 12px;
        }

        .report-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .filter-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .filter-table td {
            padding: 3px 5px;
        }

        .filter-label {
            font-weight: bold;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report th,
        table.report td {
            border: 1px solid #555;
            padding: 5px;
        }

        table.report th {
            background: #eeeeee;
            text-align: center;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #eeeeee;
        }

        .footer {
            margin-top: 15px;
            font-size: 9px;
        }

        @media print {

            .no-print {
                display: none !important;
            }

        }
    </style>

</head>


<body>


    <div class="header">

        <?php if (!empty($headerPath)) { ?>

            <img
                src="<?php echo $headerPath; ?>"
                alt="Company Header">

        <?php } else { ?>

            <?php if (!empty($company_name)) { ?>

                <div class="company-name">
                    <?php
                    echo html_escape(
                        $company_name
                    );
                    ?>
                </div>

            <?php } ?>

            <?php if (!empty($branch_name)) { ?>

                <div class="branch-name">
                    <?php
                    echo html_escape(
                        $branch_name
                    );
                    ?>
                </div>

            <?php } ?>

        <?php } ?>


        <div class="report-title">
            Stock Reservation Report
        </div>

    </div>


    <table class="filter-table">

        <tr>

            <td class="filter-label">
                From Date:
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


            <td class="filter-label">
                To Date:
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


            <td class="filter-label">
                Product:
            </td>

            <td>
                <?php
                echo html_escape(
                    $product_name
                );
                ?>
            </td>

        </tr>


        <tr>

            <td class="filter-label">
                Customer:
            </td>

            <td>
                <?php
                echo html_escape(
                    $customer_name
                );
                ?>
            </td>


            <td class="filter-label">
                Sales Order:
            </td>

            <td>
                <?php
                echo html_escape(
                    $sales_order_name
                );
                ?>
            </td>


            <td class="filter-label">
                Status:
            </td>

            <td>

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


    <?php

    $total_requested = 0;
    $total_reserved  = 0;
    $total_pending   = 0;

    ?>


    <table class="report">

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

                        <td class="text-center">
                            <?php echo $sr++; ?>
                        </td>

                        <td class="text-center">
                            <?php
                            echo !empty($row->reserve_priority)
                                ? html_escape(
                                    $row->reserve_priority
                                )
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

                        <td class="text-right">
                            <?php
                            echo number_format(
                                $requested,
                                2
                            );
                            ?>
                        </td>

                        <td class="text-right">
                            <?php
                            echo number_format(
                                $reserved,
                                2
                            );
                            ?>
                        </td>

                        <td class="text-right">
                            <?php
                            echo number_format(
                                $pending,
                                2
                            );
                            ?>
                        </td>

                        <td class="text-center">

                            <?php

                            if ($row->stock_status == 'FULL') {

                                echo 'Fully Reserved';
                            } elseif (
                                $row->stock_status == 'PARTIAL'
                            ) {

                                echo 'Partially Reserved';
                            } else {

                                echo html_escape(
                                    $row->stock_status
                                );
                            }

                            ?>

                        </td>

                    </tr>

                <?php

                }
            } else {

                ?>

                <tr>

                    <td
                        colspan="12"
                        class="text-center">
                        No reservations found.
                    </td>

                </tr>

            <?php } ?>

        </tbody>


        <tfoot>

            <tr class="total-row">

                <td
                    colspan="8"
                    class="text-right">
                    Total
                </td>

                <td class="text-right">
                    <?php
                    echo number_format(
                        $total_requested,
                        2
                    );
                    ?>
                </td>

                <td class="text-right">
                    <?php
                    echo number_format(
                        $total_reserved,
                        2
                    );
                    ?>
                </td>

                <td class="text-right">
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


    <div class="footer">

        Prepared By:
        <?php
        echo html_escape(
            $prepared_by
        );
        ?>

        &nbsp;&nbsp;&nbsp;

        Printed On:
        <?php
        echo date('d-m-Y H:i:s');
        ?>

    </div>


    <script>
        window.onload = function() {
            window.print();
        };
    </script>


</body>

</html>