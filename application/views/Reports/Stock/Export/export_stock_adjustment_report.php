<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        Stock Adjustment Report
    </title>

    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #d9eaf7;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>

</head>


<body>


    <table>

        <tr>

            <th colspan="13">

                <?php
                echo html_escape(
                    $company_name ?? ''
                );
                ?>

            </th>

        </tr>


        <?php if (!empty($branch_name)) { ?>

            <tr>

                <th colspan="13">

                    <?php
                    echo html_escape(
                        $branch_name
                    );
                    ?>

                </th>

            </tr>

        <?php } ?>


        <tr>

            <th colspan="13">

                Stock Adjustment Report

            </th>

        </tr>


        <tr>

            <td>
                From Date
            </td>

            <td>
                <?php
                echo !empty($from)
                    ? date('d-m-Y', strtotime($from))
                    : '';
                ?>
            </td>

            <td>
                To Date
            </td>

            <td>
                <?php
                echo !empty($to)
                    ? date('d-m-Y', strtotime($to))
                    : '';
                ?>
            </td>

            <td>
                Adjustment Type
            </td>

            <td colspan="2">

                <?php
                echo html_escape(
                    $adjustment_type_name ?? 'All'
                );
                ?>

            </td>

            <td>
                Warehouse
            </td>

            <td colspan="2">

                <?php
                echo html_escape(
                    $warehouse_name ?? 'All Warehouses'
                );
                ?>

            </td>

            <td>
                Store
            </td>

            <td>

                <?php
                echo html_escape(
                    $store_name ?? 'All Stores'
                );
                ?>

            </td>

        </tr>


        <tr>

            <td>
                Product
            </td>

            <td colspan="12">

                <?php
                echo html_escape(
                    $product_name ?? 'All Products'
                );
                ?>

            </td>

        </tr>


        <tr>

            <th>Sl No</th>
            <th>Adjustment No</th>
            <th>Adjustment Date</th>
            <th>Adjustment Type</th>
            <th>Stock Code</th>
            <th>Product Name</th>
            <th>Warehouse</th>
            <th>Store</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Adjustment Value</th>
            <th>Created By</th>
            <th>Remarks</th>

        </tr>


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

                    <td>
                        <?php echo $i++; ?>
                    </td>

                    <td>
                        <?php
                        echo html_escape(
                            $row->adjustment_code ?? '-'
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo !empty($row->stock_date)
                            ? date(
                                'd-m-Y',
                                strtotime($row->stock_date)
                            )
                            : '-';
                        ?>
                    </td>

                    <td>
                        <?php

                        $type =
                            strtoupper(
                                $row->adjustment_type ?? ''
                            );

                        if ($type == 'IN') {

                            echo 'Increase';
                        } elseif ($type == 'OUT') {

                            echo 'Decrease';
                        } else {

                            echo html_escape(
                                $row->adjustment_type ?? '-'
                            );
                        }

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


            <tr>

                <th
                    colspan="8"
                    style="text-align:right;">

                    Total

                </th>

                <th class="text-right">

                    <?php
                    echo number_format(
                        $total_quantity,
                        2
                    );
                    ?>

                </th>

                <th></th>

                <th class="text-right">

                    <?php
                    echo number_format(
                        $total_value,
                        2
                    );
                    ?>

                </th>

                <th colspan="2"></th>

            </tr>


        <?php } else { ?>

            <tr>

                <td
                    colspan="13"
                    style="text-align:center;">

                    No Stock Adjustment
                    records found.

                </td>

            </tr>

        <?php } ?>


        <tr>

            <td colspan="13">

                Prepared By:
                <?php
                echo html_escape(
                    $prepared_by ?? 'Admin'
                );
                ?>

            </td>

        </tr>


    </table>


</body>

</html>