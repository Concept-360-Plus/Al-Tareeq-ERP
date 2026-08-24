<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        <?php echo html_escape($title); ?>
    </title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
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


    <div class="header">

        <?php if (!empty($headerPath)) { ?>

            <img
                src="<?= base_url('public/assets/images/altariq_logo.jpeg'); ?>"
                class="company-logo"
                alt="Company Logo">

        <?php } ?>


        <?php if (!empty($company_name)) { ?>

            <div class="company-name">
                <?php echo html_escape($company_name); ?>
            </div>

        <?php } ?>


        <?php if (!empty($branch_name)) { ?>

            <div class="branch-name">
                <?php echo html_escape($branch_name); ?>
            </div>

        <?php } ?>


        <div class="report-title">
            Stock Adjustment Report
        </div>

    </div>


    <table class="filter-table">

        <tr>

            <td>
                <strong>From Date:</strong>
                <?php
                echo !empty($from)
                    ? date('d-m-Y', strtotime($from))
                    : '-';
                ?>
            </td>

            <td>
                <strong>To Date:</strong>
                <?php
                echo !empty($to)
                    ? date('d-m-Y', strtotime($to))
                    : '-';
                ?>
            </td>

            <td>
                <strong>Adjustment Type:</strong>
                <?php
                echo html_escape(
                    $adjustment_type_name ?? 'All'
                );
                ?>
            </td>

        </tr>


        <tr>

            <td>
                <strong>Warehouse:</strong>
                <?php
                echo html_escape(
                    $warehouse_name ?? 'All Warehouses'
                );
                ?>
            </td>

            <td>
                <strong>Store:</strong>
                <?php
                echo html_escape(
                    $store_name ?? 'All Stores'
                );
                ?>
            </td>

            <td>
                <strong>Product:</strong>
                <?php
                echo html_escape(
                    $product_name ?? 'All Products'
                );
                ?>
            </td>

        </tr>

    </table>


    <table class="report-table">

        <thead>

            <tr>

                <th>Sl No</th>
                <th>Adjustment No</th>
                <th>Date</th>
                <th>Type</th>
                <th>Stock Code</th>
                <th>Product Name</th>
                <th>Warehouse</th>
                <th>Store</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Value</th>
                <th>Created By</th>
                <th>Remarks</th>

            </tr>

        </thead>


        <tbody>

            <?php

            $total_quantity = 0;
            $total_value = 0;

            ?>


            <?php if (!empty($records)) { ?>

                <?php $i = 1; ?>


                <?php foreach ($records as $row) { ?>

                    <?php

                    $quantity =
                        (float)($row->quantity ?? 0);

                    $price =
                        (float)($row->price ?? 0);

                    $value =
                        isset($row->stock_value)
                        ? (float)$row->stock_value
                        : ($quantity * $price);

                    $total_quantity +=
                        $quantity;

                    $total_value +=
                        $value;

                    ?>


                    <tr>

                        <td class="text-center">
                            <?php echo $i++; ?>
                        </td>

                        <td>
                            <?php
                            echo !empty($row->adjustment_code)
                                ? html_escape($row->adjustment_code)
                                : '-';
                            ?>
                        </td>

                        <td class="text-center">
                            <?php
                            echo !empty($row->stock_date)
                                ? date(
                                    'd-m-Y',
                                    strtotime($row->stock_date)
                                )
                                : '-';
                            ?>
                        </td>

                        <td class="text-center">
                            <?php
                            echo strtoupper(
                                $row->adjustment_type ?? '-'
                            ) == 'IN'
                                ? 'Increase'
                                : (
                                    strtoupper(
                                        $row->adjustment_type ?? ''
                                    ) == 'OUT'
                                    ? 'Decrease'
                                    : html_escape(
                                        $row->adjustment_type ?? '-'
                                    )
                                );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->product_code ?? '-'
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->product_name ?? '-'
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->warehouse_name ?? '-'
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->store_name ?? '-'
                            );
                            ?>
                        </td>

                        <td class="text-right">
                            <?php
                            echo number_format(
                                $quantity,
                                2
                            );
                            ?>
                        </td>

                        <td class="text-right">
                            <?php
                            echo number_format(
                                $price,
                                2
                            );
                            ?>
                        </td>

                        <td class="text-right">
                            <?php
                            echo number_format(
                                $value,
                                2
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo html_escape(
                                $row->created_user ?? '-'
                            );
                            ?>
                        </td>

                        <td>
                            <?php

                            $remarks =
                                $row->adjustment_remark
                                ?? $row->stock_remark
                                ?? $row->item_remark
                                ?? '';

                            echo !empty($remarks)
                                ? html_escape($remarks)
                                : '-';

                            ?>
                        </td>

                    </tr>

                <?php } ?>


                <tr class="total-row">

                    <td
                        colspan="8"
                        class="text-right">

                        Total

                    </td>

                    <td class="text-right">

                        <?php
                        echo number_format(
                            $total_quantity,
                            2
                        );
                        ?>

                    </td>

                    <td></td>

                    <td class="text-right">

                        <?php
                        echo number_format(
                            $total_value,
                            2
                        );
                        ?>

                    </td>

                    <td colspan="2"></td>

                </tr>


            <?php } else { ?>

                <tr>

                    <td
                        colspan="13"
                        class="text-center">

                        No Stock Adjustment
                        records found.

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>


    <table class="footer">

        <tr>
            <td>
                Prepared By:
                <strong>
                    <?php
                    echo html_escape(
                        $prepared_by ?? 'Admin'
                    );
                    ?>
                </strong>
            </td>

            <td style="text-align:right;">
                Printed On:
                <strong>
                    <?php
                    echo date('d-m-Y h:i A');
                    ?>
                </strong>
            </td>
        </tr>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>