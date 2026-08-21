<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Stock Movement Report
    </title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .report-header img {
            max-width: 100%;
            max-height: 80px;
        }

        .report-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .filter-info {
            margin-bottom: 15px;
            border: 1px solid #ccc;
            padding: 8px;
        }

        .filter-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .filter-info td {
            padding: 4px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 6px;
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
            font-size: 11px;
        }

        @media print {

            body {
                margin: 10px;
            }

            .no-print {
                display: none !important;
            }

        }
    </style>

</head>


<body>

    <div class="no-print" style="margin-bottom:15px;">
        <button
            onclick="window.print();"
            style="
                padding:8px 15px;
                cursor:pointer;
            ">
            Print Report
        </button>
    </div>

    <div class="report-header">
        <?php if (!empty($headerPath)) { ?>
            <img
                src="<?php echo $headerPath; ?>"
                alt="Company Header">
        <?php } ?>

        <div class="report-title">
            Stock Movement Report
        </div>
    </div>


    <div class="filter-info">

        <table>

            <tr>

                <td>
                    <strong>From Date:</strong>
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
                    <strong>To Date:</strong>
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

            </tr>


            <tr>

                <td>
                    <strong>Movement Type:</strong>
                </td>

                <td>
                    <?php
                        if ($movement_type == 'IN') {
                            echo 'Stock In';
                        } elseif ($movement_type == 'OUT') {
                            echo 'Stock Out';
                        } else {
                            echo 'All Movements';
                        }
                    ?>
                </td>

                <td>
                    <strong>Warehouse:</strong>
                </td>

                <td>
                    <?php
                        if (!empty($warehouse_id)) {
                            $warehouse =
                                $this->db
                                ->where(
                                    'warehouse_id',
                                    $warehouse_id
                                )
                                ->get(
                                    'warehouse_master'
                                )
                                ->row();
                            echo !empty($warehouse)
                                ? html_escape(
                                    $warehouse->warehouse_name
                                )
                                : '-';
                        } else {

                            echo 'All Warehouses';
                        }
                    ?>
                </td>

            </tr>


            <tr>

                <td>
                    <strong>Store:</strong>
                </td>

                <td>
                    <?php
                        if (!empty($store_id)) {
                            $store =
                                $this->db
                                ->where(
                                    'store_id',
                                    $store_id
                                )
                                ->get(
                                    'store_master'
                                )
                                ->row();

                            echo !empty($store)
                                ? html_escape(
                                    $store->store_name
                                )
                                : '-';
                        } else {
                            echo 'All Stores';
                        }
                    ?>
                </td>

                <td>
                    <strong>Product:</strong>
                </td>

                <td>
                    <?php
                        if (!empty($product_id)) {
                            $product =
                                $this->db
                                ->where(
                                    'product_id',
                                    $product_id
                                )
                                ->get(
                                    'item_master'
                                )
                                ->row();
                            if (!empty($product)) {
                                echo html_escape(
                                    $product->product_code .
                                        ' ' .
                                        $product->product_name
                                );
                            } else {
                                echo '-';
                            }
                        } else {
                            echo 'All Products';
                        }
                    ?>
                </td>

            </tr>

        </table>

    </div>


    <table class="report-table">

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
                $total_in = 0;
                $total_out = 0;
            ?>


            <?php if (!empty($records)) { ?>
                <?php $i = 1; ?>

                <?php foreach ($records as $row) { ?>
                    <?php
                        $qty = (float)$row->quantity;
                        if ($row->stock_type == 'IN') {
                            $total_in += $qty;
                        } elseif (
                            $row->stock_type == 'OUT'
                        ) {
                            $total_out += $qty;
                        }
                    ?>

                    <tr>

                        <td class="text-center">
                            <?php echo $i++; ?>
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
                                if (!empty($row->bill_no)) {
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


                        <td class="text-center">
                            <?php
                                if ($row->stock_type == 'IN') {
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


                <tr class="total-row">

                    <td
                        colspan="6"
                        class="text-right">
                        Total Stock In
                    </td>

                    <td class="text-right">
                        <?php
                        echo number_format(
                            $total_in,
                            2
                        );
                        ?>
                    </td>

                    <td colspan="5"></td>

                </tr>

                <tr class="total-row">
                    <td
                        colspan="6"
                        class="text-right">
                        Total Stock Out
                    </td>

                    <td class="text-right">
                        <?php
                        echo number_format(
                            $total_out,
                            2
                        );
                        ?>
                    </td>

                    <td colspan="5"></td>

                </tr>


                <tr class="total-row">
                    <td
                        colspan="6"
                        class="text-right">
                        Net Movement
                    </td>

                    <td class="text-right">
                        <?php
                        echo number_format(
                            $total_in - $total_out,
                            2
                        );
                        ?>
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

    <div class="footer">
        Printed on:
        <?php echo date('d-m-Y H:i:s'); ?>
    </div>

</body>

</html>