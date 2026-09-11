<div class="x_panel">
    <div class="x_title">
        <h2>Edit Commission Group</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>

        <form method="post" action="<?= base_url('index.php/Setup/update_commission_group_data/'.$group->commission_group_id) ?>">

            <div class="form-group row">

                <label class="col-md-2 col-form-label">Code</label>
                <div class="col-md-3">
                    <input type="text" class="form-control"
                           value="<?= $group->commission_group_code ?>" readonly>
                </div>

                <label class="col-md-2 col-form-label">Group Name</label>
                <div class="col-md-3">
                    <input type="text" name="commission_group_name"
                           class="form-control"
                           value="<?= $group->commission_group_name ?>" required>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">Target Amount</label>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="target_amount"
                           class="form-control" value="<?= $group->target_amount ?>">
                </div>

                <label class="col-md-2 col-form-label">Commission %</label>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="commission_percent"
                           class="form-control" value="<?= $group->commission_percent ?>">
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">Sales Discount %</label>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="sales_discount_percent"
                           class="form-control" value="<?= $group->sales_discount_percent ?>">
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">Description</label>

                <div class="col-md-6">
                    <textarea name="description" class="form-control" rows="3"><?= $group->description ?></textarea>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= base_url('index.php/Setup/list_commission_group') ?>" class="btn btn-secondary">Back</a>
                </div>
            </div>

        </form>

    </div>
</div>