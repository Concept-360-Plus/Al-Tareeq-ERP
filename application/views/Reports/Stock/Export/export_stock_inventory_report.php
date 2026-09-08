<?php
    $company_name = $company_name ?? '';
    $branch_name = $branch_name ?? '';
    $warehouse_name = $warehouse_name ?? '';
    $store_name = $store_name ?? '';
    $product_name = $product_name ?? 'All Products';
    $prepared_by = $prepared_by ?? 'Admin';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Stock Inventory Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 6px;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .branch {
            font-size: 12px;
            text-align: center;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .period {
            text-align: center;
        }

        .header {
            font-weight: bold;
            text-align: center;
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

    <table>

        <!-- Company -->
        <tr>
            <td colspan="6" class="company">
                <?= htmlspecialchars($company_name); ?>
            </td>
        </tr>

        <!-- Branch -->
        <tr>
            <td colspan="6" class="branch">
                Branch : <?= htmlspecialchars($branch_name); ?>
            </td>
        </tr>

        <!-- Report Title -->
        <tr>
            <td colspan="6" class="report-title">
                STOCK INVENTORY REPORT
            </td>
        </tr>

        <!-- Filters -->
        <tr>
            <td colspan="6">

                Warehouse :
                <strong><?= htmlspecialchars($warehouse_name ?: 'All'); ?></strong>

                &nbsp;&nbsp;&nbsp;

                Store :
                <strong><?= htmlspecialchars($store_name ?: 'All'); ?></strong>

                &nbsp;&nbsp;&nbsp;

                Product :
                <strong><?= htmlspecialchars($product_name); ?></strong>

            </td>
        </tr>

        <!-- Empty row -->
        <tr>
            <td colspan="6"></td>
        </tr>

        <!-- Table Header -->
        <tr class="header">

            <th>Sl. No</th>

            <th>Stock Code</th>

            <th>Stock Qty</th>

            <th>Unit Price</th>

            <th>Total</th>

            <th>Allocated Qty</th>

        </tr>

        <?php

        $i = 1;

        $total_qty = 0;
        $total_value = 0;
        $total_allocated = 0;

        ?>

        <?php if (!empty($records)) { ?>

            <?php foreach ($records as $row) { ?>

                <?php

                $stock = (float)($row->stock ?? 0);

                $price = (float)($row->price ?? 0);

                $allocation = (float)($row->allocation ?? 0);

                $total = $stock * $price;

                $total_qty += $stock;

                $total_value += $total;

                $total_allocated += $allocation;

                ?>

                <tr>

                    <td class="center">
                        <?= $i++; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row->product_name ?? ''); ?>
                    </td>

                    <td class="right">
                        <?= number_format($stock, 2); ?>
                    </td>

                    <td class="right">
                        <?= number_format($price, 2); ?>
                    </td>

                    <td class="right">
                        <?= number_format($total, 2); ?>
                    </td>

                    <td class="right">
                        <?= number_format($allocation, 2); ?>
                    </td>

                </tr>

            <?php } ?>

        <?php } ?>

        <!-- Total -->
        <tr class="total">

            <td colspan="2" class="right">
                Total
            </td>

            <td class="right">
                <?= number_format($total_qty, 2); ?>
            </td>

            <td></td>

            <td class="right">
                <?= number_format($total_value, 2); ?>
            </td>

            <td class="right">
                <?= number_format($total_allocated, 2); ?>
            </td>

        </tr>

        <!-- Empty row -->
        <tr>
            <td colspan="6"></td>
        </tr>

        <!-- Prepared / Exported -->
        <tr>

            <td colspan="3">
                Prepared By:
                <strong><?= htmlspecialchars($prepared_by); ?></strong>
            </td>

            <td colspan="3">
                Exported On:
                <strong><?= date('d-M-Y h:i A'); ?></strong>
            </td>

        </tr>

    </table>

</body>

</html>