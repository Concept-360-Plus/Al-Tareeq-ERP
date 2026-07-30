<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">
            <h4 class="page-title">
                <?php echo isset($store) ? 'Edit Store' : 'Add Store'; ?>
            </h4>
        </div>

        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>

        <div class="card">
            <div class="card-body">

                <form method="post"
                    action="<?php
                            if (isset($store))
                                echo base_url('index.php/Setup/update_store_data');
                            else
                                echo base_url('index.php/Setup/add_store_data');
                            ?>">

                    <?php if (isset($store)) { ?>
                        <input type="hidden"
                            name="store_id"
                            value="<?php echo $store->store_id; ?>">
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Warehouse <span class="text-danger">*</span></label>

                            <select name="warehouse_id"
                                class="form-control"
                                required>
                                <option value="">Select Warehouse</option>
                                <?php foreach ($warehouses as $row) { ?>
                                    <option
                                        value="<?php echo $row->warehouse_id; ?>"
                                        <?php
                                        if (isset($store)) {
                                            if ($store->warehouse_id == $row->warehouse_id)
                                                echo "selected";
                                        }
                                        ?>>
                                        <?php echo $row->warehouse_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Store Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="store_name"
                                class="form-control"
                                required
                                value="<?php echo isset($store) ? $store->store_name : ''; ?>">

                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Store Type <span class="text-danger">*</span></label>

                            <select name="store_type"
                                class="form-control"
                                required>

                                <option value="">Select Store Type</option>

                                <option value="PHYSICAL"
                                    <?php if (isset($store) && $store->store_type == 'PHYSICAL') echo "selected"; ?>>
                                    Physical
                                </option>

                                <option value="PLANT"
                                    <?php if (isset($store) && $store->store_type == 'PLANT') echo "selected"; ?>>
                                    Plant
                                </option>

                                <option value="INSTALLATION"
                                    <?php if (isset($store) && $store->store_type == 'INSTALLATION') echo "selected"; ?>>
                                    Installation
                                </option>

                                <option value="MAINTENANCE"
                                    <?php if (isset($store) && $store->store_type == 'MAINTENANCE') echo "selected"; ?>>
                                    Maintenance
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Status</label>

                            <select
                                name="status"
                                class="form-control">

                                <option value="1"
                                    <?php
                                    if (isset($store)) {
                                        if ($store->status == 1)
                                            echo "selected";
                                    } else {
                                        echo "selected";
                                    }
                                    ?>>
                                    Active
                                </option>

                                <option value="0"
                                    <?php
                                    if (isset($store)) {
                                        if ($store->status == 0)
                                            echo "selected";
                                    }
                                    ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Store Address</label>

                            <textarea
                                name="store_address"
                                rows="4"
                                class="form-control"><?php echo isset($store) ? $store->store_address : ''; ?>
                            </textarea>

                        </div>
                    </div>

                    <br>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        <?php echo isset($store) ? 'Update Store' : 'Save Store'; ?>
                    </button>

                    <a href="<?php echo base_url('index.php/Setup/list_store'); ?>"
                        class="btn btn-secondary">
                        Cancel
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>