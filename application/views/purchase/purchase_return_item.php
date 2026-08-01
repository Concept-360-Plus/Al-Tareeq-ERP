<table class="table table-bordered">

    <thead>

        <tr>

            <th>Product</th>

            <th>Received Qty</th>

            <th>Already Returned</th>

            <th>Balance</th>

            <th>Return Qty</th>

        </tr>

    </thead>

    <tbody>

        <?php foreach ($items as $row) { ?>

            <tr>

                <td>

                    <?= $row->product_code ?>

                    -

                    <?= $row->product_name ?>

                </td>

                <td><?= $row->rec_quantity ?></td>

                <td><?= $row->returned_qty ?></td>

                <td>

                    <?= $row->rec_quantity - $row->returned_qty ?>

                </td>

                <td>

                    <input

                        type="number"

                        class="form-control"

                        name="return_qty[]"

                        max="<?= $row->rec_quantity - $row->returned_qty ?>"

                        min="0">

                    <input

                        type="hidden"

                        name="grn_transaction_id[]"

                        value="<?= $row->grn_transaction_id ?>">

                    <input

                        type="hidden"

                        name="product_id[]"

                        value="<?= $row->product_id ?>">

                </td>

            </tr>

        <?php } ?>

    </tbody>

</table>