<style>

    .report-container {
        padding: 15px;
    }

    .report-filter {
        background: #f7f7f7;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
    }

    .report-filter label {
        font-weight: 600;
        color: #333;
    }

    .report-summary {
        margin-bottom: 15px;
    }

    .summary-box {
        border: 1px solid #ddd;
        background: #fff;
        padding: 15px;
        text-align: center;
    }

    .summary-box h4 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .summary-box span {
        color: #777;
        font-size: 13px;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle !important;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
    }

    .report-title {
        margin-bottom: 15px;
    }

</style>


<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12">

        <div class="x_panel">

            <div class="x_title">

                <h2>
                    Production Reports
                </h2>

                <div class="clearfix"></div>

            </div>


            <div class="x_content report-container">


                <!-- ================================================= -->
                <!-- FILTER -->
                <!-- ================================================= -->

                <div class="report-filter">

                    <div class="row">

                        <div class="col-md-2">

                            <label>
                                From Date
                            </label>

                            <input
                                type="date"
                                id="report_from_date"
                                class="form-control">

                        </div>


                        <div class="col-md-2">

                            <label>
                                To Date
                            </label>

                            <input
                                type="date"
                                id="report_to_date"
                                class="form-control">

                        </div>


                        <div class="col-md-3">

                            <label>
                                Project
                            </label>

                            <select
                                id="report_project_id"
                                class="form-control">

                                <option value="">
                                    All Projects
                                </option>

                                <?php foreach ($projects as $project): ?>

                                    <option
                                        value="<?= $project['project_id']; ?>">

                                        <?= htmlspecialchars(
                                            $project['project_name']
                                        ); ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <div class="col-md-3">

                            <label>
                                Job Order
                            </label>

                            <select
                                id="report_job_order_id"
                                class="form-control">

                                <option value="">
                                    All Job Orders
                                </option>

                                <?php foreach ($job_orders as $jo): ?>

                                    <option
                                        value="<?= $jo['job_order_id']; ?>">

                                        <?= htmlspecialchars(
                                            $jo['job_order_no']
                                        ); ?>

                                        -
                                        <?= htmlspecialchars(
                                            $jo['project_name']
                                        ); ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!--<div class="col-md-2">

                            <label>
                                Status
                            </label>

                            <select
                                id="report_status"
                                class="form-control">

                                <option value="">
                                    All
                                </option>

                                <option value="Pending">
                                    Pending
                                </option>

                                <option value="In Progress">
                                    In Progress
                                </option>

                                <option value="Completed">
                                    Completed
                                </option>

                                <option value="QC Passed">
                                    QC Passed
                                </option>

                                <option value="Rework">
                                    Rework
                                </option>

                            </select>

                        </div>-->

                    </div>


                    <div class="row mt-3">

                        <div class="col-md-12">

                            <button
                                type="button"
                                class="btn btn-primary"
                                id="generateReport">

                                <i class="fa fa-search"></i>
                                Generate Report

                            </button>


                            <button
                                type="button"
                                class="btn btn-secondary"
                                id="resetReport">

                                <i class="fa fa-refresh"></i>
                                Reset

                            </button>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- REPORT TABS -->
                <!-- ================================================= -->

                <ul class="nav nav-tabs" id="productionReportTabs">

                    <li class="nav-item">

                        <a
                            class="nav-link active"
                            data-toggle="tab"
                            href="#summaryReport">

                            Production Summary

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#jobOrderReport">

                            Job Orders

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#completionReport">

                            Job Completion

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#materialRequestReport">

                            Material Requests

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#stockTransferReport">

                            Stock Transfer

                        </a>

                    </li>

                </ul>


                <div class="tab-content mt-3">


                    <!-- ================================================= -->
                    <!-- SUMMARY -->
                    <!-- ================================================= -->

                    <div
                        class="tab-pane fade show active"
                        id="summaryReport">

                        <div class="report-summary">

                            <div class="row">

                                <div class="col-md-3">

                                    <div class="summary-box">

                                        <h4 id="summaryJobOrders">
                                            0
                                        </h4>

                                        <span>
                                            Job Orders
                                        </span>

                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <div class="summary-box">

                                        <h4 id="summaryOrdered">
                                            0.00
                                        </h4>

                                        <span>
                                            Ordered Quantity
                                        </span>

                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <div class="summary-box">

                                        <h4 id="summaryCompleted">
                                            0.00
                                        </h4>

                                        <span>
                                            Completed Quantity
                                        </span>

                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <div class="summary-box">

                                        <h4 id="summaryRemaining">
                                            0.00
                                        </h4>

                                        <span>
                                            Remaining Quantity
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped"
                                id="summaryTable"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Job Order</th>
                                        <th>Project</th>
                                        <th>Order Date</th>
                                        <th>Items</th>
                                        <th>Ordered Qty</th>
                                        <th>Completed Qty</th>
                                        <th>Remaining Qty</th>
                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- JOB ORDER -->
                    <!-- ================================================= -->

                    <div
                        class="tab-pane fade"
                        id="jobOrderReport">

                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped"
                                id="jobOrderTable"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Job Order</th>
                                        <th>Project</th>
                                        <th>Order Date</th>
                                        <th>Product</th>
                                        <th>Code</th>
                                        <th>Ordered Qty</th>
                                        <th>Completed Qty</th>
                                        <th>Remaining Qty</th>
                                        <th>Unit</th>
                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- COMPLETION -->
                    <!-- ================================================= -->

                    <div
                        class="tab-pane fade"
                        id="completionReport">

                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped"
                                id="completionTable"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Completion No</th>
                                        <th>Date</th>
                                        <th>Job Order</th>
                                        <th>Project</th>
                                        <th>Product</th>
                                        <th>Ordered</th>
                                        <th>Completed</th>
                                        <th>Remaining</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- MATERIAL REQUEST -->
                    <!-- ================================================= -->

                    <div
                        class="tab-pane fade"
                        id="materialRequestReport">

                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped"
                                id="materialRequestTable"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Request No</th>
                                        <th>Date</th>
                                        <th>Job Order</th>
                                        <th>Material</th>
                                        <th>Code</th>
                                        <th>Required</th>
                                        <th>Requested</th>
                                        <th>Unit</th>
                                        <th>Unit Cost</th>
                                        <th>Total Cost</th>
                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- STOCK TRANSFER -->
                    <!-- ================================================= -->

                    <div
                        class="tab-pane fade"
                        id="stockTransferReport">

                        <div class="report-summary">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="summary-box">

                                        <h4 id="transferCount">
                                            0
                                        </h4>

                                        <span>
                                            Total Transfers
                                        </span>

                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <div class="summary-box">

                                        <h4 id="transferItems">
                                            0
                                        </h4>

                                        <span>
                                            Total Items
                                        </span>

                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <div class="summary-box">

                                        <h4 id="transferQuantity">
                                            0.00
                                        </h4>

                                        <span>
                                            Transfer Quantity
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped"
                                id="stockTransferTable"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Transfer No</th>
                                        <th>Reference</th>
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Job Order</th>
                                        <th>Completion No</th>
                                        <th>Product</th>
                                        <th>Code</th>
                                        <th>Completed</th>
                                        <th>Transfer Qty</th>
                                        <th>Remaining</th>
                                        <th>Unit</th>
                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script>

$(document).ready(function () {

    /* ============================================================
     * DATATABLE REFERENCES
     * ============================================================ */

    var summaryTable = null;
    var jobOrderTable = null;
    var completionTable = null;
    var materialRequestTable = null;
    var stockTransferTable = null;


    /* ============================================================
     * COMMON FUNCTIONS
     * ============================================================ */

    function numberFormat(value)
    {
        value = parseFloat(value || 0);

        return value.toFixed(2);
    }


    function getFilters()
    {
        return {
            from_date: $('#report_from_date').val(),
            to_date: $('#report_to_date').val(),
            project_id: $('#report_project_id').val(),
            job_order_id: $('#report_job_order_id').val(),
            status: $('#report_status').val()
        };
    }


    /*
     * Escape HTML before displaying database values.
     */
    function escapeHtml(value)
    {
        if (value === null || value === undefined) {
            return '';
        }

        return $('<div>')
            .text(value)
            .html();
    }


    /*
     * Destroy existing DataTable and clear tbody.
     */
    function destroyTable(selector)
    {
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().clear().destroy();
        }

        $(selector + ' tbody').empty();
    }


    /*
     * Common DataTable configuration.
     */
    function initializeDataTable(selector, orderColumn)
    {
        return $(selector).DataTable({

            destroy: true,

            responsive: true,

            pageLength: 10,

            dom: 'Bfrtip',

            buttons: [
                'excel',
                'csv',
                'pdf',
                'print'
            ],

            order: [
                [orderColumn, 'desc']
            ]

        });
    }


    /*
     * Common AJAX error handler.
     */
    function ajaxError(xhr, status, error)
    {
        console.error('Report AJAX Error:', error);
        console.error(xhr.responseText);

        alert('Unable to load report data.');
    }



    /* ============================================================
     * 1. SUMMARY REPORT
     * ============================================================ */

    function loadSummaryReport()
    {
        $.ajax({

            url: '<?= base_url("index.php/Production/get_production_summary_report"); ?>',

            type: 'POST',

            dataType: 'json',

            data: getFilters(),

            success: function(response)
            {
                var data = response.data || [];

                destroyTable('#summaryTable');

                var html = '';

                var totalOrdered = 0;
                var totalCompleted = 0;
                var totalRemaining = 0;


                $.each(data, function(i, row)
                {
                    totalOrdered += parseFloat(
                        row.ordered_quantity || 0
                    );

                    totalCompleted += parseFloat(
                        row.completed_quantity || 0
                    );

                    totalRemaining += parseFloat(
                        row.remaining_quantity || 0
                    );


                    html += '<tr>';

                    html += '<td>' +
                        (i + 1) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_order_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.project_name) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.order_date) +
                        '</td>';

                    html += '<td>' +
                        (row.total_items || 0) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.ordered_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.completed_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.remaining_quantity) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.status) +
                        '</td>';

                    html += '</tr>';
                });


                $('#summaryTable tbody').html(html);


                /*
                 * Summary cards
                 */
                $('#summaryJobOrders')
                    .text(data.length);

                $('#summaryOrdered')
                    .text(Math.floor(totalOrdered));

                $('#summaryCompleted')
                    .text(Math.floor(totalCompleted));

                $('#summaryRemaining')
                    .text(Math.floor(totalRemaining));


                /*
                 * Initialize DataTable
                 */
                summaryTable = initializeDataTable(
                    '#summaryTable',
                    3
                );
            },

            error: ajaxError

        });
    }



    /* ============================================================
     * 2. JOB ORDER REPORT
     * ============================================================ */

    function loadJobOrderReport()
    {
        $.ajax({

            url: '<?= base_url("index.php/Production/get_job_order_report"); ?>',

            type: 'POST',

            dataType: 'json',

            data: getFilters(),

            success: function(response)
            {
                var data = response.data || [];

                destroyTable('#jobOrderTable');

                var html = '';


                $.each(data, function(i, row)
                {
                    html += '<tr>';

                    html += '<td>' +
                        (i + 1) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_order_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.project_name) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.order_date) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(
                            row.product_name ||
                            row.item_description ||
                            ''
                        ) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.item_code) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.ordered_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.completed_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.remaining_quantity) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.unit) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.status) +
                        '</td>';

                    html += '</tr>';
                });


                $('#jobOrderTable tbody').html(html);


                jobOrderTable = initializeDataTable(
                    '#jobOrderTable',
                    3
                );
            },

            error: ajaxError

        });
    }



    /* ============================================================
     * 3. JOB COMPLETION REPORT
     * ============================================================ */

    function loadCompletionReport()
    {
        $.ajax({

            url: '<?= base_url("index.php/Production/get_job_completion_report"); ?>',

            type: 'POST',

            dataType: 'json',

            data: getFilters(),

            success: function(response)
            {
                var data = response.data || [];

                destroyTable('#completionTable');

                var html = '';


                $.each(data, function(i, row)
                {
                    html += '<tr>';

                    html += '<td>' +
                        (i + 1) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_completion_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.completion_date) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_order_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.project_name) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(
                            row.product_name ||
                            row.item_description ||
                            ''
                        ) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.ordered_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.completed_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.remaining_quantity) +
                        '</td>';

                    html += '</tr>';
                });


                $('#completionTable tbody').html(html);


                completionTable = initializeDataTable(
                    '#completionTable',
                    2
                );
            },

            error: ajaxError

        });
    }



    /* ============================================================
     * 4. MATERIAL REQUEST REPORT
     * ============================================================ */

    function loadMaterialRequestReport()
    {
        $.ajax({

            url: '<?= base_url("index.php/Production/get_material_request_report"); ?>',

            type: 'POST',

            dataType: 'json',

            data: getFilters(),

            success: function(response)
            {
                var data = response.data || [];

                destroyTable('#materialRequestTable');

                var html = '';


                $.each(data, function(i, row)
                {
                    html += '<tr>';

                    html += '<td>' +
                        (i + 1) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.material_request_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.request_date) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_order_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.material_name) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.material_code) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.required_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.request_quantity) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.unit) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.unit_cost) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.total_cost) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.status) +
                        '</td>';

                    html += '</tr>';
                });


                $('#materialRequestTable tbody').html(html);


                materialRequestTable = initializeDataTable(
                    '#materialRequestTable',
                    2
                );
            },

            error: ajaxError

        });
    }



    /* ============================================================
     * 5. STOCK TRANSFER REPORT
     * ============================================================ */

    function loadStockTransferReport()
    {
        $.ajax({

            url: '<?= base_url("index.php/Production/get_stock_transfer_report"); ?>',

            type: 'POST',

            dataType: 'json',

            data: getFilters(),

            success: function(response)
            {
                var data = response.data || [];

                destroyTable('#stockTransferTable');

                var html = '';

                var transferIds = {};

                var totalQuantity = 0;


                $.each(data, function(i, row)
                {
                    /*
                     * Count unique stock transfers
                     */
                    if (
                        row.stock_transfer_id !== null &&
                        row.stock_transfer_id !== undefined &&
                        row.stock_transfer_id !== ''
                    ) {
                        transferIds[
                            row.stock_transfer_id
                        ] = true;
                    }


                    /*
                     * Total transferred quantity
                     */
                    totalQuantity += parseFloat(
                        row.transfer_quantity || 0
                    );


                    html += '<tr>';

                    html += '<td>' +
                        (i + 1) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.stock_transfer_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.ref_number) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.ref_date) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.project_name) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_order_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.job_completion_no) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(
                            row.product_name ||
                            row.item_description ||
                            ''
                        ) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.item_code) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.completed_quantity) +
                        '</td>';

                    

                    html += '<td class="text-right">' +
                        numberFormat(row.transfer_quantity) +
                        '</td>';

                    html += '<td class="text-right">' +
                        numberFormat(row.remaining_quantity) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.unit) +
                        '</td>';

                    html += '<td>' +
                        escapeHtml(row.status) +
                        '</td>';

                    html += '</tr>';
                });


                $('#stockTransferTable tbody').html(html);


                /*
                 * Stock transfer summary cards
                 */
                $('#transferCount')
                    .text(
                        Object.keys(transferIds).length
                    );

                $('#transferItems')
                    .text(data.length);

                $('#transferQuantity')
                    .text(
                        numberFormat(totalQuantity)
                    );


                /*
                 * Initialize DataTable
                 */
                stockTransferTable = initializeDataTable(
                    '#stockTransferTable',
                    3
                );
            },

            error: ajaxError

        });
    }



    /* ============================================================
     * LOAD ALL REPORTS
     * ============================================================ */

    function loadAllReports()
    {
        loadSummaryReport();

        loadJobOrderReport();

        loadCompletionReport();

        loadMaterialRequestReport();

        loadStockTransferReport();
    }



    /* ============================================================
     * GENERATE REPORT
     * ============================================================ */

    $('#generateReport').on('click', function()
    {
        loadAllReports();
    });



    /* ============================================================
     * RESET REPORT
     * ============================================================ */

    $('#resetReport').on('click', function()
    {
        $('#report_from_date').val('');

        $('#report_to_date').val('');

        $('#report_project_id').val('');

        $('#report_job_order_id').val('');

        $('#report_status').val('');


        loadAllReports();
    });



    /* ============================================================
     * INITIAL LOAD
     * ============================================================ */

    loadAllReports();

});

</script>