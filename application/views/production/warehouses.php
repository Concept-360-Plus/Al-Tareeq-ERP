<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
        <?php if ($this->session->flashdata('success')): ?>

            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>

        <?php endif; ?>


        <?php if ($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>
            </div>

        <?php endif; ?>

<div class="x_title">
<h2>Warehouse List</h2>
                <button type="button"
                        class="btn btn-primary pull-right"
                        data-toggle="modal"
                        data-target="#warehouseModal">

                    <i class="fa fa-plus"></i>
                    Add Warehouse

                </button>
<div class="clearfix"></div>
        </div><div class="x_content">



                <div class="table-responsive">

                    <table id="warehouseTable"
                           class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th width="60">
                                    #
                                </th>

                                <th>
                                    Warehouse Name
                                </th>

                                <th>
                                    Code
                                </th>

                                <th width="100">
                                    Status
                                </th>

                                <th width="150">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($warehouses)): ?>

                                <?php foreach (
                                    $warehouses
                                    as $index => $warehouse
                                ): ?>

                                    <tr>

                                        <td>
                                            <?= $index + 1 ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $warehouse->name
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $warehouse->code
                                            ) ?>
                                        </td>

                                        <td>

                                            <?php if (
                                                $warehouse->status == 1
                                            ): ?>

                                                <span class="label label-success">
                                                    Active
                                                </span>

                                            <?php else: ?>

                                                <span class="label label-danger">
                                                    Inactive
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <td>

                                            <a href="<?= base_url(
                                                'index.php/Production/edit_warehouse/' .
                                                $warehouse->wa_id
                                            ) ?>"
                                               class="btn btn-xs btn-info">

                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                                Edit

                                            </a>


                                            <a href="<?= base_url(
                                                'index.php/Production/delete_warehouse/' .
                                                $warehouse->wa_id
                                            ) ?>"
                                               class="btn btn-xs btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this warehouse?');">

                                                <i class="fa fa-trash"></i>

                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>

                    </table>

               

            </div>

        </div>
 </div>
</div>
<div class="modal fade"
     id="warehouseModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post"
                  action="<?= base_url(
                      'index.php/Production/add_warehouse'
                  ) ?>">

                <div class="modal-header">

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        &times;

                    </button>

                    <h4 class="modal-title">
                        Add Warehouse
                    </h4>

                </div>


                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Warehouse Name
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
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
                               required>

                    </div>


                    <div class="form-group">

                        <label>
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="1">
                                Active
                            </option>

                            <option value="0">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">

                        Close

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fa fa-save"></i>
                        Save Warehouse

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>