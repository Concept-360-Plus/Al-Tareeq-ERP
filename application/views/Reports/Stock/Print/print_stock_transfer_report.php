<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        <?php echo html_escape($title ?? 'Stock Transfer Report'); ?>
    </title>

    <style>
        body {
            font-family:
                Arial,
                Helvetica,
                sans-serif;
            font-size: 11px;
            margin: 20px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            max-width: 100%;
            max-height: 90px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        .branch-name {
            font-size: 13px;
            margin-top: 3px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .filter-table {
            width: 100%;
            margin-top: 12px;
            margin-bottom: 12px;
            border-collapse: collapse;
        }

        .filter-table td {
            padding: 4px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .report-table th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            width: 100%;
        }

        .footer td {
            padding-top: 10px;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        @media print {
            body {
                margin: 10mm;
            }

            .no-print {
                display: none !important;
            }

            .report-table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

        }
    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================== -->

    <div class="header">


        <?php if (!empty($headerPath)) { ?>

            <img
                src="<?= base_url('public/assets/images/altariq_logo.jpeg'); ?>"
                class="company-logo"
                alt="Company Logo">

        <?php } ?>


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


        <div class="report-title">

            Stock Transfer Report

        </div>


    </div>


    <!-- =========================
         FILTERS
    ========================== -->

    <table class="filter-table">


        <tr>

            <td>

                <strong>
                    From Date:
                </strong>

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

                <strong>
                    To Date:
                </strong>

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

                <strong>
                    Status:
                </strong>

                <?php

                echo html_escape(
                    $status_name ?? 'All'
                );

                ?>

            </td>

        </tr>


        <tr>

            <td>

                <strong>
                    From Warehouse:
                </strong>

                <?php

                echo html_escape(
                    $from_warehouse_name
                        ?? 'All Warehouses'
                );

                ?>

            </td>


            <td>

                <strong>
                    From Store:
                </strong>

                <?php

                echo html_escape(
                    $from_store_name
                        ?? 'All Stores'
                );

                ?>

            </td>


            <td>

                <strong>
                    Product:
                </strong>

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
                    To Warehouse:
                </strong>

                <?php

                echo html_escape(
                    $to_warehouse_name
                        ?? 'All Warehouses'
                );

                ?>

            </td>


            <td colspan="2">

                <strong>
                    To Store:
                </strong>

                <?php

                echo html_escape(
                    $to_store_name
                        ?? 'All Stores'
                );

                ?>

            </td>

        </tr>


    </table>


    <!-- =========================
         REPORT
    ========================== -->

    <table class="report-table">


        <thead>

            <tr>

                <th>
                    Sl No
                </th>

                <th>
                    Transfer No
                </th>

                <th>
                    Date
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

        </thead>


        <tbody>


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


                        <td class="text-center">

                            <?php
                            echo $i++;
                            ?>

                        </td>


                        <td>

                            <?php

                            echo !empty($row->transfer_code)
                                ? html_escape(
                                    $row->transfer_code
                                )
                                : '-';

                            ?>

                        </td>


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


                        <td>

                            <?php

                            echo html_escape(
                                $row->from_warehouse
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo html_escape(
                                $row->from_store
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo html_escape(
                                $row->to_warehouse
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo html_escape(
                                $row->to_store
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo html_escape(
                                $row->product_code
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo html_escape(
                                $row->product_name
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo html_escape(
                                $row->unit_name
                                    ?? '-'
                            );

                            ?>

                        </td>


                        <td class="text-right">

                            <?php

                            echo number_format(
                                $available_qty,
                                2
                            );

                            ?>

                        </td>


                        <td class="text-right">

                            <?php

                            echo number_format(
                                $transfer_qty,
                                2
                            );

                            ?>

                        </td>


                        <td class="text-center">

                            <?php

                            $status_value =
                                isset($row->status)
                                ? (string)$row->status
                                : '';


                            if ($status_value === '1') {

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


                        <td>

                            <?php

                            echo html_escape(
                                $row->created_user
                                    ?? '-'
                            );

                            ?>

                        </td>


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


                <!-- TOTAL -->

                <tr class="total-row">


                    <td
                        colspan="11"
                        class="text-right">

                        Total Transfer Quantity

                    </td>


                    <td class="text-right">

                        <?php

                        echo number_format(
                            $total_transfer_qty,
                            2
                        );

                        ?>

                    </td>


                    <td colspan="3"></td>


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


        </tbody>


    </table>


    <!-- =========================
         PREPARED BY
    ========================== -->

    <table class="footer">

        <tr>

            <td>

                Prepared By:

                <strong>

                    <?php

                    echo html_escape(
                        $prepared_by
                            ?? 'Admin'
                    );

                    ?>

                </strong>

            </td>


            <td
                style="text-align:right;">

                Printed On:

                <strong>

                    <?php

                    echo date(
                        'd-m-Y h:i A'
                    );

                    ?>

                </strong>

            </td>

        </tr>

    </table>


    <!-- =========================
         FOOTER
    ========================== -->

    <div class="footer">


        <div class="footer-left">

            &copy;

            <?= date('Y'); ?>

            <?= !empty($company_name)
                ? htmlspecialchars(
                    $company_name
                )
                : 'Al Tareeq Kitchen Equipment Industry LLC'; ?>

        </div>


        <div class="footer-right">

            Designed &amp; Developed by

            Concepts 360 Plus

        </div>


    </div>


    <script>
        window.onload = function() {

            window.print();

        };
    </script>


</body>

</html>