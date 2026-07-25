<style>
    .kpi-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    }

    .kpi-card i {
        font-size: 34px;
        float: right;
        opacity: .30;
    }

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

    .panel-modern {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        margin-bottom: 20px;
    }

    .quick-btn {
        display: block;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ddd;
        border-radius: 6px;
    }
</style>


<div class="row">

    <div class="col-md-3">
        <div class="kpi-card bg1">
            <i class="fa fa-list"></i>
            <h4>Total RFQs</h4>
            <h2><?= $rfq_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg2">
            <i class="fa fa-file-text-o"></i>
            <h4>Purchase Quotations</h4>
            <h2><?= $quotation_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg3">
            <i class="fa fa-shopping-cart"></i>
            <h4>Purchase Orders</h4>
            <h2><?= $po_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg4">
            <i class="fa fa-truck"></i>
            <h4>GRN</h4>
            <h2><?= $grn_count ?></h2>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>Recent RFQs</h4>

            <table class="table table-striped">

                <thead>

                    <tr>

                        <th>RFQ No</th>

                        <th>Supplier</th>

                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($recent_rfq as $row) { ?>

                        <tr>

                            <td><?= $row->rfq_code ?></td>

                            <td><?= $row->supplier_name ?></td>

                            <td><?= date('d-m-Y', strtotime($row->rfq_date)); ?></td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

    <div class="col-md-6">

        <div class="panel-modern">

            <h4>Pending Purchase Orders</h4>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>PO</th>

                        <th>Supplier</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($pending_orders as $row) { ?>

                        <tr>

                            <td><?= $row->po_code ?></td>

                            <td><?= $row->supplier_name ?></td>

                            <td>

                                <span class="label label-warning">

                                    Pending

                                </span>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-4">

        <div class="panel-modern">

            <h4>Quick Actions</h4>

            <a href="<?= base_url() ?>index.php/Purchase/direct_rfq" class="quick-btn">

                <i class="fa fa-plus"></i>

                New RFQ

            </a>

            <a href="<?= base_url() ?>index.php/Purchase/purchase_quotation_list" class="quick-btn">

                <i class="fa fa-file"></i>

                Purchase Quotation

            </a>

            <a href="<?= base_url() ?>index.php/Purchase/purchase_order_list" class="quick-btn">

                <i class="fa fa-shopping-cart"></i>

                Purchase Order

            </a>

            <a href="<?= base_url() ?>index.php/Purchase/grn_list" class="quick-btn">

                <i class="fa fa-truck"></i>

                GRN

            </a>

        </div>

    </div>

    <div class="col-md-4">

        <div class="panel-modern">

            <h4>Today's Activities</h4>

            <ul>

                <li><?= $today_rfq ?> RFQs Created</li>

                <li><?= $today_quote ?> Quotations</li>

                <li><?= $today_po ?> Purchase Orders</li>

                <li><?= $today_grn ?> GRNs</li>

            </ul>

        </div>

    </div>

    <div class="col-md-4">

        <div class="panel-modern">

            <h4>Pending Approval</h4>

            <table class="table">

                <tr>

                    <td>Purchase Orders</td>

                    <td><?= $pending_po ?></td>

                </tr>

                <tr>

                    <td>Pending GRN</td>

                    <td><?= $pending_grn ?></td>

                </tr>

            </table>

        </div>

    </div>

</div>