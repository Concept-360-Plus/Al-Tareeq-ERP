<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Purchase Order Report</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .branch-name {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .period {
            font-size: 12px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #d9e1f2;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 6px;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <!-- COMPANY NAME -->
    <table>

        <tr>
            <td colspan="7"
                class="company-name">

                <?php
                echo !empty($company_name['company_name'])
                    ? htmlspecialchars(
                        $company_name['company_name']
                    )
                    : '-';
                ?>

            </td>
        </tr>


        <!-- BRANCH -->
        <tr>
            <td colspan="7" class="branch-name">
                Branch :
                <?php
                echo !empty($branch_name)
                    ? htmlspecialchars($branch_name)
                    : '-';
                ?>
            </td>
        </tr>


        <!-- REPORT TITLE -->
        <tr>
            <td colspan="7"
                class="report-title">
                PURCHASE ORDER REPORT
            </td>
        </tr>


        <!-- PERIOD -->
        <tr>
            <td colspan="7"
                class="period">
                Period :
                <?php
                echo !empty($from)
                    ? date(
                        'd-M-Y',
                        strtotime($from)
                    )
                    : '-';
                ?>
                &nbsp; to &nbsp;
                <?php
                echo !empty($to)
                    ? date(
                        'd-M-Y',
                        strtotime($to)
                    )
                    : '-';
                ?>
            </td>
        </tr>

        <tr>
            <td colspan="7">
                &nbsp;
            </td>
        </tr>
    </table>

    <!-- REPORT DATA -->
    <table>
        <thead>
            <tr>
                <th>
                    Sl. No
                </th>

                <th>
                    PO Code
                </th>

                <th>PO Type</th>

                <th>
                    PO Date
                </th>

                <th>
                    Supplier
                </th>

                <th>
                    Grand Total
                </th>

                <th>
                    Created By
                </th>
            </tr>

        </thead>

        <tbody>

            <?php
            $sl_no = 1;
            $total_grand = 0;
            ?>

            <?php if (!empty($records)) { ?>
                <?php foreach ($records as $row) { ?>
                    <?php
                    $grand_total = (float) $row->grand_total;
                    $total_grand += $grand_total;
                    ?>

                    <tr>
                        <td class="center">
                            <?php
                            echo $sl_no++;
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row->po_code
                            );
                            ?>
                        </td>

                        <td class="center">
                            <?php
                            echo strtoupper(
                                $row->po_type
                            );
                            ?>

                        </td>


                        <td class="center">
                            <?php
                            echo !empty($row->po_date)
                                ? date(
                                    'd-M-Y',
                                    strtotime(
                                        $row->po_date
                                    )
                                )
                                : '-';
                            ?>
                        </td>

                        <td>
                            <?php
                            echo !empty($row->supplier_name)
                                ? htmlspecialchars(
                                    $row->supplier_name
                                )
                                : '-';
                            ?>
                        </td>


                        <td class="right">
                            <?php
                            echo number_format(
                                $grand_total,
                                2
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo !empty($row->rfq_created_by)
                                ? htmlspecialchars(
                                    $row->rfq_created_by
                                )
                                : '-';
                            ?>
                        </td>
                    </tr>
                <?php } ?>

                <!-- TOTAL -->
                <tr class="total-row">
                    <td colspan="5"
                        class="right">
                        Total
                    </td>

                    <td class="right">
                        <?php
                        echo number_format(
                            $total_grand,
                            2
                        );
                        ?>
                    </td>

                    <td>
                    </td>
                </tr>


            <?php } else { ?>

                <tr>
                    <td colspan="7"
                        class="center">
                        No Purchase Orders
                        found for the selected
                        criteria.
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

    <!-- REPORT INFORMATION -->
    <table>
        <tr>
            <td colspan="3">
                <strong>
                    Prepared By:
                </strong>
                <?php
                echo $this->session
                    ->userdata('user_name');
                ?>
            </td>

            <td colspan="3"
                style="text-align:right;">
                <strong>
                    Exported On:
                </strong>
                <?php
                echo date('d-M-Y h:i A');
                ?>
            </td>
        </tr>
    </table>
</body>

</html>