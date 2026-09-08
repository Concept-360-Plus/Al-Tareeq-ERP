<html>

<head>
    <title>Request For Quotation Report</title>

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
            max-height:220px;
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

    <div class="header">

        <img src="<?= base_url('public/assets/images/altariq_logo.jpeg'); ?>" class="company-logo" alt="Company Logo">

        <div class="report-title">
            REQUEST FOR QUOTATION REPORT
        </div>

        <div class="report-subtitle">
            From <strong><?= date('d-M-Y', strtotime($_GET['from_date'])); ?></strong>
            To
            <strong><?= date('d-M-Y', strtotime($_GET['to_date'])); ?></strong>
        </div>

    </div>
    <table width=100% style='border: 0'>

        <tbody id="table-body">
            <tr class='calc' height=5px style="background-color: #525453;">
                <td></td>
            </tr>
            <table class="info-table">
                <tr>
                    <td width="50%">
                        <strong>Prepared By :</strong>
                        <?= $this->session->userdata('user_name'); ?>
                    </td>

                    <td align="right">
                        <strong>Printed On :</strong>
                        <?= date('d-M-Y h:i A'); ?>
                    </td>
                </tr>
            </table>
            <tr>
                <td>
                    <table class="report-table">

                        <thead>
                            <tr>
                                <th width="5%">Sl No</th>
                                <th width="20%">RFQ Code</th>
                                <th width="20%">RFQ Date</th>
                                <th width="40%">Supplier</th>
                                <th width="15%">Created By</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $sl = 1;
                            foreach ($records as $row) { ?>

                                <tr>
                                    <td align="center"><?= $sl++; ?></td>
                                    <td><?= $row->rfq_code; ?></td>
                                    <td><?= date('d-M-Y', strtotime($row->rfq_date)); ?></td>
                                    <td><?= $row->supplier_name; ?></td>
                                    <td><?= $row->rfq_created_by; ?></td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </td>
            </tr>





        </tbody>
        <tfoot class='footer'>

        </tfoot>
    </table>
</body>

<div class="footer">

    <div class="footer-left">
        &copy; <?= date('Y'); ?>
        Al Tareeq Kitchen Equipment Industry LLC
    </div>

    <div class="footer-right">
        Designed & Developed by Concepts 360 Plus
    </div>

</div>

</html>