<form method="post"
    action="<?= base_url('index.php/Purchase/save_purchase_return'); ?>">

    <input type="hidden" name="grn_id"
        value="<?= $grn_master[0]->grn_id ?>">

    <input type="hidden" name="supplier_id"
        value="<?= $grn_master[0]->supplier_id ?>">

    <input type="hidden" name="warehouse_id"
        value="<?= $grn_master[0]->warehouse_id ?>">

    <input type="hidden" name="store_id"
        value="<?= $grn_master[0]->store_id ?>">

    <input type="hidden" name="return_date"
        value="<?= date('Y-m-d'); ?>">

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
                        <input type="number" class="form-control" name="return_qty[]" max="<?= $row->rec_quantity - $row->returned_qty ?>"
                            min="0">

                        <input type="hidden" name="grn_transaction_id[]" value="<?= $row->trans_id ?>">

                        <input type="hidden" name="product_id[]" value="<?= $row->product_id ?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="text-center">
        <button class="btn btn-danger">
            Return Items
        </button>
    </div>

</form>