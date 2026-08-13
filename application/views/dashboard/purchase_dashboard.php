<style>
    /* =========================================================
       DASHBOARD COMMON STYLES
    ========================================================= */

    .kpi-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
        min-height: 135px;
    }

    .kpi-card i {
        font-size: 34px;
        float: right;
        opacity: .30;
    }

    .kpi-card h4 {
        margin-top: 0;
        font-weight: 500;
    }

    .kpi-card h2 {
        margin-bottom: 0;
        font-weight: 600;
    }


    /* =========================================================
       KPI COLORS
    ========================================================= */

    .bg1 {
        background: #3498db;
    }

    .bg2 {
        background: #27ae60;
    }

    .bg3 {
        background: #e67e22;
    }

    .bg4 {
        background: #8e44ad;
    }

    .bg5 {
        background: #16a085;
    }

    .bg6 {
        background: #c0392b;
    }


    /* =========================================================
       MODERN PANEL
    ========================================================= */

    .panel-modern {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        margin-bottom: 20px;
    }

    .panel-modern h4 {
        margin-top: 0;
        margin-bottom: 15px;
        font-weight: 600;
        color: #607d9f;
    }


    /* =========================================================
       QUICK ACTION BUTTON
    ========================================================= */

    .quick-btn {
        display: block;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ddd;
        border-radius: 6px;
        color: #333;
        text-decoration: none;
        transition: all .2s ease;
    }

    .quick-btn:hover {
        background: #f5f5f5;
        text-decoration: none;
    }


    /* =========================================================
       PURCHASE PROCESS
    ========================================================= */

    .pipeline-box {
        text-align: center;
        padding: 15px 5px;
        border-right: 1px solid #eee;
    }

    .pipeline-box:last-child {
        border-right: none;
    }

    .pipeline-count {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #607d9f;
    }

    .pipeline-title {
        color: #777;
        font-size: 13px;
    }


    /* =========================================================
       ACTIVITIES
    ========================================================= */

    .activity-list {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .activity-list li {
        padding: 6px 0;
    }


    /* =========================================================
       TABLES
    ========================================================= */

    .empty-row {
        text-align: center;
        color: #999;
        padding: 15px !important;
    }

    .status-label {
        font-size: 11px;
    }


    /* =========================================================
       VALUE BOX
    ========================================================= */

    .value-box {
        text-align: center;
        padding: 15px;
    }

    .value-box h2 {
        margin: 5px 0;
        font-weight: 600;
        color: #607d9f;
    }

    .value-box p {
        color: #777;
        margin-bottom: 0;
    }


    /* =========================================================
       CHART
    ========================================================= */

    .chart-container {
        position: relative;
        height: 300px;
    }

    .vendor-chart {
        height: 350px;
    }


    /* =========================================================
       SMALL RESPONSIVE FIX
    ========================================================= */

    @media (max-width: 767px) {

        .pipeline-box {
            border-right: none;
            border-bottom: 1px solid #eee;
        }

        .pipeline-box:last-child {
            border-bottom: none;
        }

        .chart-container {
            height: 280px;
        }

        .vendor-chart {
            height: 320px;
        }
    }
</style>


<!-- =========================================================
     1. PURCHASE KPI CARDS
========================================================= -->

<div class="row">

    <!-- Purchase Today -->

    <div class="col-md-4 col-sm-6">

        <div class="kpi-card bg1">

            <i class="fa fa-calendar"></i>

            <h4>
                Purchase Today
            </h4>

            <h2>
                <?= number_format((float)$purchase_today, 2) ?>
            </h2>

        </div>

    </div>


    <!-- Monthly Purchase -->

    <div class="col-md-4 col-sm-6">

        <div class="kpi-card bg2">

            <i class="fa fa-line-chart"></i>

            <h4>
                Monthly Purchase
            </h4>

            <h2>
                <?= number_format((float)$monthly_purchase, 2) ?>
            </h2>

        </div>

    </div>


    <!-- Pending PO -->

    <div class="col-md-4 col-sm-6">

        <div class="kpi-card bg3">

            <i class="fa fa-shopping-cart"></i>

            <h4>
                Pending Purchase Orders
            </h4>

            <h2>
                <?= (int)$pending_po ?>
            </h2>

        </div>

    </div>

</div>


<div class="row">

    <!-- Purchase Returns -->

    <div class="col-md-4 col-sm-6">

        <div class="kpi-card bg4">

            <i class="fa fa-undo"></i>

            <h4>
                Purchase Returns
            </h4>

            <h2>
                <?= isset($purchase_return_summary->total_returns)
                    ? (int)$purchase_return_summary->total_returns
                    : 0 ?>
            </h2>

        </div>

    </div>


    <!-- Average Purchase Cost -->

    <div class="col-md-4 col-sm-6">

        <div class="kpi-card bg5">

            <i class="fa fa-money"></i>

            <h4>
                Average Purchase Cost
            </h4>

            <h2>
                <?= number_format((float)$average_purchase_cost, 2) ?>
            </h2>

        </div>

    </div>


    <!-- PO Awaiting GRN -->

    <div class="col-md-4 col-sm-6">

        <div class="kpi-card bg6">

            <i class="fa fa-truck"></i>

            <h4>
                POs Awaiting GRN
            </h4>

            <h2>
                <?= (int)$pending_po ?>
            </h2>

        </div>

    </div>

</div>


<!-- =========================================================
     2. PURCHASE PROCESS OVERVIEW
========================================================= -->

<div class="panel-modern">

    <h4>

        <i class="fa fa-sitemap"></i>

        Purchase Process Overview

    </h4>


    <div class="row">

        <!-- RFQ -->

        <div class="col-md-3 col-sm-6">

            <div class="pipeline-box">

                <div class="pipeline-count">

                    <?= (int)$rfq_count ?>

                </div>

                <div class="pipeline-title">

                    RFQs

                </div>

            </div>

        </div>


        <!-- Quotations -->

        <div class="col-md-3 col-sm-6">

            <div class="pipeline-box">

                <div class="pipeline-count">

                    <?= (int)$quotation_count ?>

                </div>

                <div class="pipeline-title">

                    Supplier Quotations

                </div>

            </div>

        </div>


        <!-- Purchase Orders -->

        <div class="col-md-3 col-sm-6">

            <div class="pipeline-box">

                <div class="pipeline-count">

                    <?= (int)$po_count ?>

                </div>

                <div class="pipeline-title">

                    Purchase Orders

                </div>

            </div>

        </div>


        <!-- GRN -->

        <div class="col-md-3 col-sm-6">

            <div class="pipeline-box">

                <div class="pipeline-count">

                    <?= (int)$grn_count ?>

                </div>

                <div class="pipeline-title">

                    GRNs

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     3. PENDING WORK
========================================================= -->

<div class="row">

    <!-- Pending RFQ -->

    <div class="col-md-3 col-sm-6">

        <div class="panel panel-default">

            <div class="panel-body text-center">

                <h3>
                    <?= (int)$pending_rfq ?>
                </h3>

                <h4>
                    Pending RFQ
                </h4>

            </div>

        </div>

    </div>


    <!-- Pending Quotation -->

    <div class="col-md-3 col-sm-6">

        <div class="panel panel-default">

            <div class="panel-body text-center">

                <h3>
                    <?= (int)$pending_quotation ?>
                </h3>

                <h4>
                    Pending Quotation
                </h4>

            </div>

        </div>

    </div>


    <!-- PO Awaiting GRN -->

    <div class="col-md-3 col-sm-6">

        <div class="panel panel-default">

            <div class="panel-body text-center">

                <h3>
                    <?= (int)$pending_po ?>
                </h3>

                <h4>
                    POs Awaiting GRN
                </h4>

            </div>

        </div>

    </div>


    <!-- Pending GRN -->

    <div class="col-md-3 col-sm-6">

        <div class="panel panel-default">

            <div class="panel-body text-center">

                <h3>
                    <?= (int)$pending_grn ?>
                </h3>

                <h4>
                    Pending GRN
                </h4>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     4. CHARTS
========================================================= -->

<div class="row">

    <!-- MONTHLY PURCHASE BAR CHART -->

    <div class="col-md-8">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-bar-chart"></i>

                Monthly Purchase Trend

            </h4>


            <div class="chart-container">

                <canvas id="purchaseTrendChart"></canvas>

            </div>

        </div>

    </div>


    <!-- PURCHASE WORKFLOW DOUGHNUT -->

    <div class="col-md-4">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-pie-chart"></i>

                Purchase Workflow

            </h4>


            <div class="chart-container">

                <canvas id="purchaseWorkflowChart"></canvas>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     5. TODAY'S ACTIVITIES
========================================================= -->

<div class="row">

    <div class="col-md-12">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-clock-o"></i>

                Today's Activities

            </h4>


            <div class="row">

                <div class="col-md-3 col-sm-6">

                    <div class="text-center">

                        <h3>
                            <?= (int)$today_rfq ?>
                        </h3>

                        <p>
                            RFQs Created
                        </p>

                    </div>

                </div>


                <div class="col-md-3 col-sm-6">

                    <div class="text-center">

                        <h3>
                            <?= (int)$today_quotation ?>
                        </h3>

                        <p>
                            Supplier Quotations
                        </p>

                    </div>

                </div>


                <div class="col-md-3 col-sm-6">

                    <div class="text-center">

                        <h3>
                            <?= (int)$today_po ?>
                        </h3>

                        <p>
                            Purchase Orders
                        </p>

                    </div>

                </div>


                <div class="col-md-3 col-sm-6">

                    <div class="text-center">

                        <h3>
                            <?= (int)$today_grn ?>
                        </h3>

                        <p>
                            GRNs Created
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     6. RECENT RFQs + RECENT PURCHASE ORDERS
========================================================= -->

<div class="row">

    <!-- RECENT RFQs -->

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-list"></i>

                Recent RFQs

            </h4>


            <div class="table-responsive">

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th>
                                RFQ No
                            </th>

                            <th>
                                Supplier
                            </th>

                            <th>
                                Date
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($recent_rfq)) { ?>

                            <?php foreach ($recent_rfq as $row) { ?>

                                <tr>

                                    <td>
                                        <?= html_escape($row->rfq_code) ?>
                                    </td>

                                    <td>
                                        <?= html_escape($row->supplier_name) ?>
                                    </td>

                                    <td>

                                        <?= date(
                                            'd-m-Y',
                                            strtotime($row->rfq_date)
                                        ); ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>

                                <td colspan="3"
                                    class="empty-row">

                                    No recent RFQs found.

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- RECENT PURCHASE ORDERS -->

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-shopping-cart"></i>

                Recent Purchase Orders

            </h4>


            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>
                                PO
                            </th>

                            <th>
                                Supplier
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($recent_po)) { ?>

                            <?php foreach ($recent_po as $row) { ?>

                                <tr>

                                    <td>
                                        <?= html_escape($row->po_code) ?>
                                    </td>

                                    <td>
                                        <?= html_escape($row->supplier_name) ?>
                                    </td>

                                    <td>

                                        <?php if ($row->grn_status == 0) { ?>

                                            <span class="label label-warning status-label">

                                                Pending GRN

                                            </span>

                                        <?php } else { ?>

                                            <span class="label label-success status-label">

                                                Completed

                                            </span>

                                        <?php } ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>

                                <td colspan="3"
                                    class="empty-row">

                                    No recent Purchase Orders found.

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     7. PURCHASE VALUES
========================================================= -->

<div class="row">

    <!-- Quotation Value -->

    <div class="col-md-4">

        <div class="panel-modern value-box">

            <p>
                Total Quotation Value
            </p>

            <h2>

                <?= number_format(
                    (float)$quotation_value,
                    2
                ) ?>

            </h2>

        </div>

    </div>


    <!-- PO Value -->

    <div class="col-md-4">

        <div class="panel-modern value-box">

            <p>
                Total Purchase Order Value
            </p>

            <h2>

                <?= number_format(
                    (float)$po_value,
                    2
                ) ?>

            </h2>

        </div>

    </div>


    <!-- GRN Value -->

    <div class="col-md-4">

        <div class="panel-modern value-box">

            <p>
                Total GRN Value
            </p>

            <h2>

                <?= number_format(
                    (float)$grn_value,
                    2
                ) ?>

            </h2>

        </div>

    </div>

</div>


<!-- =========================================================
     8. VENDOR PURCHASE PERFORMANCE CHART
========================================================= -->

<div class="panel-modern">

    <h4>

        <i class="fa fa-bar-chart"></i>

        Vendor Purchase Performance

    </h4>


    <div class="chart-container vendor-chart">

        <canvas id="vendorPurchaseChart"></canvas>

    </div>

</div>


<!-- =========================================================
     9. VENDOR PERFORMANCE TABLE
========================================================= -->

<div class="panel-modern">

    <h4>

        <i class="fa fa-users"></i>

        Vendor Performance

    </h4>


    <div class="table-responsive">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>
                        Supplier
                    </th>

                    <th>
                        Total Orders
                    </th>

                    <th>
                        Total Purchase
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php if (!empty($top_suppliers)) { ?>

                    <?php foreach ($top_suppliers as $supplier) { ?>

                        <tr>

                            <td>
                                <?= html_escape(
                                    $supplier->supplier_name
                                ) ?>
                            </td>

                            <td>
                                <?= (int)$supplier->total_orders ?>
                            </td>

                            <td>

                                <?= number_format(
                                    (float)$supplier->total_amount,
                                    2
                                ) ?>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="3"
                            class="empty-row">

                            No supplier data available.

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<!-- =========================================================
     10. QUICK ACTIONS + PENDING ACTIONS
========================================================= -->

<div class="row">

    <!-- QUICK ACTIONS -->

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-bolt"></i>

                Quick Actions

            </h4>


            <a href="<?= base_url() ?>index.php/Purchase/list_direct_rfq"
                class="quick-btn">

                <i class="fa fa-plus"></i>

                New RFQ

            </a>


            <a href="<?= base_url() ?>index.php/Purchase/purchase_quotation_list"
                class="quick-btn">

                <i class="fa fa-file-text-o"></i>

                Purchase Quotation

            </a>


            <a href="<?= base_url() ?>index.php/Purchase/purchase_order_list"
                class="quick-btn">

                <i class="fa fa-shopping-cart"></i>

                Purchase Order

            </a>


            <a href="<?= base_url() ?>index.php/Purchase/purchase_grn_list"
                class="quick-btn">

                <i class="fa fa-truck"></i>

                GRN

            </a>

        </div>

    </div>


    <!-- PENDING ACTIONS -->

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>

                <i class="fa fa-exclamation-circle"></i>

                Pending Actions

            </h4>


            <table class="table">

                <tr>

                    <td>
                        Pending RFQs
                    </td>

                    <td class="text-right">

                        <strong>
                            <?= (int)$pending_rfq ?>
                        </strong>

                    </td>

                </tr>


                <tr>

                    <td>
                        Pending Supplier Quotations
                    </td>

                    <td class="text-right">

                        <strong>
                            <?= (int)$pending_quotation ?>
                        </strong>

                    </td>

                </tr>


                <tr>

                    <td>
                        POs Awaiting GRN
                    </td>

                    <td class="text-right">

                        <strong>
                            <?= (int)$pending_po ?>
                        </strong>

                    </td>

                </tr>


                <tr>

                    <td>
                        Pending GRNs
                    </td>

                    <td class="text-right">

                        <strong>
                            <?= (int)$pending_grn ?>
                        </strong>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>


<!-- =========================================================
     11. CHART.JS
========================================================= -->

<script>
    $(document).ready(function() {


        /* =====================================================
           MONTHLY PURCHASE BAR CHART
        ===================================================== */

        var monthlyPurchaseData =
            <?= json_encode(
                isset($monthly_purchase_chart)
                    ? $monthly_purchase_chart
                    : array()
            ) ?>;


        var monthlyLabels = [];

        var monthlyValues = [];


        var monthNames = [

            '',

            'Jan',

            'Feb',

            'Mar',

            'Apr',

            'May',

            'Jun',

            'Jul',

            'Aug',

            'Sep',

            'Oct',

            'Nov',

            'Dec'

        ];


        $.each(
            monthlyPurchaseData,
            function(index, item) {

                var monthNumber =
                    parseInt(item.month);


                if (
                    monthNumber >= 1 &&
                    monthNumber <= 12
                ) {

                    monthlyLabels.push(
                        monthNames[monthNumber]
                    );

                } else {

                    monthlyLabels.push(
                        item.month
                    );

                }


                monthlyValues.push(
                    parseFloat(
                        item.total_amount || 0
                    )
                );

            }
        );


        var purchaseTrendElement =
            document.getElementById(
                'purchaseTrendChart'
            );


        if (purchaseTrendElement) {

            var purchaseTrendCtx =
                purchaseTrendElement
                .getContext('2d');


            new Chart(
                purchaseTrendCtx, {

                    type: 'bar',


                    data: {

                        labels: monthlyLabels,


                        datasets: [{

                            label: 'Purchase Value',

                            data: monthlyValues,

                            borderWidth: 1

                        }]

                    },


                    options: {

                        responsive: true,

                        maintainAspectRatio: false,


                        legend: {

                            display: false

                        },


                        scales: {

                            yAxes: [{

                                ticks: {

                                    beginAtZero: true

                                }

                            }]

                        },


                        tooltips: {

                            callbacks: {

                                label: function(
                                    tooltipItem,
                                    data
                                ) {

                                    return 'Purchase: ' +
                                    Number(
                                        tooltipItem.yLabel
                                    ).toLocaleString(
                                        undefined, {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }
                                    );

                                }

                            }

                        }

                    }

                }
            );

        }


        /* =====================================================
           PURCHASE WORKFLOW DOUGHNUT CHART
        ===================================================== */


        var workflowElement =
            document.getElementById(
                'purchaseWorkflowChart'
            );


        if (workflowElement) {

            var workflowCtx =
                workflowElement
                .getContext('2d');


            new Chart(
                workflowCtx, {

                    type: 'doughnut',


                    data: {

                        labels: [

                            'RFQs',

                            'Supplier Quotations',

                            'Purchase Orders',

                            'GRNs'

                        ],


                        datasets: [{

                            data: [

                                <?= (int)$rfq_count ?>,

                                <?= (int)$quotation_count ?>,

                                <?= (int)$po_count ?>,

                                <?= (int)$grn_count ?>

                            ],

                            borderWidth: 2

                        }]

                    },


                    options: {

                        responsive: true,

                        maintainAspectRatio: false,


                        cutoutPercentage: 60,


                        legend: {

                            position: 'bottom'

                        },


                        tooltips: {

                            callbacks: {

                                label: function(
                                    tooltipItem,
                                    data
                                ) {

                                    var label =
                                        data.labels[
                                            tooltipItem.index
                                        ];


                                    var value =
                                        data.datasets[0]
                                        .data[
                                            tooltipItem.index
                                        ];


                                    return
                                    label +
                                        ': ' +
                                        value;

                                }

                            }

                        }

                    }

                }
            );

        }


        /* =====================================================
           VENDOR PURCHASE PERFORMANCE
        ===================================================== */


        var vendorData =
            <?= json_encode(
                !empty($top_suppliers)
                    ? $top_suppliers
                    : array()
            ) ?>;


        var vendorLabels = [];

        var vendorValues = [];


        $.each(
            vendorData,
            function(index, supplier) {

                vendorLabels.push(
                    supplier.supplier_name
                );


                vendorValues.push(
                    parseFloat(
                        supplier.total_amount || 0
                    )
                );

            }
        );


        var vendorElement =
            document.getElementById(
                'vendorPurchaseChart'
            );


        if (vendorElement) {

            var vendorCtx =
                vendorElement
                .getContext('2d');


            new Chart(
                vendorCtx, {

                    type: 'horizontalBar',


                    data: {

                        labels: vendorLabels,


                        datasets: [{

                            label: 'Total Purchase',

                            data: vendorValues,

                            borderWidth: 1

                        }]

                    },


                    options: {

                        responsive: true,

                        maintainAspectRatio: false,


                        legend: {

                            display: false

                        },


                        scales: {

                            xAxes: [{

                                ticks: {

                                    beginAtZero: true

                                }

                            }]

                        },


                        tooltips: {

                            callbacks: {

                                label: function(
                                    tooltipItem,
                                    data
                                ) {

                                    return 'Purchase: ' +
                                    Number(
                                        tooltipItem.xLabel
                                    ).toLocaleString(
                                        undefined, {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }
                                    );

                                }

                            }

                        }

                    }

                }
            );

        }

    });
</script>