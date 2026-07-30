<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">
            <h4 class="page-title">
                <?php echo isset($warehouse) ? 'Edit Warehouse' : 'Add Warehouse'; ?>
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
                <form method="post" action="<?php 
                            if (isset($warehouse))
                                echo base_url('index.php/Setup/update_warehouse_data');
                            else
                                echo base_url('index.php/Setup/add_warehouse_data');
                            ?>">

                    <?php if (isset($warehouse)) { ?>
                        <input type="hidden" name="warehouse_id" value="<?php echo $warehouse->warehouse_id; ?>">
                    <?php } ?>

                    <div class="row">

                        <div class="col-md-6">

                            <label>Branch <span class="text-danger">*</span></label>

                            <select name="branch_id"
                                class="form-control"
                                required>

                                <option value="">Select Branch</option>

                                <?php foreach ($branches as $row) { ?>

                                    <option
                                        value="<?php echo $row->branch_id; ?>"

                                        <?php
                                        if (isset($warehouse)) {
                                            if ($warehouse->branch_id == $row->branch_id)
                                                echo "selected";
                                        }
                                        ?>>

                                        <?php echo $row->branch_name; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label>Warehouse Name <span class="text-danger">*</span></label>

                            <input
                                type="text"
                                name="warehouse_name"
                                class="form-control"
                                required

                                value="<?php

                                        if (isset($warehouse))
                                            echo $warehouse->warehouse_name;

                                        ?>">

                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-12">

                            <label>Warehouse Address</label>

                            <textarea
                                name="warehouse_address"
                                class="form-control"
                                rows="4"><?php

                                if (isset($warehouse))
                                    echo $warehouse->warehouse_address;
                                ?>
                            </textarea>

                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-3">

                            <label>Status</label>

                            <select
                                name="status"
                                class="form-control">

                                <option value="1"

                                    <?php

                                    if (isset($warehouse)) {
                                        if ($warehouse->status == 1)
                                            echo "selected";
                                    } else {
                                        echo "selected";
                                    }

                                    ?>>

                                    Active

                                </option>

                                <option value="0"
                                    <?php

                                    if (isset($warehouse)) {
                                        if ($warehouse->status == 0)
                                            echo "selected";
                                    }

                                    ?>>
                                    Inactive

                                </option>

                            </select>

                        </div>

                    </div>

                    <br>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <?php

                        if (isset($warehouse))
                            echo "Update Warehouse";
                        else
                            echo "Save Warehouse";

                        ?>

                    </button>

                    <a href="<?php echo base_url('index.php/Setup/list_warehouse'); ?>"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>
        </div>

    </div>
</div>