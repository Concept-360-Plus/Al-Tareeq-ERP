<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        Purchase Return Report
    </title>


    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 70px;
            max-width: 300px;
        }

        .header h2 {
            margin: 8px 0 4px;
        }

        .header p {
            margin: 3px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f0f2f5;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 7px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #f5f5f5;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        @media print {

            body {
                margin: 10mm;
            }

            .no-print {
                display: none;
            }

        }
    </style>

</head>


<body>


    <div class="header">

        <?php if (!empty($headerPath)) { ?>

            <img
                src="<?= $headerPath ?>"
                alt="Company Header">

        <?php } ?>

        <h2>
            PURCHASE RETURN REPORT
        </h2>

        <p>

            Period:

            <?= !empty($from)
                ? date('d-m-Y', strtotime($from))
                : '' ?>

            -

            <?= !empty($to)
                ? date('d-m-Y', strtotime($to))
                : '' ?>

        </p>

    </div>


    <table>

        <thead>

            <tr>

                <th>Sl. No</th>

                <th>Return Code</th>

                <th>Date</th>

                <th>GRN No</th>

                <th>Supplier</th>

                <th>Warehouse</th>

                <th>Store</th>

                <th>Product Code</th>

                <th>Product Name</th>

                <th>Unit</th>

                <th>Return Qty</th>

                <th>Remarks</th>

            </tr>

        </thead>


        <tbody>

            <?php

            $sl = 1;

            $total_return_qty = 0;

            ?>


            <?php if (!empty($records)) { ?>

                <?php foreach ($records as $row) { ?>

                    <?php

                    $qty =
                        (float)$row->return_qty;

                    $total_return_qty += $qty;

                    ?>

                    <tr>

                        <td class="text-center">
                            <?= $sl++ ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->return_code
                            ) ?>
                        </td>

                        <td>

                            <?= !empty($row->return_date)
                                ? date(
                                    'd-m-Y',
                                    strtotime(
                                        $row->return_date
                                    )
                                )
                                : '' ?>

                        </td>

                        <td>
                            <?= html_escape(
                                $row->grn_code ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->supplier_name ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->warehouse_name ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->store_name ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->product_code ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->product_name ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape(
                                $row->unit_name ?? ''
                            ) ?>
                        </td>

                        <td class="text-right">

                            <?= number_format(
                                $qty,
                                2
                            ) ?>

                        </td>

                        <td>
                            <?= html_escape(
                                $row->remarks ?? ''
                            ) ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td
                        colspan="12"
                        class="text-center">

                        No records found.

                    </td>

                </tr>

            <?php } ?>

        </tbody>


        <?php if (!empty($records)) { ?>

            <tfoot>

                <tr class="total-row">

                    <td
                        colspan="10"
                        class="text-right">

                        Total Return Quantity

                    </td>

                    <td class="text-right">

                        <?= number_format(
                            $total_return_qty,
                            2
                        ) ?>

                    </td>

                    <td></td>

                </tr>

            </tfoot>

        <?php } ?>

    </table>


    <div class="footer">

        Generated on
        <?= date('d-m-Y H:i') ?>

    </div>


    <script>
        window.onload = function() {

            window.print();

        };
    </script>


</body>

</html>