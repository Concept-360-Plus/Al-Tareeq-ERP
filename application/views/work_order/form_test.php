<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid mt-3">
<form id="woForm">
    <input type="hidden" id="wo_id" name="wo_id" value="<?= isset($wo) ? $wo->wo_id : ''; ?>">
    <input type="hidden" id="wo_type" name="wo_type" value="<?= isset($wo) ? $wo->wo_type : $wo_type; ?>">
    <input type="hidden" id="cust_id" name="cust_id" value="<?= isset($wo) ? $wo->cust_id : ''; ?>">
    <input type="hidden" id="amc_invoice_id" name="amc_invoice_id" value="<?= isset($wo) ? $wo->amc_invoice_id : ''; ?>">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Work Order - <?= isset($wo) ? html_escape($wo->wo_type) : html_escape($wo_type); ?></h4>
        <div>
            <button type="button" class="btn btn-secondary" onclick="location.href='<?= base_url('work_order/add'); ?>'">New</button>
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-outline-secondary" onclick="window.print()">Print</button>
            <a href="<?= base_url('work_order'); ?>" class="btn btn-outline-danger">Exit</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-2">
            <label class="form-label">Division / Branch</label>
            <select id="branch_id" name="branch_id" class="form-select" required>
                <option value="">-- Select --</option>
                <!-- TODO: loop $branches from Branch_model -->
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Ref. No.</label>
            <input type="text" id="ref_no" class="form-control" value="<?= isset($wo) ? html_escape($wo->ref_no) : 'Auto Generated'; ?>" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Ref. Date</label>
            <input type="date" id="ref_date" name="ref_date" class="form-control" value="<?= isset($wo) ? $wo->ref_date : date('Y-m-d'); ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Retrieve / Duplicate</label>
            <div>
                <button type="button" id="btn_retrieve" class="btn btn-sm btn-outline-primary">Retrieve</button>
                <button type="button" id="btn_duplicate" class="btn btn-sm btn-outline-warning">Duplicate</button>
            </div>
        </div>
        <div class="col-md-2">
            <label class="form-label">Enquiry No.</label>
            <input type="text" id="enquiry_no" name="enquiry_no" class="form-control" value="<?= isset($wo) ? html_escape($wo->enquiry_no) : ''; ?>">
        </div>
    </div>

    <hr>

    <div class="row g-3">
        <div class="col-md-2">
            <label class="form-label">Customer Code</label>
            <input type="text" id="customer_code" name="customer_code" class="form-control" value="<?= isset($wo) ? html_escape($wo->customer_code) : ''; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Customer Name</label>
            <input type="text" id="customer_name" class="form-control" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label">Address</label>
            <input type="text" id="address" class="form-control" readonly>
        </div>
        <div class="col-md-2">
            <label class="form-label">Contact Name</label>
            <input type="text" id="contact_name" name="contact_name" class="form-control" value="<?= isset($wo) ? html_escape($wo->contact_name) : ''; ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Telephone</label>
            <input type="text" id="telephone" name="telephone" class="form-control" value="<?= isset($wo) ? html_escape($wo->telephone) : ''; ?>">
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-2">
            <label class="form-label">Contact No.</label>
            <input type="text" id="contact_no" name="contact_no" class="form-control" value="<?= isset($wo) ? html_escape($wo->contact_no) : ''; ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Fax</label>
            <input type="text" id="fax" name="fax" class="form-control" value="<?= isset($wo) ? html_escape($wo->fax) : ''; ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Delivery Date</label>
            <input type="date" id="delivery_date" name="delivery_date" class="form-control" value="<?= isset($wo) ? $wo->delivery_date : ''; ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Supervisor</label>
            <select id="supervisor_id" name="supervisor_id" class="form-select supervisor-select">
                <!-- Select2 AJAX -> users table -->
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Technician</label>
            <select id="technician_id" name="technician_id" class="form-select technician-select">
                <!-- Select2 AJAX -> users table -->
            </select>
        </div>
    </div>

    <hr>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Product Code</label>
            <select class="form-select product-select" name="product_id[]" multiple></select>
            <input type="hidden" name="product_code[]" id="product_code_hidden">
        </div>
        <div class="col-md-4">
            <label class="form-label">Nature of Complaint</label>
            <input type="text" id="nature_of_complaint" name="nature_of_complaint" class="form-control" value="<?= isset($wo) ? html_escape($wo->nature_of_complaint) : ''; ?>">
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-6">
            <label class="form-label">Inspection Comments</label>
            <textarea id="inspection_comments" name="inspection_comments" class="form-control" rows="3"><?= isset($wo) ? html_escape($wo->inspection_comments) : ''; ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Technical Comments</label>
            <textarea id="technical_comments" name="technical_comments" class="form-control" rows="3"><?= isset($wo) ? html_escape($wo->technical_comments) : ''; ?></textarea>
        </div>
    </div>

    <hr>

    <div class="row g-3 align-items-end">
        <div class="col-md-6">
            <label class="form-label d-block">Type of Service</label>
            <?php $tos = isset($wo) ? $wo->type_of_service : ''; ?>
            <?php foreach (['AMC','Chargeable','Free','Warranty','Self Service'] as $type): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_of_service" id="tos_<?= strtolower(str_replace(' ','_',$type)); ?>" value="<?= $type; ?>" <?= $tos === $type ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="tos_<?= strtolower(str_replace(' ','_',$type)); ?>"><?= $type; ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-3">
            <label class="form-label">Contract / Invoice / Hand Over Ref. No.</label>
            <div class="input-group">
                <input type="text" id="contract_invoice_ref" name="contract_invoice_ref" class="form-control" value="<?= isset($wo) ? html_escape($wo->contract_invoice_ref) : ''; ?>" readonly>
                <button type="button" id="btn_lookup" class="btn btn-outline-secondary" style="display:none;">Lookup</button>
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">AMC / Warranty Expiry Date</label>
            <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="<?= isset($wo) ? $wo->expiry_date : ''; ?>" readonly>
        </div>
    </div>

    <div class="mt-3">
        <button type="button" id="btn_reject" class="btn btn-outline-danger">Order Rejected</button>
        <button type="button" id="btn_undo" class="btn btn-outline-secondary">Undo</button>
    </div>
</form>
</div>

<!-- AMC Lookup Modal -->
<div class="modal fade" id="amcModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Select AMC Contract</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
          <thead><tr><th>Contract No.</th><th>Expiry Date</th><th>Project</th></tr></thead>
          <tbody id="amcModalBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- <script src="<?= base_url('assets/js/work_order.js'); ?>"></script> -->

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

    $('input[name="type_of_service"]').on('change', function () {
        var val = $(this).val();
        var labels = {AMC: 'Contract No.', Chargeable: 'Invoice No.', Warranty: 'Hand Over Ref. No.', Free: '', 'Self Service': ''};
        $('#contract_invoice_ref').attr('placeholder', labels[val] || '');
        $('#btn_lookup').toggle(val === 'AMC');
        if (val !== 'AMC') { $('#amc_invoice_id').val(''); $('#contract_invoice_ref').val(''); $('#expiry_date').val(''); }
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

    $('#woForm').on('submit', function (e) {
        e.preventDefault();
        $.post(base_url + 'index.php/AMC/save', $(this).serialize(), function (res) {
            if (res.status === 'success') {
                window.location.href = base_url + 'index.php/AMC/work_order_list/';
            }
        }, 'json');
    });
});
 </script>