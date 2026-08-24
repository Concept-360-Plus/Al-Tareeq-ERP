<div class="content-wrapper">

    <section class="content">

        <div class="card">

            <div class="card-body">

                <form
                    id="main"
                    method="post"
                    action="<?php echo base_url('index.php/Reports/get_stock_adjustment_report'); ?>"
                    autocomplete="off">

                    <div class="row">

                        <!-- FROM DATE -->
                        <div class="col-md-3">

                            <label>From Date</label>

                            <input
                                type="date"
                                name="from_date"
                                id="from_date"
                                class="form-control"
                                value="<?php echo isset($from) ? html_escape($from) : date('Y-m-01'); ?>">

                        </div>


                        <!-- TO DATE -->
                        <div class="col-md-3">

                            <label>To Date</label>

                            <input
                                type="date"
                                name="to_date"
                                id="to_date"
                                class="form-control"
                                value="<?php echo isset($to) ? html_escape($to) : date('Y-m-d'); ?>">

                        </div>


                        <!-- WAREHOUSE -->
                        <div class="col-md-3">

                            <label>Warehouse</label>

                            <select
                                name="warehouse_id"
                                id="warehouse_id"
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
                                                isset($warehouse_id) &&
                                                $warehouse_id == $warehouse->warehouse_id
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
                                                    ' ' .
                                                    $product->product_name
                                            );
                                            ?>

                                        </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>

                        </div>

                    </div>


                    <div class="row mt-3">

                        <!-- STORE -->
                        <div class="col-md-3">

                            <label>Store</label>

                            <select
                                name="store_id"
                                id="store_id"
                                class="form-control select2">

                                <option value="">
                                    All Stores
                                </option>

                                <?php
                                /*
                                 * If your Setup_model already has a store
                                 * dropdown method, populate it here.
                                 *
                                 * Otherwise the report can initially work
                                 * with All Stores.
                                 */
                                ?>

                            </select>

                        </div>


                        <!-- ADJUSTMENT TYPE -->
                        <div class="col-md-3">

                            <label>Adjustment Type</label>

                            <select
                                name="adjustment_type"
                                id="adjustment_type"
                                class="form-control select2">

                                <option value="">
                                    All
                                </option>

                                <option
                                    value="IN"
                                    <?php
                                    echo (
                                        isset($adjustment_type) &&
                                        $adjustment_type == 'IN'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>

                                    Increase

                                </option>

                                <option
                                    value="OUT"
                                    <?php
                                    echo (
                                        isset($adjustment_type) &&
                                        $adjustment_type == 'OUT'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>

                                    Decrease

                                </option>

                            </select>

                        </div>

                        <div class="col-md-6"></div>

                    </div>


                    <!-- BUTTONS -->

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
                                onclick="printStockAdjustmentReport(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportStockAdjustmentExcel(event)"
                                style="color:#fff;">

                                <i class="fa fa-file-excel-o"></i>
                                Export to Excel

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- REPORT TABLE -->

        <?php if (isset($records)) { ?>

            <div class="card mt-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>Sl No</th>

                                    <th>Adjustment No</th>

                                    <th>Adjustment Date</th>

                                    <th>Adjustment Type</th>

                                    <th>Stock Code</th>

                                    <th>Product Name</th>

                                    <th>Warehouse</th>

                                    <th>Store</th>

                                    <th class="text-right">
                                        Quantity
                                    </th>

                                    <th class="text-right">
                                        Unit Price
                                    </th>

                                    <th class="text-right">
                                        Adjustment Value
                                    </th>

                                    <th>Created By</th>

                                    <th>Remarks</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $total_quantity = 0;
                                $total_value = 0;

                                ?>


                                <?php if (!empty($records)) { ?>

                                    <?php $i = 1; ?>

                                    <?php foreach ($records as $row) { ?>

                                        <?php

                                        $quantity =
                                            isset($row->quantity)
                                            ? (float)$row->quantity
                                            : 0;

                                        $price =
                                            isset($row->price)
                                            ? (float)$row->price
                                            : 0;

                                        $stock_value =
                                            isset($row->stock_value)
                                            ? (float)$row->stock_value
                                            : ($quantity * $price);

                                        $total_quantity +=
                                            $quantity;

                                        $total_value +=
                                            $stock_value;

                                        ?>


                                        <tr>

                                            <td>
                                                <?php echo $i++; ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo !empty($row->adjustment_code)
                                                    ? html_escape($row->adjustment_code)
                                                    : '-';
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo !empty($row->stock_date)
                                                    ? date(
                                                        'd-m-Y',
                                                        strtotime($row->stock_date)
                                                    )
                                                    : '-';
                                                ?>
                                            </td>


                                            <td>

                                                <?php
                                                if (
                                                    strtoupper($row->adjustment_type) == 'IN'
                                                ) {
                                                ?>

                                                    <span
                                                        class="badge badge-success">

                                                        Increase

                                                    </span>

                                                <?php
                                                } elseif (
                                                    strtoupper($row->adjustment_type) == 'OUT'
                                                ) {
                                                ?>

                                                    <span
                                                        class="badge badge-danger">

                                                        Decrease

                                                    </span>

                                                <?php
                                                } else {
                                                ?>

                                                    <span
                                                        class="badge badge-secondary">

                                                        <?php
                                                        echo !empty($row->adjustment_type)
                                                            ? html_escape($row->adjustment_type)
                                                            : '-';
                                                        ?>

                                                    </span>

                                                <?php } ?>

                                            </td>


                                            <td>
                                                <?php
                                                echo !empty($row->product_code)
                                                    ? html_escape($row->product_code)
                                                    : '-';
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo !empty($row->product_name)
                                                    ? html_escape($row->product_name)
                                                    : '-';
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo !empty($row->warehouse_name)
                                                    ? html_escape($row->warehouse_name)
                                                    : '-';
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo !empty($row->store_name)
                                                    ? html_escape($row->store_name)
                                                    : '-';
                                                ?>
                                            </td>


                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $quantity,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $price,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $stock_value,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->created_user)
                                                    ? html_escape($row->created_user)
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php

                                                $remarks = '';

                                                if (!empty($row->adjustment_remark)) {

                                                    $remarks =
                                                        $row->adjustment_remark;
                                                } elseif (!empty($row->stock_remark)) {

                                                    $remarks =
                                                        $row->stock_remark;
                                                } elseif (!empty($row->item_remark)) {

                                                    $remarks =
                                                        $row->item_remark;
                                                }

                                                echo !empty($remarks)
                                                    ? html_escape($remarks)
                                                    : '-';

                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>


                                    <!-- TOTAL -->

                                    <tr style="font-weight:bold;">

                                        <td
                                            colspan="8"
                                            class="text-right">

                                            Total

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_quantity,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td></td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_value,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td colspan="2"></td>

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="13"
                                            class="text-center">

                                            No Stock Adjustment
                                            records found.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <tfoot>

                                <tr>

                                    <th>Sl No</th>
                                    <th>Adjustment No</th>
                                    <th>Adjustment Date</th>
                                    <th>Adjustment Type</th>
                                    <th>Stock Code</th>
                                    <th>Product Name</th>
                                    <th>Warehouse</th>
                                    <th>Store</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Adjustment Value</th>
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
    function printStockAdjustmentReport(event) {
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


        const warehouseId =
            document.querySelector(
                'select[name="warehouse_id"]'
            ).value;


        const storeId =
            document.querySelector(
                'select[name="store_id"]'
            ).value;


        const productId =
            document.querySelector(
                'select[name="product_id"]'
            ).value;


        const adjustmentType =
            document.querySelector(
                'select[name="adjustment_type"]'
            ).value;


        const baseUrl =
            "<?php echo base_url('index.php/Reports/print_stock_adjustment_report'); ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                warehouse_id: warehouseId,

                store_id: storeId,

                product_id: productId,

                adjustment_type: adjustmentType

            });


        window.open(
            baseUrl + "?" + params.toString(),
            '_blank'
        );


        return false;
    }


    function exportStockAdjustmentExcel(event) {
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


        const warehouseId =
            document.querySelector(
                'select[name="warehouse_id"]'
            ).value;


        const storeId =
            document.querySelector(
                'select[name="store_id"]'
            ).value;


        const productId =
            document.querySelector(
                'select[name="product_id"]'
            ).value;


        const adjustmentType =
            document.querySelector(
                'select[name="adjustment_type"]'
            ).value;


        const baseUrl =
            "<?php echo base_url('index.php/Reports/export_stock_adjustment_excel'); ?>";


        const params =
            new URLSearchParams({
                from_date: fromDate,
                to_date: toDate,
                warehouse_id: warehouseId,
                store_id: storeId,
                product_id: productId,
                adjustment_type: adjustmentType
            });

        window.location.href = baseUrl + "?" + params.toString();
        return false;
    }

    $(document).ready(function() {
        $('.select2').select2();
    });

    $(document).ready(function() {
        $('#warehouse_id').change(function() {
            var warehouse_id = $(this).val();
            $('#store_id').html(
                '<option value="">Loading...</option>'
            );

            $.ajax({
                url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",
                type: "POST",
                data: {
                    warehouse_id: warehouse_id
                },
                dataType: "json",
                success: function(result) {
                    var selectedStore = "<?= isset($store_id) ? $store_id : ''; ?>";
                    var html = '<option value="">All Stores</option>';
                    $.each(
                        result,
                        function(i, row) {
                            var selected = (row.store_id == selectedStore) ? 'selected' : '';
                            html += '<option value="' + row.store_id + '" ' + selected +
                                '>' +
                                row.store_name +
                                '</option>';
                        }
                    );

                    $('#store_id').html(html);
                    $('#store_id').trigger('change.select2');

                },
                error: function() {
                    $('#store_id').html(
                        '<option value="">All Stores</option>'
                    );
                }
            });
        });

        if ($('#warehouse_id').val() != '') {
            $('#warehouse_id').trigger('change');
        }
    });
</script>