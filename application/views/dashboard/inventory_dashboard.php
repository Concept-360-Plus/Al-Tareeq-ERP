<style>
    .kpi-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        margin-bottom: 20px;
        min-height: 120px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    }

    .kpi-card h2 {
        margin-top: 8px;
        font-weight: bold;
    }

    .kpi-card i {
        float: right;
        font-size: 38px;
        opacity: .25;
    }

    .bg1 {
        background: #3498db;
    }

    .bg2 {
        background: #27ae60;
    }

    .bg3 {
        background: #f39c12;
    }

    .bg4 {
        background: #8e44ad;
    }

    .bg5 {
        background: #16a085;
    }

    .bg6 {
        background: #d35400;
    }

    .bg7 {
        background: #2c3e50;
    }

    .bg8 {
        background: #c0392b;
    }

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
    }

    .quick-btn {
        display: block;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        color: #333;
        transition: .2s;
    }

    .quick-btn:hover {
        background: #f5f5f5;
        text-decoration: none;
    }

    .summary-box {
        text-align: center;
        padding: 15px;
    }

    .summary-box h3 {
        margin: 0;
        font-size: 30px;
        font-weight: bold;
    }

    .summary-box p {
        margin-top: 5px;
    }
</style>

<div class="row">

    <div class="col-md-3">
        <div class="kpi-card bg1">
            <i class="fa fa-cubes"></i>
            <h4>Total Products</h4>
            <h2><?= $product_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg2">
            <i class="fa fa-share-square-o"></i>
            <h4>Material Issues</h4>
            <h2><?= $material_issue_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg3">
            <i class="fa fa-history"></i>
            <h4>Stock Ledger</h4>
            <h2><?= $ledger_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg4">
            <i class="fa fa-exclamation-triangle"></i>
            <h4>Minimum Stock</h4>
            <h2><?= $minimum_stock_count ?></h2>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3">
        <div class="kpi-card bg5">
            <i class="fa fa-arrow-down"></i>
            <h4>Total Stock In</h4>
            <h2><?= number_format($stock_in) ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg6">
            <i class="fa fa-arrow-up"></i>
            <h4>Total Stock Out</h4>
            <h2><?= number_format($stock_out) ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg7">
            <i class="fa fa-lock"></i>
            <h4>Reserved Stock</h4>
            <h2><?= number_format($reserved_stock) ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg8">
            <i class="fa fa-check-circle"></i>
            <h4>Available Stock</h4>
            <h2><?= number_format($available_stock) ?></h2>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel-modern">

            <h4>
                Today's Activities
            </h4>

            <table class="table table-bordered">
                <tr>
                    <td>Material Issues</td>
                    <td><?= $today_issue ?></td>
                </tr>

                <tr>
                    <td>Stock In</td>
                    <td><?= $today_stockin ?></td>
                </tr>

                <tr>
                    <td>Stock Out</td>
                    <td><?= $today_stockout ?></td>
                </tr>

                <tr>
                    <td>Stock Adjustments</td>
                    <td><?= $today_adjustment ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel-modern">
            <h4>
                Stock Summary
            </h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="summary-box">
                        <h3><?= number_format($stock_in) ?></h3>
                        <p>Total Received</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="summary-box">
                        <h3><?= number_format($stock_out) ?></h3>
                        <p>Total Issued</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="summary-box">
                        <h3><?= number_format($reserved_stock) ?></h3>
                        <p>Reserved</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="summary-box">
                        <h3><?= number_format($available_stock) ?></h3>
                        <p>Available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Recent Material Issues -->

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>
                <i class="fa fa-share-square-o"></i>
                Recent Material Issues
            </h4>

            <table class="table table-striped table-bordered">

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

                                <td><?= $row->mi_code ?></td>

                                <td><?= date('d-m-Y', strtotime($row->issue_date)); ?></td>

                                <td><?= $row->warehouse_name ?></td>

                                <td><?= $row->customer_name ?></td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="4" class="text-center">
                                No Records Found
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>



    <!-- Recent Stock Ledger -->

    <div class="col-md-6">
        <div class="panel-modern">
            <h4>
                <i class="fa fa-history"></i>
                Recent Stock Ledger
            </h4>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Qty</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($recent_stock)) { ?>
                        <?php foreach ($recent_stock as $row) { ?>
                            <tr>
                                <td>
                                    <?= date('d-m-Y', strtotime($row->timestamp)); ?>
                                </td>

                                <td>
                                    <?= $row->product_code ?>
                                    <br>

                                    <small>
                                        <?= $row->product_name ?>
                                    </small>
                                </td>

                                <td>
                                    <?php
                                    if ($row->stock_type == "IN") {
                                        echo '<span class="label label-success">IN</span>';
                                    } else {
                                        echo '<span class="label label-danger">OUT</span>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?= number_format($row->quantity) ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                No Records Found
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="row">
    <!-- Low Stock -->
    <div class="col-md-12">
        <div class="panel-modern">
            <h4>
                <i class="fa fa-exclamation-triangle text-danger"></i>
                Low Stock Items
            </h4>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th class="text-center">Available</th>
                        <th class="text-center">Reorder Level</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($low_stock)) { ?>
                        <?php foreach ($low_stock as $row) { ?>
                            <tr>
                                <td><?= $row->product_code ?></td>

                                <td><?= $row->product_name ?></td>

                                <td class="text-center">
                                    <?= number_format($row->stock_qty) ?>
                                </td>

                                <td class="text-center">
                                    <?= number_format($row->reorder_level) ?>
                                </td>

                                <td class="text-center">
                                    <span class="label label-danger">
                                        Reorder Required
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                No Low Stock Items
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <!-- Warehouse Summary -->
    <div class="col-md-8">

        <div class="panel-modern">

            <h4>
                <i class="fa fa-building"></i>
                Warehouse Summary
            </h4>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Warehouse</th>
                        <th class="text-center">Products</th>
                        <th class="text-center">Available Qty</th>
                        <th class="text-center">Reserved Qty</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($warehouse_summary)) { ?>
                        <?php foreach ($warehouse_summary as $row) { ?>
                            <tr>
                                <td><?= $row->warehouse_name ?></td>

                                <td class="text-center">
                                    <?= number_format($row->total_items) ?>
                                </td>

                                <td class="text-center">
                                    <?= number_format($row->available_stock) ?>
                                </td>

                                <td class="text-center">
                                    <?= number_format($row->reserved_stock) ?>
                                </td>
                            </tr>
                        <?php } ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                No Warehouse Data Found
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="panel-modern">
            <h4>
                <i class="fa fa-bolt"></i>
                Quick Actions
            </h4>

            <a href="<?= base_url() ?>index.php/Stock/stock_adjustment"
                class="quick-btn">
                <i class="fa fa-exchange"></i>
                Stock Adjustment
            </a>

            <a href="<?= base_url() ?>index.php/Stock/list_stock_adjustment"
                class="quick-btn">
                <i class="fa fa-list"></i>
                Stock Adjustment List
            </a>

            <a href="<?= base_url() ?>index.php/Stock/min_stock"
                class="quick-btn">
                <i class="fa fa-exclamation-circle"></i>
                Minimum Stock
            </a>

            <a href="<?= base_url() ?>index.php/Stock/reorder_list"
                class="quick-btn">
                <i class="fa fa-refresh"></i>
                Reorder Stock
            </a>

            <a href="<?= base_url() ?>index.php/Reports/stock_inventory_report"
                class="quick-btn">
                <i class="fa fa-cubes"></i>
                Stock Inventory Report
            </a>

            <a href="<?= base_url() ?>index.php/Reports/item_wise_stock_ledger"
                class="quick-btn">
                <i class="fa fa-book"></i>
                Stock Ledger
            </a>

            <a href="<?= base_url() ?>index.php/Stock/list_stock_allocations"
                class="quick-btn">
                <i class="fa fa-lock"></i>
                Stock Allocation
            </a>

        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="panel-modern">

            <h4>
                <i class="fa fa-bar-chart"></i>
                Inventory Statistics
            </h4>

            <div class="row">
                <div class="col-md-3">
                    <div class="summary-box">
                        <h3><?= number_format($product_count) ?></h3>
                        <p>Total Products</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="summary-box">
                        <h3><?= number_format($available_stock) ?></h3>
                        <p>Available Quantity</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="summary-box">
                        <h3><?= number_format($reserved_stock) ?></h3>
                        <p>Reserved Quantity</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="summary-box">
                        <h3><?= number_format($minimum_stock_count) ?></h3>
                        <p>Low Stock Products</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>