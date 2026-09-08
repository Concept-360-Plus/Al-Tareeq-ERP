<div class="content-wrapper">
    <section class="content">
            <form method="post"
                action="<?= base_url() ?>index.php/Purchase/save_purchase_return">
                <div class="box-body">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Return Date <span style="color:red">*</span></label>

                                <input type="date"
                                    name="return_date"
                                    class="form-control"
                                    value="<?= date('Y-m-d') ?>"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Return No</label>

                                <input type="text"
                                    class="form-control"
                                    name="return_code"
                                    value="<?= $return_code ?>"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select GRN <span style="color:red">*</span></label>

                                <select
                                    class="form-control select2"
                                    id="grn_id"
                                    name="grn_id"
                                    required>

                                    <option value="">Select GRN</option>

                                    <?php foreach ($grn_list as $row) { ?>

                                        <option value="<?= $row->grn_id ?>">

                                            <?= $row->grn_code ?>

                                            -

                                            <?= $row->supplier_name ?>

                                        </option>

                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">

                                <label>GRN Date</label>

                                <input
                                    type="text"
                                    id="grn_date"
                                    class="form-control"
                                    readonly>

                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Supplier</label>

                                <input
                                    type="text"
                                    id="supplier_name"
                                    class="form-control"
                                    readonly>

                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Warehouse</label>

                                <input
                                    type="text"
                                    id="warehouse_name"
                                    class="form-control"
                                    readonly>

                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="form-group">

                                <label>Store</label>

                                <input
                                    type="text"
                                    id="store_name"
                                    class="form-control"
                                    readonly>

                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>GRN No</label>

                            <input
                                type="text"
                                id="grn_code"
                                class="form-control"
                                readonly>
                        </div>

                    </div>

                    <br>


                    <input type="hidden" name="supplier_id" id="supplier_id">
                    <input type="hidden" name="warehouse_id" id="warehouse_id">
                    <input type="hidden" name="store_id" id="store_id">

                    <br>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="40%">Product</th>
                                <th>Received</th>
                                <th>Returned</th>
                                <th>Balance</th>
                                <th width="120">Return Qty</th>
                            </tr>
                        </thead>

                        <tbody id="grn_items">

                        </tbody>
                    </table>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <label>Remarks</label>

                                <textarea
                                    class="form-control"
                                    rows="4"
                                    name="remarks"></textarea>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="box-footer">

                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="fa fa-save"></i>

                        Save Purchase Return

                    </button>

                    <a
                        href="<?= base_url() ?>index.php/Purchase/purchase_return_list"
                        class="btn btn-default">

                        Cancel

                    </a>

                </div>
            </form>
    </section>
</div>

<script>
    $('#grn_id').change(function() {
        var grn_id = $(this).val();
        if (grn_id == '')
            return;
        $.ajax({
            url: "<?= base_url() ?>index.php/Ajax/ajax_get_grn_info",
            type: "POST",
            data: {
                grn_id: grn_id
            },
            dataType: "json",
            success: function(res) {
                $('#grn_code').val(res.grn_code);
                $('#grn_date').val(res.grn_date);
                $('#supplier_name').val(res.supplier_name);
                $('#warehouse_name').val(res.warehouse_name);
                $('#store_name').val(res.store_name);
                $('#supplier_id').val(res.supplier_id);
                $('#warehouse_id').val(res.warehouse_id);
                $('#store_id').val(res.store_id);

            }
        });


        $.ajax({
            url: "<?= base_url() ?>index.php/Ajax/get_grn_items_for_return",
            type: "POST",
            data: {
                grn_id: grn_id
            },
            success: function(html) {
                $('#grn_items').html(html);
            }
        });
    });

    $(document).on('keyup', '.return_qty', function() {
        var max = parseFloat($(this).attr('max'));
        var qty = parseFloat($(this).val());
        if (qty > max) {
            alert("Return quantity cannot exceed Balance Qty.");
            $(this).val(max);
        }
    });

    $('form').submit(function() {
        var total = 0;
        $('.return_qty').each(function() {
            total += parseFloat($(this).val()) || 0;
        });

        if (total == 0) {
            alert("Please enter at least one Return Qty.");
            return false;
        }
    });
</script>