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

                <form action="<?= base_url() ?>index.php/Sales/add_quotation_data" method="post" id="quotationForm">
                    <input type="hidden" name="estimation_id" id="estimation_id" value="">

                   

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Select Enquiry:</label>
                        <div class="col-sm-4">
                          <select name="enquiry_id" id="enquiry_id" class="form-control ">
    <option value="">Select Enquiry</option>

    <?php foreach($enquiry_list as $row){ ?>

    <option value="<?= $row->enquiry_id ?>"
        <?= (isset($enquiry_data['enquiry_id']) && $enquiry_data['enquiry_id'] == $row->enquiry_id) ? 'selected' : ''; ?>>
        
        <?= $row->enquiry_code ?> - <?= $row->project_name ?>

    </option>

    <?php } ?>

</select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Enquiry Code -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Enquiry Code:</label>
                                <div class="col-sm-8">
                                  <input type="text"
       id="enquiry_code"
       name="enquiry_code"
       value="<?= isset($enquiry_data['enquiry_code']) ? $enquiry_data['enquiry_code'] : ''; ?>"
       class="form-control"
       readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Enquiry Branch -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Enquiry Branch:</label>
                                <div class="col-sm-8">
                                  <input type="text"
       id="branch_name"
       name="branch_name"
       value="<?= isset($enquiry_data['branch_name']) ? $enquiry_data['branch_name'] : ''; ?>"
       class="form-control"
       readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Project Name -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Project Name:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="project_name" name="project_name"
                                        value="<?= isset($enquiry_data['project_name']) ? $enquiry_data['project_name'] : "" ?>"
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Name -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Customer:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="customer_name" name="customer_name"
                                        value="<?= isset($enquiry_data['customer_name']) ? $enquiry_data['customer_name'] : "" ?>"
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Quotation Code -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Quotation Code:</label>
                                <div class="col-sm-8">
                                    <input type="text"
       name="quotation_code"
       class="form-control"
       value="<?= $quotation_code ?>"
       readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Quotation Date -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Quotation Date:</label>
                                <div class="col-sm-8">
                                    <input type="date" id="quotation_date" name="quotation_date"
                                        value="<?= date('Y-m-d') ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Sales Person -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Sales Person:</label>
                                <div class="col-sm-8">
                                    <select name="sales_person" id="sales_person" class="form-control select2">
                                        <option value="">-- Select --</option>
                                        <?php if(!empty($sales_rep_list)) { foreach($sales_rep_list as $rep) { ?>
                                        <option value="<?= $rep->sales_rep_id ?>"
                                            data-discount="<?= $rep->sales_discount_percent ?>"
                                            <?= (isset($enquiry_data['sales_person']) && $enquiry_data['sales_person'] == $rep->sales_rep_id) ? 'selected' : '' ?>>
                                            <?= $rep->sales_rep_name ?>
                                        </option>
                                        <?php } } ?>
                                    </select>
                                    <small class="text-muted">Pre-filled from the selected enquiry — you can change it.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Currency -->
                        <div class="col-md-6">
                            <div class="form-group row align-items-center">
                                <label class="col-sm-4 col-form-label">Currency:</label>
                                <div class="col-sm-8">
                                    <select name="currency_id" id="currency_id" class="form-control select2">
                                        <option value="">-- Select --</option>
                                        <?php if(!empty($currency_list)) { foreach($currency_list as $cur) { ?>
                                        <option value="<?= $cur->currency_id ?>">
                                            <?= $cur->currency_name ?>
                                        </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                   <input type="hidden" 
       name="quotation_customer"
       id="quotation_customer"
       value="<?= isset($enquiry_data['enquiry_customer']) ? $enquiry_data['enquiry_customer'] : ''; ?>">

<input type="hidden" 
       name="quotation_branch_id" 
       id="quotation_branch_id"
       value="<?= isset($enquiry_data['branch_id']) ? $enquiry_data['branch_id'] : ''; ?>">
                    <input type="hidden" name="project_name_hidden" id="project_name_hidden">

                 

<table class="table table-bordered">
    <thead>
        <tr>
            <th width="100">Code</th>
            <th>Item</th>
            <th>Description</th>
            <th width="100">Qty</th>
            <th width="150">Price</th>
            <th width="150">Amount</th>
            <th width="120">
    <button type="button" 
            class="btn btn-success btn-xs"
            id="addNewItem">
        <i class="fa fa-plus"></i>
    </button>

    <button type="button"
            class="btn btn-primary btn-xs openQuickAddItemBtn"
            title="Create New Item">
        <i class="fa fa-plus"></i>
    </button>
</th>
        </tr>
    </thead>

    <tbody id="selectedCartItems">

    <?php if(!empty($cart_items)) { ?>

        <?php foreach($cart_items as $item) { ?>

        <tr>

            <td><?= isset($item->product_code) ? $item->product_code : '' ?></td>

            <td>
                <?= $item->product_name ?>

                <input type="hidden"
                       name="item_id[]"
                       value="<?= $item->product_id ?>">
            </td>

            <td>
                <textarea class="form-control form-control-sm"
                          name="description[]"
                          rows="1"><?= isset($item->description) ? $item->description : '' ?></textarea>
            </td>

            <td>
                <input type="number"
                       class="form-control form-control-sm cart_qty"
                       name="qty[]"
                       value="<?= $item->qty ?>"
                       style="width:70px">
            </td>

            <td>
                <input type="number"
                       class="form-control form-control-sm cart_price"
                       name="price[]"
                       value="<?= $item->price ?>"
                       step="0.01"
                       style="width:100px">
            </td>

            <td>

                <span class="amount_display">
                    <?= number_format($item->amount,2) ?>
                </span>

                <input type="hidden"
                       class="amount_input"
                       name="amount[]"
                       value="<?= $item->amount ?>">

            </td>

            <td>

                <button type="button"
                        class="btn btn-primary btn-sm editItemTypeBtn"
                        data-product-id="<?= $item->product_id ?>">
                    <i class="fa fa-edit"></i>
                </button>

                <button type="button"
                        class="btn btn-danger btn-sm removeCartItem">
                    <i class="fa fa-trash"></i>
                </button>

            </td>

        </tr>

        <?php } ?>

    <?php } ?>

    </tbody>
</table>



                    <!-- Summary -->
                   <div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">

            <!-- Left Column -->
      <div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row">

            <!-- Gross -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Gross</label>
                    <div class="col-sm-8">
                        <input type="text" 
                               name="qtn_sub_total" 
                               id="qtn_sub_total" 
                               class="form-control qtn_sub_total"
                               value="<?= isset($master['sub_total']) ? $master['sub_total'] : "" ?>">
                    </div>
                </div>
            </div>

            <!-- Discount -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Discount</label>

                    <div class="col-sm-4">
                        <input type="text" 
                               name="qtn_add_discount_percentage" 
                               id="qtn_add_discount_percentage" 
                               class="form-control"
                               placeholder="%">
                    </div>

                    <div class="col-sm-4">
                        <input type="text" 
                               name="qtn_add_discount_amount" 
                               id="qtn_add_discount_amount" 
                               class="form-control"
                               placeholder="Amount">
                    </div>

                </div>
            </div>

            <!-- VAT -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Apply VAT</label>
                    <div class="col-sm-8">
                        <input type="checkbox" id="qtn_apply_vat" name="qtn_apply_vat">

                        <input type="number" 
                               name="qtn_vat_percentage" 
                               id="qtn_vat_percentage" 
                               value="<?= isset($vat_percentage) ? $vat_percentage : 5 ?>"
                               class="form-control mt-2"
                               readonly
                               style="width:100px;">
                    </div>
                </div>
            </div>

            <!-- VAT Amount -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">VAT Amount</label>
                    <div class="col-sm-8">
                        <input type="text" 
                               name="qtn_vat_amount" 
                               id="qtn_vat_amount" 
                               class="form-control">
                    </div>
                </div>
            </div>

            <!-- Net -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Net</label>
                    <div class="col-sm-8">
                        <input type="text" 
                               name="qtn_grand_total" 
                               id="qtn_grand_total" 
                               class="form-control"
                               readonly>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
        </div>
    </div>
    
        </div>
    </div>

                            <!-- Payment and Terms -->
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Payment Term</label>
                                    <textarea name="payment_term" id="payment_term" rows="4"
    class="form-control estimation_edit"><?= isset($master['payment_term']) ? $master['payment_term'] : "" ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Validity</label>
                                    <input type="text" name="validity" id="validity"
                                        class="form-control estimation_edit"
                                        value="<?= isset($master['validity']) ? $master['validity'] : "" ?>">
                                </div>
                            </div>

                             <div class="form-group row">
    <div class="col-sm-6">
        <label class="col-form-label">Warranty</label>
        <input type="text" name="warranty" id="warranty"
            class="form-control estimation_edit"
            value="<?= isset($master['warranty']) ? $master['warranty'] : "" ?>">
    </div>

    <div class="col-sm-6">
        <label class="col-form-label">Warranty Description</label>
        <textarea name="warranty_description" id="warranty_description"
            class="form-control estimation_edit"><?= isset($master['warranty_description']) ? $master['warranty_description'] : "" ?></textarea>
    </div>
</div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Delivery Term</label>
                                    <textarea name="delivery_term" id="delivery_term" rows="4"
                                        class="form-control estimation_edit"></textarea>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label">Terms & Conditions</label>
                                    <textarea name="terms_condition" id="terms_condition" rows="5"
                                        class="form-control estimation_edit"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
    <div class="col-md-12">
        <label>Notes</label>
        <textarea class="form-control"
                  name="notes"
                  id="notes"
                  rows="4"></textarea>
    </div>
</div>
 <div class="row mt-3">
      <div class="col-md-4">
        <!-- Employee Name -->
        <div class="item form-group">
            <label class="col-form-label col-md-4 col-sm-4 label-align">Prepared By:</label>
            <div class="col-md-6 col-sm-6 ">
              <select class="form-control select2" 
                id="employee_prepared" name="employee_prepared">
                <option value="">Select</option>
                <?php foreach ($employees as $s) { ?>
                <option value="<?php echo $s->employee_id  ?>"><?php echo $s->user_code . ' ' . $s->employee_name; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
      </div>

       <!-- <div class="col-md-4"> -->
        <!-- Employee Name -->
        <!-- <div class="item form-group">
            <label class="col-form-label col-md-4 col-sm-4 label-align">Approved By:</label>
            <div class="col-md-6 col-sm-6 ">
              <select class="form-control select2" 
                id="employee_approved" name="employee_approved" required>
                <option value="">Select</option>
                <?php foreach ($employees as $s) { ?>
                <option value="<?php echo $s->employee_id  ?>"><?php echo $s->user_code . ' ' . $s->employee_name; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
      </div>      
    </div>  -->


                           <div class="row justify-content-center mt-3">

    <button type="submit" 
            class="btn btn-warning mr-2"
            name="action"
            value="draft">
        Save Draft
    </button>


    <button type="submit" 
            class="btn btn-success"
            name="action"
            value="quotation">
        Confirm Quotation
    </button>

</div>
                        </div>
                    </div>

                    <div class="modal fade" id="newItemModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Select Item</h5>

                <button type="button" 
                        class="close" 
                        data-dismiss="modal">
                    ×
                </button>
            </div>


            <div class="modal-body">

                <input type="text"
                       id="new_item_search"
                       class="form-control"
                       placeholder="Search item name or code">


                <table class="table table-bordered mt-3">

                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th width="120">Qty</th>
                            <th>Select</th>
                        </tr>
                    </thead>


                    <tbody id="new_item_result">

                    </tbody>


                </table>


            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-success"
                        id="addSelectedNewItem">
                    Add To Cart
                </button>

            </div>

        </div>
    </div>
</div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>

    var baseUrl = "<?php echo base_url(); ?>";


       
      

    // Prevent accidental form submit on Enter
$(document).on("keydown", "form input, form select", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        return false;
    }
});

$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select",
        allowClear: true,
        width: '100%'
    });
});



// Load when page opens
$(document).ready(function () {
    calculateQuotationTotal();
    calculateTotals();
});

$('#quotationForm').on('submit', function (e) {
    if (!validateDiscountAgainstSalesPerson()) {
        e.preventDefault();
    }
});

   
     $(document).on('keyup change', '.cart_qty, .cart_price', function () {

    var row = $(this).closest('tr');

    var qty = parseFloat(row.find('.cart_qty').val()) || 0;
    var price = parseFloat(row.find('.cart_price').val()) || 0;

    var amount = qty * price;

    row.find('.amount_display').text(amount.toFixed(2));
    row.find('.amount_input').val(amount.toFixed(2));

    calculateQuotationTotal();
    calculateTotals();
});

function calculateQuotationTotal()
{
    var subtotal = 0;

    $('.amount_input').each(function () {
        subtotal += parseFloat($(this).val()) || 0;
    });

    $('#qtn_sub_total').val(subtotal.toFixed(2));

    var discount = parseFloat($('#qtn_add_discount_percentage').val()) || 0;
    var discountAmount = subtotal * discount / 100;

    $('#qtn_add_discount_amount').val(discountAmount.toFixed(2));

    // Always recalc VAT + Net whenever subtotal changes (fixes stale/incorrect Net)
    calculateTotals();
}

// Discount % -> Discount Amount
$('#qtn_add_discount_percentage').on('keyup change', function () {

    var gross = parseFloat($('#qtn_sub_total').val()) || 0;
    var per = parseFloat($(this).val()) || 0;

    var amount = (gross * per) / 100;

    $('#qtn_add_discount_amount').val(amount.toFixed(2));

    calculateTotals();

    validateDiscountAgainstSalesPerson();
});

// Discount Amount -> Discount %
$('#qtn_add_discount_amount').on('keyup change', function () {

    var gross = parseFloat($('#qtn_sub_total').val()) || 0;
    var amount = parseFloat($(this).val()) || 0;

    var per = 0;
    if (gross > 0) {
        per = (amount / gross) * 100;
    }

    $('#qtn_add_discount_percentage').val(per.toFixed(2));

    calculateTotals();

    validateDiscountAgainstSalesPerson();
});

// Sales Person -> re-validate discount against their allowed max
$('#sales_person').on('change', function () {
    validateDiscountAgainstSalesPerson();
});

function validateDiscountAgainstSalesPerson() {

    var selectedOption = $('#sales_person option:selected');

    if (!$('#sales_person').val()) {
        return true;
    }

    var maxDiscount = parseFloat(selectedOption.data('discount'));

    if (isNaN(maxDiscount)) {
        return true;
    }

    var currentPercent = parseFloat($('#qtn_add_discount_percentage').val()) || 0;

    if (currentPercent > maxDiscount) {

        alert('Discount of ' + currentPercent.toFixed(2) + '% exceeds the maximum allowed (' + maxDiscount.toFixed(2) + '%) for the selected Sales Person. It has been reset to the maximum allowed.');

        $('#qtn_add_discount_percentage').val(maxDiscount.toFixed(2));

        var gross = parseFloat($('#qtn_sub_total').val()) || 0;
        var amount = (gross * maxDiscount) / 100;

        $('#qtn_add_discount_amount').val(amount.toFixed(2));

        calculateTotals();

        return false;
    }

    return true;
}
function calculateTotals() {

    var subtotal = parseFloat($('#qtn_sub_total').val()) || 0;
    var discount = parseFloat($('#qtn_add_discount_amount').val()) || 0;

    // Taxable amount = Subtotal - Discount. VAT is calculated on THIS (exclusive VAT),
    // never extracted back out of the total.
    var taxable_amount = subtotal - discount;
    if (taxable_amount < 0) {
        taxable_amount = 0;
    }

    var vat_amount = 0;

    if ($('#qtn_apply_vat').is(':checked')) {

        var vat_percentage = parseFloat($('#qtn_vat_percentage').val()) || 0;

        vat_amount = (taxable_amount * vat_percentage) / 100;

        $('#qtn_vat_amount').val(vat_amount.toFixed(2));

    } else {

        $('#qtn_vat_amount').val('0.00');

    }


    var net_amount = taxable_amount + vat_amount;

    $('#qtn_grand_total').val(net_amount.toFixed(2));
}

$('#qtn_apply_vat, #qtn_vat_percentage').on('keyup change', function () {
    calculateTotals();
});

$('#addCartRow').click(function(){

    var row = `
    <tr>

        <td>
            <input type="text"
                   class="form-control form-control-sm"
                   name="product_name[]"
                   placeholder="Item Name">

            <input type="hidden"
                   name="item_id[]"
                   value="">
        </td>

        <td>
            <input type="number"
                   class="form-control form-control-sm cart_qty"
                   name="qty[]"
                   value="1"
                   style="width:70px">
        </td>

        <td>
            <input type="number"
                   class="form-control form-control-sm cart_price"
                   name="price[]"
                   value="0"
                   step="0.01"
                   style="width:100px">
        </td>

        <td>

            <span class="amount_display">0.00</span>

            <input type="hidden"
                   class="amount_input"
                   name="amount[]"
                   value="0">

        </td>

        <td>

            <button type="button"
                    class="btn btn-danger btn-sm removeCartItem">
                <i class="fa fa-trash"></i>
            </button>

        </td>

    </tr>`;

    $('#selectedCartItems').append(row);

});


$('#addNewItem').click(function(){

    $('#newItemModal').modal('show');

});

$('#new_item_search').keyup(function(){

    let keyword = $(this).val();


    if(keyword.length < 2)
    {
        $('#new_item_result').html('');
        return;
    }


    $.ajax({

        url:"<?= base_url('index.php/Sales/search_items') ?>",

        type:"POST",

        data:{
            keyword:keyword
        },

        dataType:"json",

        success:function(data){

            let html='';


            $.each(data,function(i,item){


            html += `

                <tr>

                <td>

                ${item.product_name} (${item.product_code})

                <input type="hidden"
                       class="new_item_id"
                       value="${item.product_id}">


                <input type="hidden"
                       class="new_item_name"
                       value="${item.product_name}">


                <input type="hidden"
                       class="new_item_code"
                       value="${item.product_code}">


                <input type="hidden"
                       class="new_item_description"
                       value="${item.description ? item.description : ''}">


                </td>


                <td>${item.description ? item.description : ''}</td>


                <td>

                ${item.total_price}

                <input type="hidden"
                       class="new_item_price"
                       value="${item.total_price}">

                </td>


                <td>

                <input type="number"
                       class="new_item_qty form-control"
                       value="1"
                       min="1">

                </td>


                <td>

                <input type="checkbox"
                       class="new_item_check">

                </td>


                </tr>

                `;

            });


            $('#new_item_result').html(html);

        }

    });


});

$('#addSelectedNewItem').click(function(){

    $('#new_item_result tr').each(function(){

        if($(this).find('.new_item_check').is(':checked'))
        {

            let id          = $(this).find('.new_item_id').val();
            let name        = $(this).find('.new_item_name').val();
            let code        = $(this).find('.new_item_code').val();
            let description = $(this).find('.new_item_description').val();
            let price       = parseFloat($(this).find('.new_item_price').val()) || 0;
            let qty         = parseFloat($(this).find('.new_item_qty').val()) || 0;


            // Check item already exists
            let existingRow = $('#selectedCartItems')
                .find('input[name="item_id[]"][value="'+id+'"]')
                .closest('tr');


            if(existingRow.length > 0)
            {

                // Update existing quantity
                let oldQty = parseFloat(existingRow.find('.cart_qty').val()) || 0;

                let newQty = oldQty + qty;

                existingRow.find('.cart_qty').val(newQty);


                let amount = newQty * price;

                existingRow.find('.amount_display')
                           .text(amount.toFixed(2));

                existingRow.find('.amount_input')
                           .val(amount.toFixed(2));


            }
            else
            {

                // Add new row

                let amount = qty * price;

                $('#selectedCartItems').append(`

                <tr>

                    <td>${code}</td>

                    <td>
                        ${name}

                        <input type="hidden"
                               name="item_id[]"
                               value="${id}">
                    </td>

                    <td>
                        <textarea class="form-control form-control-sm"
                                  name="description[]"
                                  rows="1">${description}</textarea>
                    </td>

                    <td>
                        <input type="number"
                               class="form-control cart_qty"
                               name="qty[]"
                               value="${qty}"
                               style="width:70px">
                    </td>


                    <td>
                        <input type="number"
                               class="form-control cart_price"
                               name="price[]"
                               value="${price}">
                    </td>


                    <td>

                        <span class="amount_display">
                            ${amount.toFixed(2)}
                        </span>

                        <input type="hidden"
                               class="amount_input"
                               name="amount[]"
                               value="${amount.toFixed(2)}">

                    </td>


                    <td>
                        <button type="button"
                                class="btn btn-primary btn-sm editItemTypeBtn"
                                data-product-id="${id}">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button"
                                class="btn btn-danger btn-sm removeCartItem">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>

                </tr>

                `);

            }

        }

    });


    calculateQuotationTotal();
    calculateTotals();

    $('#newItemModal').modal('hide');

});
$(document).off('click', '.removeCartItem');

$(document).on('click', '.removeCartItem', function(e){

    e.preventDefault();

    let row = $(this).closest('tr');

    let itemName = row.find('td:first').text().trim();

    if(confirm("Are you sure you want to remove this item?\n\n" + itemName))
    {
        row.remove();

        calculateQuotationTotal();
        calculateTotals();
    }

});

$('#enquiry_id').change(function(){

    var enquiry_id = $(this).val();

    if(enquiry_id == '')
    {
        return;
    }


    $.ajax({

        url:"<?= base_url('index.php/Sales/get_enquiry_details') ?>",

        type:"POST",

        data:{
            enquiry_id: enquiry_id
        },

        dataType:"json",

              success:function(data){

    $('#enquiry_code').val(data.enquiry_code);
    $('#branch_name').val(data.branch_name);
    $('#project_name').val(data.project_name);
    $('#customer_name').val(data.customer_name);

    $('#quotation_branch_id').val(data.branch_id);
    $('#quotation_customer').val(data.enquiry_customer);

    // Sales person is pre-filled from the enquiry, but stays editable
    $('#sales_person').val(data.sales_person ? data.sales_person : '').trigger('change');
    validateDiscountAgainstSalesPerson();


    // Load enquiry items
    $('#selectedCartItems').html('');


    $.each(data.cart_items,function(i,item){

        let amount = parseFloat(item.qty) * parseFloat(item.price);


        $('#selectedCartItems').append(`

        <tr>

            <td>${item.product_code ? item.product_code : ''}</td>

            <td>
                ${item.product_name}

                <input type="hidden"
                       name="item_id[]"
                       value="${item.product_id}">
            </td>

            <td>
                <textarea class="form-control form-control-sm"
                          name="description[]"
                          rows="1">${item.description ? item.description : ''}</textarea>
            </td>

            <td>
                <input type="number"
                       class="form-control cart_qty"
                       name="qty[]"
                       value="${item.qty}"
                       style="width:70px">
            </td>


            <td>
                <input type="number"
                       class="form-control cart_price"
                       name="price[]"
                       value="${item.price}"
                       step="0.01"
                       style="width:100px">
            </td>


            <td>

                <span class="amount_display">
                    ${amount.toFixed(2)}
                </span>

                <input type="hidden"
                       class="amount_input"
                       name="amount[]"
                       value="${amount.toFixed(2)}">

            </td>


                        <td>

                <button type="button"
                        class="btn btn-primary btn-sm editItemTypeBtn"
                        data-product-id="${item.product_id}">
                    <i class="fa fa-edit"></i>
                </button>

                <button type="button"
                        class="btn btn-danger btn-sm removeCartItem">
                    <i class="fa fa-trash"></i>
                </button>

            </td>


        </tr>

        `);

    });


    calculateQuotationTotal();
    calculateTotals();

}

    });

});

$(document).on('itemQuickAdded', function(e, item){

    let existingRow = $('#selectedCartItems')
        .find('input[name="item_id[]"][value="'+item.product_id+'"]')
        .closest('tr');

    if(existingRow.length > 0)
    {
        return;
    }

    let price = parseFloat(item.retail_price) || 0;
    let qty = 1;
    let amount = qty * price;

    $('#selectedCartItems').append(`

    <tr>

        <td>${item.product_code ? item.product_code : ''}</td>

        <td>
            ${item.product_name}

            <input type="hidden"
                   name="item_id[]"
                   value="${item.product_id}">
        </td>

        <td>
            <textarea class="form-control form-control-sm"
                      name="description[]"
                      rows="1">${item.description ? item.description : ''}</textarea>
        </td>

        <td>
            <input type="number"
                   class="form-control cart_qty"
                   name="qty[]"
                   value="${qty}"
                   style="width:70px">
        </td>


        <td>
            <input type="number"
                   class="form-control cart_price"
                   name="price[]"
                   value="${price}"
                   step="0.01"
                   style="width:100px">
        </td>


        <td>

            <span class="amount_display">
                ${amount.toFixed(2)}
            </span>

            <input type="hidden"
                   class="amount_input"
                   name="amount[]"
                   value="${amount.toFixed(2)}">

        </td>


        <td>

            <button type="button"
                    class="btn btn-primary btn-sm editItemTypeBtn"
                    data-product-id="${item.product_id}">
                <i class="fa fa-edit"></i>
            </button>

            <button type="button"
                    class="btn btn-danger btn-sm removeCartItem">
                <i class="fa fa-trash"></i>
            </button>

        </td>


    </tr>

    `);

    calculateQuotationTotal();
    calculateTotals();

});
</script>

<?php $this->load->view('includes/items/item_popups'); ?>