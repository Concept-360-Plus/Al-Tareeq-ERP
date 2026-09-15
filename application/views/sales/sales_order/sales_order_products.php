<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Amount</th>
            <th>Discount amount</th>
            <th>Taxable amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($qtn_products)): ?>
            <?php foreach ($qtn_products as $i => $item):
                $qty        = isset($item['available_qty']) ? $item['available_qty'] : 0;
                $unit_price = isset($item['unit_price']) ? $item['unit_price'] : 0;
                $discount   = isset($item['discount_amount']) ? $item['discount_amount'] : 0; // sales_quotation_items has no per-line discount, defaults 0
                $amount     = $qty * $unit_price;
                $taxable    = $amount - $discount;
            ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?= $item['item_name'] ?><br>
                        <?= $item['prd_description'] ?>
                        <input type="hidden" name="product_id[]" value="<?= $item['prd_id'] ?>">
                        <input type="hidden" name="product_desc[]" value="<?= $item['prd_description'] ?>">
                        <!-- traceability back to the quotation line this SO row came from -->
                        <input type="hidden" name="qtn_qty[]" value="<?= $qty ?>">
                        <input type="hidden" name="qtn_discount[]" value="<?= $discount ?>">
                    </td>
                    <td>
                        <?= $item['unit_name'] ?>
                        <input type="hidden" name="unit_id[]" value="<?= $item['unit_id'] ?>">
                    </td>
                    <td>
                        <input type="text" name="so_qty[]" value="<?= $qty ?>" data-maxqty="<?= $qty ?>" class="form-control so_qty">
                    </td>
                    <td>
                        <input type="text" name="so_unitp[]" value="<?= $unit_price ?>" class="form-control so_unitp" readonly>
                    </td>
                    <td>
                        <input type="text" name="so_amount[]" value="<?= number_format($amount, 2) ?>" class="form-control so_amount" readonly>
                    </td>
                    <td>
                        <input type="text" name="so_discount[]" value="<?= number_format($discount, 2) ?>" class="form-control so_discount" readonly>
                    </td>
                    <td>
                        <input type="text" name="so_taxable[]" value="<?= number_format($taxable, 2) ?>" class="form-control so_taxable" readonly>
                    </td>
                    <td>
                        <button type="button"
                                class="btn btn-primary btn-sm editItemTypeBtn"
                                data-product-id="<?= $item['prd_id'] ?>">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>