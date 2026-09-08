<!DOCTYPE html>
<html>

<head>

    <title>Purchase Order Report</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 10px;
            color: #000;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #444;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .header img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
        }

        .report-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #070707;
            margin-top: 10px;
        }

        .report-subtitle {
            text-align: center;
            font-size: 13px;
            margin: 8px 0 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px;
            border: none;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.report-table th,
        table.report-table td {
            border: 1px solid #000;
            padding: 8px;
        }

        table.report-table th {
            background: #efefef;
            text-align: center;
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

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #555;
            padding: 8px 15px;
            font-size: 11px;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        @media print {

            .footer {
                position: fixed;
                bottom: 0;
            }

        }
    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================== -->

    <div class="header">

        <img
            src="<?= base_url('public/assets/images/altariq_logo.jpeg'); ?>"
            class="company-logo"
            alt="Company Logo">


        <div class="report-title">

            PURCHASE ORDER REPORT

        </div>


        <div class="report-subtitle">

            From

            <strong>
                <?= !empty($from)
                    ? date('d-M-Y', strtotime($from))
                    : '-'; ?>
            </strong>

            &nbsp;

            To

            <strong>
                <?= !empty($to)
                    ? date('d-M-Y', strtotime($to))
                    : '-'; ?>
            </strong>

        </div>

    </div>


    <!-- =========================
         SEPARATOR
    ========================== -->

    <table width="100%" style="border:0;">

        <tbody>

            <tr
                height="5px"
                style="background-color:#525453;">

                <td style="border:0;"></td>

            </tr>

        </tbody>

    </table>


    <!-- =========================
         REPORT INFORMATION
    ========================== -->

    <table class="info-table">

        <tr>

            <td width="50%">

                <strong>
                    Prepared By :
                </strong>

                <?= $this->session->userdata('user_name'); ?>

            </td>


            <td align="right">

                <strong>
                    Printed On :
                </strong>

                <?= date('d-M-Y h:i A'); ?>

            </td>

        </tr>

    </table>


    <!-- =========================
         REPORT TABLE
    ========================== -->

    <table class="report-table">

        <thead>

            <tr>

                <th width="5%">
                    Sl No
                </th>

                <th width="17%">
                    PO Code
                </th>

                <th width="12%">
                    PO Type
                </th>

                <th width="13%">
                    PO Date
                </th>

                <th width="22%">
                    Supplier
                </th>

                <th width="12%">
                    Grand Total
                </th>

                <th width="10%">
                    Status
                </th>

                <th width="12%">
                    Created By
                </th>

            </tr>

        </thead>


        <tbody>

            <?php
            $sl = 1;
            $total_grand = 0;
            ?>

            <?php if (!empty($records)) { ?>

                <?php foreach ($records as $row) { ?>

                    <?php

                    $grand_total = (float) $row->grand_total;
                    $total_grand += $grand_total;

                    $status =
                        isset($row->report_status)
                        ? $row->report_status
                        : 'Pending';
                    ?>


                    <tr>
                        <!-- Sl No -->
                        <td class="center">
                            <?= $sl++; ?>
                        </td>

                        <!-- PO Code -->
                        <td>
                            <?= htmlspecialchars(
                                $row->po_code
                            ); ?>
                        </td>

                        <!-- PO Type -->
                        <td class="center">
                            <?php
                            if (
                                $row->po_type ==
                                'direct'
                            ) {
                                echo 'DIRECT';
                            } elseif (
                                $row->po_type ==
                                'quotation'
                            ) {
                                echo 'QUOTATION';
                            } else {
                                echo strtoupper(
                                    $row->po_type
                                );
                            }
                            ?>
                        </td>

                        <!-- PO Date -->
                        <td class="center">
                            <?= !empty($row->po_date)
                                ? date(
                                    'd-M-Y',
                                    strtotime(
                                        $row->po_date
                                    )
                                )
                                : '-';
                            ?>
                        </td>

                        <!-- Supplier -->
                        <td>
                            <?= !empty($row->supplier_name)
                                ? htmlspecialchars(
                                    $row->supplier_name
                                )
                                : '-';
                            ?>
                        </td>

                        <!-- Grand Total -->
                        <td class="right">
                            <?= number_format(
                                $grand_total,
                                2
                            ); ?>
                        </td>

                        <!-- Status -->
                        <td>
                            <?= !empty($row->report_status)
                                ? htmlspecialchars(
                                    $row->report_status
                                )
                                : 'Pending';
                            ?>
                        </td>

                        <!-- Created By -->
                        <td>
                            <?= !empty($row->rfq_created_by)
                                ? htmlspecialchars(
                                    $row->rfq_created_by
                                )
                                : '-';
                            ?>
                        </td>
                    </tr>

                <?php } ?>


                <!-- =========================
                     TOTAL
                ========================== -->

                <tr class="total-row">

                    <td
                        colspan="5"
                        class="right">

                        Total

                    </td>


                    <td class="right">

                        <?= number_format(
                            $total_grand,
                            2
                        ); ?>

                    </td>


                    <td colspan="2"></td>

                </tr>

            <?php } else { ?>

                <tr>
                    <td
                        colspan="8"
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

    <!-- =========================
         FOOTER
    ========================== -->

    <div class="footer">
        <div class="footer-left">
            &copy; <?= date('Y'); ?>
            Al Tareeq Kitchen Equipment Industry LLC
        </div>


        <div class="footer-right">
            Designed & Developed by
            Concepts 360 Plus
        </div>
    </div>

</body>

</html>