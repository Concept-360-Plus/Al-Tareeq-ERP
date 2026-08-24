<div class="content-wrapper">

    <section class="content">

        <div class="card">

            <div class="card-body">

                <form
                    id="main"
                    method="post"
                    action="<?php echo base_url('index.php/Reports/get_stock_transfer_report'); ?>"
                    autocomplete="off">

                    <!-- =========================
                         ROW 1
                    ========================== -->

                    <div class="row">

                        <!-- FROM DATE -->
                        <div class="col-md-3">

                            <label>From Date</label>

                            <input
                                type="date"
                                name="from_date"
                                id="from_date"
                                class="form-control"
                                value="<?php
                                        echo isset($from_date)
                                            ? html_escape($from_date)
                                            : date('Y-m-01');
                                        ?>">

                        </div>


                        <!-- TO DATE -->
                        <div class="col-md-3">

                            <label>To Date</label>

                            <input
                                type="date"
                                name="to_date"
                                id="to_date"
                                class="form-control"
                                value="<?php
                                        echo isset($to_date)
                                            ? html_escape($to_date)
                                            : date('Y-m-d');
                                        ?>">

                        </div>


                        <!-- FROM WAREHOUSE -->
                        <div class="col-md-3">

                            <label>From Warehouse</label>

                            <select
                                name="from_warehouse_id"
                                id="from_warehouse_id"
                                class="form-control select2">

                                <option value="">
                                    All Warehouses
                                </option>

                                <?php if (!empty($warehouse_records)) { ?>

                                    <?php foreach ($warehouse_records as $warehouse) { ?>

                                        <option
                                            value="<?php echo $warehouse->warehouse_id; ?>"
                                            <?php
                                            echo (
                                                isset($from_warehouse_id) &&
                                                $from_warehouse_id == $warehouse->warehouse_id
                                            )
                                                ? 'selected'
                                                : '';
                                            ?>>

                                            <?php
                                            echo html_escape(
                                                $warehouse->warehouse_name
                                            );
                                            ?>

                                        </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- TO WAREHOUSE -->
                        <div class="col-md-3">

                            <label>To Warehouse</label>

                            <select
                                name="to_warehouse_id"
                                id="to_warehouse_id"
                                class="form-control select2">

                                <option value="">
                                    All Warehouses
                                </option>

                                <?php if (!empty($warehouse_records)) { ?>

                                    <?php foreach ($warehouse_records as $warehouse) { ?>

                                        <option
                                            value="<?php echo $warehouse->warehouse_id; ?>"
                                            <?php
                                            echo (
                                                isset($to_warehouse_id) &&
                                                $to_warehouse_id == $warehouse->warehouse_id
                                            )
                                                ? 'selected'
                                                : '';
                                            ?>>

                                            <?php
                                            echo html_escape(
                                                $warehouse->warehouse_name
                                            );
                                            ?>

                                        </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>

                        </div>

                    </div>


                    <!-- =========================
                         ROW 2
                    ========================== -->

                    <div class="row mt-3">

                        <!-- FROM STORE -->
                        <div class="col-md-3">

                            <label>From Store</label>

                            <select
                                name="from_store_id"
                                id="from_store_id"
                                class="form-control select2">

                                <option value="">
                                    All Stores
                                </option>

                            </select>

                        </div>


                        <!-- TO STORE -->
                        <div class="col-md-3">

                            <label>To Store</label>

                            <select
                                name="to_store_id"
                                id="to_store_id"
                                class="form-control select2">

                                <option value="">
                                    All Stores
                                </option>

                            </select>

                        </div>


                        <!-- PRODUCT -->
                        <div class="col-md-3">

                            <label>Product</label>

                            <select
                                name="product_id"
                                id="product_id"
                                class="form-control select2">

                                <option value="">
                                    All Products
                                </option>

                                <?php if (!empty($products)) { ?>

                                    <?php foreach ($products as $product) { ?>

                                        <option
                                            value="<?php echo $product->product_id; ?>"
                                            <?php
                                            echo (
                                                isset($product_id) &&
                                                $product_id == $product->product_id
                                            )
                                                ? 'selected'
                                                : '';
                                            ?>>

                                            <?php
                                            echo html_escape(
                                                $product->product_code .
                                                    ' - ' .
                                                    $product->product_name
                                            );
                                            ?>

                                        </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- STATUS -->
                        <div class="col-md-3">

                            <label>Status</label>

                            <select
                                name="status"
                                id="status"
                                class="form-control select2">

                                <option value="">
                                    All
                                </option>

                                <option
                                    value="0"
                                    <?php
                                    echo (
                                        isset($status) &&
                                        (string)$status === '0'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>

                                    Pending

                                </option>

                                <option
                                    value="1"
                                    <?php
                                    echo (
                                        isset($status) &&
                                        (string)$status === '1'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>

                                    Completed

                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- =========================
                         BUTTONS
                    ========================== -->

                    <div class="row mt-3">

                        <div class="col-md-12">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="fa fa-search"></i>
                                Go

                            </button>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-warning"
                                onclick="printStockTransferReport(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportStockTransferExcel(event)"
                                style="color:#fff;">

                                <i class="fa fa-file-excel-o"></i>
                                Export to Excel

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- =========================
             REPORT TABLE
        ========================== -->

        <?php if (isset($records)) { ?>

            <div class="card mt-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>Sl No</th>

                                    <th>Transfer No</th>

                                    <th>Transfer Date</th>

                                    <th>From Warehouse</th>

                                    <th>From Store</th>

                                    <th>To Warehouse</th>

                                    <th>To Store</th>

                                    <th>Stock Code</th>

                                    <th>Product Name</th>

                                    <th>Unit</th>

                                    <th class="text-right">
                                        Available Qty
                                    </th>

                                    <th class="text-right">
                                        Transfer Qty
                                    </th>

                                    <th>Status</th>

                                    <th>Created By</th>

                                    <th>Remarks</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $total_transfer_qty = 0;

                                ?>


                                <?php if (!empty($records)) { ?>

                                    <?php $i = 1; ?>


                                    <?php foreach ($records as $row) { ?>

                                        <?php

                                        $available_qty =
                                            isset($row->available_qty)
                                            ? (float)$row->available_qty
                                            : 0;

                                        $transfer_qty =
                                            isset($row->transfer_qty)
                                            ? (float)$row->transfer_qty
                                            : 0;

                                        $total_transfer_qty +=
                                            $transfer_qty;

                                        ?>


                                        <tr>

                                            <!-- SL NO -->

                                            <td>
                                                <?php echo $i++; ?>
                                            </td>


                                            <!-- TRANSFER NO -->

                                            <td>

                                                <?php
                                                echo !empty($row->transfer_code)
                                                    ? html_escape(
                                                        $row->transfer_code
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- DATE -->

                                            <td>

                                                <?php
                                                echo !empty($row->transfer_date)
                                                    ? date(
                                                        'd-m-Y',
                                                        strtotime(
                                                            $row->transfer_date
                                                        )
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- FROM WAREHOUSE -->

                                            <td>

                                                <?php
                                                echo !empty($row->from_warehouse)
                                                    ? html_escape(
                                                        $row->from_warehouse
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- FROM STORE -->

                                            <td>

                                                <?php
                                                echo !empty($row->from_store)
                                                    ? html_escape(
                                                        $row->from_store
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- TO WAREHOUSE -->

                                            <td>

                                                <?php
                                                echo !empty($row->to_warehouse)
                                                    ? html_escape(
                                                        $row->to_warehouse
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- TO STORE -->

                                            <td>

                                                <?php
                                                echo !empty($row->to_store)
                                                    ? html_escape(
                                                        $row->to_store
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- STOCK CODE -->

                                            <td>

                                                <?php
                                                echo !empty($row->product_code)
                                                    ? html_escape(
                                                        $row->product_code
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- PRODUCT -->

                                            <td>

                                                <?php
                                                echo !empty($row->product_name)
                                                    ? html_escape(
                                                        $row->product_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- UNIT -->

                                            <td>

                                                <?php
                                                echo !empty($row->unit_name)
                                                    ? html_escape(
                                                        $row->unit_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- AVAILABLE QTY -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $available_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- TRANSFER QTY -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $transfer_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- STATUS -->

                                            <td>

                                                <?php

                                                $status_value =
                                                    isset($row->status)
                                                    ? (string)$row->status
                                                    : '';

                                                if ($status_value === '1') {

                                                ?>

                                                    <span
                                                        class="badge badge-success">

                                                        Completed

                                                    </span>

                                                <?php

                                                } elseif ($status_value === '0') {

                                                ?>

                                                    <span
                                                        class="badge badge-warning">

                                                        Pending

                                                    </span>

                                                <?php

                                                } else {

                                                ?>

                                                    <span
                                                        class="badge badge-secondary">

                                                        <?php
                                                        echo !empty($row->status)
                                                            ? html_escape(
                                                                $row->status
                                                            )
                                                            : '-';
                                                        ?>

                                                    </span>

                                                <?php } ?>

                                            </td>


                                            <!-- CREATED BY -->

                                            <td>

                                                <?php
                                                echo !empty($row->created_user)
                                                    ? html_escape(
                                                        $row->created_user
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- REMARKS -->

                                            <td>

                                                <?php

                                                $remarks = '';

                                                if (
                                                    !empty($row->remarks)
                                                ) {

                                                    $remarks =
                                                        $row->remarks;
                                                } elseif (
                                                    !empty($row->item_remarks)
                                                ) {

                                                    $remarks =
                                                        $row->item_remarks;
                                                }

                                                echo !empty($remarks)
                                                    ? html_escape(
                                                        $remarks
                                                    )
                                                    : '-';

                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>


                                    <!-- TOTAL -->

                                    <tr
                                        style="font-weight:bold;">

                                        <td
                                            colspan="11"
                                            class="text-right">

                                            Total Transfer Quantity

                                        </td>

                                        <td
                                            class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_transfer_qty,
                                                2
                                            );
                                            ?>

                                        </td>

                                        <td colspan="3"></td>

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="15"
                                            class="text-center">

                                            No Stock Transfer
                                            records found.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <tfoot>

                                <tr>

                                    <th>Sl No</th>

                                    <th>Transfer No</th>

                                    <th>Transfer Date</th>

                                    <th>From Warehouse</th>

                                    <th>From Store</th>

                                    <th>To Warehouse</th>

                                    <th>To Store</th>

                                    <th>Stock Code</th>

                                    <th>Product Name</th>

                                    <th>Unit</th>

                                    <th>Available Qty</th>

                                    <th>Transfer Qty</th>

                                    <th>Status</th>

                                    <th>Created By</th>

                                    <th>Remarks</th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

        <?php } ?>

    </section>

</div>


<script>
    // =====================================================
    // PRINT
    // =====================================================

    function printStockTransferReport(event) {

        if (event) {
            event.preventDefault();
        }


        const fromDate =
            document.querySelector(
                'input[name="from_date"]'
            ).value;


        const toDate =
            document.querySelector(
                'input[name="to_date"]'
            ).value;


        const fromWarehouseId =
            document.querySelector(
                'select[name="from_warehouse_id"]'
            ).value;


        const fromStoreId =
            document.querySelector(
                'select[name="from_store_id"]'
            ).value;


        const toWarehouseId =
            document.querySelector(
                'select[name="to_warehouse_id"]'
            ).value;


        const toStoreId =
            document.querySelector(
                'select[name="to_store_id"]'
            ).value;


        const productId =
            document.querySelector(
                'select[name="product_id"]'
            ).value;


        const status =
            document.querySelector(
                'select[name="status"]'
            ).value;


        const baseUrl =
            "<?php echo base_url('index.php/Reports/print_stock_transfer_report'); ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                from_warehouse_id: fromWarehouseId,

                from_store_id: fromStoreId,

                to_warehouse_id: toWarehouseId,

                to_store_id: toStoreId,

                product_id: productId,

                status: status

            });


        window.open(
            baseUrl +
            "?" +
            params.toString(),
            '_blank'
        );


        return false;
    }


    // =====================================================
    // EXCEL
    // =====================================================

    function exportStockTransferExcel(event) {

        if (event) {
            event.preventDefault();
        }


        const fromDate =
            document.querySelector(
                'input[name="from_date"]'
            ).value;


        const toDate =
            document.querySelector(
                'input[name="to_date"]'
            ).value;


        const fromWarehouseId =
            document.querySelector(
                'select[name="from_warehouse_id"]'
            ).value;


        const fromStoreId =
            document.querySelector(
                'select[name="from_store_id"]'
            ).value;


        const toWarehouseId =
            document.querySelector(
                'select[name="to_warehouse_id"]'
            ).value;


        const toStoreId =
            document.querySelector(
                'select[name="to_store_id"]'
            ).value;


        const productId =
            document.querySelector(
                'select[name="product_id"]'
            ).value;


        const status =
            document.querySelector(
                'select[name="status"]'
            ).value;


        const baseUrl =
            "<?php echo base_url('index.php/Reports/export_stock_transfer_excel'); ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                from_warehouse_id: fromWarehouseId,

                from_store_id: fromStoreId,

                to_warehouse_id: toWarehouseId,

                to_store_id: toStoreId,

                product_id: productId,

                status: status

            });


        window.location.href =
            baseUrl +
            "?" +
            params.toString();


        return false;
    }


    // =====================================================
    // SELECT2
    // =====================================================

    $(document).ready(function() {

        $('.select2').select2();

    });


    // =====================================================
    // LOAD FROM STORE
    // =====================================================

    function loadFromStores() {

        var warehouse_id =
            $('#from_warehouse_id').val();

        var selectedStore =
            "<?php
                echo isset($from_store_id)
                    ? $from_store_id
                    : '';
                ?>";


        $('#from_store_id').html(
            '<option value="">Loading...</option>'
        );


        if (warehouse_id === '') {

            $('#from_store_id').html(
                '<option value="">All Stores</option>'
            );

            $('#from_store_id')
                .trigger('change.select2');

            return;
        }


        $.ajax({

            url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",

            type: "POST",

            data: {
                warehouse_id: warehouse_id
            },

            dataType: "json",

            success: function(result) {

                var html =
                    '<option value="">All Stores</option>';


                $.each(
                    result,
                    function(i, row) {

                        var selected =
                            (
                                row.store_id ==
                                selectedStore
                            ) ?
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


                $('#from_store_id')
                    .html(html);


                $('#from_store_id')
                    .trigger('change.select2');

            },

            error: function() {

                $('#from_store_id').html(
                    '<option value="">All Stores</option>'
                );

            }

        });

    }


    // =====================================================
    // LOAD TO STORE
    // =====================================================

    function loadToStores() {

        var warehouse_id =
            $('#to_warehouse_id').val();

        var selectedStore =
            "<?php
                echo isset($to_store_id)
                    ? $to_store_id
                    : '';
                ?>";


        $('#to_store_id').html(
            '<option value="">Loading...</option>'
        );


        if (warehouse_id === '') {

            $('#to_store_id').html(
                '<option value="">All Stores</option>'
            );

            $('#to_store_id')
                .trigger('change.select2');

            return;
        }


        $.ajax({

            url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",

            type: "POST",

            data: {
                warehouse_id: warehouse_id
            },

            dataType: "json",

            success: function(result) {

                var html =
                    '<option value="">All Stores</option>';


                $.each(
                    result,
                    function(i, row) {

                        var selected =
                            (
                                row.store_id ==
                                selectedStore
                            ) ?
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


                $('#to_store_id')
                    .html(html);


                $('#to_store_id')
                    .trigger('change.select2');

            },

            error: function() {

                $('#to_store_id').html(
                    '<option value="">All Stores</option>'
                );

            }

        });

    }


    // =====================================================
    // WAREHOUSE CHANGE
    // =====================================================

    $(document).ready(function() {

        $('#from_warehouse_id').change(
            function() {

                loadFromStores();

            }
        );


        $('#to_warehouse_id').change(
            function() {

                loadToStores();

            }
        );


        // Load selected stores on page load

        if (
            $('#from_warehouse_id').val() !== ''
        ) {

            loadFromStores();

        }


        if (
            $('#to_warehouse_id').val() !== ''
        ) {

            loadToStores();

        }

    });
</script>