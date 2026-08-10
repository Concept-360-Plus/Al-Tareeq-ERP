<div class="x_panel">

    <div class="x_content">

        <table class="table table-bordered">

            <tr>
                <th width="20%">Transfer No</th>
                <td><?= $master->transfer_code; ?></td>

                <th width="20%">Transfer Date</th>
                <td><?= date('d-m-Y', strtotime($master->transfer_date)); ?></td>
            </tr>

            <tr>
                <th>From Branch</th>
                <td><?= $master->from_branch; ?></td>

                <th>To Branch</th>
                <td><?= $master->to_branch; ?></td>
            </tr>

            <tr>
                <th>From Warehouse</th>
                <td><?= $master->from_warehouse; ?></td>

                <th>To Warehouse</th>
                <td><?= $master->to_warehouse; ?></td>
            </tr>

            <tr>
                <th>From Store</th>
                <td><?= $master->from_store; ?></td>

                <th>To Store</th>
                <td><?= $master->to_store; ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td><?= $master->status; ?></td>

                <th>Created By</th>
                <td><?= $master->user_name; ?></td>
            </tr>

            <tr>
                <th>Remarks</th>
                <td colspan="3">
                    <?= $master->remarks; ?>
                </td>
            </tr>
        </table>

        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">Sl. No</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th width="15%">Transfer Qty</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $i = 1;
                    foreach ($items as $row) {
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>
                            <?= $row->product_code; ?>
                            -
                            <?= $row->product_name; ?>
                        </td>
                        <td><?= $row->unit_name; ?></td>
                        <td><?= $row->transfer_qty; ?></td>
                        <td><?= $row->remarks; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>