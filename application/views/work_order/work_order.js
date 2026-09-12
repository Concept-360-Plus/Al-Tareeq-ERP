$(function () {
    $('input[name="type_of_service"]').trigger('change');

    $('input[name="type_of_service"]').on('change', function () {
        var val = $(this).val();
        var labels = {AMC: 'Contract No.', Chargeable: 'Invoice No.', Warranty: 'Hand Over Ref. No.', Free: '', 'Self Service': ''};
        $('#contract_invoice_ref').attr('placeholder', labels[val] || '');
        $('#btn_lookup').toggle(val === 'AMC');
        if (val !== 'AMC') { $('#amc_invoice_id').val(''); $('#contract_invoice_ref').val(''); $('#expiry_date').val(''); }
    });

    $('#customer_code').on('blur', function () {
        $.post(base_url + 'work_order/customer_lookup', {customer_code: $(this).val()}, function (res) {
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
            url: base_url + 'work_order/product_search',
            dataType: 'json',
            delay: 250,
            data: function (params) { return {term: params.term}; }
        }
    });

    $('.supervisor-select, .technician-select').select2({
        ajax: {
            url: base_url + 'work_order/staff_search', // TODO: add this method (same pattern as product_search, querying `users`)
            dataType: 'json',
            delay: 250,
            data: function (params) { return {term: params.term}; }
        }
    });

    $('#btn_lookup').on('click', function () {
        $.post(base_url + 'work_order/amc_lookup', {cust_id: $('#cust_id').val()}, function (res) {
            var rows = '';
            $.each(res, function (i, c) {
                rows += '<tr class="amc-row" style="cursor:pointer" data-id="' + c.invoice_id + '"><td>' + c.invoice_code + '</td><td>' + c.amc_end_date + '</td><td>' + (c.project_name || '') + '</td></tr>';
            });
            $('#amcModalBody').html(rows || '<tr><td colspan="3" class="text-center">No active AMC contract found</td></tr>');
            $('#amcModal').modal('show');
        }, 'json');
    });

    $(document).on('click', '.amc-row', function () {
        $.post(base_url + 'work_order/amc_select', {invoice_id: $(this).data('id')}, function (res) {
            $('#amc_invoice_id').val(res.amc_invoice_id);
            $('#contract_invoice_ref').val(res.contract_invoice_ref);
            $('#expiry_date').val(res.expiry_date);
            $('#amcModal').modal('hide');
        }, 'json');
    });

    $('#woForm').on('submit', function (e) {
        e.preventDefault();
        $.post(base_url + 'work_order/save', $(this).serialize(), function (res) {
            if (res.status === 'success') {
                window.location.href = base_url + 'work_order/edit/' + res.wo_id;
            }
        }, 'json');
    });
});