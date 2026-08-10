<div class="x_panel">

    <div class="x_content">

        <form
            method="post"
            action="<?= base_url('index.php/Inventory/update_stock_transfer'); ?>"
            id="transfer_form">

            <input
                type="hidden"
                name="transfer_id"
                value="<?= $master->transfer_id; ?>">

            <!-- Transfer Date -->

            <table class="table table-bordered">
                <tr>
                    <th width="25%">
                        Transfer Date
                        <span class="text-danger">*</span>
                    </th>

                    <td>
                        <input
                            type="date"
                            name="transfer_date"
                            class="form-control"
                            value="<?= $master->transfer_date; ?>"
                            required>

                    </td>

                    <th width="25%">
                        Status
                    </th>

                    <td>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= $master->status; ?>"
                            readonly>
                    </td>
                </tr>

                <tr>
                    <th width="25%">Transfer Code</th>

                    <td width="25%">
                        <input
                            type="text"
                            class="form-control"
                            value="<?= $master->transfer_code; ?>"
                            readonly>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- FROM LOCATION -->

            <h4><b>From Location</b></h4>

            <table class="table table-bordered">

                <tr>
                    <th width="25%">
                        Branch
                        <span class="text-danger">*</span>
                    </th>

                    <td>

                        <select
                            name="from_branch_id"
                            class="form-control"
                            required>

                            <option value="">
                                -- Select Branch --
                            </option>

                            <?php foreach ($branch_records as $row) { ?>
                                <option
                                    value="<?= $row->branch_id; ?>"
                                    <?= $row->branch_id == $master->from_branch_id ? 'selected' : ''; ?>>
                                    <?= $row->branch_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        Warehouse
                        <span class="text-danger">*</span>
                    </th>
                    <td>

                        <select
                            name="from_warehouse_id"
                            id="from_warehouse_id"
                            class="form-control"
                            onchange="loadFromStores()"
                            required>

                            <option value="">
                                -- Select Warehouse --
                            </option>

                            <?php foreach ($warehouse_list as $row) { ?>
                                <option
                                    value="<?= $row->warehouse_id; ?>"
                                    <?= $row->warehouse_id == $master->from_warehouse_id ? 'selected' : ''; ?>>
                                    <?= $row->warehouse_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        Store
                        <span class="text-danger">*</span>
                    </th>

                    <td>
                        <select
                            name="from_store_id"
                            id="from_store_id"
                            class="form-control"
                            required>
                            <option value="<?= $master->from_store_id; ?>" selected>
                                <?= $master->from_store; ?>
                            </option>
                        </select>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- TO LOCATION -->

            <h4><b>To Location</b></h4>

            <table class="table table-bordered">

                <tr>
                    <th width="25%">
                        Branch
                        <span class="text-danger">*</span>
                    </th>

                    <td>
                        <select
                            name="to_branch_id"
                            class="form-control"
                            required>

                            <option value="">
                                -- Select Branch --
                            </option>

                            <?php foreach ($branch_records as $row) { ?>
                                <option
                                    value="<?= $row->branch_id; ?>"
                                    <?= $row->branch_id == $master->to_branch_id ? 'selected' : ''; ?>>
                                    <?= $row->branch_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        Warehouse
                        <span class="text-danger">*</span>
                    </th>
                    <td>

                        <select
                            name="to_warehouse_id"
                            id="to_warehouse_id"
                            class="form-control"
                            onchange="loadToStores()"
                            required>

                            <option value="">
                                -- Select Warehouse --
                            </option>

                            <?php foreach ($warehouse_list as $row) { ?>
                                <option
                                    value="<?= $row->warehouse_id; ?>"
                                    <?= $row->warehouse_id == $master->to_warehouse_id ? 'selected' : ''; ?>>
                                    <?= $row->warehouse_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        Store
                        <span class="text-danger">*</span>
                    </th>

                    <td>
                        <select
                            name="to_store_id"
                            id="to_store_id"
                            class="form-control"
                            required>
                            <option value="<?= $master->to_store_id; ?>" selected>
                                <?= $master->to_store; ?>
                            </option>
                        </select>
                    </td>
                </tr>
            </table>

            <!-- REMARKS -->
            <table class="table table-bordered">
                <tr>
                    <th width="25%">
                        Remarks
                    </th>

                    <td>
                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="3"><?= $master->remarks; ?></textarea>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- ITEMS -->

            <div class="text-right"
                style="margin-bottom:15px;">
                <button
                    type="button"
                    class="btn btn-primary"
                    id="addRow">
                    <i class="fa fa-plus"></i>
                    Add Item
                </button>
            </div>

            <table
                class="table table-bordered"
                id="items_table">
                <thead>
                    <tr>
                        <th width="5%">Sl.No</th>
                        <th width="30%">Product</th>
                        <th width="10%">Unit</th>
                        <th width="12%">Available Qty</th>
                        <th width="12%">Transfer Qty</th>
                        <th>Remarks</th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $i = 0;
                    foreach ($items as $item) {
                        $i++;
                    ?>

                        <tr>
                            <td class="slno">
                                <?= $i; ?>
                            </td>

                            <td>
                                <select
                                    class="form-control product_id select2"
                                    name="product_id[]"
                                    required>

                                    <option value="">
                                        -- Select Product --
                                    </option>

                                    <?php foreach ($products as $product) { ?>
                                        <option
                                            value="<?= $product->product_id; ?>"
                                            <?= $product->product_id == $item->product_id ? 'selected' : ''; ?>>
                                            <?= $product->product_code; ?>
                                            -
                                            <?= $product->product_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td>
                                <select
                                    class="form-control unit_id"
                                    name="unit_id[]"
                                    required>

                                    <option value="">
                                        -- Select Unit --
                                    </option>

                                    <?php foreach ($units as $unit) { ?>
                                        <option
                                            value="<?= $unit->unit_id; ?>"
                                            <?= $unit->unit_id == $item->unit_id ? 'selected' : ''; ?>>

                                            <?= $unit->unit_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td>
                                <input
                                    type="text"
                                    class="form-control available_qty"
                                    readonly>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    class="form-control transfer_qty"
                                    name="transfer_qty[]"
                                    min="1"
                                    value="<?= $item->transfer_qty; ?>"
                                    required>
                            </td>

                            <td>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="item_remark[]"
                                    value="<?= $item->remarks; ?>">
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="btn btn-danger removeRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="text-center">
                <button
                    type="submit"
                    class="btn btn-success btn-lg"
                    id="saveBtn">
                    <i class="fa fa-save"></i>
                    Update Stock Transfer
                </button>

                <a
                    href="<?= base_url('index.php/Inventory/list_stock_transfer'); ?>"
                    class="btn btn-default btn-lg">
                    Cancel
                </a>

            </div>
        </form>
    </div>
</div>

<script>
    const products = <?= json_encode($products); ?>;
    const units = <?= json_encode($units); ?>;
    let rowIndex = <?= count($items); ?>;

    $(document).ready(function() {
        $('.product_id').select2({
            width: '100%',
            placeholder: 'Search Product',
            allowClear: true
        });

        loadFromStores(true);
        loadToStores(true);
        $('.product_id').each(function() {
            var product_id = $(this).val();
            if (product_id) {
                var row = $(this).closest('tr');
                getProductDetailsForEdit(row,product_id);
            }
        });
        updateSlNo();

    });


    $('#addRow').click(function() {
        rowIndex++;
        let productOption =
            '<option value="">-- Select Product --</option>';
        products.forEach(function(product) {
            productOption += `
            <option value="${product.product_id}">
                ${product.product_code} - ${product.product_name}
            </option>
        `;
        });


        let unitOption =
            '<option value="">-- Select Unit --</option>';
        units.forEach(function(unit) {
            unitOption += `
            <option value="${unit.unit_id}">
                ${unit.unit_name}
            </option>
        `;

        });


        let html = `
            <tr>
                <td class="slno"></td>

                <td>
                    <select
                        class="form-control product_id select2"
                        name="product_id[]"
                        id="product${rowIndex}"
                        required>
                        ${productOption}
                    </select>
                </td>

                <td>
                    <select
                        class="form-control unit_id"
                        name="unit_id[]"
                        id="unit${rowIndex}"
                        required>

                        ${unitOption}
                    </select>
                </td>


                <td>
                    <input
                        type="text"
                        class="form-control available_qty"
                        id="available${rowIndex}"
                        readonly>
                </td>

                <td>
                    <input
                        type="number"
                        class="form-control transfer_qty"
                        name="transfer_qty[]"
                        id="transfer${rowIndex}"
                        min="1"
                        value="1"
                        required>
                </td>

                <td>
                    <input
                        type="text"
                        class="form-control"
                        name="item_remark[]">
                </td>

                <td class="text-center">
                    <button
                        type="button"
                        class="btn btn-danger removeRow">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#items_table tbody').append(html);
        $('#items_table tbody tr:last .product_id').select2({
            width: '100%',
            placeholder: 'Search Product',
            allowClear: true

        });
        updateSlNo();
    });

    $(document).on('change','.product_id',
        function() {
            var row = $(this).closest('tr');
            var product_id = $(this).val();
            var warehouse_id = $('#from_warehouse_id').val();
            var store_id = $('#from_store_id').val();

            if (!product_id) {
                row.find('.available_qty').val('');
                row.find('.transfer_qty').removeAttr('max');
                return;
            }

            if (!warehouse_id) {
                alert(
                    'Please select From Warehouse first.'
                );

                $(this)
                    .val(null)
                    .trigger('change');
                return;
            }

            if (!store_id) {
                alert(
                    'Please select From Store first.'
                );
                $(this)
                    .val(null)
                    .trigger('change');
                return;
            }

            var duplicate = false;
            $('.product_id').each(function() {
                if (
                    this !== row.find('.product_id')[0] &&
                    $(this).val() == product_id &&
                    product_id != ''
                ) {
                    duplicate = true;
                }
            });


            if (duplicate) {
                alert(
                    'Product already added.'
                );
                row.find('.product_id')
                    .val(null)
                    .trigger('change');
                row.find('.unit_id').val('');
                row.find('.available_qty').val('');
                row.find('.transfer_qty')
                    .removeAttr('max');
                return;
            }

            getProductDetailsForEdit(
                row,
                product_id
            );

        }
    );

    function getProductDetailsForEdit(
        row,
        product_id
    ) {
        var warehouse_id = $('#from_warehouse_id').val();
        var store_id = $('#from_store_id').val();
        if (!warehouse_id || !store_id) {
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/Ajax/get_direct_issue_product_details'); ?>",
            type: "POST",
            data: {
                warehouse_id: warehouse_id,
                store_id: store_id,
                product_id: product_id
            },

            dataType: "json",
            success: function(res) {
                console.log('Product Details:',res);
                row.find('.unit_id').val(res.unit_id);
                row.find('.available_qty').val(res.available_stock);
                row.find('.transfer_qty').attr('max',res.available_stock);
            },

            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function updateSlNo() {
        $('#items_table tbody tr').each(function(index) {$(this).find('.slno').html(index + 1);});
    }


    $(document).on(
        'click',
        '.removeRow',
        function() {
            if (
                $('#items_table tbody tr').length <= 1
            ) {
                alert(
                    'At least one item is required.'
                );
                return;
            }
            $(this).closest('tr').remove();
            updateSlNo();
        }
    );


    function loadFromStores(
        editMode = false
    ) {
        var warehouse_id = $('#from_warehouse_id').val();
        var selectedStore =
            editMode ?
            "<?= $master->from_store_id; ?>" :
            '';

        if (!warehouse_id) {
            $('#from_store_id')
                .html(
                    '<option value="">-- Select Store --</option>'
                );
            return;
        }

        $('#from_store_id').html('<option value="">Loading...</option>');
        $.ajax({
            url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",
            type: "POST",
            data: {
                warehouse_id: warehouse_id
            },
            dataType: "json",
            success: function(res) {
                var html =
                    '<option value="">-- Select Store --</option>';

                $.each(
                    res,
                    function(i, row) {
                        var selected =
                            row.store_id == selectedStore ?
                            'selected' :
                            '';

                        html +=
                            '<option value="' +
                            row.store_id +
                            '" ' +
                            selected +
                            '>' +
                            row.store_name +
                            '</option>';
                    }
                );

                $('#from_store_id').html(html);
                $('.product_id').each(function() {
                    var product_id = $(this).val();
                    if (product_id) {
                        getProductDetailsForEdit($(this).closest('tr'),product_id);
                    }
                });
            }
        });
    }

    function loadToStores(
        editMode = false
    ) {
        var warehouse_id = $('#to_warehouse_id').val();
        var selectedStore = editMode ? "<?= $master->to_store_id; ?>" : '';

        if (!warehouse_id) {
            $('#to_store_id').html('<option value="">-- Select Store --</option>');
            return;
        }

        $('#to_store_id').html('<option value="">Loading...</option>');
        $.ajax({
            url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",
            type: "POST",
            data: {
                warehouse_id: warehouse_id
            },

            dataType: "json",
            success: function(res) {
                var html =
                    '<option value="">-- Select Store --</option>';
                $.each(
                    res,
                    function(i, row) {
                        var selected =
                            row.store_id == selectedStore ?
                            'selected' :
                            '';
                        html +=
                            '<option value="' +
                            row.store_id +
                            '" ' +
                            selected +
                            '>' +
                            row.store_name +
                            '</option>';
                    }
                );

                $('#to_store_id').html(html);
            }
        });
    }

    $('#to_store_id').change(function() {
        validateLocations();
    });

    $('#to_warehouse_id').change(function() {
        setTimeout(function() {
            validateLocations();
        }, 300);
    });

    $('#from_store_id').change(function() {
        $('.product_id').each(function() {
            var product_id = $(this).val();
            if (product_id) {
                getProductDetailsForEdit(
                    $(this).closest('tr'),
                    product_id
                );
            }
        });
    });

    function validateLocations() {
        var fromWarehouse = $('#from_warehouse_id').val();
        var toWarehouse = $('#to_warehouse_id').val();
        var fromStore = $('#from_store_id').val();
        var toStore = $('#to_store_id').val();

        if (
            fromWarehouse &&
            toWarehouse &&
            fromStore &&
            toStore &&
            fromWarehouse == toWarehouse &&
            fromStore == toStore
        ) {
            alert(
                'Source and Destination cannot be same.'
            );
            $('#to_store_id')
                .val('')
                .trigger('change');
        }
    }

    $(document).on(
        'keyup change',
        '.transfer_qty',
        function() {
            var row = $(this).closest('tr');
            var available = parseFloat(row.find('.available_qty').val()) || 0;
            var qty = parseFloat($(this).val()) || 0;
            if (qty <= 0) {
                $(this).val(1);
                return;
            }

            if (
                available > 0 &&
                qty > available
            ) {
                alert(
                    'Transfer Qty cannot exceed Available Qty.'
                );
                $(this).val(
                    available
                );
            }
        }
    );


    $('#transfer_form').submit(function(e) {
        if (
            $('#items_table tbody tr').length == 0
        ) {
            alert(
                'Please add at least one item.'
            );
            e.preventDefault();
            return;
        }

        var fromWarehouse = $('#from_warehouse_id').val();
        var fromStore = $('#from_store_id').val();
        var toWarehouse = $('#to_warehouse_id').val();
        var toStore = $('#to_store_id').val();

        if (
            fromWarehouse == toWarehouse &&
            fromStore == toStore
        ) {
            alert(
                'Source and Destination cannot be same.'
            );
            e.preventDefault();
            return;
        }

        var valid = true;

        $('.transfer_qty').each(function() {
            var qty = parseFloat($(this).val()) || 0;
            if (qty <= 0) {
                valid = false;
            }
        });

        if (!valid) {
            alert(
                'Transfer Qty should be greater than zero.'
            );
            e.preventDefault();
            return;
        }

        $('#saveBtn')
            .prop('disabled', true)
            .html(
                '<i class="fa fa-spinner fa-spin"></i> Updating...'
            );

    });
</script>