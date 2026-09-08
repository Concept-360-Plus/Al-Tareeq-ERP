<style>

    label {
        color: #000;
        font-weight: normal;
    }

    .x_panel {
        margin-bottom: 20px;
    }

    .location-title {
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 8px;
    }

    #transferItemsTable th,
    #transferItemsTable td {
        vertical-align: middle !important;
    }

    .qty-input {
        text-align: right;
    }

    .readonly-field {
        background: #f5f5f5;
    }

</style>


<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12">

        <div class="x_panel">

            <!--<div class="x_title">

                <h2>
                    <?= !empty($stock_transfer)
                        ? 'Edit Stock Transfer - FMT'
                        : 'Stock Transfer - FMT'
                    ?>
                </h2>

                <div class="clearfix"></div>

            </div>-->


            <div class="x_content">

                <?php if ($this->session->flashdata('success')): ?>

                    <div class="alert alert-success">

                        <?= $this->session->flashdata('success'); ?>

                    </div>

                <?php endif; ?>


                <?php if ($this->session->flashdata('error')): ?>

                    <div class="alert alert-danger">

                        <?= $this->session->flashdata('error'); ?>

                    </div>

                <?php endif; ?>

                <form method="post"
                    action="<?= base_url(
                        'index.php/Production/save_stock_transfer'
                    ) ?>"
                    id="stockTransferForm"
                >


                    <input
                        type="hidden"
                        name="stock_transfer_id"
                        value="<?= $stock_transfer['stock_transfer_id'] ?? '' ?>"
                    >

                    <div class="row">


                        <!-- Transfer Number -->

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Transfer No.
                                </label>

                                <input
                                    type="text"
                                    name="stock_transfer_no"
                                    class="form-control readonly-field"
                                    value="<?= $stock_transfer['stock_transfer_no']
                                        ?? $stock_transfer_no ?>"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- Date -->

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Date
                                </label>

                                <input
                                    type="date"
                                    name="ref_date"
                                    class="form-control"
                                    value="<?= !empty($stock_transfer['ref_date'])
                                        ? date(
                                            'Y-m-d',
                                            strtotime(
                                                $stock_transfer['ref_date']
                                            )
                                        )
                                        : date('Y-m-d')
                                    ?>"
                                    required
                                >

                            </div>

                        </div>


                        <!-- Reference Number -->

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Ref. Number
                                </label>

                                <input
                                    type="text"
                                    name="ref_number"
                                    class="form-control"
                                    value="<?= $stock_transfer['ref_number'] ?? '' ?>"
                                >

                            </div>

                        </div>


                        <!-- Status -->

                        <?php if (!empty($stock_transfer)): ?>

                            <div class="col-md-3">

                                <div class="form-group">

                                    <label>
                                        Status
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control readonly-field"
                                        value="<?= $stock_transfer['status'] ?>"
                                        readonly
                                    >

                                </div>

                            </div>

                        <?php endif; ?>


                    </div>

                    <div class="row">


                        <!-- Job Completion -->

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Job Completion No.
                                </label>

                                <select
                                    name="job_completion_id"
                                    id="job_completion_id"
                                    class="form-control"
                                    <?= !empty($stock_transfer)
                                        ? 'disabled'
                                        : ''
                                    ?>
                                    required
                                >

                                    <option value="">
                                        -- Select Job Completion --
                                    </option>


                                    <?php foreach (
                                        $job_completions
                                        as $jc
                                    ): ?>

                                        <option
                                            value="<?= $jc['job_completion_id'] ?>"
                                            <?= !empty($stock_transfer)
                                                && $stock_transfer['job_completion_id']
                                                == $jc['job_completion_id']
                                                ? 'selected'
                                                : ''
                                            ?>
                                        >

                                            <?= htmlspecialchars(
                                                $jc['job_completion_no']
                                            ) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>


                                <?php if (!empty($stock_transfer)): ?>

                                    <input
                                        type="hidden"
                                        name="job_completion_id"
                                        value="<?= $stock_transfer['job_completion_id'] ?>"
                                    >

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- Job Order -->

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Job Order No.
                                </label>

                                <input
                                    type="text"
                                    id="job_order_no"
                                    class="form-control readonly-field"
                                    value="<?= $stock_transfer['job_order_id'] ?? '' ?>"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- Sales Order -->

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Sales Order
                                </label>

                                <input
                                    type="text"
                                    id="sales_order_no"
                                    class="form-control readonly-field"
                                    readonly
                                >

                            </div>

                        </div>


                    </div>


                    <div class="row">


                        <!-- Project -->

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Project
                                </label>

                                <input
                                    type="text"
                                    id="project_name"
                                    class="form-control readonly-field"
                                    readonly
                                >

                            </div>

                        </div>


                    </div>



                    <div class="row">


                        <div class="col-md-6">

                            <div class="x_panel">

                                <div class="location-title">
                                    Location From
                                </div>


                                <!-- Branch -->

                                <div class="form-group">

                                    <label>
                                        Branch
                                    </label>

                                    <select
                                        name="from_branch_id"
                                        id="from_branch_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Select Branch --
                                        </option>

                                        <?php foreach (
                                            $branches
                                            as $branch
                                        ): ?>

                                            <option
                                                value="<?= $branch['branch_id'] ?>"
                                                <?= !empty($stock_transfer)
                                                    && $stock_transfer['from_branch_id']
                                                    == $branch['branch_id']
                                                    ? 'selected'
                                                    : ''
                                                ?>
                                            >

                                                <?= htmlspecialchars(
                                                    $branch['branch_name']
                                                ) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>


                                <!-- Warehouse -->

                                <div class="form-group">

                                    <label>
                                        Warehouse
                                    </label>

                                    <select
                                        name="from_warehouse_id"
                                        id="from_warehouse_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Select Warehouse --
                                        </option>

                                        <?php if (!empty($from_warehouses)): ?>

                                            <?php foreach (
                                                $from_warehouses
                                                as $warehouse
                                            ): ?>

                                                <option
                                                    value="<?= $warehouse['warehouse_id'] ?>"
                                                    <?= !empty($stock_transfer)
                                                        && $stock_transfer['from_warehouse_id']
                                                        == $warehouse['warehouse_id']
                                                        ? 'selected'
                                                        : ''
                                                    ?>
                                                >

                                                    <?= htmlspecialchars(
                                                        $warehouse['warehouse_name']
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>


                                <!-- Store -->

                                <div class="form-group">

                                    <label>
                                        Store
                                    </label>

                                    <select
                                        name="from_store_id"
                                        id="from_store_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Select Store --
                                        </option>

                                        <?php if (!empty($from_stores)): ?>

                                            <?php foreach (
                                                $from_stores
                                                as $store
                                            ): ?>

                                                <option
                                                    value="<?= $store['store_id'] ?>"
                                                    <?= !empty($stock_transfer)
                                                        && $stock_transfer['from_store_id']
                                                        == $store['store_id']
                                                        ? 'selected'
                                                        : ''
                                                    ?>
                                                >

                                                    <?= htmlspecialchars(
                                                        $store['store_name']
                                                    ) ?>

                                                    (<?= $store['store_type'] ?>)

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                        </div>


                        <!-- ==============================
                             TO
                        =============================== -->

                        <div class="col-md-6">

                            <div class="x_panel">

                                <div class="location-title">
                                    Location To
                                </div>


                                <!-- Branch -->

                                <div class="form-group">

                                    <label>
                                        Branch
                                    </label>

                                    <select
                                        name="to_branch_id"
                                        id="to_branch_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Select Branch --
                                        </option>

                                        <?php foreach (
                                            $branches
                                            as $branch
                                        ): ?>

                                            <option
                                                value="<?= $branch['branch_id'] ?>"
                                                <?= !empty($stock_transfer)
                                                    && $stock_transfer['to_branch_id']
                                                    == $branch['branch_id']
                                                    ? 'selected'
                                                    : ''
                                                ?>
                                            >

                                                <?= htmlspecialchars(
                                                    $branch['branch_name']
                                                ) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>


                                <!-- Warehouse -->

                                <div class="form-group">

                                    <label>
                                        Warehouse
                                    </label>

                                    <select
                                        name="to_warehouse_id"
                                        id="to_warehouse_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Select Warehouse --
                                        </option>

                                        <?php if (!empty($to_warehouses)): ?>

                                            <?php foreach (
                                                $to_warehouses
                                                as $warehouse
                                            ): ?>

                                                <option
                                                    value="<?= $warehouse['warehouse_id'] ?>"
                                                    <?= !empty($stock_transfer)
                                                        && $stock_transfer['to_warehouse_id']
                                                        == $warehouse['warehouse_id']
                                                        ? 'selected'
                                                        : ''
                                                    ?>
                                                >

                                                    <?= htmlspecialchars(
                                                        $warehouse['warehouse_name']
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>


                                <!-- Store -->

                                <div class="form-group">

                                    <label>
                                        Store
                                    </label>

                                    <select
                                        name="to_store_id"
                                        id="to_store_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Select Store --
                                        </option>

                                        <?php if (!empty($to_stores)): ?>

                                            <?php foreach (
                                                $to_stores
                                                as $store
                                            ): ?>

                                                <option
                                                    value="<?= $store['store_id'] ?>"
                                                    <?= !empty($stock_transfer)
                                                        && $stock_transfer['to_store_id']
                                                        == $store['store_id']
                                                        ? 'selected'
                                                        : ''
                                                    ?>
                                                >

                                                    <?= htmlspecialchars(
                                                        $store['store_name']
                                                    ) ?>

                                                    (<?= $store['store_type'] ?>)

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         ITEMS
                    ================================================== -->

                    <h4>
                        Completed Items
                    </h4>


                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped"
                            id="transferItemsTable"
                        >

                            <thead>

                               <tr>

                                <th width="5%">#</th>

                                <th>Item Code</th>

                                <th>Item Description</th>

                                <th>Unit</th>

                                <th class="text-right">
                                    Completed Qty
                                </th>

                                <th class="text-right">
                                    Transfer Qty
                                </th>

                            </tr>

                            </thead>


                            <tbody>
                                <?php if (!empty($stock_transfer_items)): ?>
                                    <?php foreach ($stock_transfer_items as $i => $item ): ?>
                                        <?php
                                        $is_new_item = !empty($item['is_new_item']);

                                        if (!$is_new_item) {

                                            $transfer_qty = (float)$item['transfer_quantity'];
                                            $max_qty = (float)$item['remaining_quantity']+ $transfer_qty;
                                        }
                                        /*
                                        * Newly completed item
                                        */
                                        else {

                                            $transfer_qty = 0;

                                            $max_qty =
                                                (float)$item['remaining_quantity'];
                                        }

                                        ?>


                                        <tr
                                            <?= $is_new_item
                                                ? 'class="new-completed-item"'
                                                : ''
                                            ?>
                                        >
                                            <td>
                                                <?= $i + 1 ?>
                                            </td>
                                            <td>

                                                <?= htmlspecialchars(
                                                    $item['item_code']
                                                    ?: $item['master_product_code']
                                                    ?: $item['product_code']
                                                    ?: ''
                                                ) ?>

                                                <input
                                                    type="hidden"
                                                    name="job_completion_item_id[]"
                                                    value="<?= $item['job_completion_item_id'] ?>"
                                                >

                                            </td>


                                            <!-- DESCRIPTION -->

                                            <td>
                                                <?php echo htmlspecialchars($item['master_product_name'] ?? $item['product_name']); ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($item['unit_abbr'] ?: $item['unit'] ?: '' ) ?>

                                            </td>
                                            <td class="text-right">

                                                <?= number_format(
                                                    $item['completed_quantity'],
                                                    2
                                                ) ?>

                                            </td>
                                            <td>

                                                <input type="number" name="transfer_quantity[]" class="form-control qty-input"  min="0"  max="<?= number_format(
                                                        $max_qty,
                                                        2,
                                                        '.',
                                                        ''
                                                    ) ?>"
                                                    step="0.01"
                                                    value="<?= number_format(
                                                        $transfer_qty,
                                                        2,
                                                        '.',
                                                        ''
                                                    ) ?>"
                                                    required
                                                >

                                            </td>

                                        </tr>


                                    <?php endforeach; ?>


                                <?php else: ?>

                                    <tr id="noItemsRow">

                                        <td
                                            colspan="6"
                                            class="text-center"
                                        >

                                            No completed items available.

                                        </td>

                                    </tr>

                                <?php endif; ?>
                            </tbody>

                        </table>

                    </div>


                    <!-- =================================================
                         REMARKS
                    ================================================== -->

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Remarks
                                </label>

                                <textarea
                                    name="remarks"
                                    class="form-control"
                                    rows="3"
                                ><?= $stock_transfer['remarks'] ?? '' ?></textarea>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         BUTTONS
                    ================================================== -->

                    <div class="text-right">

                        <button
                            type="submit"
                            class="btn btn-success"
                        >

                            <i class="fa fa-save"></i>

                            <?= !empty($stock_transfer)
                                ? 'Update'
                                : 'Save'
                            ?>

                        </button>


                        <a
                            href="<?= base_url(
                                'index.php/Production/stock_transfers'
                            ) ?>"
                            class="btn btn-secondary"
                        >

                            Cancel

                        </a>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>
<script>

$(document).ready(function () {


    /* =========================================================
     * LOAD WAREHOUSES
     * ========================================================= */

    function loadWarehouses(
        branchId,
        warehouseSelect,
        storeSelect
    ) {

        $(warehouseSelect).html(
            '<option value="">Loading...</option>'
        );

        $(storeSelect).html(
            '<option value="">-- Select Store --</option>'
        );


        if (!branchId) {

            $(warehouseSelect).html(
                '<option value="">-- Select Warehouse --</option>'
            );

            return;
        }


        $.ajax({

            url:
                "<?= base_url(
                    'index.php/Production/get_warehouses'
                ) ?>",

            type: "POST",

            data: {
                branch_id: branchId
            },

            dataType: "json",

            success: function (response) {

                var html =
                    '<option value="">-- Select Warehouse --</option>';


                $.each(
                    response,
                    function (i, row) {

                        html +=
                            '<option value="' +
                            row.warehouse_id +
                            '">' +
                            $('<div>')
                                .text(
                                    row.warehouse_name
                                )
                                .html() +
                            '</option>';

                    }
                );


                $(warehouseSelect).html(html);
            },

            error: function () {

                $(warehouseSelect).html(
                    '<option value="">Unable to load</option>'
                );

            }

        });

    }


    /* =========================================================
     * LOAD STORES
     * ========================================================= */

    function loadStores(
        warehouseId,
        storeSelect
    ) {

        $(storeSelect).html(
            '<option value="">Loading...</option>'
        );


        if (!warehouseId) {

            $(storeSelect).html(
                '<option value="">-- Select Store --</option>'
            );

            return;
        }


        $.ajax({

            url:
                "<?= base_url(
                    'index.php/Production/get_stores'
                ) ?>",

            type: "POST",

            data: {
                warehouse_id: warehouseId
            },

            dataType: "json",

            success: function (response) {

                var html =
                    '<option value="">-- Select Store --</option>';


                $.each(
                    response,
                    function (i, row) {

                        html +=
                            '<option value="' +
                            row.store_id +
                            '">' +
                            $('<div>')
                                .text(
                                    row.store_name
                                )
                                .html() +
                            ' (' +
                            $('<div>')
                                .text(
                                    row.store_type
                                )
                                .html() +
                            ')' +
                            '</option>';

                    }
                );


                $(storeSelect).html(html);
            },

            error: function () {

                $(storeSelect).html(
                    '<option value="">Unable to load</option>'
                );

            }

        });

    }


    /* =========================================================
     * FROM BRANCH
     * ========================================================= */

    $('#from_branch_id').on(
        'change',
        function () {

            loadWarehouses(
                $(this).val(),
                '#from_warehouse_id',
                '#from_store_id'
            );

        }
    );


    /* =========================================================
     * FROM WAREHOUSE
     * ========================================================= */

    $('#from_warehouse_id').on(
        'change',
        function () {

            loadStores(
                $(this).val(),
                '#from_store_id'
            );

        }
    );


    /* =========================================================
     * TO BRANCH
     * ========================================================= */

    $('#to_branch_id').on(
        'change',
        function () {

            loadWarehouses(
                $(this).val(),
                '#to_warehouse_id',
                '#to_store_id'
            );

        }
    );


    /* =========================================================
     * TO WAREHOUSE
     * ========================================================= */

    $('#to_warehouse_id').on(
        'change',
        function () {

            loadStores(
                $(this).val(),
                '#to_store_id'
            );

        }
    );


    /* =========================================================
     * JOB COMPLETION
     * ========================================================= */

    $('#job_completion_id').on(
        'change',
        function () {

            var jobCompletionId =
                $(this).val();


            if (!jobCompletionId) {

                clearCompletionData();

                return;
            }


            $.ajax({

                url:
                    "<?= base_url(
                        'index.php/Production/get_job_completion_for_transfer'
                    ) ?>",

                type: "POST",

                data: {
                    job_completion_id:
                        jobCompletionId
                },

                dataType: "json",

                beforeSend: function () {

                    $('#transferItemsTable tbody')
                        .html(
                            '<tr>' +
                            '<td colspan="8" ' +
                            'class="text-center">' +
                            '<i class="fa fa-spinner fa-spin"></i> ' +
                            'Loading...' +
                            '</td>' +
                            '</tr>'
                        );

                },

                success: function (response) {

                    if (!response.status) {

                        alert(
                            response.message
                            ||
                            'No items available.'
                        );

                        clearCompletionData();

                        return;
                    }


                    /* -----------------------------------------
                     * HEADER
                     * -------------------------------------- */

                    var header =
                        response.header;


                    $('#job_order_no').val(
                        header.job_order_no
                    );


                    $('#sales_order_no').val(
                        header.so_id
                            ? 'SO-' + header.so_id
                            : ''
                    );


                    $('#project_name').val(
                        header.project_name
                            || ''
                    );


                    /* -----------------------------------------
                     * ITEMS
                     * -------------------------------------- */
                 

var html = '';

$.each(
    response.items,
    function (i, item) {

        var completedQty =
            parseFloat(
                item.completed_quantity
            ) || 0;

        html +=
            '<tr>' +

            /* # */
            '<td>' +
            (i + 1) +
            '</td>' +

            /* ITEM CODE */
            '<td>' +

            $('<div>')
                .text(
                    item.item_code ||
                    item.product_code ||
                    ''
                )
                .html() +

            '<input type="hidden" ' +
            'name="job_completion_item_id[]" ' +
            'value="' +
            item.job_completion_item_id +
            '">' +

            '</td>' +

            /* DESCRIPTION */
            '<td>' +

            $('<div>')
                .text(
                    item.item_description ||
                    item.product_name ||
                    ''
                )
                .html() +

            '</td>' +

            /* UNIT */
            '<td>' +

            $('<div>')
                .text(
                    item.unit_abbr ||
                    ''
                )
                .html() +

            '</td>' +

            /* COMPLETED QTY */
            '<td class="text-right">' +

            completedQty.toFixed(2) +

            '</td>' +

            /* TRANSFER QTY */
            '<td>' +

            '<input type="number" ' +
            'name="transfer_quantity[]" ' +
            'class="form-control qty-input" ' +
            'min="0" ' +
            'max="' +
            completedQty +
            '" ' +
            'step="0.01" ' +
            'value="' +
            completedQty +
            '" ' +
            'required>' +

            '</td>' +

            '</tr>';
    }
);

$('#transferItemsTable tbody').html(html);

                },

                error: function () {

                    alert(
                        'Unable to load Job Completion.'
                    );

                    clearCompletionData();

                }

            });

        }
    );


    /* =========================================================
     * CLEAR
     * ========================================================= */

    function clearCompletionData()
    {

        $('#job_order_no').val('');
        $('#sales_order_no').val('');
        $('#project_name').val('');


        $('#transferItemsTable tbody')
            .html(
                '<tr>' +
                '<td colspan="8" ' +
                'class="text-center">' +
                'Select a Job Completion ' +
                'to load completed items.' +
                '</td>' +
                '</tr>'
            );
    }


    /* =========================================================
     * VALIDATE QUANTITY
     * ========================================================= */

    $(document).on(
        'input',
        '.qty-input',
        function () {

            var max =
                parseFloat(
                    $(this).attr('max')
                ) || 0;

            var value =
                parseFloat(
                    $(this).val()
                ) || 0;


            if (value > max) {

                $(this).val(max);

                alert(
                    'Transfer quantity cannot exceed ' +
                    max.toFixed(2)
                );

            }


            if (value < 0) {

                $(this).val(0);

            }

        }
    );


    /* =========================================================
     * FORM VALIDATION
     * ========================================================= */

    $('#stockTransferForm').on(
        'submit',
        function (e) {

            var valid = true;


            $('.qty-input').each(
                function () {

                    var qty =
                        parseFloat(
                            $(this).val()
                        ) || 0;

                    var max =
                        parseFloat(
                            $(this).attr('max')
                        ) || 0;


                    if (
                        qty <= 0 ||
                        qty > max
                    ) {

                        valid = false;

                        $(this).focus();

                        return false;
                    }

                }
            );


            if (!valid) {

                e.preventDefault();

                alert(
                    'Please enter valid transfer quantities.'
                );

                return false;
            }


            if (
                $('#from_store_id').val()
                ==
                $('#to_store_id').val()
                &&
                $('#from_store_id').val() != ''
            ) {

                e.preventDefault();

                alert(
                    'From Store and To Store cannot be the same.'
                );

                return false;
            }

        }
    );


    /* =========================================================
     * EDIT PAGE - LOAD HEADER INFORMATION
     * ========================================================= */

    <?php if (!empty($stock_transfer)): ?>

        var editJobCompletion =
            $('#job_completion_id').val();


        if (editJobCompletion) {

            $.ajax({

                url:
                    "<?= base_url(
                        'index.php/Production/get_job_completion_for_transfer'
                    ) ?>",

                type: "POST",

                data: {
                    job_completion_id:
                        editJobCompletion
                },

                dataType: "json",

                success: function (response) {

                    if (!response.status) {
                        return;
                    }


                    var header =
                        response.header;


                    $('#job_order_no').val(
                        header.job_order_no
                    );


                    $('#sales_order_no').val(
                        header.so_id
                            ? 'SO-' + header.so_id
                            : ''
                    );


                    $('#project_name').val(
                        header.project_name
                            || ''
                    );

                }

            });

        }

    <?php endif; ?>


});
</script>