<!DOCTYPE html>
<html>

<head>

    <title>Purchase Request Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .report-date {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
        }

        table th {
            background: #f2f2f2;
        }

        @media print {

            .no-print {
                display: none;
            }

        }
    </style>

</head>


<body>

    <div class="no-print"
        style="text-align:right;margin-bottom:10px;">

        <button onclick="window.print()">
            Print
        </button>

    </div>


    <h2>Purchase Request Report</h2>


    <?php

    $from = isset($_GET['from_date'])
        ? $_GET['from_date']
        : '';

    $to = isset($_GET['to_date'])
        ? $_GET['to_date']
        : '';

    ?>


    <div class="report-date">

        Period:
        <?php echo $from; ?>

        to

        <?php echo $to; ?>

    </div>


    <table>

        <thead>

            <tr>

                <th>Sl No</th>
                <th>PR Code</th>
                <th>PR Date</th>
                <th>Branch</th>
                <th>Supplier</th>
                <th>Material Issue</th>
                <th>Project</th>
                <th>Created By</th>
                <th>Subject</th>

            </tr>

        </thead>


        <tbody>

            <?php if (!empty($records)) { ?>

                <?php $i = 1; ?>

                <?php foreach ($records as $row) { ?>

                    <tr>

                        <td><?php echo $i++; ?></td>

                        <td><?php echo $row->pr_code; ?></td>

                        <td>
                            <?php echo date(
                                'd-m-Y',
                                strtotime($row->pr_date)
                            ); ?>
                        </td>

                        <td>
                            <?php echo $row->branch_name ?: '-'; ?>
                        </td>

                        <td>
                            <?php echo $row->supplier_name ?: '-'; ?>
                        </td>

                        <td>
                            <?php echo $row->mi_code ?: '-'; ?>
                        </td>

                        <td>
                            <?php echo $row->project ?: '-'; ?>
                        </td>

                        <td>
                            <?php echo $row->created_by_name ?: '-'; ?>
                        </td>

                        <td>
                            <?php echo $row->subject ?: '-'; ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="9"
                        style="text-align:center;">

                        No records found.

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</body>

</html>