<div class="clearfix"></div>
<style>
.form-control{width:35%;}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
        <?php if ($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>
            </div>

        <?php endif; ?>
            <form method="post"
                  action="<?= base_url(
                      'index.php/Production/update_warehouse'
                  ) ?>">

                <div class="box-body">

                    <input type="hidden"
                           name="wa_id"
                           value="<?= $warehouse->wa_id ?>">


                    <div class="form-group">

                        <label>
                            Warehouse Name
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= htmlspecialchars(
                                   $warehouse->name
                               ) ?>"
                               required>

                    </div>


                    <div class="form-group">

                        <label>
                            Warehouse Code
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="code"
                               class="form-control"
                               value="<?= htmlspecialchars(
                                   $warehouse->code
                               ) ?>"
                               required>

                    </div>


                    <div class="form-group">

                        <label>
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="1"
                                <?= $warehouse->status == 1
                                    ? 'selected'
                                    : '' ?>>

                                Active

                            </option>

                            <option value="0"
                                <?= $warehouse->status == 0
                                    ? 'selected'
                                    : '' ?>>

                                Inactive

                            </option>

                        </select>

                    </div>

                </div>


                <div class="box-footer">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fa fa-save"></i>
                        Update Warehouse
                    </button>
                    <a href="<?= base_url(
                        'index.php/Production/warehouses'
                    ) ?>"
                       class="btn btn-default">
                       Cancel

                    </a>

                </div>

            </form>

        </div>
</div>