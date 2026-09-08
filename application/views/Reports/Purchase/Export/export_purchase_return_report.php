<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>
        Purchase Return Report
    </title>

</head>


<body>

    <table
        border="1"
        cellspacing="0"
        cellpadding="5">

        <tr>

            <td
                colspan="12"
                align="center">

                <strong>
                    PURCHASE RETURN REPORT
                </strong>

            </td>

        </tr>


        <tr>

            <td
                colspan="12"
                align="center">

                Period:

                <?= !empty($from)
                    ? date(
                        'd-m-Y',
                        strtotime($from)
                    )
                    : '' ?>

                -

                <?= !empty($to)
                    ? date(
                        'd-m-Y',
                        strtotime($to)
                    )
                    : '' ?>

            </td>

        </tr>


        <tr>

            <th>Sl. No</th>

            <th>Return Code</th>

            <th>Return Date</th>

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

                    <td>
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

                    <td>
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


            <tr>

                <td
                    colspan="10"
                    align="right">

                    <strong>
                        Total Return Quantity
                    </strong>

                </td>

                <td>

                    <strong>

                        <?= number_format(
                            $total_return_qty,
                            2
                        ) ?>

                    </strong>

                </td>

                <td></td>

            </tr>


        <?php } else { ?>

            <tr>

                <td
                    colspan="12"
                    align="center">

                    No Purchase Return records found.

                </td>

            </tr>

        <?php } ?>

    </table>

</body>

</html>