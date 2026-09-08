<style>
    /* =========================================================
       INVENTORY DASHBOARD
       ========================================================= */

    .inventory-dashboard {
        padding-bottom: 30px;
    }

    /* =========================
       KPI CARDS
       ========================= */

    .inventory-kpi {
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        padding: 20px;
        color: #fff;
        min-height: 125px;
        margin-bottom: 20px;
        box-shadow: 0 4px 14px rgba(0, 0, 0);
        transition: all 0.25s ease;
    }

    .inventory-kpi:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(0, 0, 0, 0.14);
    }

    .inventory-kpi h4 {
        margin: 0 0 8px 0;
        font-size: 17px;
        font-weight: 500;
    }

    .inventory-kpi h2 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
    }

    .inventory-kpi small {
        display: block;
        margin-top: 6px;
        opacity: 0.85;
        font-size: 12px;
    }

    .inventory-kpi .kpi-icon {
        position: absolute;
        right: 18px;
        top: 20px;
        font-size: 42px;
        opacity: 0.18;
    }

    .kpi-blue {
        background: linear-gradient(135deg, #1976D2, #2196F3);
    }

    .kpi-teal {
        background: linear-gradient(135deg, #00897B, #26A69A);
    }

    .kpi-purple {
        background: linear-gradient(135deg, #6A1B9A, #8E44AD);
    }

    .kpi-orange {
        background: linear-gradient(135deg, #EF8C00, #F5A623);
    }

    .kpi-green {
        background: linear-gradient(135deg, #2E7D32, #43A047);
    }

    .kpi-red {
        background: linear-gradient(135deg, #C62828, #E53935);
    }

    .kpi-indigo {
        background: linear-gradient(135deg, #3949AB, #5C6BC0);
    }

    /* =========================
       MODERN PANELS
       ========================= */

    .dashboard-panel {
        background: #fff;
        border-radius: 13px;
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
        border: 1px solid #f0f2f4;
    }

    .dashboard-panel h4 {
        margin: 0 0 18px 0;
        color: #34495E;
        font-size: 20px;
        font-weight: 700;
    }

    .dashboard-panel h4 i {
        margin-right: 8px;
        color: #2878B5;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .chart-container-small {
        position: relative;
        height: 260px;
        width: 100%;
    }

    /* =========================
       SUMMARY BOXES
       ========================= */

    .summary-box {
        text-align: center;
        padding: 15px 10px;
    }

    .summary-box h3 {
        margin: 0;
        color: #607D9B;
        font-size: 28px;
        font-weight: 700;
    }

    .summary-box p {
        margin: 6px 0 0;
        color: #7b8794;
        font-size: 13px;
    }

    .summary-icon {
        font-size: 25px;
        margin-bottom: 8px;
        opacity: 0.75;
    }

    /* =========================
       TABLES
       ========================= */

    .dashboard-table {
        margin-bottom: 0;
    }

    .dashboard-table thead th {
        background: #f6f8fa;
        color: #44546A;
        font-weight: 600;
        border-bottom: 1px solid #dfe4e8;
        white-space: nowrap;
    }

    .dashboard-table tbody td {
        vertical-align: middle;
    }

    .dashboard-table tbody tr:hover {
        background: #fafbfd;
    }

    .product-code {
        font-weight: 600;
        color: #3F6F9F;
    }

    .product-name-small {
        color: #7c8794;
        font-size: 11px;
        margin-top: 3px;
    }

    /* =========================
       BADGES
       ========================= */

    .inventory-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-danger-soft {
        background: #f9dddd;
        color: #b84d50;
    }

    .badge-warning-soft {
        background: #f9ebcf;
        color: #a7741f;
    }

    .badge-success-soft {
        background: #dff1e6;
        color: #397954;
    }

    .badge-info-soft {
        background: #dfeef8;
        color: #39759D;
    }

    .badge-purple-soft {
        background: #ebe4f3;
        color: #72548F;
    }

    /* =========================
       QUICK ACTIONS
       ========================= */

    .quick-action {
        display: block;
        padding: 11px 13px;
        margin-bottom: 9px;
        border: 1px solid #e1e5e9;
        border-radius: 7px;
        color: #455A64;
        background: #fff;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .quick-action:hover {
        background: #f6f9fb;
        border-color: #cbd6df;
        color: #315E82;
        transform: translateX(2px);
    }

    .quick-action i {
        width: 22px;
        text-align: center;
        margin-right: 5px;
        color: #6688A5;
    }

    /* =========================
       ALERT BOX
       ========================= */

    .stock-alert {
        border-left: 4px solid #D9797C;
    }

    .stock-alert-title {
        color: #B84D50 !important;
    }

    /* =========================
       EMPTY STATE
       ========================= */

    .empty-state {
        text-align: center;
        padding: 25px 10px !important;
        color: #9aa5af;
    }

    .empty-state i {
        font-size: 25px;
        display: block;
        margin-bottom: 8px;
    }

    /* =========================
       MOVEMENT SUMMARY
       ========================= */

    .movement-card {
        border-radius: 10px;
        padding: 14px;
        text-align: center;
        margin-bottom: 10px;
    }

    .movement-card h5 {
        margin: 0 0 5px;
        color: #718096;
        font-size: 12px;
    }

    .movement-card h3 {
        margin: 0;
        font-weight: 700;
    }

    .movement-in {
        background: #e5f3ed;
    }

    .movement-in h3 {
        color: #438461;
    }

    .movement-out {
        background: #f8e7e7;
    }

    .movement-out h3 {
        color: #b95d61;
    }

    /* =========================
       RESPONSIVE
       ========================= */

    @media (max-width: 991px) {
        .chart-container {
            height: 280px;
        }
    }

    @media (max-width: 767px) {
        .inventory-kpi {
            min-height: 115px;
        }

        .chart-container {
            height: 250px;
        }

        .dashboard-table {
            font-size: 12px;
        }
    }
</style>


<div class="inventory-dashboard">

    <!-- =====================================================
         KPI ROW 1
         ===================================================== -->

    <div class="row">

        <!-- Total Products -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-blue">
                <i class="fa fa-cubes kpi-icon"></i>

                <h4>Total Products</h4>

                <h2>
                    <?= number_format($product_count); ?>
                </h2>

                <small>Active inventory items</small>
            </div>
        </div>


        <!-- Available Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-teal">
                <i class="fa fa-check-circle kpi-icon"></i>

                <h4>Available Stock</h4>

                <h2>
                    <?= number_format($available_stock); ?>
                </h2>

                <small>Currently available quantity</small>
            </div>
        </div>


        <!-- Reserved Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-purple">
                <i class="fa fa-lock kpi-icon"></i>

                <h4>Reserved Stock</h4>

                <h2>
                    <?= number_format($reserved_stock); ?>
                </h2>

                <small>Reserved for allocation</small>
            </div>
        </div>


        <!-- Pending Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-orange">
                <i class="fa fa-clock-o kpi-icon"></i>

                <h4>Pending Stock</h4>

                <h2>
                    <?= number_format($pending_stock); ?>
                </h2>

                <small>Pending quantity</small>
            </div>
        </div>

    </div>


    <!-- =====================================================
         KPI ROW 2
         ===================================================== -->

    <div class="row">

        <!-- Inventory Value -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-indigo">
                <i class="fa fa-money kpi-icon"></i>

                <h4>Inventory Value</h4>

                <h2 style="font-size: 25px;">
                    <?= number_format($inventory_value, 2); ?>
                </h2>

                <small>Current stock valuation</small>
            </div>
        </div>


        <!-- Low Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-orange">
                <i class="fa fa-exclamation-triangle kpi-icon"></i>

                <h4>Low Stock</h4>

                <h2>
                    <?= number_format($low_stock_count); ?>
                </h2>

                <small>Items requiring attention</small>
            </div>
        </div>


        <!-- Out of Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-red">
                <i class="fa fa-times-circle kpi-icon"></i>

                <h4>Out of Stock</h4>

                <h2>
                    <?= number_format($out_of_stock_count); ?>
                </h2>

                <small>Items with zero availability</small>
            </div>
        </div>


        <!-- Today's Movement -->
        <div class="col-lg-3 col-md-6">
            <div class="inventory-kpi kpi-green">
                <i class="fa fa-exchange kpi-icon"></i>

                <h4>Today's Movement</h4>

                <h2>
                    <?= number_format(
                        ($today_stock_in ?? 0) + ($today_stock_out ?? 0)
                    ); ?>
                </h2>

                <small>Stock IN + Stock OUT</small>
            </div>
        </div>

    </div>


    <!-- =====================================================
         STOCK MOVEMENT + STOCK STATUS
         ===================================================== -->

    <div class="row">

        <!-- Stock Movement Chart -->
        <div class="col-md-8">

            <div class="dashboard-panel">

                <h4>
                    <i class="fa fa-bar-chart"></i>
                    Stock Movement
                    <small style="font-size:12px;color:#999;">
                        Monthly IN vs OUT
                    </small>
                </h4>

                <div class="chart-container">
                    <canvas id="stockMovementChart"></canvas>
                </div>

            </div>

        </div>


        <!-- Stock Status Doughnut -->
        <div class="col-md-4">

            <div class="dashboard-panel">

                <h4>
                    <i class="fa fa-pie-chart"></i>
                    Stock Status
                </h4>

                <div class="chart-container-small">
                    <canvas id="stockStatusChart"></canvas>
                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         STOCK VALUE + WAREHOUSE CHART
         ===================================================== -->

    <div class="row">

        <!-- Stock Value Movement -->
        <div class="col-md-7">

            <div class="dashboard-panel">

                <h4>
                    <i class="fa fa-line-chart"></i>
                    Stock Value Movement
                    <small style="font-size:12px;color:#999;">
                        Monthly stock value
                    </small>
                </h4>

                <div class="chart-container">
                    <canvas id="stockValueChart"></canvas>
                </div>

            </div>

        </div>


        <!-- Warehouse Chart -->
        <div class="col-md-5">

            <div class="dashboard-panel">

                <h4>
                    <i class="fa fa-building"></i>
                    Warehouse Stock
                </h4>

                <div class="chart-container">
                    <canvas id="warehouseChart"></canvas>
                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         TODAY'S ACTIVITIES + MOVEMENT SUMMARY
         ===================================================== -->

    <div class="row">

        <div class="col-md-6">

            <div class="dashboard-panel">

                <h4>
                    <i class="fa fa-calendar"></i>
                    Today's Activities
                </h4>

                <table class="table table-bordered dashboard-table">

                    <tbody>

                        <tr>
                            <td>
                                <i class="fa fa-share-square-o"></i>
                                Material Issues
                            </td>

                            <td class="text-right">
                                <strong>
                                    <?= number_format($today_issue); ?>
                                </strong>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <i class="fa fa-arrow-down"
                                    style="color:#4A90E2;"></i>
                                Stock In
                            </td>

                            <td class="text-right">
                                <strong>
                                    <?= number_format($today_stock_in); ?>
                                </strong>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <i class="fa fa-arrow-up"
                                    style="color:#D9797C;"></i>
                                Stock Out
                            </td>

                            <td class="text-right">
                                <strong>
                                    <?= number_format($today_stock_out); ?>
                                </strong>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <i class="fa fa-sliders"></i>
                                Stock Adjustments
                            </td>

                            <td class="text-right">
                                <strong>
                                    <?= number_format($today_adjustment); ?>
                                </strong>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Movement Summary -->

        <div class="col-md-6">

            <div class="dashboard-panel">

                <h4>
                    <i class="fa fa-exchange"></i>
                    Stock Movement Summary
                </h4>

                <div class="row">

                    <div class="col-xs-6">

                        <div class="movement-card movement-in">

                            <h5>
                                TOTAL STOCK IN
                            </h5>

                            <h3>
                                <?= number_format($stock_in); ?>
                            </h3>

                        </div>

                    </div>


                    <div class="col-xs-6">

                        <div class="movement-card movement-out">

                            <h5>
                                TOTAL STOCK OUT
                            </h5>

                            <h3>
                                <?= number_format($stock_out); ?>
                            </h3>

                        </div>

                    </div>


                    <div class="col-xs-6">

                        <div class="summary-box">

                            <div class="summary-icon"
                                style="color:#8064A2;">
                                <i class="fa fa-lock"></i>
                            </div>

                            <h3>
                                <?= number_format($reserved_stock); ?>
                            </h3>

                            <p>Reserved</p>

                        </div>

                    </div>


                    <div class="col-xs-6">

                        <div class="summary-box">

                            <div class="summary-icon"
                                style="color:#3E9B9A;">
                                <i class="fa fa-check-circle"></i>
                            </div>

                            <h3>
                                <?= number_format($available_stock); ?>
                            </h3>

                            <p>Available</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         LOW STOCK ALERT
         ===================================================== -->

    <div class="row">

        <div class="col-md-12">

            <div class="dashboard-panel stock-alert">

                <h4 class="stock-alert-title">

                    <i class="fa fa-exclamation-triangle"></i>

                    Low Stock / Reorder Alerts

                    <span class="pull-right inventory-badge badge-danger-soft">
                        <?= number_format($low_stock_count); ?> Items
                    </span>

                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped dashboard-table">

                        <thead>

                            <tr>

                                <th>Product Code</th>

                                <th>Product Name</th>

                                <th class="text-center">
                                    Available
                                </th>

                                <th class="text-center">
                                    Reorder Level
                                </th>

                                <th class="text-center">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($low_stock)) { ?>

                                <?php foreach ($low_stock as $row) { ?>

                                    <tr>

                                        <td>
                                            <span class="product-code">
                                                <?= html_escape($row->product_code); ?>
                                            </span>
                                        </td>


                                        <td>
                                            <?= html_escape($row->product_name); ?>
                                        </td>


                                        <td class="text-center">

                                            <?php
                                            $available_qty = (float) $row->available_qty;
                                            $reorder_level = (float) $row->reorder_level;
                                            ?>

                                            <strong>
                                                <?= number_format($available_qty); ?>
                                            </strong>

                                        </td>


                                        <td class="text-center">

                                            <?= number_format($reorder_level); ?>

                                        </td>


                                        <td class="text-center">

                                            <?php if ($available_qty <= 0) { ?>

                                                <span class="inventory-badge badge-danger-soft">
                                                    Out of Stock
                                                </span>

                                            <?php } else { ?>

                                                <span class="inventory-badge badge-warning-soft">
                                                    Reorder Required
                                                </span>

                                            <?php } ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="5"
                                        class="empty-state">

                                        <i class="fa fa-check-circle"
                                            style="color:#4B9B72;"></i>

                                        No low stock items

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FAST MOVING + DEAD STOCK
         ===================================================== -->

    <div class="row">

        <!-- Fast Moving -->
        <div class="col-md-6">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-line-chart"
                        style="color:#4A90E2;"></i>

                    Fast Moving Items

                    <small style="font-size:12px;color:#999;">
                        Last 90 Days
                    </small>

                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped dashboard-table">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th class="text-right">
                                    Issued Qty
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($fast_moving_items)) { ?>

                                <?php foreach ($fast_moving_items as $row) { ?>

                                    <tr>

                                        <td>

                                            <span class="product-code">
                                                <?= html_escape($row->product_code); ?>
                                            </span>

                                            <div class="product-name-small">
                                                <?= html_escape($row->product_name); ?>
                                            </div>

                                        </td>


                                        <td class="text-right">

                                            <strong>
                                                <?= number_format($row->issued_qty); ?>
                                            </strong>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="2"
                                        class="empty-state">

                                        <i class="fa fa-bar-chart"></i>

                                        No movement data available

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- Dead Stock -->
        <div class="col-md-6">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-pause-circle"
                        style="color:#D99A3D;"></i>

                    Dead Stock

                    <small style="font-size:12px;color:#999;">
                        No OUT movement in 90 days
                    </small>

                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped dashboard-table">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th class="text-right">
                                    Available Qty
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($dead_stock_items)) { ?>

                                <?php foreach ($dead_stock_items as $row) { ?>

                                    <tr>

                                        <td>

                                            <span class="product-code">
                                                <?= html_escape($row->product_code); ?>
                                            </span>

                                            <div class="product-name-small">
                                                <?= html_escape($row->product_name); ?>
                                            </div>

                                        </td>


                                        <td class="text-right">

                                            <strong>
                                                <?= number_format($row->available_qty); ?>
                                            </strong>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="2"
                                        class="empty-state">

                                        <i class="fa fa-check-circle"></i>

                                        No dead stock identified

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         RECENT MATERIAL ISSUES + RECENT STOCK LEDGER
         ===================================================== -->

    <div class="row">

        <!-- Recent Material Issues -->

        <div class="col-md-6">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-share-square-o"></i>

                    Recent Material Issues

                </h4>


                <div class="table-responsive">

                    <table class="table table-striped table-bordered dashboard-table">

                        <thead>

                            <tr>

                                <th>MI Code</th>

                                <th>Date</th>

                                <th>Warehouse</th>

                                <th>Customer</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($recent_issue)) { ?>

                                <?php foreach ($recent_issue as $row) { ?>

                                    <tr>

                                        <td>
                                            <strong>
                                                <?= html_escape($row->mi_code); ?>
                                            </strong>
                                        </td>


                                        <td>
                                            <?= !empty($row->issue_date)
                                                ? date('d-m-Y', strtotime($row->issue_date))
                                                : '-'; ?>
                                        </td>


                                        <td>
                                            <?= html_escape($row->warehouse_name ?? '-'); ?>
                                        </td>


                                        <td>
                                            <?= html_escape($row->customer_name ?? '-'); ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="4"
                                        class="empty-state">

                                        <i class="fa fa-inbox"></i>

                                        No recent material issues

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- Recent Stock Ledger -->

        <div class="col-md-6">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-history"></i>

                    Recent Stock Ledger

                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover dashboard-table">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>Product</th>

                                <th>Warehouse</th>

                                <th>Type</th>

                                <th class="text-right">
                                    Qty
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($recent_stock)) { ?>

                                <?php foreach ($recent_stock as $row) { ?>

                                    <tr>

                                        <td>
                                            <?= !empty($row->created_date)
                                                ? date('d-m-Y', strtotime($row->created_date))
                                                : '-'; ?>
                                        </td>


                                        <td>

                                            <span class="product-code">
                                                <?= html_escape($row->product_code ?? '-'); ?>
                                            </span>

                                            <div class="product-name-small">
                                                <?= html_escape($row->product_name ?? '-'); ?>
                                            </div>

                                        </td>


                                        <td>
                                            <?= html_escape($row->warehouse_name ?? '-'); ?>
                                        </td>


                                        <td>

                                            <?php if ($row->stock_type == 'IN') { ?>

                                                <span class="inventory-badge badge-success-soft">
                                                    IN
                                                </span>

                                            <?php } else { ?>

                                                <span class="inventory-badge badge-danger-soft">
                                                    OUT
                                                </span>

                                            <?php } ?>

                                        </td>


                                        <td class="text-right">

                                            <?= number_format($row->quantity); ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="5"
                                        class="empty-state">

                                        <i class="fa fa-history"></i>

                                        No recent stock transactions

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         WAREHOUSE SUMMARY + QUICK ACTIONS
         ===================================================== -->

    <div class="row">

        <!-- Warehouse Summary -->

        <div class="col-md-8">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-building"></i>

                    Warehouse Summary

                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped dashboard-table">

                        <thead>

                            <tr>

                                <th>Warehouse</th>

                                <th class="text-center">
                                    Products
                                </th>

                                <th class="text-center">
                                    Available Qty
                                </th>

                                <th class="text-center">
                                    Reserved Qty
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($warehouse_summary)) { ?>

                                <?php foreach ($warehouse_summary as $row) { ?>

                                    <tr>

                                        <td>
                                            <strong>
                                                <?= html_escape($row->warehouse_name); ?>
                                            </strong>
                                        </td>


                                        <td class="text-center">
                                            <?= number_format($row->total_items); ?>
                                        </td>


                                        <td class="text-center">
                                            <?= number_format($row->available_stock); ?>
                                        </td>


                                        <td class="text-center">
                                            <?= number_format($row->reserved_stock); ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="4"
                                        class="empty-state">

                                        <i class="fa fa-building"></i>

                                        No warehouse data available

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- Quick Actions -->

        <div class="col-md-4">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-bolt"></i>

                    Quick Actions

                </h4>


                <a href="<?= base_url() ?>index.php/Stock/stock_adjustment"
                    class="quick-action">

                    <i class="fa fa-exchange"></i>

                    Stock Adjustment

                </a>


                <a href="<?= base_url() ?>index.php/Stock/list_stock_adjustment"
                    class="quick-action">

                    <i class="fa fa-list"></i>

                    Stock Adjustment List

                </a>


                <a href="<?= base_url() ?>index.php/Stock/min_stock"
                    class="quick-action">

                    <i class="fa fa-exclamation-circle"></i>

                    Minimum Stock

                </a>


                <a href="<?= base_url() ?>index.php/Stock/reorder_list"
                    class="quick-action">

                    <i class="fa fa-refresh"></i>

                    Reorder Stock

                </a>


                <a href="<?= base_url() ?>index.php/Reports/get_stock_inventory_report"
                    class="quick-action">

                    <i class="fa fa-cubes"></i>

                    Stock Inventory Report

                </a>


                <a href="<?= base_url() ?>index.php/Inventory/stock_ledger"
                    class="quick-action">

                    <i class="fa fa-book"></i>

                    Stock Ledger

                </a>


                <a href="<?= base_url() ?>index.php/Stock/list_stock_allocations"
                    class="quick-action">

                    <i class="fa fa-lock"></i>

                    Stock Allocation

                </a>

            </div>

        </div>

    </div>


    <!-- =====================================================
         INVENTORY STATISTICS
         ===================================================== -->

    <div class="row">

        <div class="col-md-12">

            <div class="dashboard-panel">

                <h4>

                    <i class="fa fa-bar-chart"></i>

                    Inventory Statistics

                </h4>


                <div class="row">

                    <div class="col-md-3 col-xs-6">

                        <div class="summary-box">

                            <div class="summary-icon"
                                style="color:#4A90E2;">

                                <i class="fa fa-cubes"></i>

                            </div>

                            <h3>
                                <?= number_format($product_count); ?>
                            </h3>

                            <p>Total Products</p>

                        </div>

                    </div>


                    <div class="col-md-3 col-xs-6">

                        <div class="summary-box">

                            <div class="summary-icon"
                                style="color:#3E9B9A;">

                                <i class="fa fa-check-circle"></i>

                            </div>

                            <h3>
                                <?= number_format($available_stock); ?>
                            </h3>

                            <p>Available Quantity</p>

                        </div>

                    </div>


                    <div class="col-md-3 col-xs-6">

                        <div class="summary-box">

                            <div class="summary-icon"
                                style="color:#8064A2;">

                                <i class="fa fa-lock"></i>

                            </div>

                            <h3>
                                <?= number_format($reserved_stock); ?>
                            </h3>

                            <p>Reserved Quantity</p>

                        </div>

                    </div>


                    <div class="col-md-3 col-xs-6">

                        <div class="summary-box">

                            <div class="summary-icon"
                                style="color:#D99A3D;">

                                <i class="fa fa-exclamation-triangle"></i>

                            </div>

                            <h3>
                                <?= number_format($low_stock_count); ?>
                            </h3>

                            <p>Low Stock Products</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     CHART.JS
     ========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* =====================================================
           CHECK CHART.JS
           ===================================================== */

        if (typeof Chart === 'undefined') {

            console.error('Chart.js is not loaded.');

            return;
        }


        /* =====================================================
           SAFE DATA
           ===================================================== */

        var monthlyMovement =
            <?= json_encode($monthly_stock_movement ?: [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

        var stockValueMovement =
            <?= json_encode($inventory_value_trend ?: [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

        var stockStatus =
            <?= json_encode($stock_status_summary ?: new stdClass(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

        var warehouseSummary =
            <?= json_encode($warehouse_summary ?: [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;


        /* =====================================================
           MONTH NAMES
           ===================================================== */

        var monthNames = [
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


        /* =====================================================
           COMMON CHART OPTIONS
           ===================================================== */

        var commonOptions = {

            responsive: true,

            maintainAspectRatio: false,

            animation: {
                duration: 800
            },

            legend: {
                position: 'top',

                labels: {
                    fontSize: 12,
                    padding: 15
                }
            },

            tooltips: {
                mode: 'index',
                intersect: false
            },

            scales: {

                yAxes: [{

                    ticks: {
                        beginAtZero: true
                    },

                    gridLines: {
                        color: 'rgba(52, 73, 94, 0.08)'
                    }

                }],

                xAxes: [{

                    gridLines: {
                        display: false
                    }

                }]

            }

        };


        /* =====================================================
           1. STOCK MOVEMENT
           ===================================================== */

        var movementLabels = [];
        var movementIn = [];
        var movementOut = [];


        if (Array.isArray(monthlyMovement)) {

            monthlyMovement.forEach(function(item) {

                var month =
                    parseInt(item.month, 10);

                movementLabels.push(
                    monthNames[month - 1] || item.month
                );

                movementIn.push(
                    parseFloat(item.stock_in) || 0
                );

                movementOut.push(
                    parseFloat(item.stock_out) || 0
                );

            });

        }


        var movementCanvas =
            document.getElementById('stockMovementChart');


        if (movementCanvas) {

            new Chart(
                movementCanvas.getContext('2d'), {

                    type: 'bar',

                    data: {

                        labels: movementLabels,

                        datasets: [

                            {
                                label: 'Stock In',

                                data: movementIn,

                                backgroundColor: 'rgba(52, 152, 219, 0.45)',

                                borderColor: '#3498DB',

                                borderWidth: 1
                            },

                            {
                                label: 'Stock Out',

                                data: movementOut,

                                backgroundColor: 'rgba(231, 76, 60, 0.45)',

                                borderColor: '#E74C3C',

                                borderWidth: 1
                            }

                        ]

                    },

                    options: commonOptions

                }
            );

        }


        /* =====================================================
           2. STOCK STATUS
           ===================================================== */

        var available =
            parseFloat(stockStatus.available) || 0;

        var reserved =
            parseFloat(stockStatus.reserved) || 0;

        var pending =
            parseFloat(stockStatus.pending) || 0;


        var statusCanvas =
            document.getElementById('stockStatusChart');


        if (statusCanvas) {

            new Chart(
                statusCanvas.getContext('2d'), {

                    type: 'doughnut',

                    data: {

                        labels: [
                            'Available',
                            'Reserved',
                            'Pending'
                        ],

                        datasets: [{

                            data: [
                                available,
                                reserved,
                                pending
                            ],

                            backgroundColor: [

                                'rgba(46, 204, 113, 0.65)',

                                'rgba(155, 89, 182, 0.65)',

                                'rgba(241, 196, 15, 0.65)'

                            ],

                            borderColor: [

                                '#2ECC71',
                                '#9B59B6',
                                '#F1C40F'

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

                        }

                    }

                }
            );

        }


        /* =====================================================
           3. STOCK VALUE MOVEMENT
           ===================================================== */

        var valueLabels = [];
        var stockInValue = [];
        var stockOutValue = [];


        if (Array.isArray(stockValueMovement)) {

            stockValueMovement.forEach(function(item) {

                valueLabels.push(
                    item.month
                );

                stockInValue.push(
                    parseFloat(item.stock_in_value) || 0
                );

                stockOutValue.push(
                    parseFloat(item.stock_out_value) || 0
                );

            });

        }


        var valueCanvas =
            document.getElementById('stockValueChart');


        if (valueCanvas) {

            new Chart(
                valueCanvas.getContext('2d'), {

                    type: 'line',

                    data: {

                        labels: valueLabels,

                        datasets: [

                            {

                                label: 'Stock In Value',

                                data: stockInValue,

                                borderColor: '#3498DB',

                                backgroundColor: 'rgba(52, 152, 219, 0.10)',

                                borderWidth: 3,

                                pointRadius: 4,

                                pointHoverRadius: 6,

                                fill: true,

                                lineTension: 0.3

                            },

                            {

                                label: 'Stock Out Value',

                                data: stockOutValue,

                                borderColor: '#E67E22',

                                backgroundColor: 'rgba(230, 126, 34, 0.10)',

                                borderWidth: 3,

                                pointRadius: 4,

                                pointHoverRadius: 6,

                                fill: true,

                                lineTension: 0.3

                            }

                        ]

                    },

                    options: commonOptions

                }
            );

        }


        /* =====================================================
           4. WAREHOUSE STOCK
           ===================================================== */

        var warehouseLabels = [];
        var warehouseStock = [];


        if (Array.isArray(warehouseSummary)) {

            warehouseSummary.forEach(function(item) {

                warehouseLabels.push(
                    item.warehouse_name || 'Unknown'
                );

                warehouseStock.push(
                    parseFloat(item.available_stock) || 0
                );

            });

        }


        var warehouseCanvas =
            document.getElementById('warehouseChart');


        if (warehouseCanvas) {

            new Chart(
                warehouseCanvas.getContext('2d'), {

                    type: 'bar',

                    data: {

                        labels: warehouseLabels,

                        datasets: [{

                            label: 'Available Stock',

                            data: warehouseStock,

                            backgroundColor: 'rgba(52, 152, 219, 0.45)',

                            borderColor: '#3498DB',

                            borderWidth: 1

                        }]

                    },

                    options: commonOptions

                }
            );

        }

    });
</script>