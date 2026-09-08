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
                    action="<?php echo base_url() . 'index.php/'; ?>Reports/get_purchase_return_report"
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


                        <!-- SUPPLIER -->

                        <div class="col-md-3">

                            <label>
                                Supplier
                            </label>

                            <select
                                name="supplier_id"
                                class="form-control select2">

                                <option value="">
                                    All Suppliers
                                </option>

                                <?php
                                if (!empty($supplier_records)) {
                                ?>

                                    <?php
                                    foreach (
                                        $supplier_records as $supplier
                                    ) {
                                    ?>

                                        <option
                                            value="<?php
                                                    echo $supplier->supplier_id;
                                                    ?>"
                                            <?php
                                            echo (
                                                isset($supplier_id) &&
                                                $supplier_id ==
                                                $supplier->supplier_id
                                            )
                                                ? 'selected'
                                                : '';
                                            ?>>

                                            <?php
                                            echo
                                            $supplier->supplier_code .
                                                ' ' .
                                                $supplier->supplier_name;
                                            ?>

                                        </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- EMPTY COLUMN -->

                        <div class="col-md-3">

                            <!-- Keep layout consistent with Purchase Request -->

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
                                onclick="printPurchaseReturnReport(event)"
                                style="color:#000;">
                                <i class="fa fa-print"></i>
                                Print
                            </a>

                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportPurchaseReturnExcel(event)"
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
                                        Return Code
                                    </th>

                                    <th>
                                        Return Date
                                    </th>

                                    <th>
                                        GRN No
                                    </th>

                                    <th>
                                        Supplier
                                    </th>

                                    <th>
                                        Warehouse
                                    </th>

                                    <th>
                                        Store
                                    </th>

                                    <th>
                                        Product Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Unit
                                    </th>

                                    <th>
                                        Return Qty
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
                                    $total_return_qty = 0;
                                    ?>

                                    <?php
                                    foreach ($records as $row) {
                                    ?>

                                        <?php
                                            $qty = (float)$row->return_qty;
                                            $total_return_qty += $qty;
                                        ?>

                                        <tr>

                                            <td>
                                                <?php
                                                echo $i++;
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo
                                                html_escape(
                                                    $row->return_code
                                                );
                                                ?>
                                            </td>


                                            <td>

                                                <?php

                                                echo !empty($row->return_date)
                                                    ? date(
                                                        'd-m-Y',
                                                        strtotime(
                                                            $row->return_date
                                                        )
                                                    )
                                                    : '-';

                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->grn_code)
                                                    ? html_escape(
                                                        $row->grn_code
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->supplier_name)
                                                    ? html_escape(
                                                        $row->supplier_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->warehouse_name)
                                                    ? html_escape(
                                                        $row->warehouse_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->store_name)
                                                    ? html_escape(
                                                        $row->store_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->product_code)
                                                    ? html_escape(
                                                        $row->product_code
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->product_name)
                                                    ? html_escape(
                                                        $row->product_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->unit_name)
                                                    ? html_escape(
                                                        $row->unit_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <td>

                                                <?php
                                                echo !empty($row->remarks)
                                                    ? html_escape(
                                                        $row->remarks
                                                    )
                                                    : '-';
                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>


                                    <!-- TOTAL -->

                                    <tr>

                                        <td
                                            colspan="10"
                                            class="text-right">

                                            <strong>
                                                Total Return Quantity
                                            </strong>

                                        </td>

                                        <td class="text-right">

                                            <strong>

                                                <?php
                                                echo number_format(
                                                    $total_return_qty,
                                                    2
                                                );
                                                ?>

                                            </strong>

                                        </td>

                                        <td></td>

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="12"
                                            class="text-center">

                                            No Purchase Return records found.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>


                            <!-- Same footer style as Purchase Request -->

                            <tfoot>

                                <tr>

                                    <th>
                                        Sl No
                                    </th>

                                    <th>
                                        Return Code
                                    </th>

                                    <th>
                                        Return Date
                                    </th>

                                    <th>
                                        GRN No
                                    </th>

                                    <th>
                                        Supplier
                                    </th>

                                    <th>
                                        Warehouse
                                    </th>

                                    <th>
                                        Store
                                    </th>

                                    <th>
                                        Product Code
                                    </th>

                                    <th>
                                        Product Name
                                    </th>

                                    <th>
                                        Unit
                                    </th>

                                    <th>
                                        Return Qty
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
       PRINT PURCHASE RETURN REPORT
    ========================================================= */

    function printPurchaseReturnReport(event) {
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


        const supplierId =
            document.querySelector(
                'select[name="supplier_id"]'
            ).value;


        const baseUrl =
            "<?php
                echo base_url(
                    'index.php/Reports/print_purchase_return_report'
                );
                ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                supplier_id: supplierId

            });


        window.open(
            baseUrl + "?" + params.toString(),
            '_blank'
        );


        return false;
    }


    /* =========================================================
       EXPORT PURCHASE RETURN EXCEL
    ========================================================= */

    function exportPurchaseReturnExcel(event) {
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


        const supplierId =
            document.querySelector(
                'select[name="supplier_id"]'
            ).value;


        const baseUrl =
            "<?php
                echo base_url(
                    'index.php/Reports/export_purchase_return_excel'
                );
                ?>";

        const params =
            new URLSearchParams({
                from_date: fromDate,
                to_date: toDate,
                supplier_id: supplierId
            });

        window.location.href = baseUrl + "?" + params.toString();
        return false;
    }
</script>