<div class="content-wrapper">

    <section class="content">

        <!-- =====================================================
             FILTER
        ====================================================== -->

        <div class="card">

            <div class="card-body">

                <form
                    id="quotationComparisonForm"
                    method="post"
                    action="<?php echo base_url('index.php/Reports/get_supplier_quotation_comparison'); ?>"
                    autocomplete="off">

                    <div class="row">

                        <!-- FROM DATE -->
                        <div class="col-md-3">

                            <label>
                                From Date
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="from_date"
                                id="from_date"
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
                                To Date
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="to_date"
                                id="to_date"
                                class="form-control"
                                value="<?php
                                        echo !empty($to)
                                            ? date('Y-m-d', strtotime($to))
                                            : date('Y-m-d');
                                        ?>"
                                required />

                        </div>


                        <!-- RFQ SELECTION -->
                        <div class="col-md-6">

                            <label>
                                Select RFQs
                                <span class="text-danger">*</span>
                            </label>

                            <?php
                            $selected_rfqs = array();

                            if (!empty($selected_rfqs)) {

                                if (is_array($selected_rfqs)) {

                                    $selected_rfqs = $selected_rfqs;
                                } else {

                                    $selected_rfqs = explode(
                                        ',',
                                        $selected_rfqs
                                    );
                                }
                            }
                            ?>

                            <select
                                name="rfq_ids[]"
                                id="rfq_ids"
                                class="form-control select2"
                                multiple="multiple"
                                data-placeholder="Select RFQs"
                                style="width:100%;">

                                <?php if (!empty($rfq_list)) { ?>

                                    <?php foreach ($rfq_list as $rfq) { ?>

                                        <option
                                            value="<?php echo $rfq->rfq_id; ?>"
                                            <?php
                                            echo in_array(
                                                $rfq->rfq_id,
                                                $selected_rfqs
                                            )
                                                ? 'selected'
                                                : '';
                                            ?>>

                                            <?php
                                            echo html_escape(
                                                $rfq->rfq_code
                                            );
                                            ?>

                                            <?php if (!empty($rfq->supplier_name)) { ?>

                                                -
                                                <?php
                                                echo html_escape(
                                                    $rfq->supplier_name
                                                );
                                                ?>

                                            <?php } ?>

                                        </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>

                            <small class="text-muted">
                                Select the RFQs whose supplier quotations
                                need to be compared.
                            </small>

                        </div>

                    </div>


                    <!-- =================================================
                         ACTION BUTTONS
                    ================================================== -->

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
                                onclick="printSupplierQuotationComparison(event)"
                                style="color:#000;">

                                <i class="fa fa-print"></i>
                                Print

                            </a>


                            <a
                                href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportSupplierQuotationComparisonExcel(event)"
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
             COMPARISON REPORT
        ====================================================== -->

        <?php if (isset($records)) { ?>

            <div class="card mt-3">

                <div class="card-body">

                    <?php if (!empty($records)) { ?>

                        <?php

                        /*
                         * =================================================
                         * BUILD SUPPLIER LIST
                         * =================================================
                         */

                        $suppliers = array();

                        foreach ($records as $row) {

                            /*
                             * One quotation = one comparison column.
                             *
                             * This is important because two different
                             * RFQs can belong to the same supplier.
                             */
                            $supplier_key =
                                !empty($row->quotation_id)
                                ? $row->quotation_id
                                : $row->supplier_id;

                            if (!isset($suppliers[$supplier_key])) {

                                $suppliers[$supplier_key] = array(

                                    'supplier_id' =>
                                    $row->supplier_id,

                                    'supplier_name' =>
                                    $row->supplier_name,

                                    'rfq_code' =>
                                    $row->rfq_code,

                                    'quotation_code' =>
                                    $row->quotation_code,

                                    'revision' =>
                                    $row->revision,

                                    'subtotal' =>
                                    $row->subtotal,

                                    'vat_amt' =>
                                    $row->vat_amt,

                                    'grand_total' =>
                                    $row->grand_total,

                                    'payment_term' =>
                                    $row->payment_term,

                                    'delivery_term' =>
                                    $row->delivery_term,

                                    'validity' =>
                                    $row->validity,

                                    'po_created' =>
                                    $row->po_created

                                );
                            }
                        }


                        /*
                         * =================================================
                         * BUILD PRODUCT LIST
                         * =================================================
                         */

                        $products = array();

                        foreach ($records as $row) {

                            $product_key = $row->product_id;

                            if (!isset($products[$product_key])) {

                                $products[$product_key] = array(

                                    'product_id' =>
                                    $row->product_id,

                                    'product_code' =>
                                    $row->product_code,

                                    'product_name' =>
                                    $row->product_name,

                                    'unit_name' =>
                                    $row->unit_name,

                                    'quantity' =>
                                    $row->quantity

                                );
                            }
                        }


                        /*
                         * =================================================
                         * SUPPLIER PRICE MATRIX
                         * =================================================
                         */

                        $price_matrix = array();

                        foreach ($records as $row) {

                            $supplier_key =
                                !empty($row->quotation_id)
                                ? $row->quotation_id
                                : $row->supplier_id;

                            $product_key =
                                $row->product_id;

                            if (!isset(
                                $price_matrix[$product_key]
                            )) {

                                $price_matrix[$product_key] =
                                    array();
                            }

                            $price_matrix[$product_key][$supplier_key] =
                                $row->unit_price;
                        }

                        ?>


                        <!-- =================================================
                             REPORT HEADING
                        ================================================== -->

                        <div
                            class="text-center"
                            style="margin-bottom:20px;">

                            <h3 style="margin-bottom:5px;">

                                <strong>
                                    SUPPLIER QUOTATION COMPARISON
                                </strong>

                            </h3>

                            <div>

                                From

                                <strong>
                                    <?php
                                    echo !empty($from)
                                        ? date(
                                            'd-M-Y',
                                            strtotime($from)
                                        )
                                        : '-';
                                    ?>
                                </strong>

                                &nbsp;&nbsp;

                                To

                                <strong>
                                    <?php
                                    echo !empty($to)
                                        ? date(
                                            'd-M-Y',
                                            strtotime($to)
                                        )
                                        : '-';
                                    ?>
                                </strong>

                            </div>

                        </div>


                        <!-- =================================================
                             SUPPLIER SUMMARY
                        ================================================== -->

                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>Supplier</th>

                                        <th>RFQ</th>

                                        <th>Quotation</th>

                                        <th>Revision</th>

                                        <th>Subtotal</th>

                                        <th>VAT</th>

                                        <th>Grand Total</th>

                                        <th>PO Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach (
                                        $suppliers
                                        as $supplier
                                    ) { ?>

                                        <tr>

                                            <td>
                                                <?php
                                                echo !empty($supplier['supplier_name'])
                                                    ? html_escape(
                                                        $supplier['supplier_name']
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo !empty($supplier['rfq_code'])
                                                    ? html_escape(
                                                        $supplier['rfq_code']
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo !empty($supplier['quotation_code'])
                                                    ? html_escape(
                                                        $supplier['quotation_code']
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <td class="text-center">
                                                <?php
                                                echo isset(
                                                    $supplier['revision']
                                                )
                                                    ? $supplier['revision']
                                                    : '0';
                                                ?>
                                            </td>

                                            <td class="text-right">
                                                <?php
                                                echo number_format(
                                                    (float)$supplier['subtotal'],
                                                    2
                                                );
                                                ?>
                                            </td>

                                            <td class="text-right">
                                                <?php
                                                echo number_format(
                                                    (float)$supplier['vat_amt'],
                                                    2
                                                );
                                                ?>
                                            </td>

                                            <td class="text-right">
                                                <strong>
                                                    <?php
                                                    echo number_format(
                                                        (float)$supplier['grand_total'],
                                                        2
                                                    );
                                                    ?>
                                                </strong>
                                            </td>

                                            <td class="text-center">

                                                <?php
                                                echo (
                                                    !empty($supplier['po_created'])
                                                    &&
                                                    $supplier['po_created'] == 1
                                                )
                                                    ? 'PO Created'
                                                    : 'Pending';
                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>


                        <br>


                        <!-- =================================================
                             PRICE COMPARISON
                        ================================================== -->

                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th rowspan="2">
                                            Sl No
                                        </th>

                                        <th rowspan="2">
                                            Product Code
                                        </th>

                                        <th rowspan="2">
                                            Product Name
                                        </th>

                                        <th rowspan="2">
                                            Unit
                                        </th>

                                        <th rowspan="2">
                                            Qty
                                        </th>

                                        <?php foreach (
                                            $suppliers
                                            as $supplier_key => $supplier
                                        ) { ?>

                                            <th
                                                class="text-center"
                                                style="min-width:160px;">

                                                <?php
                                                echo html_escape(
                                                    $supplier['supplier_name']
                                                );
                                                ?>

                                                <br>

                                                <small>

                                                    <?php
                                                    echo html_escape(
                                                        $supplier['quotation_code']
                                                    );
                                                    ?>

                                                </small>

                                            </th>

                                        <?php } ?>

                                    </tr>

                                    <tr>

                                        <?php foreach (
                                            $suppliers
                                            as $supplier_key => $supplier
                                        ) { ?>

                                            <th class="text-center">
                                                Unit Price
                                            </th>

                                        <?php } ?>

                                    </tr>

                                </thead>


                                <tbody>

                                    <?php $sl = 1; ?>

                                    <?php foreach (
                                        $products
                                        as $product_key => $product
                                    ) { ?>

                                        <?php

                                        /*
                                         * Find lowest price
                                         */

                                        $lowest_price = null;

                                        if (
                                            isset(
                                                $price_matrix[$product_key]
                                            )
                                        ) {

                                            foreach (
                                                $price_matrix[$product_key]
                                                as $price
                                            ) {

                                                if (
                                                    $price !== null &&
                                                    $price !== '' &&
                                                    (float)$price > 0
                                                ) {

                                                    if (
                                                        $lowest_price === null ||
                                                        (float)$price <
                                                        $lowest_price
                                                    ) {

                                                        $lowest_price =
                                                            (float)$price;
                                                    }
                                                }
                                            }
                                        }

                                        ?>

                                        <tr>

                                            <td class="text-center">
                                                <?php echo $sl++; ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo !empty($product['product_code'])
                                                    ? html_escape(
                                                        $product['product_code']
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo !empty($product['product_name'])
                                                    ? html_escape(
                                                        $product['product_name']
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <td class="text-center">
                                                <?php
                                                echo !empty($product['unit_name'])
                                                    ? html_escape(
                                                        $product['unit_name']
                                                    )
                                                    : '-';
                                                ?>
                                            </td>

                                            <td class="text-right">
                                                <?php
                                                echo number_format(
                                                    (float)$product['quantity'],
                                                    2
                                                );
                                                ?>
                                            </td>


                                            <?php foreach (
                                                $suppliers
                                                as $supplier_key =>
                                                $supplier
                                            ) { ?>

                                                <?php

                                                $price = null;

                                                if (
                                                    isset(
                                                        $price_matrix[$product_key][$supplier_key]
                                                    )
                                                ) {

                                                    $price =
                                                        $price_matrix[$product_key][$supplier_key];
                                                }

                                                $is_lowest =
                                                    $lowest_price !== null &&
                                                    $price !== null &&
                                                    $price !== '' &&
                                                    (float)$price ==
                                                    $lowest_price;

                                                ?>

                                                <td
                                                    class="text-right"
                                                    <?php
                                                    if ($is_lowest) {
                                                        echo 'style="font-weight:bold;background:#dff0d8;"';
                                                    }
                                                    ?>>

                                                    <?php if (
                                                        $price !== null &&
                                                        $price !== ''
                                                    ) { ?>

                                                        <?php
                                                        echo number_format(
                                                            (float)$price,
                                                            2
                                                        );
                                                        ?>

                                                        <?php if (
                                                            $is_lowest
                                                        ) { ?>

                                                            <br>

                                                            <small
                                                                style="font-weight:bold;">
                                                                Lowest
                                                            </small>

                                                        <?php } ?>

                                                    <?php } else { ?>

                                                        -

                                                    <?php } ?>

                                                </td>

                                            <?php } ?>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>


                        <!-- =================================================
                             COMPARISON NOTE
                        ================================================== -->

                        <div
                            class="alert alert-info"
                            style="margin-top:15px;">

                            <i class="fa fa-info-circle"></i>

                            <strong>
                                Note:
                            </strong>

                            The lowest unit price for each product is
                            highlighted as the preferred quotation for
                            comparison purposes.

                        </div>


                    <?php } else { ?>

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>
                                        Supplier Quotation Comparison
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td class="text-center">

                                        No Supplier Quotation records
                                        found for the selected criteria.

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

    </section>

</div>


<script>
    /* =========================================================
       PRINT SUPPLIER QUOTATION COMPARISON
    ========================================================= */

    function printSupplierQuotationComparison(event) {

        if (event) {
            event.preventDefault();
        }

        var fromDate =
            document.getElementById('from_date').value;

        var toDate =
            document.getElementById('to_date').value;

        var rfqIds =
            $('#rfq_ids').val();

        if (!rfqIds || rfqIds.length === 0) {

            alert('Please select at least one RFQ.');

            return false;
        }

        var baseUrl =
            "<?php echo base_url(
                    'index.php/Reports/print_supplier_quotation_comparison'
                ); ?>";

        var params =
            new URLSearchParams();

        params.append(
            'from_date',
            fromDate
        );

        params.append(
            'to_date',
            toDate
        );

        $.each(
            rfqIds,
            function(index, value) {

                params.append(
                    'rfq_ids[]',
                    value
                );

            }
        );

        window.open(
            baseUrl + '?' + params.toString(),
            '_blank'
        );

        return false;
    }


    /* =========================================================
       EXPORT SUPPLIER QUOTATION COMPARISON
    ========================================================= */

    function exportSupplierQuotationComparisonExcel(event) {

        if (event) {
            event.preventDefault();
        }

        var fromDate =
            document.getElementById('from_date').value;

        var toDate =
            document.getElementById('to_date').value;

        var rfqIds =
            $('#rfq_ids').val();

        if (!rfqIds || rfqIds.length === 0) {

            alert('Please select at least one RFQ.');

            return false;
        }

        var baseUrl =
            "<?php echo base_url(
                    'index.php/Reports/export_supplier_quotation_comparison_excel'
                ); ?>";

        var params =
            new URLSearchParams();

        params.append(
            'from_date',
            fromDate
        );

        params.append(
            'to_date',
            toDate
        );

        $.each(
            rfqIds,
            function(index, value) {

                params.append(
                    'rfq_ids[]',
                    value
                );

            }
        );

        window.location.href =
            baseUrl + '?' + params.toString();

        return false;
    }
</script>