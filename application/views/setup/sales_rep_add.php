<div class="x_panel">
    <div class="x_title">
        <h2>Sales Rep Master</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>

        <form method="post" action="<?= base_url('index.php/Setup/add_sales_rep_data') ?>">

            <div class="form-group row">

                <label class="col-md-2">Code</label>
                <div class="col-md-3">
                    <input type="text" name="sales_rep_code" class="form-control"
                           value="<?= $auto_code ?>" readonly>
                </div>

                <label class="col-md-2">Sales Rep Name</label>
                <div class="col-md-3">
                    <input type="text" name="sales_rep_name" class="form-control" required>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2">Employee</label>
                <div class="col-md-3">
                    <select name="emp_id" class="form-control" required>
                        <option value="">Select Employee</option>
                        <?php foreach ($employees as $e) { ?>
                            <option value="<?= $e->user_code ?>">
                                <?= $e->user_code ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <label class="col-md-2">Commission Group</label>
                <div class="col-md-3">
                    <select name="commission_group_id" id="commission_group_id" class="form-control"
                            onchange="fetchCommissionGroupDetails(this.value)">
                        <option value="">Select</option>
                        <?php foreach ($commission_group as $cg) { ?>
                            <option value="<?= $cg->commission_group_id ?>">
                                <?= $cg->commission_group_name ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2">Target Amount</label>
                <div class="col-md-3">
                    <input type="number" name="target_amount" id="target_amount" class="form-control">
                </div>

                <label class="col-md-2">Commission %</label>
                <div class="col-md-3">
                    <input type="number" name="commission_percent" id="commission_percent" class="form-control">
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2">Sales Discount %</label>
                <div class="col-md-3">
                    <input type="number" name="sales_discount_percent" id="sales_discount_percent" class="form-control">
                </div>

            </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-2">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>

       </form>

    </div>
</div>

<script>
function fetchCommissionGroupDetails(id) {
    if (!id) {
        document.getElementById('target_amount').value = '';
        document.getElementById('commission_percent').value = '';
        document.getElementById('sales_discount_percent').value = '';
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/Ajax/fetch_commission_group_details/') ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            document.getElementById('target_amount').value = response.target_amount;
            document.getElementById('commission_percent').value = response.commission_percent;
            document.getElementById('sales_discount_percent').value = response.sales_discount_percent;
        }
    });
}
</script>