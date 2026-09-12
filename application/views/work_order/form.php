<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style type="text/css">
.select2Width {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  max-width: 320px !important;
  min-width: 320px !important;
}

/* Fix for Select2 width collapse inside Bootstrap grid rows */
.select2-container {
  width: 100% !important;
}
.select2-container .select2-selection--single,
.select2-container .select2-selection--multiple {
  min-height: 31px !important;
}
</style>

<div class="card-body">
    <form id="woForm" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" id="wo_id" name="wo_id" value="<?= isset($wo) ? $wo->wo_id : ''; ?>">
        <!-- <input type="hidden" id="wo_type" name="wo_type" value="<?= isset($wo) ? $wo->wo_type : $wo_type; ?>"> -->
        <input type="hidden" id="cust_id" name="cust_id" value="<?= isset($wo) ? $wo->cust_id : ''; ?>">
        <input type="hidden" id="amc_invoice_id" name="amc_invoice_id" value="<?= isset($wo) ? $wo->amc_invoice_id : ''; ?>">

        <!-- Header Actions -->
        <div class="form-group row align-items-center mb-3">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <!-- <h4 class="mb-0">Work Order - <?= isset($wo) ? html_escape($wo->wo_type) : html_escape($wo_type); ?></h4> -->
            </div>
        </div>

        <hr>
<div class="form-group row">
    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Maintenance Type<span style="color: red;"> * </span>:</label>
    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-10">
        <?php $selected_type = isset($wo) ? $wo->wo_type : $wo_type; ?>
        <?php foreach (['External','Internal'] as $t): ?>
            <div class="form-check form-check-inline mr-3">
                <input class="form-check-input" type="radio" name="wo_type" id="wo_type_<?= strtolower($t); ?>" value="<?= $t; ?>" <?= $selected_type === $t ? 'checked' : ''; ?> required>
                <label class="form-check-label" for="wo_type_<?= strtolower($t); ?>"><?= $t; ?></label>
            </div>
        <?php endforeach; ?>
    </div>
</div>
        <!-- General Info Section -->
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Division / Branch<span style="color: red;"> * </span>:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
               <select id="branch_id" name="branch_id" class="form-select select2" required>
    <option value="">-- Select --</option>
    <?php foreach ($branches as $b): ?>
        <option value="<?= $b->branch_id; ?>" <?= (isset($wo) && $wo->branch_id == $b->branch_id) ? 'selected' : ''; ?>>
            <?= html_escape($b->branch_name); ?>
        </option>
    <?php endforeach; ?>
</select>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Ref. No.:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="ref_no" class="form-control form-control-sm bg-soft-gray" value="<?= isset($wo) ? html_escape($wo->ref_no) : 'Auto Generated'; ?>" readonly>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Ref. Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="date" id="ref_date" name="ref_date" class="form-control form-control-sm" value="<?= isset($wo) ? $wo->ref_date : date('Y-m-d'); ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Enquiry No.:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="enquiry_no" name="enquiry_no" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->enquiry_no) : ''; ?>">
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Actions:</label>
            <!-- <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <button type="button" id="btn_retrieve" class="btn btn-sm btn-outline-primary">Retrieve</button>
                <button type="button" id="btn_duplicate" class="btn btn-sm btn-outline-warning">Duplicate</button>
            </div> -->
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
            <div class="input-group input-group-sm mb-1">
                <input type="text" id="retrieve_ref_no" class="form-control" placeholder="Enter Ref. No.">
                <div class="input-group-append">
                    <button type="button" id="btn_retrieve" class="btn btn-outline-primary">Retrieve</button>
                </div>
            </div>
            <button type="button" id="btn_duplicate" class="btn btn-sm btn-outline-warning">Duplicate</button>
        </div>
        </div>

        <hr>

        <!-- Customer Info Section -->
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Customer Code:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="customer_code" name="customer_code" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->customer_code) : ''; ?>">
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Customer Name:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="customer_name" class="form-control form-control-sm bg-soft-gray" readonly>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Address:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="address" class="form-control form-control-sm bg-soft-gray" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Contact Name:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="contact_name" name="contact_name" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->contact_name) : ''; ?>">
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Telephone:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="telephone" name="telephone" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->telephone) : ''; ?>">
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Contact No.:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="contact_no" name="contact_no" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->contact_no) : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Fax:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="fax" name="fax" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->fax) : ''; ?>">
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Delivery Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="date" id="delivery_date" name="delivery_date" class="form-control form-control-sm" value="<?= isset($wo) ? $wo->delivery_date : ''; ?>">
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Supervisor:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <select id="supervisor_id" name="supervisor_id" class="form-control form-control-sm select2 supervisor-select">
                    <!-- Select2 AJAX -> users table -->
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Technician:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <select id="technician_id" name="technician_id" class="form-control form-control-sm select2 technician-select">
                    <!-- Select2 AJAX -> users table -->
                </select>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Product Code:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <select class="form-control form-control-sm select2 product-select" name="product_id[]" multiple></select>
                <!-- <input type="hidden" name="product_code[]" id="product_code_hidden"> -->
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Nature of Complaint:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="text" id="nature_of_complaint" name="nature_of_complaint" class="form-control form-control-sm" value="<?= isset($wo) ? html_escape($wo->nature_of_complaint) : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Inspection Comments:</label>
            <div class="col-xs-12 col-sm-9 col-md-8 col-lg-10">
                <textarea id="inspection_comments" name="inspection_comments" class="form-control" rows="3"><?= isset($wo) ? html_escape($wo->inspection_comments) : ''; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Technical Comments:</label>
            <div class="col-xs-12 col-sm-9 col-md-8 col-lg-10">
                <textarea id="technical_comments" name="technical_comments" class="form-control" rows="3"><?= isset($wo) ? html_escape($wo->technical_comments) : ''; ?></textarea>
            </div>
        </div>

        <hr>

        <!-- Service & Contract Info -->
        <div class="form-group row align-items-center">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Type of Service:</label>
            <div class="col-xs-12 col-sm-9 col-md-8 col-lg-10">
                <?php $tos = isset($wo) ? $wo->type_of_service : ''; ?>
                <?php foreach (['AMC','Chargeable','Free','Warranty','Self Service'] as $type): ?>
                    <div class="form-check form-check-inline mr-3">
                        <input class="form-check-input" type="radio" name="type_of_service" id="tos_<?= strtolower(str_replace(' ','_',$type)); ?>" value="<?= $type; ?>" <?= $tos === $type ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="tos_<?= strtolower(str_replace(' ','_',$type)); ?>"><?= $type; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Contract / Invoice Ref:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <div class="input-group">
                    <input type="text" id="contract_invoice_ref" name="contract_invoice_ref" class="form-control form-control-sm bg-soft-gray" value="<?= isset($wo) ? html_escape($wo->contract_invoice_ref) : ''; ?>" >
                    <div class="input-group-append">
                        <button type="button" id="btn_lookup" class="btn btn-sm btn-outline-secondary" style="display:none;">Lookup</button>
                    </div>
                </div>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">AMC / Warranty Expiry:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
                <input type="date" id="expiry_date" name="expiry_date" class="form-control form-control-sm bg-soft-gray" value="<?= isset($wo) ? $wo->expiry_date : ''; ?>" >
            </div>
        </div>

        <hr>

        <!-- Footer Actions -->
        <!-- <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary btn-sm m-b-0">Save Work Order</button>
            </div>
        </div> -->
        <div class="form-group row">
    <div class="col-sm-10">
        <button type="submit" class="btn btn-primary btn-sm m-b-0">Save Work Order</button>
        <?php if (isset($wo) && $wo->order_status === 'Draft'): ?>
            <button type="button" id="btn_complete" class="btn btn-success btn-sm" data-wo="<?= $wo->wo_id; ?>">Mark Completed</button>
            <button type="button" id="btn_reject" class="btn btn-outline-danger btn-sm" data-wo="<?= $wo->wo_id; ?>">Reject Order</button>
        <?php endif; ?>
        <?php if (isset($wo)): ?>
            <span class="badge bg-secondary ms-2">Status: <?= html_escape($wo->order_status); ?></span>
        <?php endif; ?>
    </div>
</div>
    </form>
</div>

<!-- AMC Lookup Modal -->
<div class="modal fade" id="amcModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select AMC Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Contract No.</th>
                            <th>Expiry Date</th>
                            <th>Project</th>
                        </tr>
                    </thead>
                    <tbody id="amcModalBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = "<?= base_url(); ?>";
</script>
 <script>
    $(function () {
         // Branch Select2
    $('#branch_id').select2({
        width: '100%',
        placeholder: '-- Select --',
        allowClear: true
    });
    
    $('input[name="type_of_service"]').trigger('change');

    // $('input[name="type_of_service"]').on('change', function () {
    //     var val = $(this).val();
    //     var labels = {AMC: 'Contract No.', Chargeable: 'Invoice No.', Warranty: 'Hand Over Ref. No.', Free: '', 'Self Service': ''};
    //     $('#contract_invoice_ref').attr('placeholder', labels[val] || '');
    //     $('#btn_lookup').toggle(val === 'AMC');
    //     if (val !== 'AMC') { $('#amc_invoice_id').val(''); $('#contract_invoice_ref').val(''); $('#expiry_date').val(''); }
    // });
    $('input[name="type_of_service"]').on('change', function () {
    var val = $(this).val();
    var labels = {AMC: 'Contract No.', Chargeable: 'Invoice No.', Warranty: 'Hand Over Ref. No.', Free: '', 'Self Service': ''};
    $('#contract_invoice_ref').attr('placeholder', labels[val] || '');
    $('#btn_lookup').toggle(val === 'AMC');

    if (val === 'AMC') {
        $('#contract_invoice_ref').prop('readonly', true).addClass('bg-soft-gray');
        $('#expiry_date').prop('readonly', true).addClass('bg-soft-gray');
    } else {
        $('#amc_invoice_id').val('');
        $('#contract_invoice_ref').prop('readonly', false).removeClass('bg-soft-gray').val('');
        // Warranty-ന് expiry manual ആയി enter ചെയ്യാൻ അനുവദിക്കുന്നു, മറ്റുള്ളവയ്ക്ക് blank ആക്കി disable ചെയ്യുന്നു
        if (val === 'Warranty') {
            $('#expiry_date').prop('readonly', false).removeClass('bg-soft-gray').val('');
        } else {
            $('#expiry_date').prop('readonly', true).addClass('bg-soft-gray').val('');
        }
    }
});

    $('#customer_code').on('blur', function () {
        $.post(base_url + 'index.php/AMC/customer_lookup', {customer_code: $(this).val()}, function (res) {
            if (res) {
                $('#cust_id').val(res.customer_id);
                $('#customer_name').val(res.customer_name);
                $('#address').val(res.customer_address);
                $('#telephone').val(res.office_telephone);
                $('#fax').val(res.office_fax);
            }
        }, 'json');
    });

    $('.product-select').select2({
        ajax: {
            url: base_url + 'index.php/AMC/product_search',
            dataType: 'json',
            delay: 250,
            data: function (params) { return {term: params.term}; }
        }
    });

    $('.supervisor-select, .technician-select').select2({
        ajax: {
            url: base_url + 'index.php/AMC/staff_search', // TODO: add this method (same pattern as product_search, querying `users`)
            dataType: 'json',
            delay: 250,
            data: function (params) { return {term: params.term}; }
        }
    });

    $('#btn_lookup').on('click', function () {
        $.post(base_url + 'index.php/AMC/amc_lookup', {cust_id: $('#cust_id').val()}, function (res) {
            var rows = '';
            $.each(res, function (i, c) {
                rows += '<tr class="amc-row" style="cursor:pointer" data-id="' + c.invoice_id + '"><td>' + c.invoice_code + '</td><td>' + c.amc_end_date + '</td><td>' + (c.project_name || '') + '</td></tr>';
            });
            $('#amcModalBody').html(rows || '<tr><td colspan="3" class="text-center">No active AMC contract found</td></tr>');
            $('#amcModal').modal('show');
        }, 'json');
    });

    $(document).on('click', '.amc-row', function () {
        $.post(base_url + 'index.php/AMC/amc_select', {invoice_id: $(this).data('id')}, function (res) {
            $('#amc_invoice_id').val(res.amc_invoice_id);
            $('#contract_invoice_ref').val(res.contract_invoice_ref);
            $('#expiry_date').val(res.expiry_date);
            $('#amcModal').modal('hide');
        }, 'json');
    });

    // $('#woForm').on('submit', function (e) {
    //     e.preventDefault();
    //     $.post(base_url + 'index.php/AMC/save', $(this).serialize(), function (res) {
    //         if (res.status === 'success') {
    //             window.location.href = base_url + 'index.php/AMC/work_order_list/';
    //         }
    //     }, 'json');
    // });

    $('#woForm').on('submit', function (e) {
    e.preventDefault();
    $.post(base_url + 'index.php/AMC/save', $(this).serialize(), function (res) {
        if (res.status === 'success') {
            window.location.href = base_url + 'index.php/AMC/work_order_list/';
        } else {
            alert(res.message || 'Failed to save Work Order. Please check required fields.');
        }
    }, 'json').fail(function () {
        alert('Server error while saving. ');
    });
});


     $('#btn_complete, #btn_reject').on('click', function () {
    var status = $(this).attr('id') === 'btn_complete' ? 'Completed' : 'Rejected';
    var wo_id = $(this).data('wo');
    if (status === 'Rejected' && !confirm('Reject this Work Order?')) return;

    $.post(base_url + 'index.php/AMC/update_status', {wo_id: wo_id, status: status}, function (res) {
        if (res.status === 'success') location.reload();
    }, 'json');
        });


        $('#btn_retrieve').on('click', function () {
    var ref = $('#retrieve_ref_no').val();
    if (!ref) { alert('Enter a Ref. No.'); return; }
    $.post(base_url + 'index.php/AMC/retrieve_by_ref', {ref_no: ref}, function (res) {
        if (res.status !== 'success') { alert('Work Order not found'); return; }
        populateWorkOrderForm(res.wo, res.items);
    }, 'json');
});

$('#btn_duplicate').on('click', function () {
    if (!$('#cust_id').val()) { alert('Retrieve or fill a Work Order first before duplicating.'); return; }
    $('#wo_id').val('');
    $('#ref_no').val('Auto Generated');
});

function populateWorkOrderForm(wo, items) {
    $('#wo_id').val(wo.wo_id);
    $('#ref_no').val(wo.ref_no);
    $('#ref_date').val(wo.ref_date);
    $('#enquiry_no').val(wo.enquiry_no);
    $('#customer_code').val(wo.customer_code);
    $('#cust_id').val(wo.cust_id);
    $('#contact_name').val(wo.contact_name);
    $('#telephone').val(wo.telephone);
    $('#contact_no').val(wo.contact_no);
    $('#fax').val(wo.fax);
    $('#delivery_date').val(wo.delivery_date);
    $('#nature_of_complaint').val(wo.nature_of_complaint);
    $('#inspection_comments').val(wo.inspection_comments);
    $('#technical_comments').val(wo.technical_comments);
    $('#contract_invoice_ref').val(wo.contract_invoice_ref);
    $('#expiry_date').val(wo.expiry_date);
    $('#amc_invoice_id').val(wo.amc_invoice_id);

    $('#branch_id').val(wo.branch_id).trigger('change');
    $('input[name="wo_type"][value="' + wo.wo_type + '"]').prop('checked', true);
    $('input[name="type_of_service"][value="' + wo.type_of_service + '"]').prop('checked', true).trigger('change');

    // Customer Name / Address only — Telephone/Fax already set above from the saved record,
    // so this AJAX call is NOT allowed to overwrite them.
    $.post(base_url + 'index.php/AMC/customer_lookup', {customer_code: wo.customer_code}, function (res) {
        if (res) {
            $('#customer_name').val(res.customer_name);
            $('#address').val(res.customer_address);
        }
    }, 'json');

    // Supervisor Select2 pre-populate
    $('#supervisor_id').empty();
    if (wo.supervisor_id) {
        var supOption = new Option(wo.supervisor_code + ' - ' + wo.supervisor_name, wo.supervisor_id, true, true);
        $('#supervisor_id').append(supOption).trigger('change');
    }

    // Technician Select2 pre-populate
    $('#technician_id').empty();
    if (wo.technician_id) {
        var techOption = new Option(wo.technician_code + ' - ' + wo.technician_name, wo.technician_id, true, true);
        $('#technician_id').append(techOption).trigger('change');
    }

    // Product Select2 (multi) pre-populate
    $('.product-select').empty();
    $.each(items, function (i, item) {
        var prodOption = new Option(item.product_code + ' - ' + (item.product_name || ''), item.product_id, true, true);
        $('.product-select').append(prodOption);
    });
    $('.product-select').trigger('change');
}
   
});
 </script>