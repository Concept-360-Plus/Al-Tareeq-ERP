<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Supplier Quotation Comparison
    </title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header img {
            max-width: 100%;
            max-height: 90px;
        }

        h2 {
            margin: 5px 0;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .lowest {
            font-weight: bold;
        }

        .summary-title {
            margin-top: 20px;
        }

        @media print {

            body {
                margin: 10px;
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
                src="<?php echo $headerPath; ?>"
                alt="Company Header">

        <?php } ?>

        <h2>
            Supplier Quotation Comparison
        </h2>

    </div>


    <div class="info">

        <strong>
            Period:
        </strong>

        <?php echo date(
            'd-m-Y',
            strtotime($from)
        ); ?>

        &nbsp; to &nbsp;

        <?php echo date(
            'd-m-Y',
            strtotime($to)
        ); ?>

        <br>

        <strong>
            Prepared By:
        </strong>

        <?php echo htmlspecialchars(
            $prepared_by
        ); ?>

    </div>


    <!-- ====================================== -->
    <!-- SUPPLIER SUMMARY -->
    <!-- ====================================== -->

    <h3 class="summary-title">
        Supplier Quotation Summary
    </h3>

    <table>

        <thead>

            <tr>

                <th>
                    Supplier
                </th>

                <th>
                    RFQ
                </th>

                <th>
                    Quotation
                </th>

                <th>
                    Revision
                </th>

                <th>
                    Subtotal
                </th>

                <th>
                    VAT
                </th>

                <th>
                    Grand Total
                </th>

                <th>
                    Payment
                </th>

                <th>
                    Delivery
                </th>

                <th>
                    PO Status
                </th>

            </tr>

        </thead>


        <tbody>

            <?php
            $summary = array();

            foreach ($records as $row) {

                if (
                    !isset(
                        $summary[$row->quotation_id]
                    )
                ) {

                    $summary[$row->quotation_id] = $row;
                }
            }
            ?>

            <?php foreach (
                $summary
                as $row
            ) { ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars(
                            $row->supplier_name
                        ); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $row->rfq_code
                        ); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $row->quotation_code
                        ); ?>
                    </td>

                    <td class="text-center">
                        <?php echo (int)$row->revision; ?>
                    </td>

                    <td class="text-right">
                        <?php echo number_format(
                            (float)$row->subtotal,
                            2
                        ); ?>
                    </td>

                    <td class="text-right">
                        <?php echo number_format(
                            (float)$row->vat_amt,
                            2
                        ); ?>
                    </td>

                    <td class="text-right">
                        <strong>
                            <?php echo number_format(
                                (float)$row->grand_total,
                                2
                            ); ?>
                        </strong>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $row->payment_term ?: '-'
                        ); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $row->delivery_term ?: '-'
                        ); ?>
                    </td>

                    <td class="text-center">

                        <?php
                        echo (
                            (int)$row->po_created === 1
                        )
                            ? 'PO Created'
                            : 'Not Converted';
                        ?>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>


    <!-- ====================================== -->
    <!-- ITEM COMPARISON -->
    <!-- ====================================== -->

    <h3>
        Item-wise Price Comparison
    </h3>

    <table>

        <thead>

            <tr>

                <th>
                    #
                </th>

                <th>
                    Product
                </th>

                <th>
                    Code
                </th>

                <th>
                    Qty
                </th>

                <th>
                    Unit
                </th>

                <?php foreach (
                    $suppliers
                    as $supplier
                ) { ?>

                    <th>
                        <?php echo htmlspecialchars(
                            $supplier->supplier_name
                        ); ?>

                        <br>

                        <small>
                            <?php echo htmlspecialchars(
                                $supplier->quotation_code
                            ); ?>
                        </small>

                    </th>

                <?php } ?>

                <th>
                    Lowest
                </th>

                <th>
                    Lowest Supplier
                </th>

            </tr>

        </thead>


        <tbody>

            <?php

            $sr = 1;

            foreach (
                $products
                as $product
            ) {

                $prices = array();

                foreach (
                    $records
                    as $row
                ) {

                    if (
                        (int)$row->product_id ===
                        (int)$product->product_id
                    ) {

                        $price =
                            (float)$row->unit_price;

                        if ($price > 0) {

                            $prices[$row->supplier_id] = $price;
                        }
                    }
                }

                $lowest_price = null;
                $lowest_supplier = '-';

                if (!empty($prices)) {

                    $lowest_supplier_id =
                        array_search(
                            min($prices),
                            $prices
                        );

                    $lowest_price =
                        $prices[$lowest_supplier_id];

                    if (
                        isset(
                            $suppliers[$lowest_supplier_id]
                        )
                    ) {

                        $lowest_supplier =
                            $suppliers[$lowest_supplier_id]->supplier_name;
                    }
                }

            ?>

                <tr>

                    <td class="text-center">
                        <?php echo $sr++; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $product->product_name
                        ); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $product->product_code
                        ); ?>
                    </td>

                    <td class="text-right">
                        <?php echo number_format(
                            (float)$product->quantity,
                            2
                        ); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars(
                            $product->unit_name ?: '-'
                        ); ?>
                    </td>


                    <?php foreach (
                        $suppliers
                        as $supplier_id => $supplier
                    ) { ?>

                        <?php

                        $supplier_price = null;

                        foreach (
                            $records
                            as $row
                        ) {

                            if (
                                (int)$row->product_id ===
                                (int)$product->product_id
                                &&
                                (int)$row->supplier_id ===
                                (int)$supplier_id
                            ) {

                                $supplier_price =
                                    (float)$row->unit_price;

                                break;
                            }
                        }

                        ?>

                        <td class="text-right">

                            <?php

                            echo $supplier_price !== null
                                ? number_format(
                                    $supplier_price,
                                    2
                                )
                                : '-';

                            ?>

                        </td>

                    <?php } ?>


                    <td class="text-right lowest">

                        <?php
                        echo $lowest_price !== null
                            ? number_format(
                                $lowest_price,
                                2
                            )
                            : '-';
                        ?>

                    </td>


                    <td>
                        <?php echo htmlspecialchars(
                            $lowest_supplier
                        ); ?>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>


    <div style="margin-top:40px;">

        <strong>
            Prepared By:
        </strong>

        <?php echo htmlspecialchars(
            $prepared_by
        ); ?>

    </div>


    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>