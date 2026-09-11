<?php if (isset($estimation)): $i = 0; ?>
    <?php foreach ($estimation as $main): ?>
        <div id="main_heading_block_<?= $i ?>" class="border p-2 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div style="width: 40%;">
                    <label>Main Heading</label>
                    <input type="text"
                        name="main_heading[<?= $i ?>]"
                        value="<?= $main['main_heading'] ?>"
                        class="estimation_edit form-control"
                        placeholder="Enter Main Heading">
                </div>

                <div style="width: 45%;">
                    <label>Details</label>
                    <textarea name="main_details[<?= $i ?>]"
                        class="estimation_edit form-control"
                        placeholder="Enter Details"><?= $main['main_details'] ?></textarea>
                </div>
            </div>
        </div>

        <?php $j = 0;
        foreach ($main['sub_headings'] as $sub): ?>
            <div class="border p-2 mb-2 subHeadingContainer" data-main="<?= $i ?>" data-sub="<?= $j ?>">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text"
                        name="sub_heading[<?= $i ?>][<?= $j ?>]"
                        value="<?= $sub['sub_heading'] ?>"
                        class="form-control form-control-sm w-75"
                        placeholder="Enter Sub Heading">
                </div>

                <table class="table table-bordered qtn_productTable mb-0" cellspacing="0" width="100%">
                    <thead>
                        <tr style="background-color:#f8f9fa;">
                            <th style="width:220px;">Product</th>
                            <th style="width:100px;">Unit</th>
                            <th style="width:100px;">Qty</th>
                            <th style="width:120px;">Unit Price</th>
                            <th style="width:120px;">Amount</th>
                            <th style="width:60px;">Discount</th>
                            <!-- <th style="width:120px;">Warranty</th> -->
                            <th style="width:110px;">VAT</th>
                            <th style="width:60px;">Taxable Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $k = 0;
                        foreach ($sub['products'] as $prod): ?>
                            <tr>
                                <td>
                                    <select name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][product_id]"
                                        class="form-control form-control-sm estimation_edit select2 qtn_product_select">
                                        <option value="">-- Select Product --</option>
                                        <?php foreach ($all_products as $p): ?>
                                            <option value="<?= $p->item_id ?>"
                                                data-tax-applicable="<?= isset($p->tax_applicable) ? $p->tax_applicable : 0 ?>"
                                                <?= ($p->item_id == $prod['product_id']) ? 'selected' : '' ?>>
                                                <?= $p->item_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br><br>
                                    <textarea 
    id="product_desc_<?= $i ?>_<?= $j ?>_<?= $k ?>"
    name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][product_description]"
    class="form-control product_editor" rows="3"><?= $prod['product_description'] ?></textarea>
                                </td>

                                <td>
                                    <select name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][unit]"
                                        class="form-control estimation_edit">
                                        <option value="">-- Select Unit --</option>
                                        <?php foreach ($active_units as $unit): ?>
                                            <option value="<?= $unit->unit_id ?>"
                                                <?= ($prod['unit_id'] == $unit->unit_id) ? 'selected' : '' ?>>
                                                <?= $unit->unit_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td>
                                    <input type="number"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][quantity]"
                                        value="<?= $prod['quantity'] ?>"
                                        class="form-control quotation_edit qtn_qty"
                                        readonly>
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][unit_price]"
                                        value="<?= $prod['unit_price'] ?>"
                                        class="form-control quotation_edit qtn_unitPrice"
                                        readonly>
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][amount]"
                                        value="<?= $prod['amount'] ?>"
                                        class="form-control quotation_edit qtn_amount"
                                        readonly>
                                </td>

                                <td style="min-width:130px;">
                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][discount_percentage]"
                                        value="<?= isset($prod['discount_percentage']) ? $prod['discount_percentage'] : '' ?>"
                                        class="form-control form-control-sm quotation_edit qtn_discount_percentage"
                                        placeholder="%">

                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][discount_amount]"
                                        value="<?= isset($prod['discount_amount']) ? $prod['discount_amount'] : '' ?>"
                                        class="form-control form-control-sm mt-1 quotation_edit qtn_discount_amount"
                                        placeholder="Amount">
                                </td>
<!-- <td>
    <input type="text"
        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][warranty]"
        value="<?= isset($prod['warranty']) ? $prod['warranty'] : '' ?>"
        class="form-control quotation_edit">
</td> -->

                                <?php $is_taxable = isset($prod['tax_applicable']) ? $prod['tax_applicable'] : 0; ?>
                                <td style="min-width:110px;">
                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][vat_percentage]"
                                        value="<?= isset($prod['vat_percentage']) ? $prod['vat_percentage'] : '' ?>"
                                        class="form-control form-control-sm quotation_edit qtn_item_vat_percent"
                                        placeholder="VAT %"
                                        <?= $is_taxable ? '' : 'disabled' ?>>

                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][vat_amount]"
                                        value="<?= isset($prod['vat_amount']) ? $prod['vat_amount'] : '' ?>"
                                        class="form-control form-control-sm mt-1 quotation_edit qtn_item_vat_amount"
                                        placeholder="VAT Amt"
                                        readonly>
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="products[<?= $i ?>][<?= $j ?>][<?= $k ?>][taxable_amount]"
                                        value=""
                                        class="form-control quotation_edit qtn_taxable_amount"
                                        readonly>
                                </td>
                            </tr>
                        <?php $k++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php $j++;
        endforeach; ?>
    <?php $i++;
    endforeach; ?>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Toggle VAT % field based on the selected product's tax_applicable flag
    function toggleVatField($select) {
        const $row = $select.closest('tr');
        const $selectedOption = $select.find('option:selected');
        const isTaxable = $selectedOption.data('tax-applicable') == 1;

        const $vatPercent = $row.find('.qtn_item_vat_percent');
        const $vatAmount = $row.find('.qtn_item_vat_amount');

        if (isTaxable) {
            $vatPercent.prop('disabled', false);
        } else {
            $vatPercent.prop('disabled', true).val('');
            $vatAmount.val('0.00');
        }
    }

    // Run on initial load for all existing rows
    $('.qtn_product_select').each(function() {
        toggleVatField($(this));
    });

    // Run whenever the product is changed/selected (works with select2 too)
    $(document).on('change', '.qtn_product_select', function() {
        toggleVatField($(this));
    });

});
</script>