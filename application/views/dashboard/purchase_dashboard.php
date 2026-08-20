<style>
    /* =========================================================
   DASHBOARD COMMON
========================================================= */

    .kpi-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        margin-bottom: 20px;
        min-height: 135px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, .14);

        position: relative;
        overflow: hidden;

        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-3px);

        box-shadow:
            0 8px 20px rgba(0, 0, 0, .20);
    }

    .kpi-card i {
        font-size: 38px;
        float: right;
        opacity: .22;
    }

    .kpi-card h4 {
        margin-top: 0;
        font-weight: 500;
        font-size: 16px;
    }

    .kpi-card h2 {
        margin-bottom: 0;
        font-size: 28px;
        font-weight: 700;
    }


    /* =========================================================
   STRONG KPI COLORS
========================================================= */

    .bg1 {
        background: linear-gradient(135deg,
                #1565C0,
                #2196F3);
    }

    .bg2 {
        background: linear-gradient(135deg,
                #00897B,
                #26A69A);
    }

    .bg3 {
        background: linear-gradient(135deg,
                #EF6C00,
                #FB8C00);
    }

    .bg4 {
        background: linear-gradient(135deg,
                #6A1B9A,
                #8E44AD);
    }

    .bg5 {
        background: linear-gradient(135deg,
                #2E7D32,
                #43A047);
    }

    .bg6 {
        background: linear-gradient(135deg,
                #C62828,
                #E53935);
    }


    /* =========================================================
   MODERN PANEL
========================================================= */

    .panel-modern {
        background: #fff;

        border-radius: 12px;

        padding: 18px;

        box-shadow:
            0 3px 12px rgba(0, 0, 0, .08);

        margin-bottom: 20px;

        border: 1px solid #f0f0f0;
    }

    .panel-modern h4 {
        margin-top: 0;
        margin-bottom: 18px;

        font-weight: 700;

        color: #34495E;

        font-size: 19px;
    }

    .panel-modern h4 i {
        color: #2878B5;

        margin-right: 7px;
    }


    /* =========================================================
   PURCHASE PROCESS
========================================================= */

    .pipeline-box {
        text-align: center;

        padding: 18px 5px;

        border-right: 1px solid #eeeeee;

        position: relative;
    }

    .pipeline-box:last-child {
        border-right: none;
    }

    .pipeline-count {
        font-size: 28px;

        font-weight: 700;

        margin-bottom: 5px;

        color: #2878B5;
    }

    .pipeline-title {
        color: #6B7280;

        font-size: 13px;

        font-weight: 500;
    }


    /* Different colors for process stages */

    .pipeline-box:nth-child(1) .pipeline-count {
        color: #1976D2;
    }

    .pipeline-box:nth-child(2) .pipeline-count {
        color: #8E44AD;
    }

    .pipeline-box:nth-child(3) .pipeline-count {
        color: #EF6C00;
    }

    .pipeline-box:nth-child(4) .pipeline-count {
        color: #2E7D32;
    }


    /* =========================================================
   PENDING WORK CARDS
========================================================= */

    .pending-card {
        border-radius: 10px;

        border: none;

        margin-bottom: 20px;

        box-shadow:
            0 3px 10px rgba(0, 0, 0, .08);

        overflow: hidden;
    }

    .pending-card .panel-body {
        padding: 18px;
    }

    .pending-card h3 {
        margin-top: 0;

        font-size: 30px;

        font-weight: 700;
    }

    .pending-card h4 {
        margin-bottom: 0;

        color: #555;

        font-size: 15px;
    }


    /* Individual pending colors */

    .pending-rfq {
        border-top: 4px solid #1976D2;
    }

    .pending-rfq h3 {
        color: #1976D2;
    }


    .pending-quotation {
        border-top: 4px solid #8E44AD;
    }

    .pending-quotation h3 {
        color: #8E44AD;
    }


    .pending-po {
        border-top: 4px solid #EF6C00;
    }

    .pending-po h3 {
        color: #EF6C00;
    }


    .pending-grn {
        border-top: 4px solid #2E7D32;
    }

    .pending-grn h3 {
        color: #2E7D32;
    }


    /* =========================================================
   VALUE BOXES
========================================================= */

    .value-box {
        text-align: center;

        padding: 20px;

        position: relative;

        overflow: hidden;
    }

    .value-box p {
        color: #6B7280;

        margin-bottom: 8px;

        font-size: 14px;

        font-weight: 500;
    }

    .value-box h2 {
        margin: 5px 0;

        font-weight: 700;

        color: #2878B5;

        font-size: 25px;
    }


    /* Different value colors */

    .value-box:nth-child(1) h2 {
        color: #8E44AD;
    }

    .value-box:nth-child(2) h2 {
        color: #EF6C00;
    }

    .value-box:nth-child(3) h2 {
        color: #2E7D32;
    }


    /* =========================================================
   QUICK ACTION BUTTON
========================================================= */

    .quick-btn {
        display: block;

        padding: 11px 13px;

        margin: 9px 0;

        border: 1px solid #E1E5EA;

        border-radius: 7px;

        color: #34495E;

        text-decoration: none;

        background: #fff;

        transition: all .2s ease;
    }

    .quick-btn i {
        color: #2878B5;

        width: 22px;

        margin-right: 4px;
    }

    .quick-btn:hover {
        background: #F5F9FC;

        border-color: #2878B5;

        color: #2878B5;

        text-decoration: none;

        transform: translateX(3px);
    }


    /* =========================================================
   PENDING ACTIONS
========================================================= */

    .panel-modern table tr td {
        vertical-align: middle;
    }

    .panel-modern table tr td strong {
        display: inline-block;

        min-width: 30px;

        padding: 4px 9px;

        border-radius: 12px;

        background: #EAF3FB;

        color: #2878B5;

        text-align: center;
    }


    /* =========================================================
   TABLES
========================================================= */

    .panel-modern .table {
        margin-bottom: 0;
    }

    .panel-modern .table thead th {
        background: #F5F7FA;

        color: #34495E;

        font-size: 13px;

        font-weight: 700;

        border-bottom: 1px solid #DDE3EA;
    }

    .panel-modern .table tbody td {
        color: #455A64;

        font-size: 13px;

        vertical-align: middle;
    }

    .panel-modern .table tbody tr:hover {
        background: #F8FBFD;
    }

    .empty-row {
        text-align: center;

        color: #999;

        padding: 15px !important;
    }


    /* =========================================================
   STATUS LABEL
========================================================= */

    .status-label {
        font-size: 11px;

        padding: 5px 9px;

        border-radius: 12px;
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
   RESPONSIVE
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
        <div class="panel panel-default pending-card pending-rfq">
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
        <div class="panel panel-default pending-card pending-quotation">
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
        <div class="panel panel-default pending-card pending-po">
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
        <div class="panel panel-default pending-card pending-grn">
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
     11. PURCHASE DASHBOARD CHARTS
========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
    $(document).ready(function() {

        /* =========================================================
           CHECK CHART.JS
        ========================================================= */

        if (typeof Chart === 'undefined') {

            console.error('Chart.js is not loaded.');

            return;
        }


        /* =========================================================
           COMMON COLORS
        ========================================================= */

        var colors = {

            blue: '#1976D2',
            blueLight: 'rgba(25, 118, 210, 0.18)',

            purple: '#8E44AD',
            purpleLight: 'rgba(142, 68, 173, 0.18)',

            orange: '#EF6C00',
            orangeLight: 'rgba(239, 108, 0, 0.18)',

            green: '#2E7D32',
            greenLight: 'rgba(46, 125, 50, 0.18)'
        };


        /* =========================================================
           COMMON OPTIONS
        ========================================================= */

        var commonOptions = {

            responsive: true,

            maintainAspectRatio: false,

            animation: {

                duration: 900,

                easing: 'easeOutQuart'

            },

            legend: {

                position: 'top',

                labels: {

                    fontSize: 12,

                    fontColor: '#5B6B7A',

                    padding: 15,

                    usePointStyle: true

                }

            },

            tooltips: {

                backgroundColor: 'rgba(34, 45, 57, 0.92)',

                titleFontSize: 13,

                bodyFontSize: 12,

                cornerRadius: 6,

                xPadding: 12,

                yPadding: 10

            }

        };


        /* =========================================================
           1. MONTHLY PURCHASE TREND
           ---------------------------------------------------------
           Data:
           month
           total_po
           total_amount
        ========================================================= */

        var monthlyPurchaseData =
            <?= json_encode(
                !empty($monthly_purchase_chart)
                    ? $monthly_purchase_chart
                    : array()
            ) ?>;


        var monthlyLabels = [];

        var monthlyValues = [];

        var monthlyPOs = [];


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
                    parseInt(item.month, 10);


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


                monthlyPOs.push(
                    parseInt(
                        item.total_po || 0
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

                            backgroundColor: colors.blueLight,

                            borderColor: colors.blue,

                            borderWidth: 2,

                            hoverBackgroundColor: 'rgba(25, 118, 210, 0.32)',

                            barPercentage: 0.65,

                            categoryPercentage: 0.72

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        animation: {

                            duration: 900,

                            easing: 'easeOutQuart'

                        },

                        legend: {

                            display: false

                        },

                        scales: {

                            yAxes: [{

                                ticks: {

                                    beginAtZero: true,

                                    fontColor: '#7A8793',

                                    callback: function(value) {

                                        return Number(value)
                                            .toLocaleString();

                                    }

                                },

                                gridLines: {

                                    color: 'rgba(52, 73, 94, 0.07)',

                                    drawBorder: false

                                }

                            }],

                            xAxes: [{

                                ticks: {

                                    fontColor: '#7A8793',

                                    fontSize: 11

                                },

                                gridLines: {

                                    display: false,

                                    drawBorder: false

                                }

                            }]

                        },

                        tooltips: {

                            backgroundColor: 'rgba(34, 45, 57, 0.92)',

                            titleFontSize: 13,

                            bodyFontSize: 12,

                            cornerRadius: 6,

                            callbacks: {

                                label: function(
                                    tooltipItem,
                                    data
                                ) {

                                    var index =
                                        tooltipItem.index;

                                    var amount =
                                        monthlyValues[index];

                                    var poCount =
                                        monthlyPOs[index];

                                    return [

                                        'Purchase: ' +
                                        Number(amount)
                                        .toLocaleString(
                                            undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            }
                                        ),

                                        'POs: ' + poCount

                                    ];

                                }

                            }

                        }

                    }

                }
            );

        }


        /* =========================================================
           2. PURCHASE WORKFLOW
           ---------------------------------------------------------
           RFQ → Quotation → PO → GRN
        ========================================================= */

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

                            backgroundColor: [

                                'rgba(25, 118, 210, 0.75)',

                                'rgba(142, 68, 173, 0.75)',

                                'rgba(239, 108, 0, 0.75)',

                                'rgba(46, 125, 50, 0.75)'

                            ],

                            borderColor: [

                                colors.blue,

                                colors.purple,

                                colors.orange,

                                colors.green

                            ],

                            borderWidth: 2

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        cutoutPercentage: 60,

                        animation: {

                            animateRotate: true,

                            duration: 900

                        },

                        legend: {

                            position: 'bottom',

                            labels: {

                                fontSize: 11,

                                fontColor: '#5B6B7A',

                                padding: 10,

                                usePointStyle: true

                            }

                        },

                        tooltips: {

                            backgroundColor: 'rgba(34, 45, 57, 0.92)',

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

                                    return label +
                                        ': ' +
                                        value;

                                }

                            }

                        }

                    }

                }
            );

        }


        /* =========================================================
           3. VENDOR PURCHASE PERFORMANCE
           ---------------------------------------------------------
           Supplier vs Total Purchase
        ========================================================= */

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
                    supplier.supplier_name ||
                    'Unknown Supplier'
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

                            backgroundColor: colors.purpleLight,

                            borderColor: colors.purple,

                            borderWidth: 2,

                            hoverBackgroundColor: 'rgba(142, 68, 173, 0.35)',

                            barPercentage: 0.65,

                            categoryPercentage: 0.70

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        animation: {

                            duration: 900,

                            easing: 'easeOutQuart'

                        },

                        legend: {

                            display: false

                        },

                        scales: {

                            xAxes: [{

                                ticks: {

                                    beginAtZero: true,

                                    fontColor: '#7A8793',

                                    callback: function(value) {

                                        return Number(value)
                                            .toLocaleString();

                                    }

                                },

                                gridLines: {

                                    color: 'rgba(52, 73, 94, 0.07)',

                                    drawBorder: false

                                }

                            }],

                            yAxes: [{

                                ticks: {

                                    fontColor: '#5B6B7A',

                                    fontSize: 11

                                },

                                gridLines: {

                                    display: false,

                                    drawBorder: false

                                }

                            }]

                        },

                        tooltips: {

                            backgroundColor: 'rgba(34, 45, 57, 0.92)',

                            titleFontSize: 13,

                            bodyFontSize: 12,

                            cornerRadius: 6,

                            callbacks: {

                                label: function(
                                    tooltipItem
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