<?php foreach ($items as $row) {
    $balance = $row->available_qty;
    if ($balance <= 0)
        continue;

?>

    <tr>
        <td>
            <?= $row->product_code ?>
            -
            <?= $row->product_name ?>
        </td>

        <td align="center">
            <?= $row->rec_quantity ?>
        </td>

        <td align="center">
            <?= $row->returned_qty ?>
        </td>

        <td align="center">
            <b><?= $balance ?></b>
        </td>

        <td>
            <input
                type="number"
                name="return_qty[]"
                class="form-control return_qty"
                value="0"
                min="0"
                max="<?= $balance ?>">

            <input
                type="hidden"
                name="grn_transaction_id[]"
                value="<?= $row->trans_id ?>">

            <input
                type="hidden"
                name="product_id[]"
                value="<?= $row->product_id ?>">
        </td>
    </tr>

<?php } ?>