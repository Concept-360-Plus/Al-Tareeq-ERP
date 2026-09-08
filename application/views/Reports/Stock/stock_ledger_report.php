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
                    action="<?php echo base_url(); ?>index.php/Reports/get_stock_ledger_report"
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
                                required>

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
                                required>

                        </div>


                        <!-- WAREHOUSE -->

                        <div class="col-md-3">

                            <label> Warehouse</label>

                            <select name="warehouse_id" id="warehouse_id" class="form-control select2">
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

                            <label> Store</label>
                            <select name="store_id" id="store_id" class="form-control select2">

                                <option value="">
                                    All Stores
                                </option>

                                <?php
                                if (!empty($store_records)) {

                                    foreach ($store_records as $store) {
                                ?>

                                        <option
                                            value="<?php
                                                    echo $store->store_id;
                                                    ?>"
                                            <?php
                                            echo (
                                                isset($store_id) &&
                                                $store_id == $store->store_id
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
                                    } // foreach
                                } // if
                                ?>

                            </select>

                        </div>

                    </div>


                    <!-- =====================================================
                         SECOND ROW
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


                        <div class="col-md-9"></div>

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
                                onclick="printStockLedgerReport(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportStockLedgerExcel(event)"
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
             LEDGER TABLE
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
                                        Date
                                    </th>

                                    <th>
                                        Reference
                                    </th>

                                    <th>
                                        Product Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Opening
                                    </th>

                                    <th>
                                        Stock In
                                    </th>

                                    <th>
                                        Stock Out
                                    </th>

                                    <th>
                                        Balance
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
                                        Remarks
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $total_in = 0;
                                $total_out = 0;

                                ?>


                                <?php if (!empty($records)) { ?>

                                    <?php
                                    $i = 1;

                                    /*
                                     * Opening balance of the
                                     * selected period.
                                     */
                                    $first_opening =
                                        (float)$records[0]->opening_balance;
                                    ?>


                                    <?php foreach ($records as $row) { ?>

                                        <?php

                                        $stock_in =
                                            (float)$row->stock_in;

                                        $stock_out =
                                            (float)$row->stock_out;

                                        $total_in +=
                                            $stock_in;

                                        $total_out +=
                                            $stock_out;

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


                                            <!-- REFERENCE -->

                                            <td>

                                                <?php

                                                echo !empty($row->reference)
                                                    ? html_escape(
                                                        $row->reference
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


                                            <!-- OPENING -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    (float)
                                                    $row->opening_balance,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- STOCK IN -->

                                            <td class="text-right">

                                                <?php
                                                echo $stock_in > 0
                                                    ? number_format(
                                                        $stock_in,
                                                        2
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- STOCK OUT -->

                                            <td class="text-right">

                                                <?php
                                                echo $stock_out > 0
                                                    ? number_format(
                                                        $stock_out,
                                                        2
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- BALANCE -->

                                            <td
                                                class="text-right"
                                                style="font-weight:bold;">

                                                <?php
                                                echo number_format(
                                                    (float)
                                                    $row->closing_balance,
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


                                    <!-- =================================================
                                         OPENING BALANCE
                                    ================================================== -->

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-right">

                                            <strong>
                                                Opening Balance
                                            </strong>

                                        </td>

                                        <td
                                            class="text-right"
                                            style="font-weight:bold;">

                                            <?php
                                            echo number_format(
                                                $first_opening,
                                                2
                                            );
                                            ?>

                                        </td>

                                        <td colspan="7"></td>

                                    </tr>


                                    <!-- =================================================
                                         TOTAL STOCK IN
                                    ================================================== -->

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="text-right">

                                            <strong>
                                                Total Stock In
                                            </strong>

                                        </td>

                                        <td
                                            class="text-right"
                                            style="font-weight:bold;">

                                            <?php
                                            echo number_format(
                                                $total_in,
                                                2
                                            );
                                            ?>

                                        </td>

                                        <td colspan="6"></td>

                                    </tr>


                                    <!-- =================================================
                                         TOTAL STOCK OUT
                                    ================================================== -->

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="text-right">

                                            <strong>
                                                Total Stock Out
                                            </strong>

                                        </td>

                                        <td
                                            class="text-right"
                                            style="font-weight:bold;">

                                            <?php
                                            echo number_format(
                                                $total_out,
                                                2
                                            );
                                            ?>

                                        </td>

                                        <td colspan="6"></td>

                                    </tr>


                                    <!-- =================================================
                                         CLOSING BALANCE
                                    ================================================== -->

                                    <tr>

                                        <td
                                            colspan="8"
                                            class="text-right">

                                            <strong>
                                                Closing Balance
                                            </strong>

                                        </td>

                                        <td
                                            class="text-right"
                                            style="font-weight:bold;">

                                            <?php

                                            $closing_balance =
                                                $first_opening +
                                                $total_in -
                                                $total_out;

                                            echo number_format(
                                                $closing_balance,
                                                2
                                            );

                                            ?>

                                        </td>

                                        <td colspan="4"></td>

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="13"
                                            class="text-center">

                                            No Stock Ledger records found.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <!-- =====================================================
                                 TABLE FOOTER
                            ====================================================== -->

                            <tfoot>

                                <tr>

                                    <th>
                                        Sl No
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Reference
                                    </th>

                                    <th>
                                        Product Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Opening
                                    </th>

                                    <th>
                                        Stock In
                                    </th>

                                    <th>
                                        Stock Out
                                    </th>

                                    <th>
                                        Balance
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
    /* =========================================================
   PRINT STOCK LEDGER
========================================================= */

    function printStockLedgerReport(event) {
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


        const baseUrl =
            "<?php
                echo base_url(
                    'index.php/Reports/print_stock_ledger_report'
                );
                ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                warehouse_id: warehouseId,

                store_id: storeId,

                product_id: productId

            });


        window.open(
            baseUrl + "?" + params.toString(),
            '_blank'
        );


        return false;
    }


    /* =========================================================
       EXPORT STOCK LEDGER
    ========================================================= */

    function exportStockLedgerExcel(event) {
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


        const baseUrl =
            "<?php
                echo base_url(
                    'index.php/Reports/export_stock_ledger_excel'
                );
                ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                warehouse_id: warehouseId,

                store_id: storeId,

                product_id: productId

            });


        window.location.href =
            baseUrl + "?" + params.toString();


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

                    $.each(result, function(i, row) {
                        var selected = (row.store_id == selectedStore) ? 'selected' : '';
                        html += '<option value="' + row.store_id + '" ' + selected + '>' + row.store_name + '</option>';

                    });
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