<!DOCTYPE html>
<html>

<head>

    <title>Stock Transfer - <?= $master->transfer_code ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #222;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            margin: 2px;
        }

        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .label {
            font-weight: bold;
            width: 18%;
            background: #f5f5f5;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.items th,
        table.items td {
            border: 1px solid #333;
            padding: 8px;
        }

        table.items th {
            background: #f2f2f2;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .remarks {
            margin-top: 20px;
        }

        .signature {
            margin-top: 80px;
            width: 100%;
        }

        .signature td {
            width: 33%;
            text-align: center;
            padding-top: 30px;
        }

        .print-button {
            margin-bottom: 20px;
            text-align: right;
        }

        @media print {

            .print-button {
                display: none;
            }

            body {
                margin: 10px;
            }

        }
    </style>

</head>

<body>

    <div class="print-button">

        <button onclick="window.print()">
            Print
        </button>

    </div>

    <div class="header">

        <h2>AL TAREEQ</h2>

        <p>Stock Transfer</p>

    </div>

    <div class="document-title">
        STOCK TRANSFER
    </div>

    <table class="details">

        <tr>

            <td class="label">
                Transfer No
            </td>

            <td>
                <?= htmlspecialchars($master->transfer_code) ?>
            </td>

            <td class="label">
                Transfer Date
            </td>

            <td>
                <?= date('d-m-Y', strtotime($master->transfer_date)) ?>
            </td>

        </tr>

        <tr>

            <td class="label">
                From Branch
            </td>

            <td>
                <?= htmlspecialchars($master->from_branch) ?>
            </td>

            <td class="label">
                To Branch
            </td>

            <td>
                <?= htmlspecialchars($master->to_branch) ?>
            </td>

        </tr>

        <tr>

            <td class="label">
                From Warehouse
            </td>

            <td>
                <?= htmlspecialchars($master->from_warehouse) ?>
            </td>

            <td class="label">
                To Warehouse
            </td>

            <td>
                <?= htmlspecialchars($master->to_warehouse) ?>
            </td>

        </tr>

        <tr>

            <td class="label">
                From Store
            </td>

            <td>
                <?= htmlspecialchars($master->from_store) ?>
            </td>

            <td class="label">
                To Store
            </td>

            <td>
                <?= htmlspecialchars($master->to_store) ?>
            </td>

        </tr>

        <tr>

            <td class="label">
                Status
            </td>

            <td colspan="3">
                <?= htmlspecialchars($master->status) ?>
            </td>

        </tr>

    </table>


    <table class="items">

        <thead>

            <tr>

                <th width="8%">
                    Sl.No
                </th>

                <th>
                    Product Code
                </th>

                <th>
                    Product
                </th>

                <th>
                    Unit
                </th>

                <th class="text-right">
                    Transfer Qty
                </th>

                <th>
                    Remarks
                </th>

            </tr>

        </thead>

        <tbody>

            <?php

            $total_qty = 0;

            foreach ($items as $key => $item):

                $total_qty += (float)$item->transfer_qty;

            ?>

                <tr>

                    <td>
                        <?= $key + 1 ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item->product_code) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item->product_name) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item->unit_name) ?>
                    </td>

                    <td class="text-right">
                        <?= number_format($item->transfer_qty, 2) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item->remarks) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

            <tr>

                <th colspan="4" class="text-right">
                    Total
                </th>

                <th class="text-right">
                    <?= number_format($total_qty, 2) ?>
                </th>

                <th></th>

            </tr>

        </tbody>

    </table>


    <div class="remarks">

        <strong>Remarks:</strong>

        <?= nl2br(htmlspecialchars($master->remarks)) ?>

    </div>


    <table class="signature">

        <tr>

            <td>
                _______________________<br>
                Prepared By
            </td>

            <td>
                _______________________<br>
                Issued By
            </td>

            <td>
                _______________________<br>
                Received By
            </td>

        </tr>

    </table>

</body>

</html>