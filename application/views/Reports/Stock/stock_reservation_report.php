<div class="card-body">

    <div class="row">

        <div class="col-md-12">

            <h4 class="mb-3">
                <i class="fa fa-lock"></i>
                Stock Reservation Report
            </h4>

        </div>

    </div>


    <!-- =====================================================
         FILTER FORM
    ====================================================== -->

    <form
        method="post"
        action="<?php echo base_url('index.php/Reports/get_stock_reservation_report'); ?>">

        <div class="form-row">

            <!-- FROM DATE -->

            <div class="form-group col-md-2">

                <label>
                    From Date
                </label>

                <input
                    type="date"
                    name="from_date"
                    class="form-control form-control-sm"
                    value="<?php echo html_escape($from); ?>">

            </div>


            <!-- TO DATE -->

            <div class="form-group col-md-2">

                <label>
                    To Date
                </label>

                <input
                    type="date"
                    name="to_date"
                    class="form-control form-control-sm"
                    value="<?php echo html_escape($to); ?>">

            </div>


            <!-- PRODUCT -->

            <div class="form-group col-md-2">

                <label>
                    Product
                </label>

                <select
                    name="product_id"
                    class="form-control form-control-sm">

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
                                    $product_id == $product->product_id
                                )
                                    ? 'selected'
                                    : '';
                                ?>>
                                <?php
                                echo html_escape(
                                    $product->product_code
                                );
                                ?>
                                -
                                <?php
                                echo html_escape(
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


            <!-- CUSTOMER -->

            <div class="form-group col-md-2">

                <label>
                    Customer
                </label>

                <select
                    name="customer_id"
                    class="form-control form-control-sm">

                    <option value="">
                        All Customers
                    </option>

                    <?php
                    if (!empty($customer_records)) {

                        foreach (
                            $customer_records as $customer
                        ) {
                    ?>

                            <option
                                value="<?php echo $customer->customer_id; ?>"
                                <?php
                                echo (
                                    $customer_id ==
                                    $customer->customer_id
                                )
                                    ? 'selected'
                                    : '';
                                ?>>
                                <?php
                                echo html_escape(
                                    $customer->customer_name
                                );
                                ?>
                            </option>

                        <?php
                        }
                        ?>

                    <?php } ?>

                </select>

            </div>


            <!-- SALES ORDER -->

            <div class="form-group col-md-2">

                <label>
                    Sales Order
                </label>

                <select
                    name="so_id"
                    class="form-control form-control-sm">

                    <option value="">
                        All Sales Orders
                    </option>

                    <?php
                    if (!empty($sales_orders)) {

                        foreach (
                            $sales_orders as $so
                        ) {
                    ?>

                            <option
                                value="<?php echo $so->so_id; ?>"
                                <?php
                                echo (
                                    $so_id ==
                                    $so->so_id
                                )
                                    ? 'selected'
                                    : '';
                                ?>>
                                <?php
                                echo html_escape(
                                    $so->so_code
                                );
                                ?>
                            </option>

                        <?php
                        }
                        ?>

                    <?php } ?>

                </select>

            </div>


            <!-- STATUS -->

            <div class="form-group col-md-2">

                <label>
                    Reservation Status
                </label>

                <select
                    name="status"
                    class="form-control form-control-sm">

                    <option value="">
                        All
                    </option>

                    <option
                        value="FULL"
                        <?php
                        echo ($status == 'FULL')
                            ? 'selected'
                            : '';
                        ?>>
                        Fully Reserved
                    </option>

                    <option
                        value="PARTIAL"
                        <?php
                        echo ($status == 'PARTIAL')
                            ? 'selected'
                            : '';
                        ?>>
                        Partially Reserved
                    </option>

                </select>

            </div>

        </div>


        <!-- BUTTONS -->

        <div class="form-group mt-2">

            <button
                type="submit"
                class="btn btn-primary btn-sm">
                <i class="fa fa-search"></i>
                Go
            </button>

        </div>

    </form>


    <hr>


    <?php if (!empty($records)) { ?>


        <!-- =================================================
             ACTION BUTTONS
        ================================================== -->

        <div class="mb-3">

            <button
                type="button"
                class="btn btn-warning btn-sm"
                onclick="printReport()">
                <i class="fa fa-print"></i>
                Print
            </button>


            <button
                type="button"
                class="btn btn-success btn-sm"
                onclick="exportReport()">
                <i class="fa fa-file-excel-o"></i>
                Export to Excel
            </button>

        </div>


        <!-- =================================================
             REPORT TABLE
        ================================================== -->

        <div class="table-responsive">

            <table
                class="table table-bordered table-hover table-sm"
                id="reservationReport">

                <thead>

                    <tr>

                        <th width="5%">
                            #
                        </th>

                        <th>
                            Priority
                        </th>

                        <th>
                            Reservation Date
                        </th>

                        <th>
                            Sales Order
                        </th>

                        <th>
                            Product Code
                        </th>

                        <th>
                            Product Name
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Branch
                        </th>

                        <th class="text-right">
                            Requested Qty
                        </th>

                        <th class="text-right">
                            Reserved Qty
                        </th>

                        <th class="text-right">
                            Pending Qty
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    $sr = 1;

                    $total_requested = 0;
                    $total_reserved  = 0;
                    $total_pending   = 0;

                    foreach ($records as $row) {

                        $requested =
                            (float)$row->requested_qty;

                        $reserved =
                            (float)$row->reserved_quantity;

                        $pending =
                            (float)$row->pending_quantity;

                        $total_requested += $requested;
                        $total_reserved  += $reserved;
                        $total_pending   += $pending;

                    ?>

                        <tr>

                            <td>
                                <?php echo $sr++; ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($row->reserve_priority)
                                    ? html_escape(
                                        $row->reserve_priority
                                    )
                                    : '-';
                                ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($row->reserved_date)
                                    ? date(
                                        'd-m-Y',
                                        strtotime(
                                            $row->reserved_date
                                        )
                                    )
                                    : '-';
                                ?>
                            </td>

                            <td>
                                <strong>
                                    <?php
                                    echo html_escape(
                                        $row->so_code
                                    );
                                    ?>
                                </strong>
                            </td>

                            <td>
                                <?php
                                echo html_escape(
                                    $row->product_code
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo html_escape(
                                    $row->product_name
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($row->customer_name)
                                    ? html_escape(
                                        $row->customer_name
                                    )
                                    : '-';
                                ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($row->branch_name)
                                    ? html_escape(
                                        $row->branch_name
                                    )
                                    : '-';
                                ?>
                            </td>

                            <td class="text-right">
                                <?php
                                echo number_format(
                                    $requested,
                                    2
                                );
                                ?>
                            </td>

                            <td class="text-right">
                                <?php
                                echo number_format(
                                    $reserved,
                                    2
                                );
                                ?>
                            </td>

                            <td class="text-right">
                                <?php
                                echo number_format(
                                    $pending,
                                    2
                                );
                                ?>
                            </td>

                            <td>

                                <?php
                                if (
                                    $row->stock_status ==
                                    'FULL'
                                ) {
                                ?>

                                    <span
                                        class="badge badge-success">
                                        Fully Reserved
                                    </span>

                                <?php
                                } elseif (
                                    $row->stock_status ==
                                    'PARTIAL'
                                ) {
                                ?>

                                    <span
                                        class="badge badge-warning">
                                        Partially Reserved
                                    </span>

                                <?php
                                } else {
                                ?>

                                    <span
                                        class="badge badge-secondary">
                                        <?php
                                        echo html_escape(
                                            $row->stock_status
                                        );
                                        ?>
                                    </span>

                                <?php } ?>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>


                <tfoot>

                    <tr>

                        <th colspan="8" class="text-right">
                            Total
                        </th>

                        <th class="text-right">
                            <?php
                            echo number_format(
                                $total_requested,
                                2
                            );
                            ?>
                        </th>

                        <th class="text-right">
                            <?php
                            echo number_format(
                                $total_reserved,
                                2
                            );
                            ?>
                        </th>

                        <th class="text-right">
                            <?php
                            echo number_format(
                                $total_pending,
                                2
                            );
                            ?>
                        </th>

                        <th></th>

                    </tr>

                </tfoot>

            </table>

        </div>


    <?php } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

        <div class="alert alert-info">
            No stock reservations found for the selected filters.
        </div>

    <?php } ?>


</div>


<script>
    function printReport() {
        var url =
            "<?php echo base_url('index.php/Reports/print_stock_reservation_report'); ?>";

        var params = new URLSearchParams({

            from_date: "<?php echo html_escape($from); ?>",

            to_date: "<?php echo html_escape($to); ?>",

            product_id: "<?php echo html_escape($product_id); ?>",

            customer_id: "<?php echo html_escape($customer_id); ?>",

            so_id: "<?php echo html_escape($so_id); ?>",

            status: "<?php echo html_escape($status); ?>"
        });

        window.open(
            url + '?' + params.toString(),
            '_blank'
        );
    }


    function exportReport() {
        var url =
            "<?php echo base_url('index.php/Reports/export_stock_reservation_excel'); ?>";

        var params = new URLSearchParams({

            from_date: "<?php echo html_escape($from); ?>",

            to_date: "<?php echo html_escape($to); ?>",

            product_id: "<?php echo html_escape($product_id); ?>",

            customer_id: "<?php echo html_escape($customer_id); ?>",

            so_id: "<?php echo html_escape($so_id); ?>",

            status: "<?php echo html_escape($status); ?>"
        });

        window.location.href =
            url + '?' + params.toString();
    }
</script>