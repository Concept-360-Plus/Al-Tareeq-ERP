<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Purchase Return
            <small>Create Purchase Return</small>
        </h1>
    </section>

    <section class="content">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Purchase Return
                </h3>
            </div>

            <form method="post"
                action="<?= base_url() ?>index.php/Purchase/save_purchase_return">
                <div class="box-body">
                    <input type="hidden"
                        name="grn_id"
                        value="<?= $grn_master[0]->grn_id; ?>">

                    <input type="hidden"
                        name="supplier_id"
                        value="<?= $grn_master[0]->supplier_id; ?>">

                    <input type="hidden"
                        name="warehouse_id"
                        value="<?= $grn_master[0]->warehouse_id; ?>">

                    <input type="hidden"
                        name="store_id"
                        value="<?= $grn_master[0]->store_id; ?>">

                    <div class="col-md-3">
                        <label>Return Date</label>

                        <input type="date"
                            name="return_date"
                            class="form-control"
                            value="<?= date('Y-m-d') ?>"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label>Return No</label>
                        <input type="text"
                            class="form-control"
                            readonly
                            value="<?= $return_code; ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>GRN No</label>

                            <input
                                type="text"
                                class="form-control"
                                readonly
                                value="<?= $grn_master[0]->grn_code; ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Date</label>
                            <input
                                type="text"
                                class="form-control"
                                readonly
                                value="<?= date('d-m-Y'); ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Warehouse</label>
                            <input
                                type="text"
                                class="form-control"
                                readonly
                                value="<?= $grn_master[0]->warehouse_name; ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Store</label>
                            <input
                                type="text"
                                class="form-control"
                                readonly
                                value="<?= $grn_master[0]->store_name; ?>">
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Supplier</label>
                            <input
                                type="text"
                                class="form-control"
                                readonly
                                value="<?= $grn_master[0]->supplier_name; ?>">
                        </div>
                    </div>

                    <br>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="40%">Product</th>
                                <th>Received</th>
                                <th>Returned</th>
                                <th>Balance</th>
                                <th width="120">Return Qty</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($items as $row) { ?>
                                <?php
                                $balance = $row->rec_quantity - $row->returned_qty;
                                ?>
                                <tr>
                                    <td>
                                        <?= $row->product_code; ?> -
                                        <?= $row->product_name; ?>
                                    </td>

                                    <td align="center">
                                        <?= $row->rec_quantity; ?>
                                    </td>

                                    <td align="center">
                                        <?= $row->returned_qty; ?>
                                    </td>

                                    <td align="center">
                                        <b><?= $balance; ?></b>
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            class="form-control return_qty"
                                            name="return_qty[]"
                                            value="0"
                                            min="0"
                                            max="<?= $balance; ?>">

                                        <input
                                            type="hidden"
                                            name="grn_transaction_id[]"
                                            value="<?= $row->trans_id; ?>">

                                        <input
                                            type="hidden"
                                            name="product_id[]"
                                            value="<?= $row->product_id; ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Return Reason</label>
                            <textarea
                                class="form-control"
                                rows="4"
                                name="remarks"
                                placeholder="Enter Return Reason"></textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer text-center">
                    <button
                        type="submit"
                        class="btn btn-danger">
                        <i class="fa fa-undo"></i>
                        Return Items
                    </button>

                    <a
                        href="<?= base_url() ?>index.php/Purchase/purchase_return_list"
                        class="btn btn-default">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>