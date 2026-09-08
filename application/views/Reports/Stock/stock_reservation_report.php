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
                    action="<?php echo base_url('index.php/Reports/get_stock_reservation_report'); ?>"
                    autocomplete="off">


                    <div class="row">

                        <!-- =================================================
                             FROM DATE
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                From Date
                            </label>

                            <input
                                type="date"
                                name="from_date"
                                id="from_date"
                                class="form-control"
                                value="<?php echo isset($from) ? html_escape($from) : date('Y-m-01'); ?>">

                        </div>


                        <!-- =================================================
                             TO DATE
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                To Date
                            </label>

                            <input
                                type="date"
                                name="to_date"
                                id="to_date"
                                class="form-control"
                                value="<?php echo isset($to) ? html_escape($to) : date('Y-m-d'); ?>">

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


                        <!-- =================================================
                             CUSTOMER
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                Customer
                            </label>

                            <select
                                name="customer_id"
                                id="customer_id"
                                class="form-control select2">

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
                                                isset($customer_id) &&
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
                                }
                                ?>

                            </select>

                        </div>

                    </div>


                    <div class="row mt-3">

                        <!-- =================================================
                             SALES ORDER
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                Sales Order
                            </label>

                            <select
                                name="so_id"
                                id="so_id"
                                class="form-control select2">

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
                                                isset($so_id) &&
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
                                }
                                ?>

                            </select>

                        </div>


                        <!-- =================================================
                             RESERVATION STATUS
                        ================================================== -->

                        <div class="col-md-3">

                            <label>
                                Reservation Status
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-control select2">

                                <option value="">
                                    All
                                </option>

                                <option
                                    value="FULL"
                                    <?php
                                    echo (
                                        isset($status) &&
                                        $status == 'FULL'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>
                                    Fully Reserved
                                </option>

                                <option
                                    value="PARTIAL"
                                    <?php
                                    echo (
                                        isset($status) &&
                                        $status == 'PARTIAL'
                                    )
                                        ? 'selected'
                                        : '';
                                    ?>>
                                    Partially Reserved
                                </option>

                            </select>

                        </div>


                        <div class="col-md-6"></div>

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
                                onclick="printStockReservationReport(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportStockReservationExcel(event)"
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
                                        Priority
                                    </th>

                                    <th>
                                        Reservation Date
                                    </th>

                                    <th>
                                        Sales Order
                                    </th>

                                    <th>
                                        Stock Code
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

                                $total_requested = 0;
                                $total_reserved  = 0;
                                $total_pending   = 0;

                                ?>


                                <?php if (!empty($records)) { ?>

                                    <?php
                                    $i = 1;
                                    ?>


                                    <?php foreach ($records as $row) { ?>

                                        <?php

                                        $requested_qty =
                                            isset($row->requested_qty)
                                            ? (float)$row->requested_qty
                                            : 0;

                                        $reserved_qty =
                                            isset($row->reserved_quantity)
                                            ? (float)$row->reserved_quantity
                                            : 0;

                                        $pending_qty =
                                            isset($row->pending_quantity)
                                            ? (float)$row->pending_quantity
                                            : 0;


                                        $total_requested +=
                                            $requested_qty;

                                        $total_reserved +=
                                            $reserved_qty;

                                        $total_pending +=
                                            $pending_qty;

                                        ?>


                                        <tr>

                                            <!-- SL NO -->

                                            <td>
                                                <?php echo $i++; ?>
                                            </td>


                                            <!-- PRIORITY -->

                                            <td>

                                                <?php
                                                echo !empty($row->reserve_priority)
                                                    ? html_escape(
                                                        $row->reserve_priority
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- RESERVATION DATE -->

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


                                            <!-- SALES ORDER -->

                                            <td>

                                                <?php
                                                echo !empty($row->so_code)
                                                    ? html_escape(
                                                        $row->so_code
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


                                            <!-- CUSTOMER -->

                                            <td>

                                                <?php
                                                echo !empty($row->customer_name)
                                                    ? html_escape(
                                                        $row->customer_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- BRANCH -->

                                            <td>

                                                <?php
                                                echo !empty($row->branch_name)
                                                    ? html_escape(
                                                        $row->branch_name
                                                    )
                                                    : '-';
                                                ?>

                                            </td>


                                            <!-- REQUESTED -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $requested_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- RESERVED -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $reserved_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- PENDING -->

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $pending_qty,
                                                    2
                                                );
                                                ?>

                                            </td>


                                            <!-- STATUS -->

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
                                                        echo !empty($row->stock_status)
                                                            ? html_escape(
                                                                $row->stock_status
                                                            )
                                                            : '-';
                                                        ?>

                                                    </span>

                                                <?php } ?>

                                            </td>

                                        </tr>

                                    <?php } ?>


                                    <!-- =================================================
                                         TOTAL
                                    ================================================== -->

                                    <tr style="font-weight:bold;">

                                        <td
                                            colspan="8"
                                            class="text-right">

                                            Total

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_requested,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_reserved,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td class="text-right">

                                            <?php
                                            echo number_format(
                                                $total_pending,
                                                2
                                            );
                                            ?>

                                        </td>


                                        <td></td>

                                    </tr>


                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="12"
                                            class="text-center">

                                            No Stock Reservation
                                            records found.

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
                                        Priority
                                    </th>

                                    <th>
                                        Reservation Date
                                    </th>

                                    <th>
                                        Sales Order
                                    </th>

                                    <th>
                                        Stock Code
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

                                    <th>
                                        Requested Qty
                                    </th>

                                    <th>
                                        Reserved Qty
                                    </th>

                                    <th>
                                        Pending Qty
                                    </th>

                                    <th>
                                        Status
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
    function printStockReservationReport(event) {

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

        const productId =
            document.querySelector(
                'select[name="product_id"]'
            ).value;

        const customerId =
            document.querySelector(
                'select[name="customer_id"]'
            ).value;

        const soId =
            document.querySelector(
                'select[name="so_id"]'
            ).value;

        const status =
            document.querySelector(
                'select[name="status"]'
            ).value;


        const baseUrl =
            "<?php echo base_url('index.php/Reports/print_stock_reservation_report'); ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                product_id: productId,

                customer_id: customerId,

                so_id: soId,

                status: status

            });


        window.open(
            baseUrl + "?" + params.toString(),
            '_blank'
        );

        return false;
    }


    function exportStockReservationExcel(event) {

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

        const productId =
            document.querySelector(
                'select[name="product_id"]'
            ).value;

        const customerId =
            document.querySelector(
                'select[name="customer_id"]'
            ).value;

        const soId =
            document.querySelector(
                'select[name="so_id"]'
            ).value;

        const status =
            document.querySelector(
                'select[name="status"]'
            ).value;


        const baseUrl =
            "<?php echo base_url('index.php/Reports/export_stock_reservation_excel'); ?>";


        const params =
            new URLSearchParams({

                from_date: fromDate,

                to_date: toDate,

                product_id: productId,

                customer_id: customerId,

                so_id: soId,

                status: status

            });


        window.location.href =
            baseUrl + "?" + params.toString();

        return false;
    }


    $(document).ready(function() {

        /*
         * Keep the same Select2 behaviour
         * as the other Inventory reports.
         */

        $('.select2').select2();

    });
</script>