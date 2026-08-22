<div class="content-wrapper">

    <section class="content">

        <!-- =====================================================
             FILTER CARD
        ====================================================== -->

        <div class="card">

            <div class="card-body">

                <form
                    id="main"
                    method="post"
                    action="<?php echo base_url('index.php/Reports/get_stock_valuation_report'); ?>"
                    autocomplete="off">


                    <div class="row">

                        <!-- =================================================
                             WAREHOUSE
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                Warehouse
                            </label>

                            <select
                                name="warehouse_id"
                                id="warehouse_id"
                                class="form-control select2">

                                <option value="">
                                    All Warehouses
                                </option>

                                <?php
                                if (!empty($warehouse_records)) {

                                    foreach ($warehouse_records as $warehouse) {
                                ?>

                                        <option
                                            value="<?php echo $warehouse->warehouse_id; ?>"
                                            <?php
                                            echo (
                                                isset($warehouse_id) &&
                                                $warehouse_id ==
                                                $warehouse->warehouse_id
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

                                <?php
                                    }
                                }
                                ?>

                            </select>

                        </div>


                        <!-- =================================================
                             STORE
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                Store
                            </label>

                            <select
                                name="store_id"
                                id="store_id"
                                class="form-control select2">

                                <option value="">
                                    All Stores
                                </option>

                                <?php
                                if (!empty($store_records)) {

                                    foreach ($store_records as $store) {
                                ?>

                                        <option
                                            value="<?php echo $store->store_id; ?>"
                                            <?php
                                            echo (
                                                isset($store_id) &&
                                                $store_id ==
                                                $store->store_id
                                            )
                                                ? 'selected'
                                                : '';
                                            ?>>

                                            <?php
                                            echo html_escape(
                                                $store->store_name
                                            );
                                            ?>

                                        </option>

                                <?php
                                    }
                                }
                                ?>

                            </select>

                        </div>


                        <!-- =================================================
                             PRODUCT
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                Product
                            </label>

                            <select
                                name="product_id"
                                id="product_id"
                                class="form-control select2">

                                <option value="">
                                    All Products
                                </option>

                                <?php
                                if (!empty($products)) {

                                    foreach ($products as $product) {
                                ?>

                                        <option
                                            value="<?php echo $product->product_id; ?>"
                                            <?php
                                            echo (
                                                isset($product_id) &&
                                                $product_id ==
                                                $product->product_id
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

                                <?php
                                    }
                                }
                                ?>

                            </select>

                        </div>


                        <div class="col-md-3"></div>

                    </div>


                    <!-- =====================================================
                         BUTTONS
                    ====================================================== -->

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
                                onclick="printStockValuationReport(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportStockValuationExcel(event)"
                                style="color:#fff;">

                                <i class="fa fa-file-excel-o"></i>
                                Export to Excel

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- =====================================================
             REPORT TABLE
        ====================================================== -->

        <?php if (isset($records)) { ?>

            <div class="card mt-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>
                                        Sl No
                                    </th>

                                    <th>
                                        Stock Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Warehouse
                                    </th>

                                    <th>
                                        Store
                                    </th>

                                    <th class="text-right">
                                        Stock Qty
                                    </th>

                                    <th class="text-right">
                                        Allocated Qty
                                    </th>

                                    <th class="text-right">
                                        Available Qty
                                    </th>

                                    <th class="text-right">
                                        Unit Price
                                    </th>

                                    <th class="text-right">
                                        Stock Value
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $total_stock = 0;
                                $total_allocated = 0;
                                $total_available = 0;
                                $total_value = 0;

                                ?>


                                <?php if (!empty($records)) { ?>

                                    <?php
                                    $i = 1;
                                    ?>


                                    <?php foreach ($records as $row) { ?>

                                        <?php

                                        $stock_qty =
                                            isset($row->stock_qty)
                                            ? (float)$row->stock_qty
                                            : 0;

                                        $allocated_qty =
                                            isset($row->allocated_qty)
                                            ? (float)$row->allocated_qty
                                            : 0;

                                        $available_qty =
                                            isset($row->available_qty)
                                            ? (float)$row->available_qty
                                            : (
                                                $stock_qty -
                                                $allocated_qty
                                            );

                                        $unit_price =
                                            isset($row->unit_price)
                                            ? (float)$row->unit_price
                                            : 0;

                                        $stock_value =
                                            isset($row->stock_value)
                                            ? (float)$row->stock_value
                                            : (
                                                $stock_qty *
                                                $unit_price
                                            );


                                        $total_stock +=
                                            $stock_qty;

                                        $total_allocated +=
                                            $allocated_qty;

                                        $total_available +=
                                            $available_qty;

                                        $total_value +=
                                            $stock_value;

                                        ?>


                                        <tr>

                                            <!-- SL NO -->

                                            <td>
                                                <?php echo $i++; ?>
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


                                            <!-- PRODUCT NAME -->

                                            <td>

                                                <?php
                                                echo !empty($row->product_name)
                                                    ? html_escape(
                                                        $row->product_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- WAREHOUSE -->

                                            <td>

                                                <?php
                                                echo !empty($row->warehouse_name)
                                                    ? html_escape(
                                                        $row->warehouse_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- STORE -->

                                            <td>

                                                <?php
                                                echo !empty($row->store_name)
                                                    ? html_escape(
                                                        $row->store_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- STOCK QTY -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $stock_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- ALLOCATED -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $allocated_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- AVAILABLE -->

                                            <td
                                                class="text-right"
                                                style="font-weight:bold;">

                                                <?php
                                                echo number_format(
                                                    $available_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- UNIT PRICE -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $unit_price,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- STOCK VALUE -->

                                            <td
                                                class="text-right"
                                                style="font-weight:bold;">

                                                <?php
                                                echo number_format(
                                                    $stock_value,
                                                    2
                                                );
                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>


                                    <!-- =================================================
                                         TOTAL
                                    ================================================== -->

                                    <tr style="font-weight:bold;">

                                        <td
                                            colspan="5"
                                            class="text-right">

                                            Total

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_stock,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_allocated,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_available,
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

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="10"
                                            class="text-center">

                                            No Stock Valuation records found.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <tfoot>

                                <tr>

                                    <th>
                                        Sl No
                                    </th>

                                    <th>
                                        Stock Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Warehouse
                                    </th>

                                    <th>
                                        Store
                                    </th>

                                    <th>
                                        Stock Qty
                                    </th>

                                    <th>
                                        Allocated Qty
                                    </th>

                                    <th>
                                        Available Qty
                                    </th>

                                    <th>
                                        Unit Price
                                    </th>

                                    <th>
                                        Stock Value
                                    </th>

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
    function printStockValuationReport(event) {
        if (event) {
            event.preventDefault();
        }
        const warehouseId = document.querySelector('select[name="warehouse_id"]').value;
        const storeId = document.querySelector('select[name="store_id"]').value;
        const productId = document.querySelector('select[name="product_id"]').value;
        const baseUrl = "<?php echo base_url('index.php/Reports/print_stock_valuation_report'); ?>";
        const params = new URLSearchParams({warehouse_id: warehouseId,store_id: storeId,product_id: productId});

        window.open(baseUrl + "?" + params.toString(),'_blank');
        return false;
    }

    function exportStockValuationExcel(event) {
        if (event) {
            event.preventDefault();
        }
        const warehouseId = document.querySelector('select[name="warehouse_id"]').value;
        const storeId = document.querySelector('select[name="store_id"]').value;
        const productId = document.querySelector('select[name="product_id"]').value;
        const baseUrl = "<?php echo base_url( 'index.php/Reports/export_stock_valuation_excel'); ?>";
        const params = new URLSearchParams({warehouse_id: warehouseId,store_id: storeId,product_id: productId});
        window.location.href = baseUrl + "?" + params.toString();
        return false;
    }

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