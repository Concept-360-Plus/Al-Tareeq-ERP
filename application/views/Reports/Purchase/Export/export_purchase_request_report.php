<table border="1">

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

                    <td>
                        <?php echo $i++; ?>
                    </td>

                    <td>
                        <?php echo $row->pr_code; ?>
                    </td>

                    <td>
                        <?php
                        echo date(
                            'd-M-Y',
                            strtotime($row->pr_date)
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo !empty($row->branch_name)
                            ? $row->branch_name
                            : '-';
                        ?>
                    </td>

                    <td>
                        <?php
                        if (!empty($row->supplier_name)) {

                            echo !empty($row->supplier_code)
                                ? $row->supplier_code . ' ' . $row->supplier_name
                                : $row->supplier_name;
                        } else {

                            echo '-';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        echo !empty($row->mi_code)
                            ? $row->mi_code
                            : '-';
                        ?>
                    </td>

                    <td>
                        <?php
                        echo !empty($row->project)
                            ? $row->project
                            : '-';
                        ?>
                    </td>

                    <td>
                        <?php
                        if (!empty($row->created_by_name)) {

                            echo !empty($row->created_by_code)
                                ? $row->created_by_code . ' ' . $row->created_by_name
                                : $row->created_by_name;
                        } else {

                            echo '-';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        echo !empty($row->subject)
                            ? $row->subject
                            : '-';
                        ?>
                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="9">
                    No records found.
                </td>
            </tr>

        <?php } ?>

    </tbody>


    <tfoot>

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

    </tfoot>

</table>