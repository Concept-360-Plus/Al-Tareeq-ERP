<html>

<head>

    <meta charset="UTF-8">

</head>

<body>

    <table border="1">

        <tr>
            <th colspan="5">
                REQUEST FOR QUOTATION REPORT
            </th>
        </tr>

        <tr>
            <td>
                <strong>From Date</strong>
            </td>

            <td>
                <?php
                echo !empty($from)
                    ? date('d-M-Y', strtotime($from))
                    : '-';
                ?>
            </td>

            <td>
                <strong>To Date</strong>
            </td>

            <td>
                <?php
                echo !empty($to)
                    ? date('d-M-Y', strtotime($to))
                    : '-';
                ?>
            </td>

            <td></td>
        </tr>

        <tr>
            <td colspan="5"></td>
        </tr>

        <tr>
            <th>Sl. No</th>
            <th>RFQ Code</th>
            <th>RFQ Date</th>
            <th>Supplier</th>
            <th>Created By</th>
        </tr>


        <?php if (!empty($records)) { ?>

            <?php $i = 1; ?>

            <?php foreach ($records as $row) { ?>

                <tr>
                    <td>
                        <?php echo $i++; ?>
                    </td>

                    <td>
                        <?php
                        echo $row->rfq_code;
                        ?>
                    </td>

                    <td>
                        <?php
                        echo date(
                            'd-M-Y',
                            strtotime($row->rfq_date)
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        if (!empty($row->supplier_code)) {
                            echo $row->supplier_code
                                . ' - '
                                . $row->supplier_name;
                        } else {
                            echo $row->supplier_name;
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        echo $row->rfq_created_by;
                        ?>
                    </td>

                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5">
                    No records found.
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>