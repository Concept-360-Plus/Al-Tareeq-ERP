<style>
    .kpi-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
        min-height: 120px;
    }

    .kpi-card h2 {
        margin-top: 5px;
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

    .summary-box {
        text-align: center;
        padding: 15px;
    }

    .summary-box h3 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
    }

    .summary-box p {
        margin: 5px 0 0;
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
</style>

<div class="row">

    <div class="col-md-3">
        <div class="kpi-card bg1">
            <i class="fa fa-book"></i>
            <h4>Total Ledgers</h4>
            <h2><?= $ledger_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg2">
            <i class="fa fa-arrow-circle-down"></i>
            <h4>Receipts</h4>
            <h2><?= $receipt_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg3">
            <i class="fa fa-arrow-circle-up"></i>
            <h4>Payments</h4>
            <h2><?= $payment_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg4">
            <i class="fa fa-money"></i>
            <h4>Expenses</h4>
            <h2><?= $expense_count ?></h2>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3">
        <div class="kpi-card bg5">
            <i class="fa fa-credit-card"></i>
            <h4>Credit Notes</h4>
            <h2><?= $credit_note_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg6">
            <i class="fa fa-file-text"></i>
            <h4>Debit Notes</h4>
            <h2><?= $debit_note_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg7">
            <i class="fa fa-random"></i>
            <h4>Journal Entries</h4>
            <h2><?= $journal_count ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-card bg8">
            <i class="fa fa-exchange"></i>
            <h4>Contra Entries</h4>
            <h2><?= $contra_count ?></h2>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel-modern">
            <h4>Today's Activities</h4>

            <table class="table table-bordered">
                <tr>
                    <td>Receipts</td>
                    <td><?= $today_receipts ?></td>
                </tr>

                <tr>
                    <td>Payments</td>
                    <td><?= $today_payments ?></td>
                </tr>

                <tr>
                    <td>Expenses</td>
                    <td><?= $today_expenses ?></td>
                </tr>

                <tr>
                    <td>Journal Entries</td>
                    <td><?= $today_journals ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel-modern">
            <h4>Today's Cash Summary</h4>

            <table class="table table-bordered">
                <tr>
                    <th>Cash In</th>
                    <td><?= number_format($cash_in, 2) ?></td>
                </tr>

                <tr>
                    <th>Cash Out</th>
                    <td><?= number_format($cash_out, 2) ?></td>
                </tr>

                <tr>
                    <th>Net Cash</th>
                    <td>
                        <strong>
                            <?= number_format($net_cash, 2) ?>
                        </strong>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>