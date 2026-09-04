<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            font-weight: bold;
            text-align: center;
            background: #eaeaea;
        }

        .text-right {
            text-align: right;
        }
    </style>

</head>


<body>

    <table>

        <tr>

            <td colspan="<?php echo 7 + count($suppliers); ?>">

                <strong>
                    <?php echo htmlspecialchars(
                        $company_name
                    ); ?>
                </strong>

            </td>

        </tr>


        <tr>

            <td colspan="<?php echo 7 + count($suppliers); ?>">

                <strong>
                    Supplier Quotation Comparison
                </strong>

            </td>

        </tr>


        <tr>

            <td colspan="<?php echo 7 + count($suppliers); ?>">

                From:
                <?php echo htmlspecialchars($from); ?>

                &nbsp;&nbsp;

                To:
                <?php echo htmlspecialchars($to); ?>

            </td>

        </tr>

    </table>


    <br>


    <!-- SUPPLIER SUMMARY -->

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
                    Payment Term
                </th>

                <th>
                    Delivery Term
                </th>

                <th>
                    Validity
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

                    <td>
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
                        <?php echo number_format(
                            (float)$row->grand_total,
                            2
                        ); ?>
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

                    <td>
                        <?php echo htmlspecialchars(
                            $row->validity ?: '-'
                        ); ?>
                    </td>

                    <td>

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


    <br>


    <!-- ITEM COMPARISON -->

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
                    Product Code
                </th>

                <th>
                    Quantity
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

                        -
                        <?php echo htmlspecialchars(
                            $supplier->quotation_code
                        ); ?>

                    </th>

                <?php } ?>


                <th>
                    Lowest Price
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

                    <td>
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


                    <td class="text-right">

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


    <br>

    Prepared By:
    <?php echo htmlspecialchars(
        $prepared_by
    ); ?>

</body>

</html>