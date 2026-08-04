<html>

<head>
    <title>Purchase Return</title>
</head>

<body style="margin-left:5px; margin-top:5px; font-family:Arial;font-size:12px;text-align:center">

    <table width="100%" style="border:0">
        <tbody>

            <!-- Heading -->
            <tr>
                <td>
                    <table width="95%" cellpadding="5" style="font-size:20px;text-align:center;border:0">
                        <tr>
                            <td style="color:#e8b41a;">
                                PURCHASE RETURN
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Supplier & Return Details -->
            <tr>
                <td>

                    <table width="95%" cellpadding="5" style="border-collapse:collapse;border:0;">

                        <tr>

                            <!-- Supplier Details -->
                            <td width="60%">

                                <table width="100%" style="font-size:12px;">

                                    <tr>
                                        <td width="30%">Supplier</td>
                                        <td>:</td>
                                        <td><?= $master->supplier_name ?></td>
                                    </tr>

                                    <tr>
                                        <td>Address</td>
                                        <td>:</td>
                                        <td><?= $master->billing_address ?></td>
                                    </tr>

                                    <tr>
                                        <td>Contact No</td>
                                        <td>:</td>
                                        <td><?= $master->contact_number ?></td>
                                    </tr>

                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><?= $master->supplier_email ?></td>
                                    </tr>

                                </table>

                            </td>

                            <!-- Return Details -->
                            <td width="40%">

                                <table width="100%" style="font-size:12px;">

                                    <tr>
                                        <td width="35%">Return Date</td>
                                        <td>:</td>
                                        <td><?= date('d-m-Y', strtotime($master->return_date)); ?></td>
                                    </tr>

                                    <tr>
                                        <td>Return No</td>
                                        <td>:</td>
                                        <td><?= $master->return_code; ?></td>
                                    </tr>

                                    <tr>
                                        <td>GRN No</td>
                                        <td>:</td>
                                        <td><?= $master->grn_code; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Warehouse</td>
                                        <td>:</td>
                                        <td><?= $master->warehouse_name; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Store</td>
                                        <td>:</td>
                                        <td><?= $master->store_name; ?></td>
                                    </tr>

                                </table>

                            </td>

                        </tr>

                    </table>

                </td>
            </tr>

            <!-- Divider -->
            <tr height="5" style="background:#525453;">
                <td></td>
            </tr>

            <!-- Remarks -->
            <tr>
                <td>

                    <table width="95%" cellpadding="5">

                        <tr>
                            <td align="left">
                                <b>Remarks :</b>
                                <?= $master->remarks; ?>
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>

            <!-- Items -->
            <tr>

                <td>

                    <table width="100%" cellpadding="8" style="border-collapse:collapse;border:1px solid;font-size:12px;">

                        <thead>

                            <tr style="background:#525453;color:#e8b41a;font-weight:bold;">

                                <td width="5%">Sl No</td>

                                <td width="15%">Product Code</td>

                                <td width="25%">Product</td>

                                <td width="25%">Description</td>

                                <td width="8%">Unit</td>

                                <td width="10%">Returned Qty</td>

                                <td width="12%">Reason</td>

                            </tr>

                        </thead>

                        <tbody style="background:#edebe4;">

                            <?php
                            $i = 1;
                            $total_qty = 0;

                            foreach ($items as $row):

                                $total_qty += $row->return_qty;
                            ?>

                                <tr>

                                    <td><?= $i++; ?></td>

                                    <td><?= $row->product_code; ?></td>

                                    <td><?= $row->product_name; ?></td>

                                    <td><?= $row->description; ?></td>

                                    <td><?= $row->unit_name; ?></td>

                                    <td align="right"><?= number_format($row->return_qty, 2); ?></td>

                                    <td><?= $row->reason; ?></td>

                                </tr>

                            <?php endforeach; ?>

                            <tr style="font-weight:bold;">

                                <td colspan="5" align="right">
                                    Total Returned Qty
                                </td>

                                <td align="right">
                                    <?= number_format($total_qty, 2); ?>
                                </td>

                                <td></td>

                            </tr>

                        </tbody>

                    </table>

                </td>

            </tr>

            <!-- Signatures -->
            <tr>

                <td>

                    <br><br>

                    <table width="100%">

                        <tr>

                            <td align="center">
                                ___________________<br>
                                Prepared By
                            </td>

                            <td align="center">
                                ___________________<br>
                                Checked By
                            </td>

                            <td align="center">
                                ___________________<br>
                                Approved By
                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </tbody>

    </table>

</body>

</html>