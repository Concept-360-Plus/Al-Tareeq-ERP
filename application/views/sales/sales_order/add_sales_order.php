<style>
    label,
    h4 {
        color: black;
        font-weight: bold;
    }
</style>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                    <form action="<?= base_url() ?>index.php/Sales/save_sales_order" method="post" id="soForm">
                    <!-- <input type="hidden" name="quotation_id" id="quotation_id" value=""> -->
                    <input type="hidden" name="enquiry_id" id="enquiry_id" value="">
                    <input type="hidden" name="estimation_id" id="estimation_id" value="">
                    <input type="hidden" id="so_sales_rep_max_discount" value="">

                    <table class="table table-bordered" style="width:100%; border-collapse:collapse; font-size:13px; margin-bottom:20px;">
                        <tr>
                            <th colspan="2">Quotation</th>
                            <td colspan="2">
                                <select class="form-control select2" name="quotation_id" id="quotation_id">
    <option value="">Select Quotation</option>
    <?php foreach ($approved_quotations as $approved_quotation) { ?>
        <option value="<?= $approved_quotation['qtn_id'] ?>"
            <?= isset($selected_quotation) && $selected_quotation == $approved_quotation['qtn_id'] ? 'selected' : '' ?>>
            <?= $approved_quotation['quotation_code'] . '/Rev-' . $approved_quotation['quotation_revision']; ?>
        </option>
    <?php } ?>
</select>
                            </td>
                        </tr>
                        <tr>
                            <th>Sales Order Date</th>
                            <td><input type="date" name="so_date" class="form-control" value="<?= date('Y-m-d') ?>"></td>
                            <th>Sales Order No</th>
                            <td><input type="text" name="so_code" class="form-control" value="<?= $so_code ?>" readonly></td>
                        </tr>

                        <tr>
                            <th>Branch</th>
                            <td><input type="text" name="branch_name" id="branch_name" class="form-control" value="" readonly></td>
                            <th>Prepared By</th>
                            <td><input type="text" name="prepared_by" id="prepared_by" class="form-control" value="" readonly></td>
                        </tr>
                        <tr>
                            <th>Project Name</th>
                            <td><input type="text" name="project_name" id="project_name" class="form-control" value="" readonly></td>
                            <th>Customer</th>
                            <td><input type="text" name="customer_name" id="customer_name" class="form-control" value="" readonly></td>
                        </tr>
                    </table>

                    <hr>

                    <!-- Product List -->
                    <div class="row mb-2">
                        <div class="col-12 text-right">
                            <!-- <button type="button"
                                    class="btn btn-primary btn-xs openQuickAddItemBtn"
                                    title="Create New Item">
                                <i class="fa fa-plus"></i> New Item
                            </button> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive_sales_order  quotation_product_table"></div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td><input type="text" name="so_subtotal" id="so_subtotal" value="" class="form-control so_subtotal" readonly></td>
                                </tr>
                                <tr>
                                    <th>Discount (%)</th>
                                    <td>
                                        <input type="text" name="so_add_discount_percentage" id="so_add_discount_percentage" value="" class="form-control" style="width:100px; display:inline-block;">
                                        <input type="text" name="so_add_discount_amount" id="so_add_discount_amount" value="" class="form-control so_discount_amount mt-2" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Before VAT</th>
                                    <td><input type="text" name="so_totalbefore_vat_amount" id="so_totalbefore_vat_amount" value="" class="form-control so_totalbefore_vat_amount" readonly></td>
                                </tr>
                                <tr>
                                    <th>VAT (%)</th>
                                    <td>
                                        <input type="text" name="so_vat_percentage" id="so_vat_percentage" value="" class="form-control so_vat_percentage" readonly style="width:100px; display:inline-block;">
                                        <input type="text" name="so_vat_amount" id="so_vat_amount" value="" class="form-control so_vat_amount mt-2" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Grand Total:</th>
                                    <td><input type="text" name="so_grand_total" id="so_grand_total" value="" class="form-control so_grand_total" readonly></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table class="table" style="width:100%; border-collapse:collapse; font-size:13px;">
                        <thead>
                            <tr>
                                <th colspan="2"> <!-- Address Section -->
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="copyAddress" class="flat">
                                            Shipping address is same as Billing address
                                        </label>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th style="width:50%;">Billing Address</th>
                                <th style="width:50%;">Shipping Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- Billing -->
                                <td>
                                    <div class="form-group"><label>Name</label><input type="text" id="billing_name" name="billing_name" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Address</label><input type="text" id="billing_address" name="billing_address" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Emirate</label><input type="text" id="billing_city" name="billing_city" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Phone</label><input type="text" id="billing_phone" name="billing_phone" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Email</label><input type="text" id="billing_email" name="billing_email" value="" class="form-control" /></div>
                                </td>

                                <!-- Shipping -->
                                <td>
                                    <div class="form-group"><label>Name</label><input type="text" id="shipping_name" name="shipping_name" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Address</label><input type="text" id="shipping_address" name="shipping_address" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Emirate</label><input type="text" id="shipping_city" name="shipping_city" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Phone</label><input type="text" id="shipping_phone" name="shipping_phone" value="" class="form-control" /></div>
                                    <div class="form-group"><label>Email</label><input type="text" id="shipping_email" name="shipping_email" value="" class="form-control" /></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Terms & Remarks Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Terms & Conditions</h5>
                            <table class="table table-bordered" style="width:100%; border-collapse:collapse; font-size:13px;">
                                <tbody>
                                    <tr>
                                        <th>Payment Term</th>
                                        <td><input type="text" name="so_payment_term" id="so_payment_term" class="form-control" value=""></td>
                                    </tr>
                                    <tr>
                                        <th>Validity</th>
                                        <td><input type="text" name="so_validity" id="so_validity" class="form-control" value=""></td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Term</th>
                                        <td><textarea name="so_delivery_term" id="so_delivery_term" class="form-control" rows="3"></textarea></td>
                                    </tr>
                                    <tr>
                                        <th>General Terms & Conditions</th>
                                        <td><textarea name="so_terms_condition" id="so_terms_condition" class="form-control" rows="4"></textarea></td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td><textarea name="so_remarks" rows="2" class="form-control"></textarea></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row justify-content-center mt-3">
                                <button type="submit" class="btn btn-success" name="action" value="save">Save Sales Order</button>
                                <!-- <button type="submit" class="btn btn-primary ml-2" name="action" value="delivery_challan">Save & Create Delivery Challan</button> -->
                                
                            </div>

                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('includes/items/item_popups'); ?>

<!-- Action Buttons -->
<script>
    var baseUrl = "<?php echo base_url(); ?>";

    function recalculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTaxable = 0;

        $(".quotation_product_table table tbody tr").each(function() {
            let qty = parseFloat($(this).find(".so_qty").val()) || 0;
            let unitp = parseFloat($(this).find(".so_unitp").val()) || 0;
            let discount = parseFloat($(this).find(".so_discount").val()) || 0;
            // Recalculate row amounts
            let amount = qty * unitp;
            $(this).find(".so_amount").val(amount.toFixed(2));
            // Taxable amount = amount - discount
            let taxable = amount - discount;

            $(this).find(".so_taxable").val(taxable.toFixed(2));

            subtotal += taxable;
            totalDiscount += discount;
            totalTaxable += taxable;
        });


        // Update subtotal
        $(".so_subtotal").val(subtotal.toFixed(2));

        // Discount
        let discountPercentage = parseFloat($("input[name='so_add_discount_percentage']").val()) || 0;
        let discountAmount = subtotal * (discountPercentage / 100);
        let totalbforevat = subtotal - discountAmount;

        $(".so_discount_amount").val(discountAmount.toFixed(2));
        $(".so_totalbefore_vat_amount").val(totalbforevat.toFixed(2));
        // VAT
        let vatAmount = 0;
        let vatPercentage = parseFloat($(".so_vat_percentage").val()) || 0;
        if (vatPercentage > 0) {
            vatAmount = (totalbforevat) * (vatPercentage / 100);
        }
        $(".so_vat_amount").val(vatAmount.toFixed(2));

        // Grand total
        let grandTotal = subtotal - discountAmount + vatAmount;
        $(".so_grand_total").val(grandTotal.toFixed(2));
    }

        // Discount % edited directly on the sales order — recalc, then enforce the linked quotation's sales rep max discount
    $(document).on("input change", "#so_add_discount_percentage", function() {
        recalculateTotals();
        validateDiscountAgainstSalesPerson();
    });

    function validateDiscountAgainstSalesPerson() {

        var maxDiscount = parseFloat($('#so_sales_rep_max_discount').val());

        if (isNaN(maxDiscount)) {
            return true;
        }

        var currentPercent = parseFloat($('#so_add_discount_percentage').val()) || 0;

        if (currentPercent > maxDiscount) {

            alert('Discount of ' + currentPercent.toFixed(2) + '% exceeds the maximum allowed (' + maxDiscount.toFixed(2) + '%) for this quotation\'s Sales Person. It has been reset to the maximum allowed.');

            $('#so_add_discount_percentage').val(maxDiscount.toFixed(2));

            recalculateTotals();

            return false;
        }

        return true;
    }

        // Newly created item from the quick-add popup — append it as a sales order line
    $(document).on('itemQuickAdded', function(e, item) {

        let existingRow = $('.quotation_product_table')
            .find('input[name="product_id[]"][value="' + item.product_id + '"]')
            .closest('tr');

        if (existingRow.length > 0) {
            return;
        }

        let price = parseFloat(item.retail_price) || 0;
        let qty = 1;
        let amount = qty * price;
        let rowCount = $('.quotation_product_table tbody tr').length + 1;

        $('.quotation_product_table tbody').append(`

        <tr>
            <td>${rowCount}</td>
            <td>
                ${item.product_name}<br>
                ${item.description ? item.description : ''}
                <input type="hidden" name="product_id[]" value="${item.product_id}">
                <input type="hidden" name="product_desc[]" value="${item.description ? item.description : ''}">
                <input type="hidden" name="qtn_qty[]" value="0">
                <input type="hidden" name="qtn_discount[]" value="0">
            </td>
            <td>
                ${item.unit_name ? item.unit_name : ''}
                <input type="hidden" name="unit_id[]" value="${item.unit_id ? item.unit_id : ''}">
            </td>
            <td>
                <input type="text" name="so_qty[]" value="${qty}" data-maxqty="${item.available_qty ? item.available_qty : qty}" class="form-control so_qty">
            </td>
            <td>
                <input type="text" name="so_unitp[]" value="${price.toFixed(2)}" class="form-control so_unitp" readonly>
            </td>
            <td>
                <input type="text" name="so_amount[]" value="${amount.toFixed(2)}" class="form-control so_amount" readonly>
            </td>
            <td>
                <input type="text" name="so_discount[]" value="0.00" class="form-control so_discount">
            </td>
            <td>
                <input type="text" name="so_taxable[]" value="${amount.toFixed(2)}" class="form-control so_taxable" readonly>
            </td>
            <td>
                <button type="button"
                        class="btn btn-primary btn-sm editItemTypeBtn"
                        data-product-id="${item.product_id}">
                    <i class="fa fa-edit"></i>
                </button>

                <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>

        `);

        recalculateTotals();
    });

    // Quantity or unit price change
    $(document).on("input", ".so_qty, .so_unitp,.so_discount", function() {
        let row = $(this).closest("tr");
        let qtyField = row.find(".so_qty");
        let maxQty = parseFloat(qtyField.data("maxqty")) || 0;
        let qty = parseFloat(qtyField.val()) || 0;

        if (qty > maxQty) {
            alert("Entered quantity cannot exceed available qty (" + maxQty + ")");
            qtyField.val(maxQty);
        }

        recalculateTotals();
    });

    // Delete row and recalc
    function deleteRow(btn) {
        if (confirm("Are you sure you want to remove this product from the list?")) {
            $(btn).closest("tr").remove();
            recalculateTotals();
        }
    }

    // Initial calculation on page load

    // Attach event listener to quantity and unit price fields
    document.addEventListener("input", function(e) {
        if (e.target.classList.contains("so_qty") || e.target.classList.contains("so_unitp")) {
            let row = e.target.closest("tr");

            let qty = parseFloat(row.querySelector(".so_qty").value) || 0;
            let qtyField = row.querySelector(".so_qty");
            let maxQty = parseFloat(qtyField.dataset.maxqty) || 0;
            let unitp = parseFloat(row.querySelector(".so_unitp").value) || 0;
            let amountField = row.querySelector(".so_amount");

            if (qty > maxQty) {
                alert("Entered quantity cannot exceed available qty (" + maxQty + ")");
                qty = maxQty;
                qtyField.value = maxQty; // reset to max
            }

            let amount = qty * unitp;
            amountField.value = amount.toFixed(2);
        }
    });

        $(document).ready(function() {
        recalculateTotals();
        $('#quotation_id').select2({
    placeholder: "Select Quotation",
    allowClear: true,
    width: '100%'
});
    });

    $('#soForm').on('submit', function(e) {
        if (!validateDiscountAgainstSalesPerson()) {
            e.preventDefault();
        }
    });

    $(document).ready(function() {
        // $("form").on("submit", function() {
        //     $("#so_delivery_term").val($("#delivery-editor").html());
        //     $("#so_terms_condition").val($("#terms-editor").html());
        // });

        $('#copyAddress').on('ifChecked', function() {
            $("#shipping_name").val($("#billing_name").val());
            $("#shipping_address").val($("#billing_address").val());
            $("#shipping_city").val($("#billing_city").val());
            $("#shipping_phone").val($("#billing_phone").val());
            $("#shipping_email").val($("#billing_email").val());
        });

        $('#copyAddress').on('ifUnchecked', function() {
            $("#shipping_name, #shipping_address, #shipping_city, #shipping_phone, #shipping_email").val('');

        });
    });



function loadQuotationDetails(qtn_id) {
    console.log('loadQuotationDetails called with:', qtn_id, typeof qtn_id);

    if (qtn_id === null || qtn_id === undefined || qtn_id === '' || qtn_id === '0' || (Array.isArray(qtn_id) && qtn_id.length === 0)) {
        $(".quotation_product_table").html('');
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/Sales/get_quotation_details') ?>",
        type: "POST",
        data: { qtn_id: qtn_id },
        dataType: "json",
        beforeSend: function() {
            $(".quotation_product_table").html('<p>Loading...</p>');
        },
        success: function(res) {
            if (res.status) {
                var q = res.quotation;

                // Header fields
                $("#enquiry_id").val(q.enquiry_id);
                $("#estimation_id").val(q.estimation_id);
                $("#branch_name").val(q.branch_name);
                $("#prepared_by").val(q.prepared_by);
                $("#project_name").val(q.project_name);
                $("#customer_name").val(q.customer_name);

                // Totals — discount % carried over from the quotation, still editable here
                $("#so_subtotal").val(q.sub_total);
                $("#so_add_discount_percentage").val(q.discount_percentage);
                $("#so_add_discount_amount").val(q.discount_amount);
                $("#so_totalbefore_vat_amount").val(q.total_before_vat);
                $("#so_vat_percentage").val(q.vat_percentage);
                $("#so_vat_amount").val(q.vat_amount);
                $("#so_grand_total").val(q.grand_total);

                // Sales rep's max discount %, used to re-validate any edit made here
                $("#so_sales_rep_max_discount").val(q.sales_rep_max_discount);

                // Billing info
                $("#billing_name").val(q.customer_name);
                $("#billing_address").val(q.customer_address);
                $("#billing_city").val(q.emirate);
                $("#billing_phone").val(q.contact_number);
                $("#billing_email").val(q.customer_email);

                // Terms & Conditions
                $("#so_payment_term").val(q.payment_term);
                $("#so_validity").val(q.validity);
                $("#so_delivery_term").val(q.delivery_term);
                $("#so_terms_condition").val(q.terms_condition);

                // Product table
                $(".quotation_product_table").html(res.table_html);

                // Recalculate totals after table is loaded
                recalculateTotals();
                validateDiscountAgainstSalesPerson();
            } else {
                alert(res.message || "No data found.");
            }
        },
        error: function() {
            alert("Error loading quotation data.");
        }
    });
}

$(document).ready(function() {
    var selectedQuotation = <?= json_encode(isset($selected_quotation) ? $selected_quotation : ''); ?>;

    if (selectedQuotation) {
        $('#quotation_id').val(selectedQuotation).trigger('change.select2'); 
        loadQuotationDetails(selectedQuotation);   
    }

        // Handle manual dropdown change
    $('#quotation_id').on('change', function() {
        var qtn_id = $(this).val();
        if (qtn_id) {
            loadQuotationDetails(qtn_id);
        } else {
            $(".quotation_product_table").html('');
        }
    });
});
</script>

<?php $this->load->view('includes/items/item_popups'); ?>