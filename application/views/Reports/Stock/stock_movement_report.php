<div class="content-wrapper">

    <section class="content">

        <!-- =====================================================
             FILTER
        ====================================================== -->

        <div class="card">

            <div class="card-body">

                <form
                    id="main"
                    method="post"
                    action="<?php echo base_url() . 'index.php/'; ?>Reports/get_stock_movement_report"
                    autocomplete="off">

                    <div class="row">

                        <!-- FROM DATE -->

                        <div class="col-md-3">

                            <label>
                                From Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="from_date"
                                class="form-control"
                                value="<?php
                                        echo !empty($from)
                                            ? date('Y-m-d', strtotime($from))
                                            : date('Y-m-01');
                                        ?>"
                                required />

                        </div>


                        <!-- TO DATE -->

                        <div class="col-md-3">

                            <label>
                                To Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="to_date"
                                class="form-control"
                                value="<?php
                                        echo !empty($to)
                                            ? date('Y-m-d', strtotime($to))
                                            : date('Y-m-d');
                                        ?>"
                                required />

                        </div>


                        <!-- WAREHOUSE -->

                        <div class="col-md-3">

                            <label>
                                Warehouse
                            </label>

                            <select
                                name="warehouse_id"
                                class="form-control select2">

                                <option value="">
                                    All Warehouses
                                </option>

                                <?php
                                if (!empty($warehouse_records)) {

                                    foreach (
                                        $warehouse_records as $warehouse
                                    ) {
                                ?>

                                        <option
                                            value="<?php
                                                    echo $warehouse->warehouse_id;
                                                    ?>"
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


                        <!-- STORE -->

                        <div class="col-md-3">

                            <label>
                                Store
                            </label>

                            <select
                                name="store_id"
                                class="form-control select2">

                                <option value="">
                                    All Stores
                                </option>

                                <?php
                                if (!empty($store_records)) {

                                    foreach (
                                        $store_records as $store
                                    ) {
                                ?>

                                        <option
                                            value="<?php
                                                    echo $store->store_id;
                                                    ?>"
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

                    </div>


                    <!-- =====================================================
                         SECOND FILTER ROW
                    ====================================================== -->

                    <div class="row mt-3">

                        <!-- PRODUCT -->

                        <div class="col-md-3">

                            <label>
                                Product
                            </label>

                            <select
                                name="product_id"
                                class="form-control select2">

                                <option value="">
                                    All Products
                                </option>

                                <?php
                                if (!empty($products)) {

                                    foreach (
                                        $products as $product
                                    ) {
                                ?>

                                        <option
                                            value="<?php
                                                    echo $product->product_id;
                                                    ?>"
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


                        <!-- MOVEMENT TYPE -->

                        <div class="col-md-3">

                            <label>
                                Movement Type
                            </label>

                            <select
                                name="movement_type"
                                class="form-control">

                                <option value="">
                                    All Movements
                                </option>

                                <option
                                    value="IN"
                                    <?php
                                    echo (
                                        isset($movement_type) &&
                                        $movement_type == 'IN'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>
                                    Stock In
                                </option>

                                <option
                                    value="OUT"
                                    <?php
                                    echo (
                                        isset($movement_type) &&
                                        $movement_type == 'OUT'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>
                                    Stock Out
                                </option>

                            </select>

                        </div>


                        <!-- EMPTY -->

                        <div class="col-md-6">

                        </div>

                    </div>


                    <!-- =====================================================
                         ACTION BUTTONS
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
                                onclick="printStockMovementReport(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportStockMovementExcel(event)"
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
                                        Movement Date
                                    </th>

                                    <th>
                                        Product Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Reference
                                    </th>

                                    <th>
                                        Movement Type
                                    </th>

                                    <th>
                                        Quantity
                                    </th>

                                    <th>
                                        Price
                                    </th>

                                    <th>
                                        Warehouse
                                    </th>

                                    <th>
                                        Store
                                    </th>

                                    <th>
                                        Storage Location
                                    </th>

                                    <th>
                                        Remarks
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php if (!empty($records)) { ?>

                                    <?php $i = 1; ?>

                                    <?php
                                    $total_qty = 0;
                                    ?>

                                    <?php
                                    foreach ($records as $row) {
                                    ?>

                                        <?php
                                        $qty = (float)$row->quantity;

                                        $total_qty += $qty;
                                        ?>


                                        <tr>

                                            <!-- SL NO -->

                                            <td>

                                                <?php
                                                echo $i++;
                                                ?>

                                            </td>


                                            <!-- DATE -->

                                            <td>

                                                <?php

                                                echo !empty($row->stock_date)
                                                    ? date(
                                                        'd-m-Y',
                                                        strtotime(
                                                            $row->stock_date
                                                        )
                                                    )
                                                    : '-';

                                                ?>

                                            </td>


                                            <!-- PRODUCT CODE -->

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


                                            <!-- REFERENCE -->

                                            <td>

                                                <?php

                                                if (
                                                    !empty($row->bill_no)
                                                ) {

                                                    echo 'Bill: ' .
                                                        html_escape(
                                                            $row->bill_no
                                                        );
                                                } elseif (
                                                    !empty($row->order_ref_no)
                                                ) {

                                                    echo 'Ref: ' .
                                                        html_escape(
                                                            $row->order_ref_no
                                                        );
                                                } elseif (
                                                    !empty($row->trans_id)
                                                ) {

                                                    echo 'Transaction: ' .
                                                        html_escape(
                                                            $row->trans_id
                                                        );
                                                } elseif (
                                                    !empty($row->adjustment_id)
                                                ) {

                                                    echo 'Adjustment: ' .
                                                        html_escape(
                                                            $row->adjustment_id
                                                        );
                                                } else {

                                                    echo '-';
                                                }

                                                ?>

                                            </td>


                                            <!-- MOVEMENT TYPE -->

                                            <td>

                                                <?php

                                                if (
                                                    $row->stock_type == 'IN'
                                                ) {

                                                    if (
                                                        !empty($row->adjustment_id)
                                                    ) {

                                                        echo
                                                        '<span class="label label-warning">
                                                            Adjustment IN
                                                        </span>';
                                                    } else {

                                                        echo
                                                        '<span class="label label-success">
                                                            Stock In
                                                        </span>';
                                                    }
                                                } elseif (
                                                    $row->stock_type == 'OUT'
                                                ) {

                                                    if (
                                                        !empty($row->adjustment_id)
                                                    ) {

                                                        echo
                                                        '<span class="label label-warning">
                                                            Adjustment OUT
                                                        </span>';
                                                    } else {

                                                        echo
                                                        '<span class="label label-danger">
                                                            Stock Out
                                                        </span>';
                                                    }
                                                } else {

                                                    echo '-';
                                                }

                                                ?>

                                            </td>


                                            <!-- QUANTITY -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- PRICE -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    (float)$row->price,
                                                    2
                                                );
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


                                            <!-- STORAGE LOCATION -->

                                            <td>

                                                <?php
                                                echo !empty($row->storage_location)
                                                    ? html_escape(
                                                        $row->storage_location
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- REMARKS -->

                                            <td>

                                                <?php

                                                if (
                                                    !empty($row->item_remark)
                                                ) {

                                                    echo html_escape(
                                                        $row->item_remark
                                                    );
                                                } elseif (
                                                    !empty($row->remark)
                                                ) {

                                                    echo html_escape(
                                                        $row->remark
                                                    );
                                                } else {

                                                    echo '-';
                                                }

                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>


                                    <!-- TOTAL -->

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="text-right">

                                            <strong>
                                                Total Quantity
                                            </strong>

                                        </td>

                                        <td
                                            class="text-right">

                                            <strong>

                                                <?php
                                                echo number_format(
                                                    $total_qty,
                                                    2
                                                );
                                                ?>

                                            </strong>

                                        </td>

                                        <td colspan="5"></td>

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="12"
                                            class="text-center">

                                            No Stock Movement records found.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <!-- FOOTER -->

                            <tfoot>

                                <tr>

                                    <th>
                                        Sl No
                                    </th>

                                    <th>
                                        Movement Date
                                    </th>

                                    <th>
                                        Product Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Reference
                                    </th>

                                    <th>
                                        Movement Type
                                    </th>

                                    <th>
                                        Quantity
                                    </th>

                                    <th>
                                        Price
                                    </th>

                                    <th>
                                        Warehouse
                                    </th>

                                    <th>
                                        Store
                                    </th>

                                    <th>
                                        Storage Location
                                    </th>

                                    <th>
                                        Remarks
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
    $(document).ready(function() {
        $('#warehouse_id').change(function() {
            var warehouse_id = $(this).val();
            $('#store_id').html('<option value="">Loading...</option>');
            $.ajax({
                url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",
                type: "POST",
                data: {
                    warehouse_id: warehouse_id
                },
                dataType: "json",
                success: function(result) {
                    var selectedStore = "<?= $store_id ?>";
                    var html = '<option value="">Select Store</option>';
                    $.each(result, function(i, row) {
                        var selected = (row.store_id == selectedStore) ? 'selected' : '';
                        html += '<option value="' + row.store_id + '" ' + selected + '>' +
                            row.store_name +
                            '</option>';
                    });
                    $('#store_id').html(html);
                    // Refresh Select2
                    $('#store_id').trigger('change.select2');
                }
            });
        });
        // Trigger AFTER binding
        if ($('#warehouse_id').val() != '') {
            $('#warehouse_id').trigger('change');
        }
    });

    function printStockMovementReport(event) {
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


        const movementType =
            document.querySelector(
                'select[name="movement_type"]'
            ).value;


        const baseUrl =
            "<?php
                echo base_url(
                    'index.php/Reports/print_stock_movement_report'
                );
                ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                warehouse_id: warehouseId,

                store_id: storeId,

                product_id: productId,

                movement_type: movementType

            });


        window.open(
            baseUrl + "?" + params.toString(),
            '_blank'
        );


        return false;
    }


    /* =========================================================
       EXPORT STOCK MOVEMENT EXCEL
    ========================================================= */

    function exportStockMovementExcel(event) {
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

        const movementType =
            document.querySelector(
                'select[name="movement_type"]'
            ).value;

        const baseUrl =
            "<?php
                echo base_url(
                    'index.php/Reports/export_stock_movement_excel'
                );
                ?>";

        const params =
            new URLSearchParams({
                from_date: fromDate,
                to_date: toDate,
                warehouse_id: warehouseId,
                store_id: storeId,
                product_id: productId,
                movement_type: movementType
            });

        window.location.href = baseUrl + "?" + params.toString();

        return false;
    }
</script>